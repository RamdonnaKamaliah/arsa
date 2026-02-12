<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas;
use App\Models\Peminjaman;
use App\Models\Pengembalian; // ✅ Tambahkan Model Pengembalian
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PengembalianController extends Controller
{
    public function index()
{
    $peminjaman = Peminjaman::with('pengembalian')
        ->where('status', 'diambil')
        ->orWhere('status', 'kembali')->latest()
        ->get();

    return view('petugas.pengembalian.index', compact('peminjaman'));
}


    public function verifyPengembalian(Request $request, $id)
    {
        $request->validate([
            'kondisi_kembali' => 'required|in:baik,rusak,hilang',
            'catatan' => 'nullable|string'
        ]);

        $peminjaman = Peminjaman::with('detail.alat', 'user')->findOrFail($id);
        
        if($peminjaman->status !== 'diambil') {
            return redirect()->route('petugas.pengembalian.index')
                ->with('error', 'Peminjaman tidak valid untuk dikembalikan');
        }

        // Set tanggal pengembalian sebenarnya
        $tanggalKembaliSebenarnya = now();
        $tanggalKembaliRencana = \Carbon\Carbon::parse($peminjaman->tanggal_pengembalian_rencana);

        // Cek apakah pengembalian terlambat 
        $terlambat = $tanggalKembaliSebenarnya->greaterThan($tanggalKembaliRencana);
        $hariTerlambat = 0;

        if ($terlambat) {
            $hariTerlambat = $tanggalKembaliSebenarnya->diffInDays($tanggalKembaliRencana);
            $masaBlokir = now()->addDays($hariTerlambat);
            
            $peminjaman->user->update([
                'status_blokir' => true,
                'masa_blokir' => $masaBlokir,
                'alasan_blokir' => "Terlambat mengembalikan {$hariTerlambat} hari"
            ]);
        }

        // Cek Kondisi Alat Baik?
        $kondisiBaik = $request->kondisi_kembali === 'baik';
        
        if (!$kondisiBaik) {
            $peminjaman->user->update([
                'status_blokir' => true,
                'masa_blokir' => now()->addYears(10),
                'alasan_blokir' => "Menunggu penggantian alat yang {$request->kondisi_kembali}"
            ]);
        } else {
    // $peminjaman->update([
    //     'status' => 'bermasalah'
    // ]);
}
        
        // ✅ UPDATE PEMINJAMAN - Set status jadi 'dikembalikan'
        $peminjaman->update([
            'status' => 'kembali', // ✅ UBAH INI
        ]);

        // ✅ BUAT RECORD BARU DI TABEL PENGEMBALIAN
        $pengembalian = Pengembalian::create([
            'id_pengembalian' => Str::uuid(),
            'id_peminjaman' => $peminjaman->id,
            'tanggal_pengembalian_sebenarnya' => $tanggalKembaliSebenarnya,
            'status_pelanggaran' => $terlambat || !$kondisiBaik, // true jika ada pelanggaran
            'catatan' => $request->catatan,
            'kondisi_kembali' => $request->kondisi_kembali, // ✅ Tambahkan kolom ini di migration jika belum ada
            'hari_terlambat' => $hariTerlambat,
            'tanggal_penggantian' => null,
            'status_penggantian' => $kondisiBaik ? null : 'menunggu' // ✅ Pakai ENUM yang benar
        ]);

        // Update stok
        foreach ($peminjaman->detail as $detail) {
            $qty = (int) $detail->quantity;
            
            if ($qty <= 0) {
                continue;
            }

            if ($kondisiBaik) {
                $detail->alat->increment('stok', $qty);
            }
            elseif ($request->kondisi_kembali === 'rusak') {
                $detail->alat->increment('stok_rusak', $qty);
            }
        }

        // Log aktivitas
        Aktivitas::simpanLog('VERIFIKASI', 'PENGEMBALIAN', "Verifikasi pengembalian #{$peminjaman->id} - Kondisi: {$request->kondisi_kembali}");

        $message = 'Pengembalian berhasil diproses';
        
        if ($terlambat) {
            $message .= ". Terlambat {$hariTerlambat} hari";
        }
        
        if (!$kondisiBaik) {
            $message .= ". User diblokir sampai mengganti alat";
        }

        return redirect()->route('petugas.pengembalian.index')->with('success', $message);
    }
}
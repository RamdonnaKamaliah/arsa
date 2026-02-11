<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index() {
        $pengembalian = Peminjaman::where('status', 'diambil')->latest()->get();
        return view('petugas.pengembalian.index', compact('pengembalian'));
    }

    public function verifyPengembalian(Request $request, $id){
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'kondisi_kembali' => 'required|in:baik,rusak,hilang',
            'catatan' => 'nullable|string'
        ]);

        $peminjaman = Peminjaman::with('detail.alat')->findOrFail($request->peminjaman_id);
        
        if($peminjaman->status !== 'diambil') {
            return back()->with('error', 'Peminjaman tidak valid');
        }

        // Set tanggal pengembalian sebenarnya
        $tanggalKembaliSebenarnya = now();
        $tanggalKembaliRencana = \Carbon\Carbon::parse($peminjaman->tanggal_pengembalian_rencana);

        //cek apakah pengembalian terlambat 
        $terlambat = $tanggalKembaliSebenarnya->greaterThan($tanggalKembaliRencana);
        $hariTerlambat = 0;

         if ($terlambat) {
        // Hitung berapa hari terlambat
        $hariTerlambat = $tanggalKembaliSebenarnya->diffInDays($tanggalKembaliRencana);
        
        // Sistem Menetapkan Masa Blokir Peminjaman
        // Telat 1 hari = blokir 1 hari
        $masaBlokir = now()->addDays($hariTerlambat);
        
        // Update masa blokir pada user
        $peminjaman->user->update([
            'masa_blokir' => $masaBlokir,
            'alasan_blokir' => "Terlambat mengembalikan {$hariTerlambat} hari"
        ]);
    }

     // Cek Kondisi Alat Baik?
    $kondisiBaik = $request->kondisi_kembali === 'baik';
    
    if (!$kondisiBaik) {
        // Sistem Memberitahukan Pembatasan Peminjaman pada User
        // Jika rusak/hilang, blokir sampai user mengembalikan/mengganti
        $peminjaman->user->update([
            'tanggal_blokir_sampai' => now()->addYears(10), // Blokir permanent
            'alasan_blokir' => "Menunggu penggantian alat yang {$request->kondisi_kembali}",
            'peminjaman_id_penggantian' => $peminjaman->id // Simpan ID peminjaman yang perlu diganti
        ]);
    }
    
    $peminjaman->update([
        'status_pelanggaran' => $kondisiBaik ? 'selesai' : 'menunggu_penggantian',
        'tanggal_pengembalian_sebenarnya' => $tanggalKembaliSebenarnya,
        'kondisi_kembali' => $request->kondisi_kembali,
        'catatan' => $request->catatan,
        'hari_terlambat' => $hariTerlambat
    ]);

     foreach ($peminjaman->detail as $detail) {
        
        // ✅ Validasi quantity adalah numeric
        $qty = (int) $detail->quantity; // atau $detail->jumlah sesuai nama kolom
        
        if ($qty <= 0) {
            continue; // Skip jika quantity tidak valid
        }

        if ($kondisiBaik) {
            $detail->alat->increment('stok', $qty);
        }
        elseif ($request->kondisi_kembali === 'rusak') {
            $detail->alat->increment('stok_rusak', $qty);
        }
        // Jika hilang, tidak kembalikan stok
    }

    Aktivitas::simpanLog('TAMBAH', 'PENGEMBALIAN', 'Mengajukan pengembalian baru');


        return redirect()->route('petugas.pengembalian.index')->with('success', 'pengembalian berhasil');

        
    }
}
<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas;
use App\Models\Alat;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PeminjamanAlatController extends Controller
{
    public function index() {
    $peminjaman = Peminjaman::where('id_user', auth()->id())
                    ->with('user')
                    ->latest()
                    ->get();

    return view('peminjam.peminjamanAlat.index', compact('peminjaman'));
}

    public function store(Request $request) {
        $request->validate([
        'tanggal_pengambilan_rencana' => 'required|date',
        'tanggal_pengembalian_rencana' => 'required|date|after_or_equal:tanggal_pengambilan_rencana',
        'alasan_peminjaman' => 'required|string',
        ]);

        $keranjang = session('keranjang');

    if (!$keranjang || count($keranjang) == 0) {
        return redirect()->back()->with('error', 'Keranjang kosong!');
    }

        $peminjaman = Peminjaman::create([
            'id_peminjaman' => Str::uuid(),
            'id_user' => auth()->id(),
            'tanggal_pengambilan_rencana' => $request->tanggal_pengambilan_rencana,
            'tanggal_pengembalian_rencana' => $request->tanggal_pengembalian_rencana,
            'alasan_peminjaman' => $request->alasan_peminjaman,
            'status' => 'pending',
        ]);
        
       
    foreach ($keranjang as $id_alat => $item) {
        DetailPeminjaman::create([
            'id_detail_peminjaman' => Str::uuid(),
            'id_peminjaman' => $peminjaman->id,
            'id_alat' => $id_alat,
            'jumlah' => $item['jumlah'],
            'kondisi_keluar' => 'baik',
        ]);
    }

    session()->forget('keranjang');

    Aktivitas::simpanLog('TAMBAH', 'PEMINJAMAN', 'Mengajukan peminjaman baru');

    return redirect()->route('peminjam.peminjamAlat')->with('success', 'Berhasil mengajukan pinjaman!');
        
    }

    // Tambahkan di dalam class PeminjamanAlatController

    public function downloadQr($id)
    {
        $peminjaman = Peminjaman::where('id_user', auth()->id())->findOrFail($id);

        // Jika Anda menggunakan library Simple Software IO QR Code
        // Anda bisa men-generate ulang datanya untuk diunduh sebagai file
        $qrCode = \QrCode::format('png')
                        ->size(500)
                        ->margin(2)
                        ->generate($peminjaman->id_peminjaman);

        $fileName = 'QR_ARSA_' . $peminjaman->id . '.png';

        return response($qrCode)
                ->header('Content-Type', 'image/png')
                ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }

    public function show(String $id){
        
     $peminjaman = Peminjaman::with('user')->findOrFail($id);
    return view('peminjam.peminjamanAlat.show', compact('peminjaman'));
    
    }
}
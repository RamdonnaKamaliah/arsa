<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use Illuminate\Http\Request;


class PeminjamanController extends Controller
{
    public function index() {
        $peminjaman = Peminjaman::with('user', 'detail.alat')->latest()->get();
        return view('petugas.peminjaman.index', compact('peminjaman'));
    }

    public function approve($id){
        $peminjaman = Peminjaman::findOrFail($id);
        
        $peminjaman->status = 'disetujui';
        $peminjaman->disetujui_oleh = $peminjaman->id_user;

        $peminjaman->save();

        return back()->with('success', 'Peminjaman disetujui & QR Code berhasil dibuat!');
        
    } 

    public function scan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        return view('petugas.peminjaman.scan', compact('peminjaman'));
    }



public function verifyScan(Request $request)
{
    $alat = Alat::where('kode_barang',$request->qr_result)->first();

    if(!$alat){
        return back()->with('error', 'Qr tidak valid');
    }
    
    $detail = DetailPeminjaman::where('id_peminjaman', $request->peminjaman_id)->where('id_alat', $alat->id)->first();
    
    if(!$detail){
        return back()->with('error', 'Barang tidak termasuk dalam peminjaman ini');
    }

    $detail->diambil = true;
    $detail->save();

    $alat->stok -= $detail->jumlah;
    $alat->save();
    
    return back()->with('success', 'Barang berhasil diverifikasi & diambil');
}

    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string'
        ]);

        $peminjaman = Peminjaman::findOrFail($id);

        $peminjaman->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan
        ]);

        return back()->with('success', 'Peminjaman berhasil ditolak');
    }


}
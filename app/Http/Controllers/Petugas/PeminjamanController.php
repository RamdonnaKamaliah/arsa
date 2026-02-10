<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
// use BaconQrCode\Encoder\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Zxing\QrReader;



class PeminjamanController extends Controller
{
    public function index() {
        $peminjaman = Peminjaman::with('user')->latest()->get();
        return view('petugas.peminjaman.index', compact('peminjaman'));
    }

    public function approve($id){
        $peminjaman = Peminjaman::findOrFail($id);
        
        $peminjaman->status = 'disetujui';
        $peminjaman->save();

        $qrText = "PEMINJAMAN-ID" . $peminjaman->id;
        
        $qrImage = QrCode::format('svg')->size(300)->generate($qrText);

        $fileName = "qr_peminjaman_" . $peminjaman->id . ".svg";

        Storage::disk('public')->put('qrcode/' . $fileName, $qrImage);

        $peminjaman->qr_token = $fileName;
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
    $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);

    $qrText = $request->qr_result;

    // Kalau upload file
    if (!$qrText && $request->hasFile('qr_file')) {
        $qrcode = new QrReader($request->file('qr_file')->getPathname());
        $qrText = $qrcode->text();
    }

    if (!$qrText) {
        return back()->with('error', 'QR tidak terbaca');
    }

    // Validasi QR
    if ($qrText !== 'PEMINJAMAN-ID' . $peminjaman->id) {
        return back()->with('error', 'QR tidak valid, proses dibatalkan');
    }

    // Update peminjaman
    $peminjaman->update([
        'status' => 'diambil',
        'tanggal_pengambilan_sebenarnya' => now(),
    ]);

    return redirect()
        ->route('petugas.peminjaman.index')
        ->with('success', 'QR valid, alat berhasil diambil');
}



}
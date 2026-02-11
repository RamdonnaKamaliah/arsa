<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
// use BaconQrCode\Encoder\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Zxing\QrReader;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index() {
        $peminjaman = Peminjaman::with('user')->latest()->get();
        return view('petugas.peminjaman.index', compact('peminjaman'));
    }

    public function approve($id){
        $peminjaman = Peminjaman::findOrFail($id);
        
        $peminjaman->status = 'disetujui';
        $peminjaman->disetujui_oleh = $peminjaman->id_user;
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
    DB::transaction(function () use ($request) {

        $peminjaman = Peminjaman::with('detail.alat')
            ->findOrFail($request->peminjaman_id);

        // 1️⃣ Validasi status
        if ($peminjaman->status !== 'disetujui') {
            abort(400, 'QR tidak bisa digunakan');
        }

        // 2️⃣ Validasi QR
        $qrText = $request->qr_result;

        if (!$qrText && $request->hasFile('qr_file')) {
            $qrcode = new QrReader($request->file('qr_file')->getPathname());
            $qrText = $qrcode->text();
        }

        if ($qrText !== 'PEMINJAMAN-ID' . $peminjaman->id) {
            abort(400, 'QR tidak valid');
        }

        // 3️⃣ CEK STOK SEMUA ALAT
        foreach ($peminjaman->detail as $detail) {
            if ($detail->alat->stok < $detail->jumlah) {
                abort(400, 'Stok alat ' . $detail->alat->nama_alat . ' tidak mencukupi');
            }
        }

        // 4️⃣ KURANGI STOK
        foreach ($peminjaman->detail as $detail) {
            $alat = $detail->alat;
            $alat->stok -= $detail->jumlah;
            $alat->save();
        }

        // 5️⃣ UPDATE PEMINJAMAN
        $peminjaman->update([
            'status' => 'diambil',
            'tanggal_pengambilan_sebenarnya' => now(),
        ]);
    });

    return redirect()
        ->route('petugas.peminjaman.index')
        ->with('success', 'QR valid, barang berhasil diambil');
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
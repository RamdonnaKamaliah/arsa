<?php

namespace App\Http\Controllers\Petugas;
use Carbon\Carbon;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
   public function index(Request $request)
    {
        $query = Peminjaman::with(['user','detail.alat','pengembalian']);

        if ($request->filter == 'hari') {
            $query->whereDate('tanggal_pinjam', Carbon::today());
        }

        if ($request->filter == 'minggu') {
            $query->whereBetween('tanggal_pinjam', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]);
        }

        if ($request->filter == 'bulan') {
            $query->whereMonth('tanggal_pinjam', Carbon::now()->month)
                  ->whereYear('tanggal_pinjam', Carbon::now()->year);
        }

        $peminjaman = $query->latest()->get();

        return view('petugas.laporan.index', compact('peminjaman'));
    }

     

public function unduh(Request $request)
{
    $query = Peminjaman::with(['user','alat']);

    if ($request->filter == 'hari') {
        $query->whereDate('tanggal_pinjam', Carbon::today());
    }

    if ($request->filter == 'minggu') {
        $query->whereBetween('tanggal_pinjam', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ]);
    }

    if ($request->filter == 'bulan') {
        $query->whereMonth('tanggal_pinjam', Carbon::now()->month)
              ->whereYear('tanggal_pinjam', Carbon::now()->year);
    }

    $peminjaman = $query->get();

    $pdf = Pdf::loadView('petugas.laporan.pdf', compact('peminjaman'))
              ->setPaper('A4', 'portrait');

    return $pdf->download('laporan_peminjaman.pdf');
}


}
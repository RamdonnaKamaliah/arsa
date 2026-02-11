<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class PengembalianAlatController extends Controller
{
   public function index() {
    $peminjaman = Peminjaman::where('id_user', auth()->id())
                    ->where('status', 'kembali') // Menambahkan filter status
                    ->with('user')
                    ->latest()
                    ->get();

    return view('peminjam.peminjamanAlat.index', compact('peminjaman'));
}

}
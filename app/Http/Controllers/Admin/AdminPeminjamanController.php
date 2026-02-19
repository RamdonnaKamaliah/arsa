<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;


class AdminPeminjamanController extends Controller
{
    public function index(){

        $stats = [
    'total_peminjaman' => Peminjaman::count(),
    'total_barangKembali' => Peminjaman::where('status', 'kembali')->count(),
    'total_barangPending' => Peminjaman::where('status', 'pending')->count(),
    'total_barangDitolak' => Peminjaman::where('status', 'ditolak')->count(),
];
    
        $peminjaman = Peminjaman::latest()->get();
        return view('admin.peminjaman.index', compact('peminjaman', 'stats'));
    }

    public function show(String $id) {
        $peminjaman = Peminjaman::findOrFail($id);
        return view ('admin.peminjaman.show', compact('peminjaman'));
    }
}
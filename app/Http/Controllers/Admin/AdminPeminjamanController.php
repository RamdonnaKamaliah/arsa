<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;


class AdminPeminjamanController extends Controller
{
    public function index(){
        $peminjaman = Peminjaman::latest()->get();
        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    public function show(String $id) {
        $peminjaman = Peminjaman::findOrFail($id);
        return view ('admin.peminjaman.show', compact('peminjaman'));
    }
}
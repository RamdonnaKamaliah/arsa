<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;


class AdminPeminjamanController extends Controller
{
    public function index(){
        $peminjaman = Peminjaman::all()->latest()->get();
        return view('admin.peminjaman.index');
    }

    public function show(){
        
}
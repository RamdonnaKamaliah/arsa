<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;

class AdminPengembalianController extends Controller
{
    public function index(){
        $pengembalian = Pengembalian::latest()->get();
        return view('admin.pengembalian.index', compact('pengembalian'));
    }

    public function show(String $id){
        $pengembalian = Pengembalian::findOrFail($id);
        return view('admin.pengembalian.show', compact('pengembalian'));
    }
}
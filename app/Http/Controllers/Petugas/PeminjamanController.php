<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index() {
        return view('petugas.peminjaman.index');
    }

    public function store(Request $request){
        
    } 
}
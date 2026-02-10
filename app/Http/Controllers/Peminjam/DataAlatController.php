<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use Illuminate\Http\Request;

class DataAlatController extends Controller
{
    public function index() {
        $alat = Alat::where('stok', '>', 0)->get();
        return view('peminjam.daftarAlat.index', compact('alat'));
    }

    public function show($id) {
        $alat = Alat::where('id', $id)->firstOrFail();
        return view('peminjam.daftarAlat.show', compact('alat'));
    }
}
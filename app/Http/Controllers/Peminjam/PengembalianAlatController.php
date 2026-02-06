<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengembalianAlatController extends Controller
{
    public function index() {
        return view('peminjam.pengembalianAlat.index');
    }
}
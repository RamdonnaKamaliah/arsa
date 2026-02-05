<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KategoriAlatController extends Controller
{
    public function index() {
        return view('admin.kategori_alat.index');
    }
}
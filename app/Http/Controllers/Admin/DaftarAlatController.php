<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DaftarAlatController extends Controller
{
    public function index(){
        return view('admin.data_alat.index');
    }
}
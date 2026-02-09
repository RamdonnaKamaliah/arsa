<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PeminjamProfileController extends Controller
{
    public function index() {
        
        return view('peminjam.profile.index');
        
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas;


class AdminAktivitasController extends Controller
{
    public function index() {
        $logs = Aktivitas::with('user')->latest()->paginate(10);
        return view('admin.aktivitas.index', compact('logs'));
    }
}
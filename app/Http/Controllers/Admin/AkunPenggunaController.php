<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Password;


class AkunPenggunaController extends Controller
{
    public function index() {
        $akun = User::all();
        return view('admin.data_pengguna.index', compact('akun'));
    }

    public function create() {
        return view('admin.data_pengguna.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:peminjam,petugas'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password' => null,
            'role' => $request->role
        ]);

        Aktivitas::simpanLog('Tambah', 'Akun Pengguna', 'Menambahkan akun pengguna baru:' . $request->name);

        Password::sendResetLink([
            'email' => $user->email
        ]);

        Aktivitas::simpanLog('Tambah', 'Akun Pengguna', 'Menambah akun pengguna:' . $user->name );

        return redirect()->route('admin.akun-pengguna.index')->with('success', 'akun berhasil di buat');
    }

    public function destroy(String $id) {
        $akun = User::where('id', $id)->firstOrFail();

        $namaAkun = $akun->name;
        
        $akun->delete();

        Aktivitas::simpanLog('Hapus', 'Akun Pengguna', 'Menghapus akun pengguna' . $namaAkun);

        return redirect()->route('admin.akun-pengguna.index')->with('success', 'Akun berhasil di hapus');
    }
}
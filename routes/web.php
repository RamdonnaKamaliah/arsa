<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AkunPenggunaController;
use App\Http\Controllers\Admin\DaftarAlatController;
use App\Http\Controllers\Admin\DaftarLaporanController;
use App\Http\Controllers\Admin\KategoriAlatController;
use App\Http\Controllers\Peminjam\DataAlatController;
use App\Http\Controllers\Peminjam\PeminjamanAlatController;
use App\Http\Controllers\Peminjam\PeminjamDashboardController;
use App\Http\Controllers\Peminjam\PengembalianAlatController;
use App\Http\Controllers\Petugas\LaporanController;
use App\Http\Controllers\Petugas\PeminjamanController;
use App\Http\Controllers\Petugas\PengembalianController;
use App\Http\Controllers\Petugas\PetugasDashboardController;
use App\Http\Controllers\ProfileController;
use App\Models\Pengembalian;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/akunPengguna', [AkunPenggunaController::class, 'index'])->name('akunPengguna');
    Route::get('/dataAlat', [DaftarAlatController::class, 'index'])->name('dataAlat');
    Route::get('/kategoriAlat', [KategoriAlatController::class, 'index'])->name('kategoriAlat');
    Route::get('/daftarLaporan', [DaftarLaporanController::class, 'index'])->name('daftarLaporan');
});

//petugas
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {

    Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('dashboard');
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
});

//peminjam
Route::middleware(['auth', 'role:peminjam'])->prefix('peminjam')->name('peminjam.')->group(function () {

    Route::get('/dashboard', [PeminjamDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dataAlat', [DataAlatController::class, 'index'])->name('dataAlat');
    Route::get('/peminjamAlat', [PeminjamanAlatController::class, 'index'])->name('peminjamAlat');
    Route::get('/pengembalianAlat', [PengembalianAlatController::class, 'index'])->name('pengembalianAlat');
});




require __DIR__.'/auth.php';
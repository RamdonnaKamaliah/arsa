<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Peminjam\PeminjamDashboardController;
use App\Http\Controllers\Petugas\PetugasDashboardController;
use App\Http\Controllers\ProfileController;
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
});

//petugas
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {

    Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('dashboard');
});

//peminjam
Route::middleware(['auth', 'role:peminjam'])->prefix('peminjam')->name('peminjam.')->group(function () {

    Route::get('/dashboard', [PeminjamDashboardController::class, 'index'])->name('dashboard');
});




require __DIR__.'/auth.php';
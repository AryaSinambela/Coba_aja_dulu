<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('buku.index'));

// --- Autentikasi ---
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.attempt');
});
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// --- Seluruh rute mutasi: wajib login (letakkan di ATAS rute publik) ---
Route::middleware('auth')->group(function () {
    Route::resource('buku', BukuController::class)->except(['index', 'show']);
    Route::resource('kategori', KategoriController::class)->except(['index', 'show']);

    Route::post('buku/{id}/pinjam', [PeminjamanController::class, 'pinjam'])->whereNumber('id')->name('buku.pinjam');
    Route::get('peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::patch('peminjaman/{id}/kembali', [PeminjamanController::class, 'kembali'])->whereNumber('id')->name('peminjaman.kembali');
});

// --- Katalog publik (hanya baca) ---
Route::resource('buku', BukuController::class)->only(['index', 'show']);
Route::resource('kategori', KategoriController::class)->only(['index', 'show']);
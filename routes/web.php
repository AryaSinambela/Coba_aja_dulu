<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('buku.index'));

Route::resource('buku', BukuController::class);
Route::resource('kategori', KategoriController::class);
use App\Http\Controllers\PeminjamanController;

Route::post('buku/{id}/pinjam', [PeminjamanController::class, 'pinjam'])->whereNumber('id')->name('buku.pinjam');
Route::get('peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
Route::patch('peminjaman/{id}/kembali', [PeminjamanController::class, 'kembali'])->whereNumber('id')->name('peminjaman.kembali');
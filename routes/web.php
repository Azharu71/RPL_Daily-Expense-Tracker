<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnggaranController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Auth routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'tampil'])->name('dashboard');

    // Transaksi
    Route::get('/transaksi',               [TransaksiController::class, 'indeks'])->name('transaksi.indeks');
    Route::get('/transaksi/tambah',        [TransaksiController::class, 'tampilTambah'])->name('transaksi.tambah');
    Route::post('/transaksi/simpan',       [TransaksiController::class, 'simpan'])->name('transaksi.simpan');
    Route::get('/transaksi/{id}/ubah',     [TransaksiController::class, 'tampilUbah'])->name('transaksi.ubah');
    Route::put('/transaksi/{id}/perbarui', [TransaksiController::class, 'perbarui'])->name('transaksi.perbarui');
    Route::delete('/transaksi/{id}/hapus', [TransaksiController::class, 'hapus'])->name('transaksi.hapus');

    // Kategori
    Route::get('/kategori',                   [KategoriController::class, 'indeks'])->name('kategori.indeks');
    Route::post('/kategori/simpan',           [KategoriController::class, 'simpan'])->name('kategori.simpan');
    Route::put('/kategori/{id}/perbarui',     [KategoriController::class, 'perbarui'])->name('kategori.perbarui');
    Route::delete('/kategori/{id}/hapus',     [KategoriController::class, 'hapus'])->name('kategori.hapus');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'tampil'])->name('laporan.indeks');

    // Anggaran
    Route::get('/anggaran',        [AnggaranController::class, 'tampil'])->name('anggaran.indeks');
    Route::post('/anggaran/simpan', [AnggaranController::class, 'simpan'])->name('anggaran.simpan');
    Route::delete('/anggaran/{id}/hapus', [AnggaranController::class, 'hapus'])->name('anggaran.hapus');
});

<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'register' => false,
]);

// Route General
Route::namespace('Web')->middleware('auth')->group(function () {
    // Admin
    Route::get('/dashboard/admin', 'HomeController@admin')->name('home')->middleware('admin.web');
    Route::get('admin/settings', 'HomeController@settings')->name('admin.settings');

    // Staf
    Route::get('/dashboard/staff', 'HomeController@staf')->name('staf')->middleware('auth', 'staf.web');

    // Kasir
    Route::get('/kasir', 'HomeController@kasir')->name('kasir');
});

// Route Kasir
Route::namespace('Web\Kasir')->middleware('auth')->group(function () {
    // Keranjang
    Route::get('/hapus/keranjang/{keranjang}', 'KasirController@hapusKeranjang');
    Route::get('/transaksi-belumselesai', 'KasirController@belumSelesai');
    Route::post('/tambah/keranjang', 'KasirController@keranjang');

    // transaksi
    Route::post('/bayar', 'KasirController@bayar')->name('bayar.cash');
    Route::post('/bayar/member', 'KasirController@bayarMember')->name('bayar.saldo');
    Route::post('/transaksi/cancel', 'KasirController@destroy')->name('transaksi.cancel');

    // Topup saldo
    Route::post('/cari-member', 'KasirController@cari');
    Route::post('/isi-saldo', 'KasirController@isiSaldo');

    // Cetak
    Route::post('/cetak-penjualan', 'KasirController@cetak');
});

// Lupa Password Member
Route::get('/password/reset/{token}/{nomor}', 'Web\LupaPassword@index');
Route::post('/lupa/password', 'Web\LupaPassword@ubahPassword')->name('resetPassword');

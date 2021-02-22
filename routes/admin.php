<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// Laporan
Route::get('/laporan', 'LaporanController@index')->name('admin.laporan');

// Member
Route::get('/daftar-member', 'MemberController@index')->name('admin.member');
Route::get('/member/{member}', 'MemberController@show')->name('admin.member.show');
Route::post('/daftar-member', 'MemberController@cari')->name('admin.member.cari');
Route::delete('/member/delete/{member}', 'MemberController@destroy');

// Karyawan
Route::get('/daftar-karyawan', 'KaryawanController@index')->name('admin.karyawan');
Route::get('/karyawan/{user}', 'KaryawanController@show')->name('admin.karyawan.show');
Route::post('/add-karyawan', 'KaryawanController@store')->name('admin.karyawan.store');
Route::post('/daftar-karyawan', 'KaryawanController@cari')->name('admin.karyawan.cari');
Route::post('/daftar-karyawan/staf', 'KaryawanController@staf')->name('admin.karyawan.staf');
Route::post('/daftar-karyawan/kasir', 'KaryawanController@kasir')->name('admin.karyawan.kasir');
Route::delete('/karyawan/delete/{user}', 'KaryawanController@destroy');

// Supplier
Route::get('daftar-supplier', 'SupplierController@index')->name('admin.supplier');
Route::post('/daftar-supplier', 'SupplierController@cari')->name('admin.supplier.cari');

// Produk
Route::get('/daftar-produk', 'ProdukController@index')->name('admin.produk');
Route::get('/produk/{barang}', 'ProdukController@show')->name('admin.produk.show');
Route::post('/daftar-produk', 'ProdukController@cari')->name('admin.produk.cari');

// pengeluaran
Route::get('/pengeluaran', 'PengeluaranController@index')->name('admin.pengeluaran');
Route::post('/add-pengeluaran', 'PengeluaranController@store')->name('admin.pengeluaran.store');

// Aktivitas
Route::get('/aktivitas-karyawan', 'AktivitasController@index')->name('admin.aktivitas');
Route::post('/aktivitas-karyawan', 'AktivitasController@cari')->name('admin.aktivitas.cari');

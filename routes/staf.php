<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Staf Routes
|--------------------------------------------------------------------------
*/

// Pembelian
Route::get('/daftar-pembelian', 'PembelianController@index')->name('staf.pembelian');
Route::get('/tambah-pembelian', 'PembelianController@create')->name('staf.pembelian.create');
Route::get('/cetak-pembelian/{pembelian}', 'PembelianController@cetak')->name('pembelian.cetak');

Route::post('/daftar-pembelian', 'PembelianController@cari')->name('staf.pembelian.cari');
Route::post('/tambah-supplier', 'PembelianController@addSupplier')->name('staf.pembelian.addSupplier');
Route::post('/tambah-pembelian', 'PembelianController@store')->name('staf.pembelian.store');

// Produk
Route::get('/daftar-produk', 'ProdukController@index')->name('staf.produk');
Route::post('/daftar-produk', 'ProdukController@cari')->name('staf.produk.cari');

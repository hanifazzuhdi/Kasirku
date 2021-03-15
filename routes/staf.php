<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Staf Routes
|--------------------------------------------------------------------------
*/

// Tambah komponen
Route::post('/tambah-supplier', 'StaffController@addSupplier')->name('staf.pembelian.addSupplier');
Route::post('/tambah-kategori', 'StaffController@addKategori')->name('staf.pembelian.addKategori');
Route::post('/tambah-merek', 'StaffController@addMerek')->name('staf.pembelian.addMerek');

// Pembelian
Route::get('/daftar-pembelian', 'PembelianController@index')->name('staf.pembelian');
Route::get('/tambah-pembelian', 'PembelianController@create')->name('staf.pembelian.create');
Route::get('/cetak-pembelian/{pembelian}', 'PembelianController@cetak')->name('pembelian.cetak');

Route::post('/daftar-pembelian', 'PembelianController@cari')->name('staf.pembelian.cari');
Route::post('/tambah-pembelian', 'PembelianController@store')->name('staf.pembelian.store');

// Produk
Route::get('/daftar-produk', 'ProdukController@index')->name('staf.produk');
Route::get('/produk/{barang}', 'ProdukController@show')->name('staf.produk.show');
Route::get('/tambah-produk', 'ProdukController@create')->name('staf.produk.create');

Route::post('/tambah-produk', 'ProdukController@store')->name('staf.produk.store');
Route::post('/daftar-produk', 'ProdukController@cari')->name('staf.produk.cari');
Route::post('/update-produk/{barang}', 'ProdukController@update')->name('staf.produk.update');

Route::delete('/delete-produk/{barang}', 'ProdukController@destroy');

<?php

use Illuminate\Support\Facades\Route;

// Route auth
Route::group(['namespace' => 'Auth'], function () {
    // login semua role
    Route::post('/login', 'LoginController@login');
    Route::post('/logout', 'LogoutController@logout')->middleware('jwt.auth');

    // register member
    Route::post('/register', 'RegisterController@register');

    // Verifikasi OTP
    Route::post('/verify', 'VerificationController@verify');
    Route::post('/resend', 'VerificationController@resend');

    // forgot password
    Route::post('/forgot-password', 'ForgotPasswordController@forgot');
});

// Route Pimpinan
Route::group(['namespace' => 'Pimpinan', 'middleware' => 'jwt.auth'], function () {
    // stok => pilih uid barang terlebih dulu
    Route::get('/laporan-stok', "LaporanController@stok");

    //pembelian
    Route::get('/laporan-pembelian', 'LaporanController@allPembelian');
    Route::post('/laporan-pembelian', 'LaporanController@pembelian');

    // Penjualan
    Route::get('/laporan-penjualan', 'LaporanController@allPenjualan');
    Route::post('/laporan-penjualan', 'LaporanController@penjualan');

    // Laba Rugi
    Route::get('/laporan/laba-rugi', 'LabaRugiController@show');
    Route::post('/laporan/laba-rugi', 'LabaRugiController@cari');

    // Total pengeluaran => 2. pengeluaran
    Route::get('/laporan-pengeluaran', 'PengeluaranController@index');
    Route::post('/laporan-pengeluaran', 'PengeluaranController@show');
    Route::post('/add-pengeluaran', 'PengeluaranController@store');

    // Pemasukan
    Route::get('/laporan-pemasukan', 'PemasukanController@index');
    Route::post('/laporan-pemasukan', 'PemasukanController@show');

    // Ansensi Karyawan
    Route::get('/absen-harian', 'AbsenController@harian');
    Route::post('/absen-bulanan', 'AbsenController@bulanan');
});

// Staff
Route::group(['namespace' => 'Staff', 'middleware' => 'jwt.auth'], function () {
    // supplier
    Route::get('/supplier', 'SupplierController@index');
    Route::post('/add-supplier', 'SupplierController@store');

    // kategori
    Route::get('/kategori', 'KategoriController@index');
    Route::post('/add-kategori', 'KategoriController@store');
    Route::delete('/hapus-kategori/{id}', 'KategoriController@delete');

    // Merek
    Route::get('/merek', 'MerekController@index');
    Route::post('/add-merek', 'MerekController@store');

    // barang
    Route::get('/barang', 'BarangController@index');
    Route::get('/barang/{uid}', 'BarangController@show');
    Route::post('/add-barang', 'BarangController@store');
    Route::post('/update-barang/{barang}', 'BarangController@update');
    Route::delete('/delete-barang/{barang}', 'BarangController@delete');

    // pembelian
    Route::get('/pembelian', 'PembelianController@index');
    Route::post('/add-pembelian', 'PembelianController@store');
    Route::post('/update-pembelian/{id}', 'PembelianController@updateStatus');
});

// Kasir
Route::group(['namespace' => 'Kasir', 'middleware' => 'jwt.auth'], function () {
    // penjualan
    Route::get('/keranjang', 'KeranjangController@index');
    Route::post('/add-keranjang', 'KeranjangController@store');
    Route::delete('/hapus/keranjang/{keranjang}', 'KeranjangController@destroy');

    // bayar pakai cash
    Route::post('/add-transaksi', 'TransaksiController@store');
    Route::delete('/delete-transaksi', 'TransaksiController@destroy');

    // bayar pakai saldo
    Route::post('/transaksi-member', 'TransaksiController@bayarSaldo');
});

// Staff + Kasir
Route::group(['middleware' => ['jwt.auth']], function () {
    Route::get('/profile', 'UserController@show');
    Route::post('/update-profile', 'UserController@update');
});

// Member
Route::group(['namespace' => 'Member'], function () {
    // Member
    Route::get('/get-member', 'MemberController@index');
    Route::post('/change-password', 'MemberController@change');

    // Saldo
    Route::get('/saldo', 'SaldoController@index');
    Route::get('/transaksi', 'SaldoController@transaksi');
    Route::get('/daftar-bank', 'SaldoController@bank');

    Route::post('/isi-saldo', 'SaldoController@isiSaldo');
    Route::post('/payments', 'SaldoController@store');
    Route::post('/notif/payments', 'SaldoController@webhooks');
});

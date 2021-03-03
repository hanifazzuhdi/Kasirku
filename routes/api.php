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


/** Pimpinan
 *  1. Laporan
 *  2. Laporan harian - bulanan
 *
 */
Route::group(['namespace' => 'Pimpinan', 'middleware' => 'jwt.auth'], function () {
    // stok => pilih uid barang terlebih dulu
    Route::get('/laporan-stok', "LaporanController@stok");

    //pembelian
    Route::get('/laporan-pembelian', 'LaporanController@allPembelian');
    Route::post('/laporan-pembelian', 'LaporanController@pembelian');

    // Penjualan / pemasukan
    Route::get('/laporan-penjualan', 'LaporanController@allPenjualan');
    Route::post('/laporan-penjualan', 'LaporanController@penjualan');

    // Laba Rugi
    Route::post('/laporan/laba-rugi', 'LabaRugiController@show');

    // Total pengeluaran => 1. pembelian 2. pengeluaran
    Route::get('/laporan-pengeluaran', 'PengeluaranController@index');
    Route::post('/laporan-pengeluaran', 'PengeluaranController@show');
    Route::post('/add-pengeluaran', 'PengeluaranController@store');
});


/** Staf
 *  1. Data supplier
 *  2. Buat supplier
 *  3. Kategori
 *  4. Barang
 *  5. Pembelian / stok masuk
 */
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


/** Kasir
 *  1. Transaksi/Penjualan
 *  2. isi saldo member
 */
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


/** Staf + Kasir
 *
 */
Route::group(['middleware' => ['jwt.auth']], function () {
    // Karyawan
    Route::get('/profile', 'UserController@show');
    Route::post('/update-profile', 'UserController@update');
});


/** Member
 *  1. Member
 *  2. Saldo
 */
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

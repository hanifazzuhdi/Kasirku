<?php

use Illuminate\Support\Facades\Route;
use Milon\Barcode\Facades\DNS1DFacade;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/coba', function () {

    echo '<img src="data:image/png;base64,' . DNS1DFacade::getBarcodePNG('12-232323', 'C39', 1, 33) . '" alt="barcode"   />';
});

Route::get('/png', function () {
    //
});

// Route auth
Route::group(['namespace' => 'Auth'], function () {
    // Route::get('/email/resend', 'VerificationController@resend')->name('verification.resend');
    // Route::get('/email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');

    Route::post('/login', 'LoginController@login');             // login semua role

    Route::post('/register', 'RegisterController@register');    // register member

    Route::post('/verify', 'VerificationController@verify');     // verifikasi otp member
    Route::post('/resend', 'VerificationController@resend');    // kirim ulang otp
});


// Pimpinan


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

    // barang
    Route::get('/barang', 'BarangController@index');
    Route::post('/add-barang', 'BarangController@store');

    // pembelian
    Route::get('/pembelian', 'PembelianController@index');
    Route::post('/add-pembelian', 'PembelianController@store');
    Route::post('/update-pembelian/{id}', 'PembelianController@updateStatus');
});


// Kasir


// Staf + Kasir
Route::post('/update-profile', 'UserController@update');     // update prodile staf dan kasir


// Member
Route::post('/change-password', 'MemberController@change');  // update password member

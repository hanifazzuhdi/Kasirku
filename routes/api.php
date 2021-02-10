<?php

use App\Models\Barang;
use App\Models\Member;
use Illuminate\Support\Facades\Route;
use Milon\Barcode\Facades\DNS1DFacade;
use Milon\Barcode\Facades\DNS2DFacade;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
    // echo DNS2DFacade::getBarcodeHTML($member->kode_member, 'QRCODE');
    // echo  DNS1DFacade::getBarcodeSVG('12-' . str_split(time(), 5)[1] . random_int(10, 30), 'C39', 1, 33);
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

    // barang
    Route::get('/barang', 'BarangController@index');
    Route::post('/add-barang', 'BarangController@store');

    // pembelian
    Route::get('/pembelian', 'PembelianController@index');
    Route::post('/add-pembelian', 'PembelianController@store');
});


// Kasir


// Staf + Kasir
Route::post('/update-profile', 'UserController@update');     // update prodile staf dan kasir


// Member
Route::post('/change-password', 'MemberController@change');  // update password member

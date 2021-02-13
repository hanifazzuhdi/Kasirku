<?php

use App\Models\Barang;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

// Route::get('/email/resend', 'VerificationController@resend')->name('verification.resend');
// Route::get('/email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');


Route::get('/coba', function () {
    $user = Barang::find(21);

    return $user->barcode;
});

Route::post('/coba', function (Request $request) {

    $order_id = Str::upper($request->bank) . "-" . random_int(10000, 99999) . '-2';

    $res = Http::withBasicAuth('SB-Mid-server-P_D1Q6IGgH4b-_YqgY6Ybnra', '')
        ->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])
        ->post('https://api.sandbox.midtrans.com/v2/charge', [
            "payment_type" => "bank_transfer",

            "transaction_details" => [
                "gross_amount" => $request->jumlah,
                "order_id" => $order_id
            ],

            "customer_details" => [
                "email" => "0005210593721",
                "first_name" => "Zen",
                "phone" => "+6285210593721"
            ],

            "bank_transfer" => [
                "bank" => $request->bank,
            ]
        ]);

    Payment::create([
        'order_id' => $order_id,
        'jumlah' => $request->jumlah,
        "kode_member" => "0005210593721",
        "nama_member" => "Zen",
        "nomor_member" => "+6285210593721",
        'bank' => $request->bank
    ]);

    dd($res->json());
});

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
    Route::get('/laporan-pembelian/{tanggalAwal}/{tanggalAkhir}', 'LaporanController@pembelian');
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

    // barang
    Route::get('/barang', 'BarangController@index');
    Route::get('/barang/{uid}', 'BarangController@show');
    Route::post('/add-barang', 'BarangController@store');
    Route::post('/update-barang', 'BarangController@update');
    Route::delete('/delete-barang', 'BarangController@delete');

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
    Route::post('/add-transaksi', 'TransaksiController@store');
});


/** Staf + Kasir
 *
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
 *
 */
Route::group(['namespace' => 'Member'], function () {
    // Member
    Route::post('/change-password', 'MemberController@change');

    // Saldo
    Route::get('/saldo', 'SaldoController@index');
    Route::get('/transaksi', 'SaldoController@transaksi');

    Route::post('/isi-saldo', 'SaldoController@isiSaldo');
    Route::post('/payments', 'SaldoController@store');
    Route::post('/notif/payments', 'SaldoController@webhooks');
});

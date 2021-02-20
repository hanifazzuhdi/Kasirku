<?php

use App\Models\Member;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Milon\Barcode\Facades\DNS1DFacade;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $datas = Payment::get();

    return view('welcome', compact('datas'));
});

Auth::routes([
    'register' => false
]);

// Route General
Route::group(['middleware' => 'auth', 'namespace' => 'Web'], function () {
    Route::get('/dashboard', 'HomeController@index')->name('home');
});

// Route Admin
Route::group(['middleware' => ['auth', 'admin.web'], 'namespace' => 'Web\Admin', 'prefix' => 'admin'], function () {
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
});


// route percobaan
Route::get('/{token}/{nomor}', function ($token, $nomor) {
    $db = DB::select("SELECT * FROM password_resets WHERE token = '$token' AND email = '$nomor'");

    if (!$db) {
        return abort('404');
    }

    return view('welcome', compact('nomor', 'token'));
});

Route::post('/lupa/password', function (Request $request) {

    $request->validate([
        'password' => 'required|confirmed'
    ]);

    $member = Member::where('nomor', $request->nomor)->first();

    $status = $member->update([
        'password' => Hash::make($request->password)
    ]);

    if ($status) {
        DB::delete("DELETE FROM password_resets WHERE token = '$request->token' AND email = '$request->nomor'");

        return response()->json(['status' => 'berhasil diubah']);
    } else {
        return response()->json(['status' => 'gagal ubah password']);
    }
});

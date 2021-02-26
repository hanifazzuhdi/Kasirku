<?php

use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes([
    'register' => false,
]);

// Route General
Route::namespace('Web')->middleware('auth')->group(function () {
    // Admin
    Route::get('/dashboard/admin', 'HomeController@admin')->name('home')->middleware('auth', 'admin.web');
    // Staf
    Route::get('/dashboard/staff', 'HomeController@staf')->name('staf')->middleware('auth', 'staf.web');

    // Kasir
    Route::get('/kasir', 'HomeController@kasir')->name('kasir');
    Route::post('/tambah/keranjang', 'HomeController@keranjang');
});

// Lupa Password Member
Route::get('/password/reset/{token}/{nomor}', 'Web/LupaPassword@index');
Route::post('/lupa/password', 'Web/LupaPassword@ubahPassword')->name('resetPassword');

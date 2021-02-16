<?php

use App\Models\Member;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
    $datas = Payment::get();

    return view('welcome', compact('datas'));
});

Auth::routes();

// Route General
Route::group(['middleware' => 'auth', 'namespace' => 'Web'], function () {
    Route::get('/dashboard', 'HomeController@index')->name('home');
});

// Route Admin
Route::group(['middleware' => 'auth', 'namespace' => 'Web\Admin', 'prefix' => 'admin'], function () {
    // Member
    Route::get('/daftar-member', 'MemberController@index')->name('admin.member');
    Route::get('/member/{member}', 'MemberController@show')->name('admin.member.show');
    Route::post('/daftar-member', 'MemberController@cari')->name('admin.member.cari');
    Route::delete('/member/delete/{id}', 'MemberController@destroy');
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

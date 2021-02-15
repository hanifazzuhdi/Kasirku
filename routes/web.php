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

Route::get('/home', 'HomeController@index')->name('home');


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

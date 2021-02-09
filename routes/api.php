<?php

use Illuminate\Support\Facades\Route;

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

// Route auth
Route::group(['namespace' => 'Auth'], function () {
    Route::get('/email/resend', 'VerificationController@resend')->name('verification.resend');
    Route::get('/email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');

    Route::post('/register', 'RegisterController@register');    // register admin
    Route::post('/login', 'LoginController@login');             // login semua role
});


Route::group(['middleware' => ['jwt.auth']], function () {
    // Suplier
    // Route::get('/supplier',);

    Route::post('update-profile', 'UserController@update');    // update profile user
});


Route::get('/coba', function () {
    return "halo";
})->middleware('jwt.auth');

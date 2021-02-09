<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $this->validation($request);

        DB::transaction(function () use ($request) {
            User::create([
                'nama' => $request->input('nama'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'role_id' => 1
            ])->sendEmailVerificationNotification();
        });

        return response([
            'status' => 'success',
            'message' => 'User berhasil dibuat, silahkan verifikasi email anda'
        ], 201);
    }

    public function validation($request)
    {
        return $request->validate([
            'nama' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);
    }
}

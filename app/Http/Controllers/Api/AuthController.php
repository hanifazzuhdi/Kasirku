<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->input('email'))->first();

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'isi Username dan Password dengan benar'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user->update([
            'remember_token' => $token
        ]);

        return response()->json(compact('user', 'token'));
    }

    public function register(Request $request)
    {
        $this->validation($request);

        DB::transaction(function () use ($request) {
            User::create([
                'nama' => $request->input('nama'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ])->sendEmailVerificationNotification();
        });

        return response([
            'status' => 'berhasil',
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

<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str;
use Namshi\JOSE\Signer\OpenSSL\HS256;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        $credentials = $request->only('email', 'password');

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
}

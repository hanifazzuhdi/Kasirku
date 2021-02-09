<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $loginType = filter_var($request->email, FILTER_VALIDATE_EMAIL)  ? 'email' : 'nomor';

        if ($loginType == 'nomor') {
            return $this->memberLogin($request);
        }

        $user = User::where('email', $request->email)->first();

        $credentials = [
            $loginType => $request->email,
            'password' => $request->password
        ];

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'isi Username dan Password dengan benar'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('user', 'token'));
    }

    protected function memberLogin($request)
    {
        $user = Member::where('nomor', $request->email)->first();

        $credentials = [
            'nomor' => $request->email,
            'password' => $request->password
        ];

        try {
            if (!$token = auth('member')->attempt($credentials)) {
                return response()->json(['error' => 'isi Username dan Password dengan benar'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('user', 'token'));
    }
}

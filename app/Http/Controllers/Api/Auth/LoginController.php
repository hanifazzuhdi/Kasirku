<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use App\Models\Member;
use App\Events\LoginKaryawan;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{
    // Login Karyawan
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

        if ($user->role_id != 1) {
            event(new LoginKaryawan($request->email, 'Mobile', 'Login'));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil Login',
            'data' => $user->only('role_id', 'is_verified',),
            'token' => $token
        ]);
    }

    // Login Member
    protected function memberLogin($request)
    {
        $nomor = $this->formatNumber($request);

        $user = Member::where('nomor', $nomor)->first();

        if ($user == null) {
            return $this->sendResponse('failed', 'Akun tidak terdaftar', null, 404);
        } else if ($user->is_verified == 0) {
            return $this->sendResponse('failed', 'Akun belum terverifikasi', null, 400);
        }

        $credentials = [
            'nomor' => $nomor,
            'password' => $request->password
        ];

        try {
            if (!$token = auth('member')->attempt($credentials)) {
                return response()->json(['error' => 'isi Username dan Password dengan benar'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil Login',
            'data' => $user->only('role_id', 'is_verified',),
            'token' => $token
        ]);
    }

    // Format nomor telpon
    public function formatNumber($request)
    {
        if (str_contains($request->email, '+62') and str_split($request->email, 3)[0] == '+62') {
            $nomor = $request->email;
        } else {
            $nomor = str_split($request->email, 2);

            if ($nomor[0] === '08') {

                unset($nomor[0]);

                $nomor = '+628' . implode($nomor);
            } else {
                return $this->sendResponse('failed', 'input nomor dengan benar', null, 404);
            }
        }

        return $nomor;
    }
}

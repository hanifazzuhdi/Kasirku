<?php

namespace App\Http\Controllers\Api\Auth;

use App\Events\LoginKaryawan;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{
    /**
     * Method Login for Staff or Kasir
     *
     *
     */
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

        event(new LoginKaryawan($request->email, 'Mobile', 'Login'));

        return response()->json(compact('user', 'token'));
    }

    /**
     * Method login for member
     *
     *
     */
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

        return response()->json(compact('user', 'token'));
    }

    /**
     * format number phone member, change 08 to +62
     *
     *
     */
    public function formatNumber($request)
    {
        if (str_contains($request->input('email'), '+62') and str_split($request->input('email'), 3)[0] == '+62') {
            $nomor = $request->input('email');
        } else {
            $nomor = str_split($request->input('email'), 2);

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

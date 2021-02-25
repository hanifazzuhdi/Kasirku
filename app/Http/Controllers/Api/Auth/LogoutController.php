<?php

namespace App\Http\Controllers\Api\Auth;

use App\Events\LoginKaryawan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutController extends Controller
{
    /**
     *  Method for destroy token
     *
     */
    public function logout()
    {
        $user = Auth::user();

        JWTAuth::invalidate(Auth::id());

        if ($user->role_id != 1) {
            event(new LoginKaryawan($user->email, 'Mobile', 'Logout'));
        }

        return response([
            'status' => 'success',
            'message' => 'Token deleted successfully'
        ], 200);
    }
}

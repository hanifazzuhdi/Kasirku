<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Providers\MessageProvider;
use App\Http\Controllers\Controller;

class ForgotPasswordController extends Controller
{
    /**
     * lupa password
     *
     */
    public function forgot(Request $request)
    {
        $this->validation($request);

        $nomor = $this->formatNumber($request);

        $member = Member::where('nomor', $nomor)->first();

        if ($member == null) {
            return $this->sendResponse('failed', 'Nomor belum terdaftar', null, 400);
        }

        $token = Str::random(30);

        DB::insert("INSERT INTO password_resets VALUES ('$nomor','$token', now())");

        MessageProvider::sendMessage($nomor, $token);

        return response([
            'status'  => 'success',
            'message' => 'Link ubah password berhasil dikirim',
            'data'    => $nomor
        ], 201);
    }

    /**
     * validasi request
     *
     */
    public function validation($request)
    {
        return $this->validate($request, [
            'nomor' => 'required'
        ]);
    }
}

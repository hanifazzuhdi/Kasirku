<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Member;

use Illuminate\Http\Request;
use App\Providers\MessageProvider;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

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

        $pesan = new MessageProvider();
        $pesan->sendMessage($nomor);

        // $res = Http::get('https://websms.co.id/api/smsgateway', [
        //     'token' => 'cfb5b569ba4dd350fd94d800e479810d',
        //     'to' => '085883241556',
        //     'msg' => urlencode('Link Lupa Password Anda : https://project-mini.herokuapp.com/AcZ8uzpHLRXmbxAH46usgvJMURZBLv/+628999981907')
        // ]);

        // return response($res);


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

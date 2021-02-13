<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Twilio\Rest\Client;

class ForgotPasswordController extends Controller
{
    protected $token, $twilio_sid, $twilio_verify_sid;

    /**
     * Construct method for assign property
     *
     */
    public function __construct()
    {
        $this->token = getenv("TWILIO_AUTH_TOKEN");
        $this->twilio_sid = getenv("TWILIO_SID");
        $this->twilio_verify_sid = getenv("TWILIO_MESSAGE_SID");

        $this->middleware('throttle:10,1')->only('verify', 'resend');
    }

    /**
     * lupa password
     *
     */
    public function forgot(Request $request)
    {
        $this->validate($request, [
            'nomor' => 'required'
        ]);

        $nomor = $this->formatNumber($request);

        $member = Member::where('nomor', $nomor)->first();

        if ($member == null) {
            return $this->sendResponse('failed', 'Nomor belum terdaftar', null, 400);
        }

        $token = \Str::random(20);

        DB::insert("INSERT INTO password_resets VALUES ('$nomor','$token', now())");

        $twilio = new Client($this->twilio_sid, $this->token);

        $twilio->messages
            ->create(
                '+628999981907',
                [
                    'messagingServiceSid' => $this->twilio_verify_sid,
                    'body' => "Ini link lupa password anda : https://project-mini.herokuapp.com/{$nomor}/{$token}"
                ]
            );

        return response([
            'status'  => 'success',
            'message' => 'OTP berhasil dikirim ulang',
            'data'    => $nomor
        ], 201);
    }
}

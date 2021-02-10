<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;
use Twilio\Rest\Client;

class VerificationController extends Controller
{
    protected $token, $twilio_sid, $twilio_verify_sid;

    /**
     * Construc method for assign property
     *
     */
    public function __construct()
    {
        $this->token = getenv("TWILIO_AUTH_TOKEN");
        $this->twilio_sid = getenv("TWILIO_SID");
        $this->twilio_verify_sid = getenv("TWILIO_VERIFY_SID");

        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * function for verification otp from sms
     *
     */
    protected function verify(Request $request)
    {
        $data = $request->validate([
            'kode' => ['required', 'numeric'],
            'nomor' => ['required', 'string'],
        ]);

        // Verification Checks
        $twilio = new Client($this->twilio_sid, $this->token);

        $verification = $twilio->verify->v2->services($this->twilio_verify_sid)
            ->verificationChecks
            ->create(
                $data['kode'],
                [
                    'to' => $data['nomor']
                ]
            );

        if ($verification->valid) {
            $user = tap(Member::where('nomor', $data['nomor']))->update(['is_verified' => true]);

            return response()->json([
                'status' => 'success',
                'message' => 'Akun berhasi diverifikasi'
            ], 200);
        } else {
            return $this->sendResponse('failed', 'Akun sudah diverifikasi', null, 400);
        }
    }

    public function resend(Request $request)
    {
        $data = $this->validate($request, [
            'nomor' => 'required'
        ]);

        $twilio = new Client($this->twilio_sid, $this->token);

        $twilio->verify->v2->services($this->twilio_verify_sid)
            ->verifications
            ->create($data['nomor'], "sms");

        return response([
            'status' => 'success',
            'message' => 'OTP berhasil dikirim ulang'
        ], 201);
    }
}

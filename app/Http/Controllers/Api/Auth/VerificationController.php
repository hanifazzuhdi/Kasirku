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
     * Construct method for assign property
     *
     */
    public function __construct()
    {
        $this->token = getenv("TWILIO_AUTH_TOKEN");
        $this->twilio_sid = getenv("TWILIO_SID");
        $this->twilio_verify_sid = getenv("TWILIO_VERIFY_SID");

        // $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * function for verification otp from sms
     *
     */
    protected function verify(Request $request)
    {
        $request->validate([
            'kode' => ['required', 'numeric'],
            'nomor' => ['required', 'string'],
        ]);

        $nomor = $this->formatNumber($request);

        $member = Member::where('nomor', $nomor)->first();
        if ($member->is_verified == 1) {
            return $this->sendResponse('failed', 'Nomor sudah diverifikasi', null, 404);
        }

        // Verification Checks
        $twilio = new Client($this->twilio_sid, $this->token);

        $verification = $twilio->verify->v2->services($this->twilio_verify_sid)
            ->verificationChecks
            ->create(
                $request->input('kode'),
                [
                    'to' => $nomor
                ]
            );

        if ($verification->valid) {
            $user = tap(Member::where('nomor', $nomor))->update(['is_verified' => 1]);

            return response()->json([
                'status' => 'success',
                'message' => 'Akun berhasil diverifikasi'
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Kode OTP Salah'
            ], 404);
        }
    }

    public function resend(Request $request)
    {
        $this->validate($request, [
            'nomor' => 'required'
        ]);

        $nomor = $this->formatNumber($request);

        $member = Member::where('nomor', $nomor)->first();

        if ($member == null) {
            return $this->sendResponse('failed', 'Nomor belum terdaftar', null, 400);
        }

        $twilio = new Client($this->twilio_sid, $this->token);

        $twilio->verify->v2->services($this->twilio_verify_sid)
            ->verifications
            ->create($nomor, "sms");

        return response([
            'status'  => 'success',
            'message' => 'OTP berhasil dikirim ulang',
            'data'    => $nomor
        ], 201);
    }
}

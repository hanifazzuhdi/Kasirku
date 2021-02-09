<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Twilio\Rest\Client;

class RegisterController extends Controller
{
    public $token, $twilio_sid, $twilio_verify_sid;

    public function __construct()
    {
        $this->token = getenv("TWILIO_AUTH_TOKEN");
        $this->twilio_sid = getenv("TWILIO_SID");
        $this->twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
    }


    public function register(Request $request)
    {
        $this->validation($request);

        DB::transaction(function () use ($request) {
            $kode_member = '00' . $request->input('nomor');

            $qrCode = QrCode::generate($kode_member);

            $user = Member::create([
                'nomor' => $request->input('nomor'),
                'nama' => $request->input('nama'),
                'password' => Hash::make($request->input('password')),
                'kode_member' => $kode_member,
                'qrCode' => $qrCode,
                'role_id' => 4
            ]);

            // send sms
            // $twilio = new Client($this->twilio_sid, $this->token);
            // $twilio->verify->services($this->twilio_verify_sid)
            //     ->verifications
            //     ->create($user->nomor, "sms");
        });

        return response([
            'status' => 'success',
            'message' => 'Member berhasil dibuat'
        ], 201);
    }

    public function validation($request)
    {
        return $request->validate([
            'nomor' => 'required|unique:members',
            'nama' => 'required',
            'password' => 'required',
        ]);
    }

    protected function verify(Request $request)
    {
        $data = $request->validate([
            'verification_code' => ['required', 'numeric'],
            'phone_number' => ['required', 'string'],
        ]);

        /* Get credentials from .env */
        $twilio = new Client($this->twilio_sid, $this->token);

        $verification = $twilio->verify->services($this->twilio_verify_sid)
            ->verificationChecks
            ->create($data['verification_code'], array('to' => $data['phone_number']));

        if ($verification->valid) {
            $user = tap(Member::where('phone_number', $data['phone_number']))->update(['isVerified' => true]);

            /* Authenticate user */
            Auth::login($user->first());

            return response([
                'message' => 'Phone number verified'
            ]);
        }
        return response([
            'message' => 'gagal'
        ]);
    }
}

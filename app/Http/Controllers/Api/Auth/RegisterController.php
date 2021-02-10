<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Twilio\Rest\Client;

class RegisterController extends Controller
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
    }

    /**
     * Validation Request
     *
     */
    public function validation($request)
    {
        return $request->validate([
            'nomor' => 'required|unique:members',
            'nama' => 'required',
            'password' => 'required',
        ]);
    }

    /**
     * Format number phone request
     *
     */
    public function formatNumber($request)
    {
        if (str_contains($request->input('nomor'), '+62')) {
            $nomor = $request->input('nomor');
        } else {
            $nomor = str_split($request->input('nomor'), 1);

            if ($nomor[0] == 0) {
                unset($nomor[0]);
            }

            $nomor = '+62' . implode($nomor);
        }

        return $nomor;
    }

    /**
     * Function for registration
     *
     */
    public function register(Request $request)
    {
        $this->validation($request);

        DB::transaction(function () use ($request) {

            $nomor = $this->formatNumber($request);

            $kode_member = '000' . substr($request->input('nomor'), 3);

            $user = Member::create([
                'nomor' => $nomor,
                'nama' => $request->input('nama'),
                'password' => Hash::make($request->input('password')),
                'kode_member' => $kode_member,
                'qrCode' => QrCode::generate($kode_member),
                'role_id' => 4
            ]);

            // Kirim SMS
            $twilio = new Client($this->twilio_sid, $this->token);

            $twilio->verify->v2->services($this->twilio_verify_sid)
                ->verifications
                ->create($user->nomor, "sms");
        });

        return response([
            'status' => 'success',
            'message' => 'Member berhasil dibuat'
        ], 201);
    }
}

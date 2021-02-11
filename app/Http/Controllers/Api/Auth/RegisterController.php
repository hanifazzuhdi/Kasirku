<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Providers\UploadProvider;
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
     * Function for registration
     *
     */
    public function register(Request $request)
    {
        $this->validation($request);

        $nomor = $this->formatNumber($request);

        $member = Member::where('nomor', $nomor)->first();

        if ($member) {
            return $this->sendResponse('failed', 'Akun sudah terdaftar', null, 404);
        }

        DB::transaction(function () use ($request, $nomor) {

            $kode_member = '000' . substr($request->input('nomor'), 2);

            $user = Member::create([
                'nomor' => $nomor,
                'nama' => $request->input('nama'),
                'password' => Hash::make($request->input('password')),
                'kode_member' => $kode_member,
                'qr_code' => UploadProvider::uploadCode($kode_member, 'register'),
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
            'message' => 'Member berhasil dibuat',
            'data' => $nomor
        ], 201);
    }

    /**
     * Validation Request
     *
     */
    public function validation($request)
    {
        return $request->validate([
            'nomor' => 'required|unique:members,nomor',
            'nama' => 'required',
            'password' => 'required',
        ]);
    }
}

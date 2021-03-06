<?php

namespace App\Services;

use Illuminate\Support\Facades\{DB, Http};
use Illuminate\Support\{ServiceProvider, Str};

class MessageServices extends ServiceProvider
{
    public $token;

    /**
     * Construct method for assign property
     */
    public function __construct()
    {
        $this->token = env('TOKEN_MESSAGE');
    }

    public function sendMessage($nomor1, $nomor)
    {
        $token = Str::random(5);

        DB::insert("INSERT INTO password_resets VALUES ('$nomor1','$token', now())");

        // Buat short link
        $req = Http::withToken(env('TOKEN_BITLY'))->withHeaders([
            'Content-Type' => ' application/json'
        ])->post('https://api-ssl.bitly.com/v4/shorten', [
            'long_url' => "https://project-mini.herokuapp.com/password/reqet/$token/$nomor1",
            "domain" => "bit.ly"
        ]);

        json_encode($req, true);

        $url = explode('https://', $req['link'])[1];

        Http::get('http://websms.co.id/api/smsgateway', [
            'token' => $this->token,
            'to' => $nomor,
            'msg' => "Ini link permintaan lupa password anda " . $url
        ]);
    }
}

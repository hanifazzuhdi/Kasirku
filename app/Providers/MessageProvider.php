<?php

namespace App\Providers;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class MessageProvider extends ServiceProvider
{
    public $token;

    /**
     * Construct method for assign property
     *
     */
    public function __construct()
    {
        $this->token = 'cfb5b569ba4dd350fd94d800e479810d';
    }

    public function sendMessage($nomor1, $nomor)
    {
        $token = Str::random(5);

        DB::insert("INSERT INTO password_resets VALUES ('$nomor1','$token', now())");

        $res = Http::withToken('5ee9a7b457c02acab98278fdd99d7f50e3aafbb8')->withHeaders([
            'Content-Type' => ' application/json'
        ])->post('https://api-ssl.bitly.com/v4/shorten', [
            'long_url' => "https://project-mini.herokuapp.com/password/reset/$token/$nomor1",
            "domain" => "bit.ly"
        ]);

        json_encode($res, true);

        $url = explode('https://', $res['link'])[1];

        Http::get('http://websms.co.id/api/smsgateway', [
            'token' => $this->token,
            'to' => $nomor,
            'msg' => "Ini link permintaan lupa password anda " . $url
        ]);
    }
}

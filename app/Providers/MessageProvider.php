<?php

namespace App\Providers;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class MessageProvider extends ServiceProvider
{
    public $token, $twilio_sid, $twilio_message_sid;

    /**
     * Construct method for assign property
     *
     */
    public function __construct()
    {
        $this->token = getenv("TWILIO_AUTH_TOKEN");
        $this->twilio_sid = getenv("TWILIO_SID");
        $this->twilio_message_sid = getenv("TWILIO_MESSAGE_SID");
    }

    public function sendMessage($nomor)
    {
        $token = Str::random(30);

        DB::insert("INSERT INTO password_resets VALUES ('$nomor','$token', now())");

        $twilio = new Client($this->twilio_sid, $this->token);

        $twilio->messages
            ->create(
                $nomor,
                [
                    'messagingServiceSid' => $this->twilio_message_sid,
                    'body' => "Ini link lupa password anda : https://project-mini.herokuapp.com/{$token}/{$nomor}"
                ]
            );
    }
}

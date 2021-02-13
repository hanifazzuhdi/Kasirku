<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Twilio\Rest\Client;

class MessageProvider extends ServiceProvider
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
    }

    public static function sendMessage($nomor, $token)
    {
        $twilio = new Client(self::$twilio_sid, self::$token);

        $twilio->messages
            ->create(
                $nomor,
                [
                    'messagingServiceSid' => self::$twilio_verify_sid,
                    'body' => "Ini link lupa password anda : https://project-mini.herokuapp.com/{$token}/{$nomor}"
                ]
            );
    }
}

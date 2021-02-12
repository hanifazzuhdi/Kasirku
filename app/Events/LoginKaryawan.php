<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LoginKaryawan
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $email;
    public $device;
    public $activity;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($request, $device, $activity)
    {
        $this->email = $request;
        $this->device = $device;
        $this->activity = $activity;
    }
}

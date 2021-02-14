<?php

namespace App\Listeners;

use App\Events\LoginKaryawan;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Log;

class LogKaryawan
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  LoginKaryawan  $event
     * @return void
     */
    public function handle(LoginKaryawan $event)
    {
        $user = User::where('email', $event->email)->first();

        switch (true) {
            case $user->role_id == 2:
                # code...
                $role = 'Staf';
                break;
            case $user->role_id == 3:
                # code...
                $role = 'Kasir';
                break;
        }

        Log::create([
            'nama' => $user->nama,
            'role' => $role,
            'device' => $event->device,
            'activity' => $event->activity,
            'pesan' => "Karyawan anda $user->nama sebagai $role telah $event->activity melaui $event->device App"
        ]);
    }
}

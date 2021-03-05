<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Support\Facades\{Auth, DB};

use Illuminate\Http\Request;
use App\Providers\UploadProvider;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    // Melihat data user yang login
    public function show()
    {
        $data = User::find(Auth::id());

        return $this->sendResponse('success', 'Data berhasil dimuat', $data, 200);
    }

    //  Update profile user
    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        $this->validate($request, [
            'avatar' => 'image|file'
        ]);

        DB::transaction(function () use ($user, $request) {
            if ($request->file('avatar')) {
                $avatar = UploadProvider::upload($request);
            }

            $user->update([
                'nama'   => $request->nama ?? $user->nama,
                'umur'   => $request->umur ?? $user->umur,
                'alamat' => $request->alamat ?? $user->alamat,
                'avatar' => $avatar ?? $user->avatar,
            ]);
        });

        return $this->sendResponse('success', 'User berhasil diperbarui', $user->only('id', 'nama', 'email', 'alamat', 'avatar', 'role_id'), 200);
    }
}

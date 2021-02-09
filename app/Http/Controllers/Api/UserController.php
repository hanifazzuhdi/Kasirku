<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserValidation;
use App\Providers\UploadProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Construct function
     *
     */
    public function __construct()
    {
        return $this->middleware('verified');
    }

    /**
     * Function for update profile user
     *
     */
    public function update(Request $request, UserValidation $userValidation)
    {
        $user = User::find(Auth::id());

        if ($request->input('email')) {
            $user->update(['email' => 'update']);
        }

        $userValidation;

        DB::transaction(function () use ($user, $request) {
            if ($request->file('avatar')) {
                $avatar = UploadProvider::upload($request);
            }

            $user->update([
                'nama' => $request->input('nama') ?? $user->nama,
                'email' => $request->input('email') ?? $user->email,
                'umur' => $request->input('umur') ?? $user->umur,
                'alamat' => $request->input('alamat') ?? $user->alamat,
                'avatar' => $avatar ?? $user->avatar,
            ]);
        });

        return $this->sendResponse('success', 'User berhasil diperbarui', $user, 200);
    }
}

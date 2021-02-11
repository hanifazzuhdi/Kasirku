<?php

namespace App\Http\Controllers\Api\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function change(Request $request)
    {
        $this->validate($request, [
            'password_lama' => 'required',
            'password_baru' => 'required',
        ]);

        $user = Member::find(auth('member')->id());

        if (Hash::check($request->input('password_lama'), $user->password)) {

            if ($request->input('password_baru') == $request->input('password_lama')) {
                return $this->sendResponse('failed', 'Password tidak boleh sama dengan sebelumnya', null, 404);
            }

            $user->update([
                'password' => Hash::make($request->input('password_baru'))
            ]);

            return $this->sendResponse('success', 'Password berhasil diubah', $user, 200);
        }
        return $this->sendResponse('failed', 'Password tidak cocok', null, 404);
    }
}

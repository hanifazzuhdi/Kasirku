<?php

namespace App\Http\Controllers\Api\Member;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    // Jwt Auth
    public function __construct()
    {
        return $this->middleware('jwt.auth');
    }

    // Melihat data member yang sedang login
    public function index()
    {
        $data = auth('member')->user();

        return $this->sendResponse('success', 'Data member berhasil ditampilkan', $data, 200);
    }

    // Ubah password member
    public function change(Request $request)
    {
        $this->validate($request, [
            'password_lama' => 'required',
            'password_baru' => 'required',
        ]);

        $user = Member::find(auth('member')->id());

        if (Hash::check($request->password_lama, $user->password)) {

            if ($request->password_baru == $request->password_lama) {
                return $this->sendResponse('failed', 'Password tidak boleh sama dengan sebelumnya', null, 404);
            }

            $user->update([
                'password' => Hash::make($request->password_baru)
            ]);

            return $this->sendResponse('success', 'Password berhasil diubah', $user, 200);
        }
        return $this->sendResponse('failed', 'Password tidak cocok', null, 404);
    }
}

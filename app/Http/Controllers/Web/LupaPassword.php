<?php

namespace App\Http\Controllers\Web;

use App\Models\Member;
use Illuminate\Support\Facades\{DB, Hash};

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LupaPassword extends Controller
{
    public function index($token, $nomor)
    {
        $db = DB::select("SELECT * FROM password_resets WHERE token = '$token' AND email = '$nomor'");

        if (!$db) {
            return abort('404');
        }

        return view('auth.passwords.email', compact('nomor', 'token'));
    }

    public function ubahPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed'
        ]);

        $member = Member::where('nomor', $request->nomor)->first();

        $status = $member->update([
            'password' => Hash::make($request->password)
        ]);

        if ($status) {
            DB::delete("DELETE FROM password_resets WHERE token = '$request->token' AND email = '$request->nomor'");

            return response()->json(['status' => 'berhasil diubah']);
        } else {
            return response()->json(['status' => 'gagal ubah password']);
        }
    }
}

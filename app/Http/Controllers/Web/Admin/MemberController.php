<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Member::paginate(10);

        return view('dashboard.pages.admin.member', compact('datas'));
    }

    /**
     * Cari berdasarkan pencarian.
     *
     * @return \Illuminate\Http\Response
     */
    public function cari(Request $request)
    {
        if (!$request->input('datefilter')) {
            $datas = Member::where('kode_member', 'LIKE', "%$request->search%")->paginate(10);
        } else {
            $tanggal = $request->datefilter;
            $tHasil = explode(' - ', $tanggal);

            $datas = Member::whereBetween('created_at', [$tHasil[0] . ' 00:00:00', $tHasil[1] . ' 23:59:59'])->paginate(10);
        }

        return view('dashboard.pages.admin.member', compact('datas'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        if ($member->is_verified == 1) {
            $member->is_verified = 'Aktif';
        } else {
            $member->is_verified = 'Belum Aktif';
        }

        $data = json_encode($member);

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = Member::find($id);
        $member->delete();


        return back();
    }
}

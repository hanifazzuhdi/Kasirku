<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    /**
     * Lihat semua karyawan
     *
     */
    public function index()
    {
        $datas = User::where('role_id', '!=', 1)->paginate(10);

        return view('dashboard.pages.admin.karyawan', compact('datas'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if ($user->is_verified == 1) {
            $user->is_verified = 'Aktif';
        } else {
            $user->is_verified = 'Belum Aktif';
        }

        $data = json_encode($user);

        return $data;
    }

    /**
     * Tambah karyawan
     *
     */
    public function store(Request $request)
    {
        dd($request);

        $data = $this->validate($request, [
            'nama' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'umur' => 'required',
            'alamat' => 'required',
            'avatar' => 'required',
            'role_id' => 'required',
        ]);

        User::create($data);

        return back();
    }

    /**
     * Cari berdasarkan pencarian.
     *
     * @return \Illuminate\Http\Response
     */
    public function cari(Request $request)
    {
        if (!$request->input('datefilter')) {

            $searchType = filter_var(request('search'), FILTER_VALIDATE_INT) ? 'id' : 'email';
            $datas = User::where($searchType, 'LIKE', "%$request->search%")->where('id', '!=', 1)->paginate(10);
        } else {

            $tanggal = $request->datefilter;
            $tHasil = explode(' - ', $tanggal);

            $datas = User::whereBetween('created_at', [$tHasil[0] . ' 00:00:00', $tHasil[1] . ' 23:59:59'])->where('id', '!=', 1)->paginate(10);
        }

        return view('dashboard.pages.admin.karyawan', compact('datas'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return back();
    }
}
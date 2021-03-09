<?php

namespace App\Http\Controllers\Web\Admin;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class KaryawanController extends Controller
{
    /**
     * Lihat semua karyawan
     */
    public function index()
    {
        $datas = User::where('role_id', '!=', 1)->paginate(10);

        return view('dashboard.admin.karyawan.index', compact('datas'));
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
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'nama' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'role_id' => 'required',
        ]);

        $umur = Carbon::createFromDate($data['tangal_lahir'])->age;

        $data['password'] = Hash::make(request('password'));
        $data['umur'] = $umur;

        User::create($data);

        Alert::success('Success', 'Karyawan Berhasil didaftarkan');

        return back();
    }

    /**
     * Cari berdasarkan pencarian.
     *
     * @return \Illuminate\Http\Response
     */
    public function cari(Request $request)
    {
        if (!$request->datefilter) {
            $searchType = filter_var(request('search'), FILTER_VALIDATE_INT) ? 'id' : 'email';
            $datas = User::where($searchType, 'LIKE', "%$request->search%")->where('id', '!=', 1)->paginate(10);
        } else {
            $tanggal = $request->datefilter;
            $tHasil = explode(' - ', $tanggal);

            $datas = User::whereBetween('created_at', [$tHasil[0] . ' 00:00:00', $tHasil[1] . ' 23:59:59'])->where('id', '!=', 1)->paginate(10);
        }

        return view('dashboard.admin.karyawan.index', compact('datas'));
    }

    // filter staf
    public function staf()
    {
        $datas = User::where('role_id', '!=', 1)->where('role_id', 2)->paginate(10);

        return view('dashboard.admin.karyawan.index', compact('datas'));
    }

    // filter kasir
    public function kasir()
    {
        $datas = User::where('role_id', '!=', 1)->where('role_id', 3)->paginate(10);

        return view('dashboard.admin.karyawan.index', compact('datas'));
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

        Alert::toast('Karyawan berhasil diberhentikan', 'success');

        return back();
    }
}

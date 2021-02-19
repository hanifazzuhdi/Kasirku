<?php

namespace App\Http\Controllers\Web\Admin;

use App\Models\Log;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AktivitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Log::where('date', date('Y-m-d'))->paginate(10);

        return view('dashboard.pages.admin.aktivitas', compact('datas'));
    }

    /**
     * Cari berdasarkan pencarian.
     *
     * @return \Illuminate\Http\Response
     */
    public function cari(Request $request)
    {

        $tanggal = $request->datefilter;
        $tHasil = explode(' - ', $tanggal);

        $datas = Log::whereBetween('created_at', [$tHasil[0] . ' 00:00:00', $tHasil[1] . ' 23:59:59'])->paginate(10);

        return view('dashboard.pages.admin.aktivitas', compact('datas'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Api\Pimpinan;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PemasukanController extends Controller
{
    /**
     * lihat data pemasukan bulan ini
     */
    public function index()
    {
        //  pemasukan hari ini
        $hari   = Transaksi::whereDay('created_at', date('d'))->pluck('harga_total')->sum();

        //  pemasukan bulan ini
        $bulan   = Transaksi::whereMonth('created_at', date('m'))->pluck('harga_total')->sum();

        //  data pemasukan bulan ini
        $pemasukan = Transaksi::select('harga_total', 'created_at')->whereMonth('created_at', date('m'))->get();

        return response()->json([
            'status'            => 'success',
            'message'           => 'Data pemasukan berhasil dimuat',
            'pemasukan_hari'    => $hari,
            'pemasukan_bulan'   => $bulan,
            'data'              => $pemasukan
        ]);
    }

    /**
     * Laporan pemasukan berdasarkan bulan
     */
    public function show(Request $request)
    {
        $this->validate($request, [
            'bulan' => 'required'
        ]);
        //  pemasukan hari ini
        $hari   = Transaksi::whereDay('created_at', date('d'))->pluck('harga_total')->sum();

        //  pemasukan bulan ini
        $bulan   = Transaksi::whereMonth('created_at', request('bulan'))->pluck('harga_total')->sum();

        //  data pemasukan bulan ini
        $pemasukan = Transaksi::whereMonth('created_at', request('bulan'))->get();

        return response()->json([
            'status'            => 'success',
            'message'           => 'Data pemasukan berhasil dimuat',
            'pemasukan_hari'    => $hari,
            'pemasukan_bulan'   => $bulan,
            'data'              => $pemasukan
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class PemasukanController extends Controller
{
    /**
     * lihat data pengeluaran bulan ini
     */
    public function index()
    {
        //  pengeluaran hari ini
        $hari   = Transaksi::whereDay('created_at', date('d'))->pluck('harga_total')->sum();

        //  pengeluaran bulan ini
        $bulan   = Transaksi::whereMonth('created_at', date('m'))->pluck('harga_total')->sum();

        //  data pengeluaran bulan ini
        $pengeluaran = Transaksi::whereMonth('created_at', date('m'))->get();

        return response()->json([
            'status'            => 'success',
            'message'           => 'Data Pengeluaran berhasil dimuat',
            'pengeluaran_hari'  => $hari,
            'pengeluaran_bulan' => $bulan,
            'data'              => $pengeluaran
        ]);
    }

    /**
     * Laporan Pengeluaran berdasarkan bulan
     */
    public function show()
    {
        //  pengeluaran hari ini
        $hari   = Transaksi::whereDay('created_at', date('d'))->pluck('harga_total')->sum();

        //  pengeluaran bulan ini
        $bulan   = Transaksi::whereMonth('created_at', request('bulan'))->pluck('harga_total')->sum();

        //  data pengeluaran bulan ini
        $pengeluaran = Transaksi::whereMonth('created_at', request('bulan'))->get();

        return response()->json([
            'status'            => 'success',
            'message'           => 'Data Pengeluaran berhasil dimuat',
            'pengeluaran_hari'  => $hari,
            'pengeluaran_bulan' => $bulan,
            'data'              => $pengeluaran
        ]);
    }
}

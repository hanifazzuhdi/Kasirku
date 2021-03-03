<?php

namespace App\Http\Controllers\Api\Pimpinan;

use App\Models\{Pengeluaran};

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class PengeluaranController extends Controller
{
    /**
     * lihat data pengeluaran bulan ini
     */
    public function index()
    {
        //  pengeluaran hari ini
        $hari   = Pengeluaran::whereDay('created_at', date('d'))->pluck('jumlah')->sum();

        //  pengeluaran bulan ini
        $bulan   = Pengeluaran::whereMonth('created_at', date('m'))->pluck('jumlah')->sum();

        //  data pengeluaran bulan ini
        $pengeluaran = Pengeluaran::whereMonth('created_at', date('m'))->get();

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
    public function show(Request $request)
    {
        $this->validate($request, [
            'bulan' => 'required'
        ]);

        //  pengeluaran hari ini
        $hari   = Pengeluaran::whereDay('created_at', date('d'))->pluck('jumlah')->sum();

        //  pengeluaran bulan ini
        $bulan   = Pengeluaran::whereMonth('created_at', request('bulan'))->pluck('jumlah')->sum();

        //  data pengeluaran bulan ini
        $pengeluaran = Pengeluaran::whereMonth('created_at', request('bulan'))->get();

        return response()->json([
            'status'            => 'success',
            'message'           => 'Data Pengeluaran berhasil dimuat',
            'pengeluaran_hari'  => $hari,
            'pengeluaran_bulan' => $bulan,
            'data'              => $pengeluaran
        ]);
    }

    /**
     * Tambah data pengeluaran
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'nama_pengeluaran' => 'required',
            'jumlah' => 'required'
        ]);

        $data = Pengeluaran::create($data);

        return $this->sendResponse('success', 'Data Pengeluaran berhasil ditambahkan', $data, 201);
    }
}

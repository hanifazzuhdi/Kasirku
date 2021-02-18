<?php

namespace App\Http\Controllers\Api\Pimpinan;

use App\Models\{Pembelian, Pengeluaran};

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class PengeluaranController extends Controller
{
    /**
     * lihat data pengeluaran
     *
     */
    public function index()
    {
        $datas = Pengeluaran::all();

        if (count($datas)  == null) {
            return $this->sendResponse('failed', 'Data Pengeluaran Kosong', null, 404);
        }

        return $this->sendResponse('success', 'Data Pengeluaran berhasil ditampilakan', $datas, 200);
    }

    /**
     * Laporan Pengeluaran
     *
     */
    public function show(Request $request)
    {
        $tanggalAwal = $request->input('tAwal');
        $tanggalAkhir = $request->input('tAkhir');

        $data = Pengeluaran::antara($tanggalAwal, $tanggalAkhir)->get();

        if (count($data)  == null) {
            return $this->sendResponse('failed', 'Data Pembelian Kosong', null, 404);
        }

        return $this->sendResponse('success', 'Data berhasil ditampilakan', $data, 200);
    }

    /**
     * Tambah data pengeluaran
     *
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

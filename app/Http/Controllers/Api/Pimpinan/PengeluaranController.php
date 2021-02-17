<?php

namespace App\Http\Controllers\Api\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

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

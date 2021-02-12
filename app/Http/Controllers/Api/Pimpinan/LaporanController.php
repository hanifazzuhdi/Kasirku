<?php

namespace App\Http\Controllers\Api\Pimpinan;

use App\Models\Barang;
use App\Http\Controllers\Controller;
use App\Http\Resources\StokResource;
use App\Models\Pembelian;

class LaporanController extends Controller
{
    /**
     * Laporan Stok
     *
     */
    public function stok()
    {
        $datas = StokResource::collection(Barang::get());

        return $this->sendResponse('success', 'data berhasil dimuat', $datas, 200);
    }

    /**
     * Laporan semua permbelian
     *
     */
    public function allPembelian()
    {
        $data = Pembelian::get();

        return $this->sendResponse('success', 'data berhasil ditampilakan', $data, 200);
    }

    /**
     * Laporan Pembelian
     *
     */
    public function pembelian($tanggalAwal, $tanggalAkhir)
    {
        $tanggalAwal = "2021-02-12 ";
        $tanggalAkhir = "2021-02-13 ";

        $data = Pembelian::whereBetween('created_at', [$tanggalAwal . '00:00:00', $tanggalAkhir . '23:59:59'])->get();

        return response()->json([
            'status' => 'success',
            'message' => 'data berhasil ditampilkan',
            'data' => $data
        ]);
    }
}

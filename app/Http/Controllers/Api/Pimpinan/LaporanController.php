<?php

namespace App\Http\Controllers\Api\Pimpinan;

use App\Models\Barang;
use App\Http\Controllers\Controller;
use App\Http\Resources\StokResource;

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
     * Laporan Pembelian
     *
     */
    public function pembelian()
    {
    }
}

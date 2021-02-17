<?php

namespace App\Http\Controllers\Api\Pimpinan;

use App\Models\{Barang, Pembelian, Transaksi};

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LaporanKasir;
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
     * Laporan semua permbelian
     *
     */
    public function allPembelian()
    {
        $data = Pembelian::get();

        if (count($data)  == null) {
            return $this->sendResponse('failed', 'Data Pembelian Kosong', null, 404);
        }

        return $this->sendResponse('success', 'Data berhasil ditampilakan', $data, 200);
    }

    /**
     * Laporan Pembelian berdasarkan antara tanggal
     *
     */
    public function pembelian(Request $request)
    {
        $tanggalAwal = $request->input('tAwal');
        $tanggalAkhir = $request->input('tAkhir');

        $data = Pembelian::whereBetween('created_at', [$tanggalAwal . ' 00:00:00', $tanggalAkhir . ' 23:59:59'])->get();

        if (count($data)  == null) {
            return $this->sendResponse('failed', 'Data Pembelian Kosong', null, 404);
        }

        return $this->sendResponse('success', 'Data berhasil ditampilakan', $data, 200);
    }

    /**
     * Laporan Penjualan
     *
     */
    public function allPenjualan()
    {
        $datas = Transaksi::with('kasir')->where('status', 1)->get();

        if (count($datas) == null) {
            return $this->sendResponse('failed', 'Data penjualan Kosong', null, 404);
        }

        $data = LaporanKasir::collection($datas);

        return $this->sendResponse('success', 'Data penjualan berhasil ditampilakan', $data, 200);
    }
}

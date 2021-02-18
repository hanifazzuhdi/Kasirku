<?php

namespace App\Http\Controllers\Api\Pimpinan;

use App\Models\{Pembelian, Pengeluaran, Transaksi};

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LabaRugiController extends Controller
{
    public function show(Request $request)
    {
        $data = $this->validate($request, [
            'bulan' => 'required'
        ]);
        /**
         * Pendapatan
         * 1. Penjualan
         * 2. Pembelian
         * 3. laba kotor
         */

        $penjualan = Transaksi::whereMonth('created_at', $data['bulan'])->pluck('harga_total')->sum();
        $pembelian = Pembelian::whereMonth('created_at', $data['bulan'])->pluck('total_harga')->sum();

        $labaKotor = $penjualan - $pembelian;

        /**
         * Beban Usaha
         * 1. pengeluaran
         */
        $pengeluaran = Pengeluaran::whereMonth('created_at', $data['bulan'])->where('jenis', 'Pengeluaran')->pluck('jumlah')->sum();

        // Laba/Rugi
        $labaRugi = $labaKotor - $pengeluaran;

        return response()->json([
            'status' => 'success',
            'message' => 'Data Laba Rugi berhasil dimuat',
            'data' => [
                'penjualan' => $penjualan,
                'pembelian_produk' => $pembelian,
                'laba_kotor' => $labaKotor,
                'pengeluaran' => $pengeluaran,
                'laba_rugi' => $labaRugi
            ],
        ]);
    }
}

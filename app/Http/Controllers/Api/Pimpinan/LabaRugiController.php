<?php

namespace App\Http\Controllers\Api\Pimpinan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\User;

class LabaRugiController extends Controller
{
    public function index()
    {
        /**
         * Pendapatan
         * 1. Penjualan
         * 2. laba kotor
         *
         */

        $bulan = 02;

        $penjualan = Transaksi::whereMonth('created_at', $bulan)->pluck('harga_total')->sum();

        return $penjualan;

        // pengeluaran

        return response()->json([
            'status' => 'success',
            'message' => 'Data Laba Rugi berhasil dimuat',
        ]);
    }
}

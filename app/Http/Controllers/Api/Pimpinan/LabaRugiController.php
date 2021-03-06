<?php

namespace App\Http\Controllers\Api\Pimpinan;

use App\Models\{Pembelian, Pengeluaran, Transaksi};

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class LabaRugiController extends Controller
{

    // Laporan laba rugi Bulan ini
    public function show()
    {
        $penjualan = Transaksi::whereMonth('created_at', date('m'))->pluck('harga_total')->sum();
        $pembelian = Pembelian::whereMonth('created_at', date('m'))->pluck('total_harga')->sum();

        $labaKotor = $penjualan - $pembelian;

        $pengeluaran = Pengeluaran::whereMonth('created_at', date('m'))->where('jenis', 'Pengeluaran')->pluck('jumlah')->sum();

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

    // Cari laporan laba rugi berdasarkan bulan
    public function cari(Request $request)
    {
        $data = $this->validate($request, [
            'bulan' => 'required'
        ]);

        $pembelian = Pembelian::whereMonth('created_at', $data['bulan'])->pluck('total_harga')->sum();
        $penjualan = Transaksi::whereMonth('created_at', $data['bulan'])->pluck('harga_total')->sum();

        $labaKotor = $penjualan - $pembelian;

        $pengeluaran = Pengeluaran::whereMonth('created_at', $data['bulan'])->where('jenis', 'Pengeluaran')->pluck('jumlah')->sum();

        $dt = Carbon::parse('2012-' . date(request('bulan')) . '-5 23:26:11.123789');
        $bulanName = $dt->monthName;

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
                'laba_rugi' => $labaRugi,
                'bulan'     => $bulanName
            ],
        ]);
    }
}

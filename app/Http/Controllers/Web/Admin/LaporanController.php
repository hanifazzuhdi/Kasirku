<?php

namespace App\Http\Controllers\Web\Admin;

use App\Models\{Keranjang, Pembelian, Pengeluaran, Transaksi};
use App\Exports\{PembelianExport, PenjualanExport};

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    // Laporan pembelian
    public function pembelian()
    {
        $datas = Pembelian::orderBy('id', 'DESC')->paginate(10);

        return view('dashboard.admin.laporan.pembelian', compact('datas'));
    }

    public function cari(Request $request)
    {
        if ($request->input('search') == null) {
            $tanggal = explode(' - ', request('datefilter'));

            $tAwal = Carbon::create($tanggal[0]);
            $tAwal = date_format($tAwal, 'Y-m-d');

            $tAkhir = Carbon::create($tanggal[1]);
            $tAkhir = date_format($tAkhir, 'Y-m-d');

            $datas = Pembelian::whereBetween('created_at', [$tAwal . ' 00:00:00', $tAkhir . ' 23:59:59'])->orderBy('id', 'DESC')->paginate(10);
        } else {

            $datas = Pembelian::whereHas('supplier', function ($q) {
                $q->where('nama_supplier', 'LIKE', '%' . request('search') . '%');
            })->orderBy('id', 'DESC')->paginate(10);
        }

        return view('dashboard.admin.laporan.pembelian', compact('datas'));
    }

    public function cetakPembelian()
    {
        return Excel::download(new PembelianExport, 'laporan-pembelian.xlsx');
    }

    // Laporan Penjualan
    public function penjualan()
    {
        $datas = Transaksi::with('kasir')->orderBy('id', 'DESC')->paginate(10);

        return view('dashboard.admin.laporan.penjualan', compact('datas'));
    }

    public function cariPenjualan(Request $request)
    {
        if ($request->input('search') == null) {
            $tanggal = explode(' - ', request('datefilter'));

            $tAwal = Carbon::create($tanggal[0]);
            $tAwal = date_format($tAwal, 'Y-m-d');

            $tAkhir = Carbon::create($tanggal[1]);
            $tAkhir = date_format($tAkhir, 'Y-m-d');

            $datas = Transaksi::whereBetween('created_at', [$tAwal . ' 00:00:00', $tAkhir . ' 23:59:59'])->orderBy('id', 'DESC')->paginate(10);
        } else {

            $datas = Transaksi::whereHas('kasir', function ($q) {
                $q->where('nama', 'LIKE', '%' . request('search') . '%')->where('role_id', 3);
            })->orderBy('id', 'DESC')->paginate(10);
        }

        return view('dashboard.admin.laporan.penjualan', compact('datas'));
    }

    public function cetakPenjualan(Transaksi $transaksi)
    {
        $keranjang = Keranjang::where('transaksi_id', $transaksi->id)->get();

        $penjualan = Transaksi::with('kasir')->where('id', $transaksi->id)->first();

        $pdf = App::make('dompdf.wrapper');

        $pdf->setPaper('A5');

        $pdf->loadView('dashboard.admin.laporan._cetak-penjualan', compact('keranjang', 'penjualan'));

        return $pdf->stream('Laporan-penjualan.pdf');
    }

    public function exportPenjualan()
    {
        return Excel::download(new PenjualanExport, 'laporan-penjualan.xlsx');
    }

    // Laporan Laba Rugi
    public function labaRugi()
    {
        $now = date('m');

        /**
         * Pendapatan
         * 1. Penjualan
         * 2. Pembelian
         * 3. laba kotor
         */

        $penjualan = Transaksi::whereMonth('created_at', $now)->pluck('harga_total')->sum();
        $pembelian = Pembelian::whereMonth('created_at', $now)->pluck('total_harga')->sum();

        $labaKotor = $penjualan - $pembelian;

        /**
         * Beban Usaha
         * 1. pengeluaran
         */
        $pengeluaran = Pengeluaran::whereMonth('created_at', $now)->where('jenis', 'Pengeluaran')->pluck('jumlah')->sum();

        // Laba/Rugi
        $labaRugi = $labaKotor - $pengeluaran;

        return view('dashboard.admin.laporan.labarugi', compact('penjualan', 'pembelian', 'labaKotor', 'pengeluaran', 'labaRugi'));
    }
}

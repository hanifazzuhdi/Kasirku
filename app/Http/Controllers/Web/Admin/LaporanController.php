<?php

namespace App\Http\Controllers\Web\Admin;

use App\Models\{Keranjang, Pembelian, Pengeluaran, Transaksi};
use App\Exports\{PemasukanExport, PembelianExport, PengeluaranExport, PenjualanExport};

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

    public function exportPenjualan()
    {
        return Excel::download(new PenjualanExport, 'laporan-penjualan.xlsx');
    }

    // Laporan Laba Rugi
    public function labaRugi()
    {
        $bulan = date('m');

        $dt = Carbon::parse('2012-' . $bulan . '-5 23:26:11.123789');
        $bulanName = $dt->monthName;

        /**
         * Pendapatan
         * 1. Penjualan
         * 2. Pembelian
         * 3. laba kotor
         */

        $penjualan = Transaksi::whereMonth('created_at', $bulan)->pluck('harga_total')->sum();
        $pembelian = Pembelian::whereMonth('created_at', $bulan)->pluck('total_harga')->sum();

        $labaKotor = $penjualan - $pembelian;

        /**
         * Beban Usaha
         * 1. pengeluaran
         */
        $pengeluaran = Pengeluaran::whereMonth('created_at', $bulan)->where('jenis', 'Pengeluaran')->pluck('jumlah')->sum();

        // Laba/Rugi
        $labaRugi = $labaKotor - $pengeluaran;

        return view('dashboard.admin.laporan.labarugi', compact('penjualan', 'pembelian', 'labaKotor', 'pengeluaran', 'labaRugi', 'bulan', 'bulanName'));
    }

    public function labaCari(Request $request)
    {
        $bulan = explode('-', $request->bulan)[1];

        $dt = Carbon::parse('2012-' . $bulan . '-5 23:26:11.123789');
        $bulanName = $dt->monthName;

        $penjualan = Transaksi::whereMonth('created_at', $bulan)->pluck('harga_total')->sum();
        $pembelian = Pembelian::whereMonth('created_at', $bulan)->pluck('total_harga')->sum();

        $labaKotor = $penjualan - $pembelian;

        $pengeluaran = Pengeluaran::whereMonth('created_at', $bulan)->where('jenis', 'Pengeluaran')->pluck('jumlah')->sum();

        $labaRugi = $labaKotor - $pengeluaran;

        return view('dashboard.admin.laporan.labarugi', compact('penjualan', 'pembelian', 'labaKotor', 'pengeluaran', 'labaRugi', 'bulan', 'bulanName'));
    }

    // Laporan Pemasukan
    public function pemasukan()
    {
        $hari = date('d');
        $bulan = date('m');

        $dt = Carbon::parse('2012-' . $bulan . '-5 23:26:11.123789');
        $bulanName = $dt->monthName;

        $hari = Transaksi::whereDay('created_at', $hari)->pluck('harga_total')->sum();
        $tBulan = Transaksi::whereMonth('created_at', $bulan)->pluck('harga_total')->sum();

        $pemasukan = Transaksi::whereMonth('created_at', $bulan)->get();

        return view('dashboard.admin.laporan.pemasukan', compact('hari', 'bulan', 'tBulan', 'bulanName', 'pemasukan'));
    }

    public function cariPemasukan(Request $request)
    {
        $hari = date('d');
        $bulan = explode('-', $request->bulan)[1];

        $dt = Carbon::parse('2012-' . $bulan . '-5 23:26:11.123789');
        $bulanName = $dt->monthName;

        $hari = Transaksi::whereDay('created_at', $hari)->pluck('harga_total')->sum();
        $tBulan = Transaksi::whereMonth('created_at', $bulan)->pluck('harga_total')->sum();

        $pemasukan = Transaksi::whereMonth('created_at', $bulan)->get();

        return view('dashboard.admin.laporan.pemasukan', compact('hari', 'bulan', 'tBulan', 'bulanName', 'pemasukan'));
    }

    // Export to Excel
    public function exportPemasukan(Request $request)
    {
        return Excel::download(new PemasukanExport($request->bulan), 'laporan-pemasukan.xlsx');
    }

    // Laporan Pengeluaran
    public function pengeluaran()
    {
        $hari = date('d');
        $bulan = date('m');

        $dt = Carbon::parse('2012-' . $bulan . '-5 23:26:11.123789');
        $bulanName = $dt->monthName;

        $hari   = Pengeluaran::whereDay('created_at', $hari)->pluck('jumlah')->sum();
        $tBulan = Pengeluaran::whereMonth('created_at', $bulan)->pluck('jumlah')->sum();

        $pengeluaran = Pengeluaran::whereMonth('created_at', $bulan)->get();

        return view('dashboard.admin.laporan.pengeluaran', compact('bulan', 'hari', 'tBulan', 'bulanName', 'pengeluaran'));
    }

    public function cariPengeluaran(Request $request)
    {
        $hari = date('d');
        $bulan = explode('-', $request->bulan)[1];

        $dt = Carbon::parse('2012-' . $bulan . '-5 23:26:11.123789');
        $bulanName = $dt->monthName;

        $hari = Transaksi::whereDay('created_at', $hari)->pluck('harga_total')->sum();
        $tBulan = Transaksi::whereMonth('created_at', $bulan)->pluck('harga_total')->sum();

        $pengeluaran = Pengeluaran::whereMonth('created_at', $bulan)->get();

        return view('dashboard.admin.laporan.pengeluaran', compact('bulan', 'hari', 'tBulan', 'bulanName', 'pengeluaran'));
    }

    // Export to Excel
    public function exportPengeluaran(Request $request)
    {
        return Excel::download(new PengeluaranExport($request->bulan), 'laporan-pengeluaran.xlsx');
    }
}

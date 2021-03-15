<?php

namespace App\Http\Controllers\Web;

use App\Models\{Barang, Log, Member, Pembelian, Pengeluaran, Transaksi};
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function admin()
    {
        $member = Member::MemberActive()->count();
        $logs = Log::orderBy('id', 'DESC')->limit(3)->get();

        $penjualan = Transaksi::whereDay('created_at', date('d'))->pluck('harga_total');

        $bulan = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];

        $labaRugi = [];
        $penghasilan = [];

        for ($i = 0; $i < 12; $i++) {

            if ($i >= date('m')) {
                break;
            }

            $penjualann = Transaksi::whereMonth('created_at', $bulan[$i])->pluck('harga_total')->sum();
            $pembelian = Pembelian::whereMonth('created_at', $bulan[$i])->pluck('total_harga')->sum();

            $penghasilan[] = $penjualann;

            $labaKotor = $penjualann - $pembelian;

            /**
             * Beban Usaha
             * 1. pengeluaran
             */
            $pengeluaran = Pengeluaran::whereMonth('created_at', $bulan[$i])->where('jenis', 'Pengeluaran')->pluck('jumlah')->sum();

            // Laba/Rugi
            $labaRugi[] = $labaKotor - $pengeluaran;

            // untuk stats
            $keuntungan = $labaKotor - $pengeluaran;
        }

        return view('dashboard.admin.home.index', compact('member', 'logs', 'penjualan', 'keuntungan', 'penghasilan', 'labaRugi', 'penghasilan'));
    }

    public function settings()
    {
        return view('dashboard.admin.settings');
    }

    public function staf()
    {
        $sapa = $this->sapa();

        return view('dashboard.staf.home.index', compact('sapa'));
    }

    public function kasir()
    {
        $sapa = $this->sapa();

        $produks = Barang::get();
        $members = Member::get();

        return view('dashboard.kasir.home', compact('produks', 'members', 'sapa'));
    }
}

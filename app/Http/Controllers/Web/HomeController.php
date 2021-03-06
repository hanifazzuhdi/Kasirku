<?php

namespace App\Http\Controllers\Web;

use App\Models\{Barang, Log, Member, Pembelian, Pengeluaran, Transaksi};

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    // Home Admin
    public function admin()
    {
        $member = Member::MemberActive()->count();
        $logs = Log::orderBy('id', 'DESC')->limit(3)->get();


        $penjualan = Transaksi::whereDay('created_at', date('d'))->pluck('harga_total');

        $penghasilan = DB::table('transaksis')
            ->select(DB::raw("SUM(harga_total) AS penghasilan"))
            ->whereMonth('created_at', date('m'))
            ->groupBy('minggu')
            ->pluck('penghasilan');

        $bulan = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        $labaRugi = [];

        for ($i = 0; $i < 12; $i++) {

            if ($i >= date('m')) {
                break;
            }

            $penjualann = Transaksi::whereMonth('created_at', $bulan[$i])->pluck('harga_total')->sum();
            $pembelian = Pembelian::whereMonth('created_at', $bulan[$i])->pluck('total_harga')->sum();

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

        return view('dashboard.admin.home.index', compact('member', 'logs', 'penjualan', 'keuntungan', 'penghasilan', 'labaRugi'));
    }

    public function settings()
    {
        return view('dashboard.admin.settings');
    }

    // Home Admin
    public function staf()
    {
        $sapa = $this->sapa();

        return view('dashboard.staf.home.index', compact('sapa'));
    }

    // Home Kasir
    public function kasir()
    {
        $sapa = $this->sapa();

        $produks = Barang::get();
        $members = Member::get();

        return view('dashboard.kasir.home', compact('produks', 'members', 'sapa'));
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Models\{Log, Member, Pembelian, Pengeluaran, Transaksi};

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function admin()
    {
        $member = Member::MemberActive()->count();
        $logs = Log::orderBy('id', 'DESC')->limit(3)->get();
        $penjualan = Transaksi::whereDay('created_at', date('d'))->pluck('harga_total');
        $pengeluaran = Pengeluaran::whereMonth('created_at', date('m'))->pluck('jumlah')->sum();

        $now = date('d');



        return view('dashboard.admin.home.index', compact('member', 'logs', 'penjualan', 'pengeluaran'));
    }

    public function staf()
    {
        return view('dashboard.staf.home.index');
    }
}

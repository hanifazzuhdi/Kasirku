<?php

namespace App\Http\Controllers\Web;

use App\Models\{Barang, Keranjang, Log, Member, Pembelian, Pengeluaran, Transaksi};

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // Home Admin
    public function admin()
    {
        $member = Member::MemberActive()->count();
        $logs = Log::orderBy('id', 'DESC')->limit(3)->get();
        $penjualan = Transaksi::whereDay('created_at', date('d'))->pluck('harga_total');
        // $pengeluaran = Pengeluaran::whereMonth('created_at', date('m'))->pluck('jumlah')->sum();

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
            # code...
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

    // Home Admin
    public function staf()
    {
        $waktu = date('H');

        switch (true) {
            case $waktu >= '02' and $waktu <= '10':
                $sapa = 'Pagi';
                break;
            case $waktu >= '11' and $waktu <= '15':
                $sapa = 'Siang';
                break;
            case $waktu >= '16' and $waktu <= '18':
                $sapa = 'Petang';
                break;
            default:
                $sapa = 'Malam';
                break;
        }

        return view('dashboard.staf.home.index', compact('sapa'));
    }

    // Home Kasir
    public function kasir()
    {
        $produks = Barang::get();

        return view('dashboard.kasir.home', compact('produks'));
    }

    public function keranjang()
    {
        DB::beginTransaction();
        // logic transaksi
        $cek_transaksi = Transaksi::transaksiAktif()->first();

        if (empty($cek_transaksi)) {
            $transaksi = Transaksi::create([
                'kasir_id' => Auth::id(),
            ]);
        } else {
            $transaksi = Transaksi::transaksiAktif()->first();
        }

        // logic keranjang
        $barang = Barang::where('uid', request('uid'))->first();

        // Cek Stok
        if ($barang->stok < request('pcs')) {
            return false;
        }

        $cekKeranjang = Keranjang::where('uid', $barang->uid)->first();

        if ($cekKeranjang) {
            $cekKeranjang->pcs = $cekKeranjang->pcs + request('pcs');
            $cekKeranjang->total_harga = $barang->harga_jual * $cekKeranjang->pcs;
            $cekKeranjang->save();

            // Cek Stok
            if ($cekKeranjang->pcs > $barang->stok) {
                return false;
            }
        } else {
            $keranjang = Keranjang::create([
                'uid' => request('uid'),
                'nama_barang' => $barang->nama_barang,
                'harga' => $barang->harga_jual,
                'pcs' => request('pcs'),
                'total_harga' => $barang->harga_jual * request('pcs'),
                'transaksi_id' => $transaksi->id
            ]);
        }

        // jika dia member
        if (request('kode_member')) {

            $transaksi->update([
                'kode_member' => request('kode_member')
            ]);

            $this->member($transaksi, $barang);
        }

        // update total harga transaksi
        $transaksi->update([
            'harga_total' => Keranjang::where('transaksi_id', $transaksi->id)->sum('total_harga')
        ]);

        DB::commit();

        return Keranjang::where('transaksi_id', $transaksi->id)->get();
    }

    // Jika dia member
    public function member($transaksi, $barang)
    {
        // code
        $keranjang = Keranjang::where('transaksi_id', $transaksi->id)->where('uid', $barang->uid)->first();

        $keranjang->update([
            'diskon' => $barang->diskon * $keranjang->pcs,
            'total_harga' => $keranjang->harga * $keranjang->pcs - ($barang->diskon * $keranjang->pcs)
        ]);
    }
}

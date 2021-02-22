<?php

namespace App\Http\Controllers\Web\Admin;

use App\Models\{Barang};

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProdukController extends Controller
{
    /**
     * Melihat semua data produk
     *
     */
    public function index()
    {
        $datas = Barang::with('kategori', 'merek')->paginate(10);

        return view('dashboard.admin.produk.index', compact('datas'));
    }

    /**
     * Cari berdasarkan id
     *
     */
    public function show(Barang $barang)
    {
        $barang['kategori_id'] = $barang->kategori->nama_kategori;
        $barang['merek_id'] = $barang->merek->nama_merek;

        $barang['harga_beli'] = 'Rp. ' . number_format($barang->harga_beli, '0', ',', '.');
        $barang['harga_jual'] = 'Rp. ' . number_format($barang->harga_jual, '0', ',', '.');
        $barang['diskon'] = number_format($barang->diskon, '0', ',', '.');

        $data = json_encode($barang);

        return $data;
    }

    /**
     * Cari berdasarkan pencarian.
     *
     */
    public function cari(Request $request)
    {
        if (!$request->input('datefilter')) {
            $datas = Barang::where('uid', 'LIKE', "%$request->search%")->paginate(10);
        } else {
            $tanggal = $request->datefilter;
            $tHasil = explode(' - ', $tanggal);

            $datas = Barang::whereBetween('created_at', [$tHasil[0] . ' 00:00:00', $tHasil[1] . ' 23:59:59'])->paginate(10);
        }

        return view('dashboard.admin.produk.index', compact('datas'));
    }
}

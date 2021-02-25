<?php

namespace App\Http\Controllers\Web\Staf;

use App\Models\Barang;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Merek;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProdukController extends Controller
{
    /**
     *Tampilkan halaman daftar produk
     */
    public function index()
    {
        $datas = Barang::orderBy('id', 'DESC')->paginate(10);

        return view('dashboard.staf.produk.index', compact('datas'));
    }

    /**
     * Cari berdasarkan id
     */
    public function show(Barang $barang)
    {
        $barang['kategori_id'] = $barang->kategori->nama_kategori;
        $barang['merek_id'] = $barang->merek->nama_merek;

        $data = json_encode($barang);

        return $data;
    }

    /**
     * Cari berdasarkan pencarian.
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

        return view('dashboard.staf.produk.index', compact('datas'));
    }

    // Update Produk
    public function update(Barang $barang, Request $request)
    {
        $data = $this->validate($request, [
            'nama_produk' => 'required',
            'stok' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'diskon' => 'required|numeric',
        ]);

        $barang->update($data);

        Alert::success('success', 'Data Produk Berhasil diupdate');

        return back();
    }

    // Tampilkan tambah produk
    public function create()
    {
        $kategoris = Kategori::get();
        $mereks = Merek::get();

        return view('dashboard.staf.produk.tambah', compact('kategoris', 'mereks'));
    }
}

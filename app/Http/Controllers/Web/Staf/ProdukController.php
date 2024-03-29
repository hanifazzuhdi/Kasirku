<?php

namespace App\Http\Controllers\Web\Staf;

use App\Models\{Barang, Merek, Kategori};


use Illuminate\Http\Request;
use App\Services\UploadServices;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Controller;

class ProdukController extends Controller
{

    // Tampilkan halaman daftar produk
    public function index()
    {
        $datas = Barang::orderBy('id', 'DESC')->paginate(10);

        return view('dashboard.staf.produk.index', compact('datas'));
    }

    //   Cari berdasarkan id
    public function show(Barang $barang)
    {
        $barang['kategori_id'] = $barang->kategori->nama_kategori;
        $barang['merek_id'] = $barang->merek->nama_merek;

        $data = json_encode($barang);

        return $data;
    }


    // Cari berdasarkan pencarian.
    public function cari(Request $request)
    {
        if (!$request->datefilter) {
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
            'nama_barang' => 'required',
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

    // Tambah Produk
    public function store(Request $request)
    {
        $this->validated($request);

        // Begin transaction
        DB::beginTransaction();
        $data = Barang::create([
            'uid'         => "{$request->kategori_id}{$request->merek_id}" . str_split(time(), 6)[1] . random_int(1, 9),
            'nama_barang' => $request->nama_barang,
            'harga_beli'  => $request->harga_beli,
            'harga_jual'  => $request->harga_jual,
            'kategori_id' => $request->kategori_id,
            'merek_id'    => $request->merek_id,
            'stok'        => $request->stok,
            'diskon'      => $request->diskon ?? 0,
        ]);
        $data->update([
            'barcode' => UploadServices::uploadCode($data->uid, 'barang')
        ]);
        DB::commit();
        // Commit transaction

        Alert::success('Success', 'Data barang berhasil dibuat');

        return back();
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();

        Alert::success('Success', 'Data barang berhasil dihapus');

        return back();
    }

    // Validasi request
    public function validated($request)
    {
        return $this->validate($request, [
            'nama_barang' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|numeric',
            'kategori_id' => 'required',
            'merek_id' => 'required',
        ]);
    }
}

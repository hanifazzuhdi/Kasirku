<?php

namespace App\Http\Controllers\Api\Staff;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Providers\UploadProvider;
use App\Http\Controllers\Controller;
use App\Http\Resources\BarangResource;

class BarangController extends Controller
{
    /**
     * Method for get data all products
     */
    public function index()
    {
        $datas = BarangResource::collection(Barang::with('kategori', 'merek')->get());

        return $this->sendResponse('success', 'data berhasil dimuat', $datas, 200);
    }

    /**
     * Method show barang per uid
     */
    public function show($uid)
    {
        $barang = Barang::where('uid', $uid)->get();

        $data = BarangResource::collection($barang);

        return $this->sendResponse('success', 'data barang berhasil dimuat', $data, 200);
    }

    /**
     * Method for store data products
     */
    public function store(Request $request)
    {
        $this->validated($request);

        // Begin transaction
        DB::beginTransaction();
        $data = Barang::create([
            'uid' => "{$request->kategori_id}{$request->merek_id}" . str_split(time(), 6)[1] . random_int(1, 9),
            'nama_barang' => $request->nama_barang,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'kategori_id' => $request->kategori_id,
            'merek_id' => $request->merek_id,
            'stok' => $request->stok,
            'diskon' => $request->diskon ?? 0,
        ]);
        $data->update([
            'barcode' => UploadProvider::uploadCode($data->uid, 'barang')
        ]);
        DB::commit();
        // Commit transaction

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dibuat',
            'data' => $data
        ], 201);
    }

    /**
     * Api Update barang
     */
    public function update(Barang $barang, Request $request)
    {
        $barang->update([
            'nama_barang' => $request->inama_barang ?? $barang->nama_barang,
            'harga_beli'  => $request->harga_beli ?? $barang->harga_beli,
            'harga_jual'  => $request->harga_jual ?? $barang->harga_jual,
            'stok'        => $request->stok ?? $barang->stok,
            'diskon'      => $request->diskon ?? $barang->diskon,
        ]);

        return $this->sendResponse('success', 'Data barang berhasil diupdate', $barang, 202);
    }

    /**
     * Api Hapus barang
     */
    public function delete(Barang $barang)
    {
        $barang->delete();

        return $this->sendResponse('success', 'Barang berhasil dihapus', $barang->only('uid', 'nama_barang'), 202);
    }

    /**
     * Method for validate request
     */
    public function validated($request)
    {
        return $this->validate($request, [
            'nama_barang' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'stok' => 'required',
            'kategori_id' => 'required',
            'merek_id' => 'required',
        ]);
    }
}

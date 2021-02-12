<?php

namespace App\Http\Controllers\Api\Staff;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Providers\UploadProvider;
use Milon\Barcode\Facades\DNS1DFacade;

class BarangController extends Controller
{

    /**
     * Method for get data all products
     *
     */

    public function index()
    {
        $data = Barang::all();

        return $this->sendResponse('success', 'data berhasil dimuat', $data, 200);
    }

    /**
     * Method for store data products
     *
     */
    public function store(Request $request)
    {
        $this->validated($request);

        // Begin transaction
        DB::beginTransaction();
        $data = Barang::create([
            'uid' => "{$request->kategori}{$request->merek}-" . str_split(time(), 5)[1] . random_int(10, 30),
            'nama_barang' => $request->input('nama_barang'),
            'harga_beli' => $request->input('harga_beli'),
            'harga_jual' => $request->input('harga_jual'),
            'kategori' => $request->input('kategori'),
            'merek' => $request->input('merek'),
            'stok' => $request->input('stok'),
            'diskon' => $request->input('diskon') ?? 0,
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
        ], 202);
    }

    /**
     * Method for validate request
     *
     */
    public function validated($request)
    {
        return $this->validate($request, [
            'nama_barang' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'stok' => 'required',
            'kategori' => 'required',
            'merek' => 'required',
        ]);
    }
}

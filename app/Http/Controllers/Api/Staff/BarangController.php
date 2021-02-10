<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        DB::beginTransaction();
        $data = Barang::create([
            'uid' => "{$request->kategori}{$request->merek}-" . str_split(time(), 5)[1] . random_int(10, 30),
            'nama_barang' => $request->input('nama_barang'),
            'harga_beli' => $request->input('harga_beli'),
            'harga_jual' => $request->input('harga_jual'),
            'kategori' => $request->input('kategori'),
            'merek' => $request->input('merek'),
            'stok' => $request->input('stok'),
            'diskon' => $request->input('diskon'),
        ]);

        $data->update([
            'barcode' => DNS1DFacade::getBarcodeSVG($data->uid, 'C39', 1, 33)
        ]);
        DB::commit();

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
            'stok' => 'required'
        ]);
    }
}

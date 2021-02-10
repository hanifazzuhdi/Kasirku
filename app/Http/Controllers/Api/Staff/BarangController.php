<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $data = Barang::all();

        return $this->sendResponse('success', 'data berhasil dimuat', $data, 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'uuid' => 'required',
            'nama_barang' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            // 'kategori'
        ]);
    }
}

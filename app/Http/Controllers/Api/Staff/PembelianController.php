<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Pembelian;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    /**
     * Get all data pembelian
     *
     */
    public function index()
    {
        $data = Pembelian::get();

        $this->sendResponse('success', 'data berhasil dimuat', $data, 200);
    }

    /**
     * function for store data pembelian
     *
     */
    public function store(Request $request)
    {
        $this->validated($request);

        $data = Pembelian::store([
            'supplier'      => $request->input('supplier'),
            'barang'        => $request->input('barang'),
            'total_barang'  => $request->input('total_barang'),
            'total_harga'   => $request->input('total_harga')
        ]);

        return $this->sendResponse('success', 'data berhasil ditambahkan', $data, 202);
    }

    public function updateStatus($id)
    {
        $pembelian = Pembelian::find($id);

        $pembelian->update([
            'status' => 1
        ]);

        return $this->sendResponse('success', 'status berhasil diupdate', $pembelian, 200);
    }

    /**
     * validate all request
     *
     */
    public function validated($request)
    {
        return $this->validate($request, [
            'supplier'     => 'required',
            'barang'       => 'required',
            'total_barang' => 'required',
            'total_harga'  => 'required'
        ]);
    }
}

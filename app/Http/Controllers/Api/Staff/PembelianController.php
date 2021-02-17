<?php

namespace App\Http\Controllers\Api\Staff;

use App\Models\{Member, Pembelian, Pengeluaran};

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PembelianController extends Controller
{
    /**
     * Get all data pembelian
     *
     */
    public function index()
    {
        $data = Pembelian::get();

        if (count($data) == null) {
            return $this->sendResponse('failed', 'data pembelian kosong', null, 404);
        }

        return $this->sendResponse('success', 'data berhasil dimuat', $data, 200);
    }

    /**
     * function for store data pembelian
     *
     */
    public function store(Request $request)
    {
        $this->validated($request);

        $data = Pembelian::create([
            'supplier_id'   => $request->input('supplier'),
            'barang'        => $request->input('barang'),
            'harga_satuan'  => $request->input('harga_satuan'),
            'total_barang'  => $request->input('total_barang'),
            'total_harga'   => $request->input('harga_satuan') * $request->input('total_barang')
        ]);

        Pengeluaran::create([
            'nama_pengeluaran' => "Pembelian Barang $request->barang",
            'jumlah' => $request->input('harga_satuan') * $request->input('total_barang'),
            'jenis' => 'Pembelian'
        ]);

        return $this->sendResponse('success', 'data berhasil ditambahkan', $data, 202);
    }

    /**
     * Method for update status pembelian
     *
     */

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
            'harga_satuan'  => 'required'
        ]);
    }
}

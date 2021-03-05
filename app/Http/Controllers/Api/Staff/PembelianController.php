<?php

namespace App\Http\Controllers\Api\Staff;

use App\Models\{Pembelian, Pengeluaran, Supplier};

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\PembelianResource;

class PembelianController extends Controller
{
    /**
     * Get all data pembelian
     */
    public function index()
    {
        $data = Pembelian::with('supplier')->get();

        if (count($data) == null) {
            return $this->sendResponse('failed', 'data pembelian kosong', null, 404);
        }

        $data = PembelianResource::collection($data);

        return $this->sendResponse('success', 'data berhasil dimuat', $data, 200);
    }

    /**
     * function for store data pembelian
     */
    public function store(Request $request)
    {
        $this->validated($request);

        DB::beginTransaction();
        $data = Pembelian::create([
            'supplier_id'   => $request->supplier,
            'nama_barang'   => $request->barang,
            'harga_satuan'  => $request->harga_satuan,
            'pcs'           => $request->total_barang,
            'total_harga'   => $request->harga_satuan * $request->total_barang
        ]);

        $supp = Supplier::find(request('supplier'));
        $supp->update([
            'jml_order' => $supp->jml_order + 1
        ]);

        Pengeluaran::create([
            'nama_pengeluaran' => "Pembelian Barang $request->barang",
            'jumlah' => $request->harga_satuan * $request->total_barang,
            'jenis' => 'Pembelian'
        ]);
        DB::commit();

        return $this->sendResponse('success', 'data berhasil ditambahkan', $data, 202);
    }

    /**
     * Method for update status pembelian
     */
    public function updateStatus($id)
    {
        $pembelian = Pembelian::find($id);

        $pembelian->update([
            'status' => 1
        ]);

        return $this->sendResponse('success', 'status berhasil diupdate', $pembelian->only('id', 'barang', 'status', 'created_at'), 202);
    }

    /**
     * validate all request
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

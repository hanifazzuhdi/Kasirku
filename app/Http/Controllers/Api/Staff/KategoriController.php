<?php

namespace App\Http\Controllers\Api\Staff;

use App\Models\{Barang, Kategori};

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\KategoriResource;

class KategoriController extends Controller
{
    /**
     * Method for get all data kategori
     */
    public function index()
    {
        $data = KategoriResource::collection(Kategori::get());

        return $this->sendResponse('success', 'data berhasil dimuat', $data, 200);
    }

    /**
     * Method for add new kategori
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'nama_kategori' => 'required'
        ]);

        $data = Kategori::create($data);

        return $this->sendResponse('success', 'data berhasil ditambahkan', $data->only('id', 'nama_kategori', 'created_at'), 201);
    }

    /**
     * Delete Kategori
     */
    public function delete($id)
    {
        $barang = Barang::find($id);
        $barang->delete();

        return $this->sendResponse('success', 'Kategori berhasil dihapus', $barang, 200);
    }
}

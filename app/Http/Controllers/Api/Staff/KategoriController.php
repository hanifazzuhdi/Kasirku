<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Method for get all data kategori
     *
     */
    public function index()
    {
        $data = Kategori::all();

        return $this->sendResponse('success', 'data berhasil dimuat', $data, 200);
    }

    /**
     * Method for add new kategori
     *
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'nama_kategori' => 'required'
        ]);

        $data = Kategori::create($data);

        return $this->sendResponse('success', 'data berhasil ditambahkan', $data, 202);
    }
}

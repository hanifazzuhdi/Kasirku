<?php

namespace App\Http\Controllers\Api\Staff;

use App\Models\Merek;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MerekResource;

class MerekController extends Controller
{
    /**
     * Method melihat semua data merek
     *
     */

    public function index()
    {
        $datas = MerekResource::collection(Merek::get());

        return $this->sendResponse('success', 'Data merek berhasil ditampilkan', $datas, 200);
    }

    /**
     * Method untuk menambah data merek
     *
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'nama_merek' => 'required'
        ]);

        $merek = Merek::create([
            'nama_merek' => $data['nama_merek']
        ]);

        return $this->sendResponse('success', 'Merek berhasil ditambahkan', $merek->only('id', 'nama_merek', 'created_at'), 201);
    }
}

<?php

namespace App\Http\Controllers\Api\Staff;

use App\Models\Supplier;
use App\Http\Controllers\Controller;
use App\Http\Resources\SupplierResource;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Method for get all data supplier
     */
    public function index()
    {
        $data = SupplierResource::collection(Supplier::get());

        if (count($data) == null) {
            return $this->sendResponse('success', 'Belum ada supplier', null, 200);
        }

        return $this->sendResponse('success', 'data berhasil dimuat', $data, 200);
    }

    /**
     * Method for add new supplier
     *
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'nama_supplier' => 'required'
        ]);

        $data = Supplier::create($data);

        return $this->sendResponse('success', 'data berhasil dibuat', $data->only('id', 'nama_supplier', 'created_at'), 201);
    }
}

<?php

namespace App\Http\Controllers\Api\Staff;

use App\Models\Supplier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        /**
         * Method for get all data supplier
         *
         */
        $data = Supplier::all();

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

        return $this->sendResponse('success', 'data berhasil dibuat', $data, 202);
    }
}

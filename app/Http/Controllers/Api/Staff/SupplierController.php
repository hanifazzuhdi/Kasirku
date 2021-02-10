<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $data = Supplier::all();

        return $this->sendResponse('success', 'data berhasil dimuat', $data, 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_supplier' => 'required'
        ]);

        $data = Supplier::create([
            'nama_supplier' => $request->input('nama_supplier')
        ]);

        return $this->sendResponse('success', 'data berhasil dibuat', $data, 202);
    }
}

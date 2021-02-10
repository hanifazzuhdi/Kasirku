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

    public function store()
    {
        //
    }
}

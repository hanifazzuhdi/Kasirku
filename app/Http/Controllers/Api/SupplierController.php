<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     *
     *  Show all supplier
     *
     */
    public function index()
    {
        $data = Supplier::get();

        return $this->sendResponse('success', 'data berhasil dimuat', $data, 200);
    }
}

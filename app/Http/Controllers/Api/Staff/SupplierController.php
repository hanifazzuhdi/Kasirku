<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function index()
    {
        /**
         * Method for get all data supplier
         *
         */
        $data = Supplier::all();

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

        dd(auth('member')->user());

        $data = Supplier::create($data);

        return $this->sendResponse('success', 'data berhasil dibuat', $data, 202);
    }
}

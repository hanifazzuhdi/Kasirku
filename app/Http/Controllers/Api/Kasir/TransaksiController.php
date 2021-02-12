<?php

namespace App\Http\Controllers\Api\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function validated($request)
    {
        return $this->validate($request, [
            // keranjang
            'uid' => "required",
            'pcs' => 'required'
            // transaksi

        ]);
    }

    public function store(Request $request)
    {
        $this->validated($request);

        DB::beginTransaction();
        // logic transaksi
        Transaksi::create([
            'kasir_id' => Auth::id(),
        ]);

        // logic keranjang
        Keranjang::create([
            //
        ]);
        DB::commit();
    }
}

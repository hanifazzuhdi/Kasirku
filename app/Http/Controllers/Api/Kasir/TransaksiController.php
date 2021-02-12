<?php

namespace App\Http\Controllers\Api\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Barang;
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

        // logic transaksi
        $transaksi = Transaksi::create([
            'kasir_id' => Auth::id(),
        ]);

        $barang = Barang::where('uid', $request->input('uid'))->firstOrFail();

        // logic keranjang
        $keranjang = Keranjang::create([
            'uid' => $request->input('uid'),
            'nama_barang' => $barang->nama_barang,
            'harga' => $barang->harga,
            'pcs' => $request->input('pcs'),
            'total_harga' => $barang->harga * $request->input('pcs'),
            'transaksi_id' => $transaksi->id
        ]);
    }
}

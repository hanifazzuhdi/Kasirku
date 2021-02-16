<?php

namespace App\Http\Controllers\Api\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function validation($request)
    {
        return $this->validate($request, [
            'dibayar' => 'required'
        ]);
    }

    /**
     * Untuk Post pesanan
     *
     */
    public function store(Request $request)
    {
        $this->validation($request);
        $transaksi = Transaksi::transaksiAktif();

        if ($transaksi->harga_total < request('dibayar')) {
            // update
            $transaksi->update([
                'dibayar' => request('dibayar'),
                'kembalian' => request('dibayar') - $transaksi->harga_total,
                'status' => 1
            ]);
        } else if ($transaksi->harga_total > request('dibayar')) {
            return $this->sendResponse('failed', 'Uangnya Kurang', null, 400);
        } else {
            // update
            $transaksi->update([
                'dibayar' => $request->input('dibayar'),
                'status' => 1
            ]);
        }

        return "success";
    }
}

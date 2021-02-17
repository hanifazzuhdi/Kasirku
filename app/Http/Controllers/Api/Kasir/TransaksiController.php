<?php

namespace App\Http\Controllers\Api\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Keranjang;
use App\Models\Transaksi;
use Illuminate\Http\Request;

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

        $transaksi = Transaksi::transaksiAktif()->firstOrFail();

        $this->kurangiStok($transaksi);

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

        // Kurangi stok barang

        return $this->sendResponse('success', 'Transaksi berhasil dilakukan', $transaksi, 202);
    }

    /**
     * Kurangi Stok barang
     *
     */
    public function kurangiStok($transaksi)
    {
        $keranjang = Keranjang::where('transaksi_id', $transaksi->id)->get();

        for ($i = 0; $i < count($keranjang); $i++) {
            # code...
            $barang = Barang::where('uid', $keranjang[$i]->uid)->first();

            $barang->update([
                'stok' => $barang->stok - $keranjang[$i]->pcs
            ]);
        }
    }

    /**
     * Tidak jadi pesan
     *
     */
    public function destroy()
    {
        Transaksi::transaksiAktif()->delete();

        return response()->json(['status' => 'success', 'message' => 'Transaksi berhasil digagalkan'], 202);
    }
}

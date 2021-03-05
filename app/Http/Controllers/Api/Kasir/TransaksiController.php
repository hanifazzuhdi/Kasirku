<?php

namespace App\Http\Controllers\Api\Kasir;

use App\Models\{Barang, Keranjang, Member, Transaksi};

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\KeranjangResource;

class TransaksiController extends Controller
{
    public function validation($request)
    {
        return $this->validate($request, [
            'dibayar' => 'required'
        ]);
    }

    // Jalankan Transaksi Bayar melalui cash
    public function store(Request $request)
    {
        $this->validation($request);

        $transaksi = Transaksi::transaksiAktif()->firstOrFail();

        $keranjang = KeranjangResource::collection(Keranjang::where('transaksi_id', $transaksi->id)->get());

        if ($transaksi->harga_total < request('dibayar')) {
            // Jalankan Transaksi
            DB::beginTransaction();
            $this->kurangiStok($transaksi);

            $transaksi->update([
                'dibayar' => request('dibayar'),
                'kembalian' => request('dibayar') - $transaksi->harga_total,
                'status' => 1
            ]);
            DB::commit();
        } else if ($transaksi->harga_total > request('dibayar')) {
            return $this->sendResponse('failed', 'Uangnya Kurang', null, 400);
        }

        return $this->transaksiResponse($transaksi, $keranjang);
    }

    // Jalankan transaksi bayar pakai saldo member
    public function bayarSaldo(Request $request)
    {
        $member = Member::where('kode_member', $request->kode_member)->firstOrFail();

        $transaksi = Transaksi::transaksiAktif()->firstOrFail();

        $keranjang = KeranjangResource::collection(Keranjang::where('transaksi_id', $transaksi->id)->get());

        if ($member->saldo < $transaksi->harga_total) {
            return $this->sendResponse('failed', 'Saldo tidak cukup', null, 400);
        } else {
            DB::beginTransaction();
            $this->kurangiStok($transaksi);

            $transaksi->update([
                'dibayar' => $transaksi->harga_total,
                'status' => 1,
                'type' => 'Saldo',
                'kode_member' => request('kode_member')
            ]);

            $member->update([
                'saldo' => $member->saldo - $transaksi->harga_total
            ]);
            DB::commit();
        }

        return $this->transaksiResponse($transaksi, $keranjang);
    }

    // Kurangi Stok Barang
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

    // Tidak jadi pesan
    public function destroy()
    {
        Transaksi::transaksiAktif()->delete();

        return response()->json(['status' => 'success', 'message' => 'Transaksi berhasil digagalkan'], 202);
    }
}

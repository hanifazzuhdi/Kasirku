<?php

namespace App\Http\Controllers\Api\Kasir;

use App\Models\{Barang, Keranjang, Transaksi};
use Illuminate\Support\Facades\{Auth, DB};

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransaksiResource;

class KeranjangController extends Controller
{
    // Validasi Request
    public function validated($request)
    {
        return $this->validate($request, [
            'uid' => "required",
            'pcs' => 'required'

        ]);
    }

    // Lihat data keranjang sekarang
    public function index()
    {
        $datas = Keranjang::whereHas('transaksi', function ($q) {
            $q->where('status', 0);
        })->get();

        if (count($datas) == null) {
            return $this->sendResponse('failed', 'Data keranjang masih kosong', null, 400);
        }

        $data = TransaksiResource::collection($datas);

        return response()->json([
            'status' => 'success',
            'message' => 'Data Keranjang berhasil dimuat',
            'total_belanja' => $datas->sum('total_harga'),
            'data' => $data,
        ], 200);
    }

    // Buat Keranjang baru
    public function store(Request $request)
    {
        $this->validated($request);

        DB::beginTransaction();
        // logic transaksi
        $cek_transaksi = Transaksi::transaksiAktif()->first();

        if (empty($cek_transaksi)) {
            $transaksi = Transaksi::create([
                'kasir_id' => Auth::id(),
            ]);
        } else {
            $transaksi = Transaksi::transaksiAktif()->first();
        }

        // logic keranjang
        $barang = Barang::where('uid', request('uid'))->first();

        // Cek Stok
        if ($barang->stok < request('pcs')) {
            return $this->sendResponse('failed', 'Stok Tidak Cukup', null, 400);
        }

        $keranjang = Keranjang::where('uid', $barang->uid)->first();

        if ($keranjang) {
            $keranjang->pcs = $keranjang->pcs + request('pcs');
            $keranjang->total_harga = $barang->harga_jual * $keranjang->pcs;
            $keranjang->save();

            // Cek Stok
            if ($keranjang->pcs > $barang->stok) {
                return $this->sendResponse('failed', 'Stok Tidak Cukup', null, 400);
            }
        } else {
            $keranjang = Keranjang::create([
                'uid' => request('uid'),
                'nama_barang' => $barang->nama_barang,
                'harga' => $barang->harga_jual,
                'pcs' => request('pcs'),
                'total_harga' => $barang->harga_jual * request('pcs'),
                'transaksi_id' => $transaksi->id
            ]);
        }

        // jika dia member
        if (request('kode_member')) {

            $transaksi->update([
                'kode_member' => request('kode_member')
            ]);

            $this->member($transaksi, $barang);
        }

        // update total harga transaksi
        $transaksi->update([
            'harga_total' => Keranjang::where('transaksi_id', $transaksi->id)->sum('total_harga')
        ]);

        DB::commit();

        return $this->sendResponse('success', 'Berhasil tambah ke keranjang', $keranjang, 200);
    }

    public function member($transaksi, $barang)
    {
        // code
        $keranjang = Keranjang::where('transaksi_id', $transaksi->id)->where('uid', $barang->uid)->first();

        $keranjang->update([
            'diskon' => $barang->diskon * $keranjang->pcs,
            'total_harga' => $keranjang->harga * $keranjang->pcs - ($barang->diskon * $keranjang->pcs)
        ]);
    }

    // Hapus 1 Kolom keranjang
    public function destroy(Keranjang $keranjang)
    {
        $total = $keranjang->total_harga;

        $keranjang->delete();

        // kurangi total harga
        $transaksi = Transaksi::transaksiAktif()->first();

        $transaksi->update([
            'harga_total' => $transaksi->harga_total - $total
        ]);

        return $this->sendResponse('success', 'data berhasil dihapus', $keranjang->only('id', 'uid', 'nama_barang', 'total_harga'), 202);
    }
}

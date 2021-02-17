<?php

namespace App\Http\Controllers\Api\Kasir;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransaksiResource;
use Illuminate\Support\Facades\{Auth, DB};
use App\Models\{Barang, Keranjang, Transaksi};

class KeranjangController extends Controller
{
    /**
     * Method for validation request
     *
     */
    public function validated($request)
    {
        return $this->validate($request, [
            'uid' => "required",
            'pcs' => 'required'

        ]);
    }

    /**
     * Lihat keranjang saat ini
     *
     */
    public function index()
    {
        $transaksi = Transaksi::transaksiAktif()->first();

        if (empty($transaksi)) {
            return $this->sendResponse('failed', 'Data keranjang masih kosong', null, 400);
        }

        $datas = Keranjang::where('transaksi_id', $transaksi->id)->get();

        $data = TransaksiResource::collection($datas);

        return $this->sendResponse('success', 'Data berhasil dimuat', $data, 200);
    }

    /**
     * buat keranjang
     *
     */
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
        $barang = Barang::where('uid', $request->input('uid'))->first();

        if ($barang->stok < $request->input('pcs')) {
            return $this->sendResponse('failed', 'Stok barang nggak cukup', $barang->only('uid', 'nama_barang', 'stok'), 400);
        }

        $keranjang = Keranjang::create([
            'uid' => $request->input('uid'),
            'nama_barang' => $barang->nama_barang,
            'harga' => $barang->harga_jual,
            'pcs' => $request->input('pcs'),
            'total_harga' => $barang->harga_jual * $request->input('pcs'),
            'transaksi_id' => $transaksi->id
        ]);

        // jika dia member
        if ($request->input('kode_member')) {
            $keranjang->update([
                'diskon' => $barang->diskon * $request->input('pcs'),
                'total_harga' => $keranjang->total_harga - ($barang->diskon * request('pcs'))
            ]);

            $transaksi->update([
                'kode_member' => $request->input('kode_member')
            ]);
        }

        // update total harga transaksi
        $transaksi->update([
            'harga_total' => $transaksi->harga_total += $keranjang->total_harga,
        ]);
        DB::commit();

        return $this->sendResponse('success', 'Berhasil tambah ke keranjang', $keranjang, 200);
    }

    /**
     * Untuk hapus data 1 kolom keranjang
     *
     */
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

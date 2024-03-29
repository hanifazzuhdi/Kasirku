<?php

namespace App\Http\Controllers\Web\Kasir;

use App\Models\{Barang, Keranjang, Member, Payment, Transaksi};

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{App, Auth, DB};

class KasirController extends Controller
{
    // Tambah Data ke Keranjang
    public function keranjang()
    {
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
            return false;
        }

        $cekKeranjang = Keranjang::whereHas('transaksi', function ($q) {
            $q->where('status', 0);
        })->where('uid', $barang->uid)->first();

        if ($cekKeranjang) {
            $cekKeranjang->pcs = $cekKeranjang->pcs + request('pcs');
            $cekKeranjang->total_harga = $barang->harga_jual * $cekKeranjang->pcs;
            $cekKeranjang->save();

            // Cek Stok
            if ($cekKeranjang->pcs > $barang->stok) {
                return false;
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

        return Keranjang::where('transaksi_id', $transaksi->id)->get();
    }

    // Jika dia member
    public function member($transaksi, $barang)
    {
        // code
        $keranjang = Keranjang::where('transaksi_id', $transaksi->id)->where('uid', $barang->uid)->first();

        $keranjang->update([
            'diskon' => $barang->diskon * $keranjang->pcs,
            'total_harga' => $keranjang->harga * $keranjang->pcs - ($barang->diskon * $keranjang->pcs)
        ]);
    }

    // Bayar melalui Cash
    public function bayar()
    {
        $transaksi = Transaksi::transaksiAktif()->firstOrFail();

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
        }

        return $this->sendResponse('success', 'Transaksi berhasil dilakukan', $transaksi, 202);
    }

    // Jalankan transaksi bayar pakai saldo member
    public function bayarMember(Request $request)
    {
        $member = Member::where('kode_member', $request->kode_member)->firstOrFail();

        $transaksi = Transaksi::transaksiAktif()->firstOrFail();

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

        return $this->sendResponse('success', 'Pembayaran berhasil', $member, 202);
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

    // Hapus 1 Kolom keranjang
    public function hapusKeranjang(Keranjang $keranjang)
    {
        $total = $keranjang->total_harga;

        $keranjang->delete();

        // kurangi total harga
        $transaksi = Transaksi::transaksiAktif()->first();

        $transaksi->update([
            'harga_total' => $transaksi->harga_total - $total
        ]);

        return back();
    }

    // Tidak jadi pesan
    public function destroy()
    {
        Transaksi::transaksiAktif()->where('kasir_id', Auth::id())->delete();

        return response()->json(['status' => 'success', 'message' => 'Transaksi berhasil digagalkan'], 202);
    }

    // cari member
    public function cari(Request $request)
    {
        $member = Member::where('kode_member', $request->kode_member)->firstOrFail();

        return $this->sendResponse('success', 'Member berhasil di muat', $member, 200);
    }

    // Topup saldo
    public function isiSaldo(Request $request)
    {
        $this->validate($request, [
            'kode_member' => 'required',
            'nominal' => 'required'
        ]);

        DB::beginTransaction();
        $member = Member::where('kode_member', $request->kode_member)->firstOrFail();

        $member->update([
            'saldo' => $member->saldo + $request->nominal
        ]);

        Payment::create([
            'order_id'     => 'KASIR-' . date('dmyHis') . '-' . $member->id,
            'jumlah'       => $request->nominal,
            'kode_member'  => $request->kode_member,
            'nama_member'  => $member->nama,
            'nomor_member' => $member->nomor,
            'bank'         => 'Kasir',
            'status'       => 1
        ]);
        DB::commit();

        return $this->sendResponse('success', 'Transaksi berhasil, saldo ditambahkan', $request->nominal, 200);
    }

    // transaksi belum selesai
    public function belumSelesai()
    {
        $keranjang =  Keranjang::whereHas('transaksi', function ($q) {
            $q->where('status', 0)->where('kasir_id', Auth::id());
        })->get();

        if (count($keranjang) == null) {
            return $this->sendResponse('success', 'Data Keranjang Kosong', null, 404);
        }

        return $keranjang;
    }

    // Cetak Struk
    public function cetak()
    {
        $penjualan = Transaksi::where('status', 1)->where('kasir_id', Auth::id())->orderBy('id', 'DESC')->first();

        $keranjang = Keranjang::where('transaksi_id', $penjualan->id)->get();

        $pdf = App::make('dompdf.wrapper');

        $pdf->setPaper('A5');

        $pdf->loadView('dashboard.admin.laporan._cetak-penjualan', compact('keranjang', 'penjualan'));

        return $pdf->stream('struk-penjualan.pdf');
    }
}

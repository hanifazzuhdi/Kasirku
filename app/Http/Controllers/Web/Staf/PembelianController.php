<?php

namespace App\Http\Controllers\Web\Staf;

use App\Models\{Pembelian, Pengeluaran, Supplier};
use Illuminate\Support\Facades\{App, DB};

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class PembelianController extends Controller
{
    /**
     *Tampilkan halaman daftar pembelian
     *
     */
    public function index()
    {
        $datas = Pembelian::with('supplier')->orderBy('id', 'DESC')->paginate(10);

        return view('dashboard.staf.pembelian.index', compact('datas'));
    }

    /**
     * Cari berdasarkan pencarian.
     *
     */
    public function cari(Request $request)
    {
        if (!$request->datefilter) {
            $datas = Pembelian::whereHas('supplier', function ($q) use ($request) {
                $q->where('nama_supplier', 'LIKE', '%' . $request->search . '%');
            })->paginate(10);
        } else {
            $tanggal = $request->datefilter;
            $tHasil = explode(' - ', $tanggal);

            $datas = Pembelian::whereBetween('created_at', [$tHasil[0] . ' 00:00:00', $tHasil[1] . ' 23:59:59'])->paginate(10);
        }

        return view('dashboard.staf.pembelian.index', compact('datas'));
    }

    // Tampilkan halaman buat data pembelian baru
    public function create()
    {
        $datas = Supplier::get();

        return view('dashboard.staf.pembelian.tambah', compact('datas'));
    }

    // Buat data pembelian baru
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'supplier_id' => 'required',
            'nama_barang' => 'required',
            'pcs' => 'required',
            'harga_satuan' => 'required',
        ]);

        $data['total_harga'] = $data['pcs'] * $data['harga_satuan'];

        DB::beginTransaction();
        Pembelian::create($data);

        $supp = Supplier::find(request('supplier_id'));
        $supp->update([
            'jml_order' => $supp->jml_order + 1
        ]);

        Pengeluaran::create([
            'nama_pengeluaran' => "Pembelian Barang " . $request->nama_barang,
            'jumlah' => $request->harga_satuan * $request->pcs,
            'jenis' => 'Pembelian'
        ]);
        DB::commit();

        Alert::success('success', 'Data pembelihan ditambahkan');

        return back();
    }

    // cetak pdf
    public function cetak(Pembelian $pembelian)
    {
        $pembelians = Pembelian::with('supplier')->where('id', $pembelian->id)->get();

        $pdf = App::make('dompdf.wrapper');

        $pdf->setPaper('A5');

        $pdf->loadView('dashboard.staf.pembelian._cetak', compact('pembelians'));

        return $pdf->stream('laporan.pdf');
    }
}

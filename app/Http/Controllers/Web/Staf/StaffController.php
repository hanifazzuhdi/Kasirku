<?php

namespace App\Http\Controllers\Web\Staf;

use Illuminate\Http\Request;

use App\Models\{Pembelian, Pengeluaran, Supplier};

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class StaffController extends Controller
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
        if (!$request->input('datefilter')) {
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

    // Buat Supplier Baru
    public function addSupplier(Request $request)
    {
        $data = $this->validate($request, [
            'nama_supplier' => 'required'
        ]);

        Supplier::create($data);

        Alert::toast('Supplier berhasil ditambahkan', 'success');

        return back();
    }

    // Buat data pembelian baru
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'supplier_id' => 'required',
            'barang' => 'required',
            'total_barang' => 'required',
            'harga_satuan' => 'required',
        ]);

        $data['total_harga'] = $data['total_barang'] * $data['harga_satuan'];

        DB::beginTransaction();
        Pembelian::create($data);

        $supp = Supplier::find(request('supplier_id'));
        $supp->update([
            'jml_order' => $supp->jml_order + 1
        ]);

        Pengeluaran::create([
            'nama_pengeluaran' => "Pembelian Barang $request->barang",
            'jumlah' => $request->input('harga_satuan') * $request->input('total_barang'),
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

        // return view('dashboard.staf.pembelian._cetak', compact('pembelians'));

        $pdf = App::make('dompdf.wrapper');

        $pdf->loadView('dashboard.staf.pembelian._cetak', compact('pembelians'));

        return $pdf->download('invoice.pdf');
    }
}

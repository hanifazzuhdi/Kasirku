<?php

namespace App\Http\Controllers\Web\Admin;

use App\Models\{Pengeluaran, Pembelian};

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    public function index()
    {
        $pengeluarans = Pengeluaran::where('jenis', 'Pengeluaran')->limit(3)->get();
        $pembelians = Pengeluaran::where('jenis', 'Pembelian')->limit(3)->get();

        return view('dashboard.pages.admin.pengeluaran', compact('pengeluarans', 'pembelians'));
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'nama_pengeluaran' => 'required',
            'jumlah' => 'required',
        ]);

        Pengeluaran::create($data);

        return back();
    }
}

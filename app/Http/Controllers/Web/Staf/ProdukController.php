<?php

namespace App\Http\Controllers\Web\Staf;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     *Tampilkan halaman daftar produk
     *
     */
    public function index()
    {
        $datas = Barang::orderBy('id', 'DESC')->paginate(10);

        return view('dashboard.staf.produk.index', compact('datas'));
    }
}

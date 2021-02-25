<?php

namespace App\Http\Controllers\Web\Staf;

use App\Models\{Kategori, Merek, Supplier};

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class StaffController extends Controller
{
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

    // Buat Kategori Baru
    public function addKategori(Request $request)
    {
        $data = $this->validate($request, [
            'nama_kategori' => 'required'
        ]);

        Kategori::create($data);

        Alert::toast('Kategori berhasil ditambahkan', 'success');

        return back();
    }

    // Buat Merek Baru
    public function addMerek(Request $request)
    {
        $data = $this->validate($request, [
            'nama_merek' => 'required'
        ]);

        Merek::create($data);

        Alert::toast('Merek berhasil ditambahkan', 'success');

        return back();
    }
}

<?php

namespace App\Exports;

use App\Models\Pembelian;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('dashboard.admin.laporan._cetak-pembelian', [
            'datas' => Pembelian::with('supplier')->get()
        ]);
    }
}

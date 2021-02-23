<?php

namespace App\Exports;

use App\Models\Transaksi as ModelsTransaksi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PenjualanExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('dashboard.admin.laporan._export-penjualan', [
            'datas' => ModelsTransaksi::with('kasir')->get()
        ]);
    }
}

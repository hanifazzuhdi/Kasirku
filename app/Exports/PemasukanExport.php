<?php

namespace App\Exports;

use App\Models\Transaksi;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PemasukanExport implements FromView
{
    public $bulan;

    public function __construct($bulan)
    {
        $this->bulan = $bulan;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('dashboard.admin.laporan._pemasukan-export', [
            'datas' => Transaksi::whereMonth('created_at', $this->bulan)->get()
        ]);
    }
}

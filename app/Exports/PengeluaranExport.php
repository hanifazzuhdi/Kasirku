<?php

namespace App\Exports;

use App\Models\Pengeluaran;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PengeluaranExport implements FromView
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
        return view('dashboard.admin.laporan._pengeluaran-export', [
            'datas' => Pengeluaran::whereMonth('created_at', $this->bulan)->get()
        ]);
    }
}

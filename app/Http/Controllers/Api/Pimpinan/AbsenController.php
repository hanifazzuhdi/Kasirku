<?php

namespace App\Http\Controllers\Api\Pimpinan;

use App\Models\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AbsenController extends Controller
{
    // abssen harian
    public function harian()
    {
        $datas = Log::where('date', date('Y-m-d'))->orderBy('id', 'DESC')->get();

        return $this->sendResponse('success', 'Data absen berhasil dimuat', $datas, 200);
    }

    // Absen bulanan
    public function bulanan(Request $request)
    {
        $this->validate($request, [
            'bulan' => 'required'
        ]);

        // cari data
        $datas = Log::whereMonth('created_at', request('bulan'))->get();

        return $this->sendResponse('success', 'Data absen berhasil dimuat', $datas, 200);
    }
}

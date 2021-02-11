<?php

namespace App\Http\Controllers\Api\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;

class SaldoController extends Controller
{
    /**
     * Method get saldo
     *
     */
    public function index()
    {
        $data = Member::where('id', auth('member')->id())->first();

        return $this->sendResponse('success', 'Saldo berhasil dimuat', $data->saldo, 200);
    }
}

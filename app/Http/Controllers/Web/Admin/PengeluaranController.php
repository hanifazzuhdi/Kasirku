<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.admin.pengeluaran');
    }
}

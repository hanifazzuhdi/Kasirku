<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Member;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $member = Member::MemberActive()->count();

        $logs = Log::orderBy('id', 'DESC')->get();

        return view('dashboard.home', compact('member', 'logs'));
    }
}

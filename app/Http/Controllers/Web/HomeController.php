<?php

namespace App\Http\Controllers\Web;

use App\Models\{Log, Member};

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $member = Member::MemberActive()->count();

        $logs = Log::orderBy('id', 'DESC')->limit(3)->get();

        return view('dashboard.home', compact('member', 'logs'));
    }
}

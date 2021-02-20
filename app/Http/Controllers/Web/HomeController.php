<?php

namespace App\Http\Controllers\Web;

use App\Models\{Log, Member};

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function admin()
    {
        $member = Member::MemberActive()->count();
        $logs = Log::orderBy('id', 'DESC')->limit(3)->get();

        return view('dashboard.admin.home.index', compact('member', 'logs'));
    }

    public function staf()
    {
        return view('dashboard.staf.home.index');
    }
}

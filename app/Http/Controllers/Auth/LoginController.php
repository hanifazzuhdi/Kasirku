<?php

namespace App\Http\Controllers\Auth;

use App\Events\LoginKaryawan;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::DASHBOARD;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Login
    protected function sendLoginResponse($request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if (auth()->user()->role_id == 1) {
            return redirect()->route('home');
        } else {
            event(new LoginKaryawan($request->email, 'Web', 'Login'));

            if (auth()->user()->role_id == 2) {
                return redirect()->route('staf');
            } else {
                return redirect()->route('kasir');
            }
        }
    }
}

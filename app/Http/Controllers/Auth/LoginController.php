<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

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

    public function redirectTo() {
        if (Auth::user()->role == "peserta") {
            return route('peserta');
        } else if (Auth::user()->role == "upgrade") {
            return route('upgrade');
        } else if (Auth::user()->role == "pasar") {
            return route('market');
        } else if (Auth::user()->role == "acara") {
            return route('score-recap');
        } else if (Auth::user()->role == "lokal") {
            return route('ingredient-lokal');
        } else if (Auth::user()->role == "impor") {
            return route('ingredient-import');
        } else if (Auth::user()->role == "administrator") {
            return route('batch');
        }
    }
 
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function username()
    {
        return 'username';
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/login');
    }
}
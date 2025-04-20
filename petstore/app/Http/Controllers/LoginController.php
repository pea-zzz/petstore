<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function showUserLoginForm()
    {
        return view('auth.login');
    }

    public function userLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $remember = $request->has('remember'); 

        if (Auth::attempt($credentials, $remember)) { 
            $request->session()->regenerate();
            
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->intended('/home');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }


    public function showAdminLoginForm()
    {
        return view('auth.login', ['url' => 'admin']); 
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $remember = $request->has('remember'); 

        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            session()->forget('url.intended'); 

            if (Auth::guard('admin')->user()->role == 'admin') {
                return redirect()->route('admin.dashboard');
            }
        }

        return back()->withInput($request->only('email', 'remember'));
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/home');
    }
}

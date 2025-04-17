<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('loginRegister.login');
    }

    public function login(Request $request)
    {
        // Validate login data
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);
    
        // Attempt to login
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Migrate guest history after login
            app(\App\Http\Controllers\BrowsingHistoryController::class)->migrateGuestHistory();
    
            // Set a cookie for session tracking
            $cookie = cookie('user_session', Auth::user()->id, 60); // 60 minutes
    
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->withCookie($cookie);
            }
            
            return redirect()->intended($this->redirectTo)->withCookie($cookie);
        }

        // Login failed
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email', 'remember'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the login page after logout
        return redirect()->route('login')->with('status', 'You have been logged out.');
    }
}
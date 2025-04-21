<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    // Admin dashboard
    public function index()
    {
        if (Gate::denies('isAdmin')) {
            abort(403, 'Unauthorized');
        }

        return view('admin.dashboard'); 
    }

    // Admin logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

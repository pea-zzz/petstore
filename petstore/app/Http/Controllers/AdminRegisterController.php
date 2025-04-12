<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (User::where('role', 'admin')->exists()) {
                return redirect()->route('login')->with('status', 'Admin already exists.');
            }
            return $next($request);
        });
    }

    public function showRegistrationForm()
    {
        return view('loginRegister.adminRegister');
    }

    public function registerAdmin(Request $request)
    {
        if (User::where('role', 'admin')->exists()) {
            return redirect()->route('login')->with('status', 'Admin already exists.');
        }

        // Validate input data
        $request->validate([
            'name' => 'required | max:255',
            'email' => 'required | email | max:255 | unique:users',
            'password' => 'required | min:8 | max:12 | regex:/[a-z]/ | regex:/[A-Z]/ | regex:/[0-9]/ | regex:/[@$!%*#?&]/ | confirmed',
            'phone_number' => 'required | max:15', 
            'address' => 'required | max:500', 
        ]);

        // Create a new admin user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        // Log the user in
        Auth::login($user);

        // Redirect to the admin dashboard or wherever appropriate
        return redirect()->route('admin.dashboard')->with('status', 'Admin registered successfully.');
    }
}

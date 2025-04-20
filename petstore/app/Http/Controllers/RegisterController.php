<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showUserRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required | max:255',
            'email' => 'required | email | max:255 | unique:users',
            'password' => 'required | min:8 | max:15 | regex:/[a-z]/ | regex:/[A-Z]/ | regex:/[0-9]/ | regex:/[@$!%*#?&]/ | confirmed',
            'phone_number' => 'required | min:10 | max:11', 
            'address' => 'required | max:500', 
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'role' => 'user', 
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }


    public function showAdminRegistrationForm()
    {
        return view('auth.adminRegister');
    }

    public function registerAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users|unique:admins',
            'password' => 'required | min:8 | max:15 | regex:/[a-z]/ | regex:/[A-Z]/ | regex:/[0-9]/ | regex:/[@$!%*#?&]/ | confirmed',
        ]);

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        User::create([
            'name' => $admin->name,
            'email' => $admin->email,
            'password' => $admin->password, 
            'role' => 'admin',
        ]);


        Auth::guard('admin')->login($admin);

        return redirect()->route('admin.dashboard')->with('status', 'Admin registered successfully.');
    }

}

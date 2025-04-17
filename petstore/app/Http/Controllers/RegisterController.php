<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('loginRegister.register');
    }

    public function register(Request $request)
    {
        // Validate input data
        $request->validate([
            'name' => 'required | max:255',
            'email' => 'required | email | max:255 | unique:users',
            'password' => 'required | min:8 | max:15 | regex:/[a-z]/ | regex:/[A-Z]/ | regex:/[0-9]/ | regex:/[@$!%*#?&]/ | confirmed',
            'phone_number' => 'required | min:10 | max:11', 
            'address' => 'required | max:500', 
        ]);

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        // Log the user in
        Auth::login($user);

        // Migrate guest history after login
        app(\App\Http\Controllers\BrowsingHistoryController::class)->migrateGuestHistory();

        // Redirect to the intended path
        return redirect($this->redirectTo);
    }

}
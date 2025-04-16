<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function showProfile()
    {
        return view('profile');     // profile.blade.php
    }
    
    public function edit()
    {
        return view('profile_edit');    // profile_edit.blade.php
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();
        $user->update($request->only('name', 'email', 'phone_number', 'address'));

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }
}

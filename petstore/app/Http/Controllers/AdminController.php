<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (Gate::denies('access-admin-dashboard')) {
            abort(403, 'Unauthorized');
        }

        return view('reviews.admindashboard');
    }
}
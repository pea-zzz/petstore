<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class AutoLoginFromCookie
{
    public function handle(Request $request, Closure $next)
    {
        // if the user is not authenticated and the cookie exists
        if (!Auth::check() && $request->hasCookie('user_session')) {
            $userId = $request->cookie('user_session');
            $user = User::find($userId);

            if ($user) {
                Auth::login($user);
            }
        }

        return $next($request);

        
    }

    
}

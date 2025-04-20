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

    // 用户登录
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

        $remember = $request->has('remember'); // ✅ 加这一行

        if (Auth::attempt($credentials, $remember)) { // ✅ 传进去
            $request->session()->regenerate();
            
            // 检查用户角色，跳转到对应的页面
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

    // 管理员登录
    public function showAdminLoginForm()
    {
        return view('auth.login', ['url' => 'admin']); // 传递 'admin' 以便区分视图
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $remember = $request->has('remember'); // ✅ 同样加这一行

        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            session()->forget('url.intended'); // 清除 redirect URL，防止跳错

            // 额外检查角色，确保是管理员
            if (Auth::guard('admin')->user()->role == 'admin') {
                return redirect()->route('admin.dashboard'); // 强制跳转到管理员面板
            }
        }

        return back()->withInput($request->only('email', 'remember'));
    }

    // 退出登录
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/home'); // 登出后重定向到 home
    }
}

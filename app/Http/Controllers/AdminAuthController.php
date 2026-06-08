<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            if (Auth::user()->is_admin) {
                return redirect()->route('admin.dashboard');
            }
            Auth::logout();
            return back()->withErrors(['email' => 'You are not an admin!']);
        }

        return back()->withErrors(['email' => 'Invalid email or password!']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
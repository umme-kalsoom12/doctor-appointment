<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $email    = $request->email;
        $password = $request->password;

        // DOCTOR check
        $doctor = Doctor::where('email', $email)->first();
        if ($doctor && !empty($doctor->password) && Hash::check($password, $doctor->password)) {
            Auth::logout();
            Auth::guard('doctor')->login($doctor);
            return redirect('/doctor/dashboard');
        }

        // ADMIN check
        $admin = User::where('email', $email)->first();
        if ($admin && Hash::check($password, $admin->password)) {
            Auth::login($admin);
            if ((int)$admin->is_admin === 1) {
                return redirect('/admin/dashboard');
            }
            return redirect('/dashboard');
        }

        return back()
            ->withErrors(['email' => 'Email ya password galat hai!'])
            ->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Auth::guard('doctor')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:patient,doctor',
        ]);

        if ($request->role == 'doctor') {
            if (Doctor::where('email', $request->email)->exists()) {
                return back()->withErrors(['email' => 'Email already registered!'])->withInput();
            }
            $doctor = Doctor::create([
                'name'           => $request->name,
                'email'          => $request->email,
                'password'       => Hash::make($request->password),
                'specialization' => $request->specialization ?? 'General Physician',
                'phone'          => $request->phone ?? '0300-0000000',
                'experience'     => $request->experience ?? 0,
                'fee'            => $request->fee ?? 500,
            ]);
            Auth::guard('doctor')->login($doctor);
            return redirect('/doctor/dashboard');
        }

        if (User::where('email', $request->email)->exists()) {
            return back()->withErrors(['email' => 'Email already registered!'])->withInput();
        }
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => 0,
        ]);
        Auth::login($user);
        return redirect('/dashboard');
    }
}
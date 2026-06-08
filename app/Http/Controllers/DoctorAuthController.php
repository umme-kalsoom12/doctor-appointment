<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Appointment;
use Illuminate\Support\Facades\Hash;

class DoctorAuthController extends Controller
{
    public function showLogin()
    {
        return view('doctor.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $doctor = Doctor::where('email', $request->email)->first();

        if ($doctor && Hash::check($request->password, $doctor->password)) {
            Auth::guard('doctor')->login($doctor);
            return redirect('/doctor/dashboard');
        }

        return back()->withErrors(['email' => 'Invalid email or password!']);
    }

    public function logout()
    {
        Auth::guard('doctor')->logout();
        return redirect('/login');
    }

    public function dashboard()
    {
        $doctor = Auth::guard('doctor')->user();

        if (!$doctor) {
            return redirect('/login');
        }

        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->with('user')
            ->latest()
            ->get();

        $schedules = DoctorSchedule::where('doctor_id', $doctor->id)->get();
        $pendingCount = $appointments->where('status', 'pending')->count();

        return view('doctor.dashboard', compact('doctor', 'appointments', 'schedules', 'pendingCount'));
    }

    public function approveAppointment($id)
    {
        $doctor = Auth::guard('doctor')->user();

        $appointment = Appointment::where('id', $id)
            ->where('doctor_id', $doctor->id)
            ->firstOrFail();

        $appointment->update([
            'status'           => 'confirmed',
            'patient_notified' => false
        ]);

        return redirect('/doctor/dashboard')->with('success', 'Appointment approved!');
    }

    public function rejectAppointment(Request $request, $id)
    {
        $doctor = Auth::guard('doctor')->user();

        $appointment = Appointment::where('id', $id)
            ->where('doctor_id', $doctor->id)
            ->firstOrFail();

        $appointment->update([
            'status'           => 'cancelled',
            'rejection_reason' => $request->reason ?? 'Doctor unavailable',
            'patient_notified' => false
        ]);

        return redirect('/doctor/dashboard')->with('success', 'Appointment rejected!');
    }

    public function saveSchedule(Request $request)
    {
        $doctor = Auth::guard('doctor')->user();

        DoctorSchedule::where('doctor_id', $doctor->id)->delete();

        foreach ($request->day as $i => $day) {
            DoctorSchedule::create([
                'doctor_id'    => $doctor->id,
                'day'          => $day,
                'start_time'   => $request->start_time[$i],
                'end_time'     => $request->end_time[$i],
                'is_available' => isset($request->is_available[$i]) ? 1 : 0,
            ]);
        }

        return redirect('/doctor/dashboard')->with('success', 'Schedule saved!');
    }
}
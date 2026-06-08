<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalDoctors = Doctor::count();
        $totalPatients = User::where('is_admin', false)->count();
        $totalAppointments = Appointment::count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();
        $recentAppointments = Appointment::with(['doctor', 'user'])->latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'totalDoctors', 'totalPatients',
            'totalAppointments', 'pendingAppointments',
            'recentAppointments'
        ));
    }

    public function doctors()
    {
        $doctors = Doctor::all();
        return view('admin.doctors', compact('doctors'));
    }

    public function addDoctor(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:100',
            'specialization' => 'required|string|max:100',
            'email'          => 'required|email|unique:doctors',
            'phone'          => 'required|string|max:20',
            'experience'     => 'required|integer|min:0',
            'fee'            => 'required|numeric|min:0',
            'password'       => 'required|min:6',
        ]);

        Doctor::create([
            'name'           => $request->name,
            'specialization' => $request->specialization,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'experience'     => $request->experience,
            'fee'            => $request->fee,
            'password'       => Hash::make($request->password),
        ]);

        return redirect()->route('admin.doctors')->with('success', 'Doctor added successfully!');
    }

    public function deleteDoctor($id)
    {
        Doctor::findOrFail($id)->delete();
        return redirect()->route('admin.doctors')->with('success', 'Doctor deleted successfully!');
    }

    public function appointments()
    {
        $appointments = Appointment::with(['doctor', 'user'])->latest()->get();
        return view('admin.appointments', compact('appointments'));
    }

    public function updateStatus(Request $request, $id)
    {
        Appointment::findOrFail($id)->update(['status' => $request->status]);
        return redirect()->route('admin.appointments')->with('success', 'Status updated!');
    }
}
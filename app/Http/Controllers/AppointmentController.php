<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function dashboard()
    {
        $appointments = Appointment::where('user_id', auth()->id())
            ->with('doctor')
            ->latest()
            ->get();
        return view('dashboard', compact('appointments'));
    }

    public function create(Doctor $doctor)
    {
        $schedules = $doctor->schedules()->where('is_available', 1)->get();
        return view('appointment.create', compact('doctor', 'schedules'));
    }

   public function store(Request $request)
{
    $request->validate([
        'doctor_id'        => 'required|exists:doctors,id',
        'appointment_date' => 'required|date|after:today',
        'appointment_time' => 'required',
        'notes'            => 'nullable|string|max:500',
    ]);

    $doctor = \App\Models\Doctor::find($request->doctor_id);
    $date = \Carbon\Carbon::parse($request->appointment_date);
    $dayName = $date->format('l'); // Monday, Tuesday etc

    // Schedule check karo
    $schedules = $doctor->schedules()->where('is_available', 1)->get();

    if ($schedules->count() > 0) {
        $availableDays = $schedules->pluck('day')->toArray();

        if (!in_array($dayName, $availableDays)) {
            return back()
                ->withErrors(['appointment_date' => "Dr. {$doctor->name} {$dayName} ko available nahi hain! Available days: " . implode(', ', $availableDays)])
                ->withInput();
        }

        // Time check karo
        $schedule = $schedules->where('day', $dayName)->first();
        $selectedTime = \Carbon\Carbon::createFromFormat('H:i', $request->appointment_time);
        $startTime = \Carbon\Carbon::createFromFormat('H:i:s', $schedule->start_time);
        $endTime = \Carbon\Carbon::createFromFormat('H:i:s', $schedule->end_time);

        if ($selectedTime < $startTime || $selectedTime > $endTime) {
            return back()
                ->withErrors(['appointment_time' => "Is time pe doctor available nahi! Available time: " . $startTime->format('h:i A') . " - " . $endTime->format('h:i A')])
                ->withInput();
        }
    }

    Appointment::create([
        'user_id'          => auth()->id(),
        'doctor_id'        => $request->doctor_id,
        'appointment_date' => $request->appointment_date,
        'appointment_time' => $request->appointment_time,
        'notes'            => $request->notes,
        'status'           => 'pending',
    ]);

    return redirect()->route('dashboard')
        ->with('success', 'Appointment request sent! Waiting for doctor approval.');
}

    public function myAppointments()
    {
        $appointments = Appointment::where('user_id', auth()->id())
            ->with('doctor')
            ->latest()
            ->get();
        return view('appointments.my', compact('appointments'));
    }

    public function cancel($id)
    {
        $appointment = Appointment::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        $appointment->update(['status' => 'cancelled']);
        return redirect()->route('appointments.my')
            ->with('success', 'Appointment cancelled!');
    }
}
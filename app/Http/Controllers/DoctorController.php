<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('schedules')->get();
        $specializations = Doctor::distinct()->pluck('specialization');
        return view('doctors.index', compact('doctors', 'specializations'));
    }

    public function search(Request $request)
    {
        $query = Doctor::with('schedules')->query();

        if ($request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->specialization) {
            $query->where('specialization', $request->specialization);
        }

        if ($request->max_fee) {
            $query->where('fee', '<=', $request->max_fee);
        }

        $doctors = $query->get();
        $specializations = Doctor::distinct()->pluck('specialization');
        return view('doctors.index', compact('doctors', 'specializations'));
    }
}
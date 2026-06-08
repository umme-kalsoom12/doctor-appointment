<?php

namespace App\Http\Controllers;

use App\Models\Doctor;

class HomeController extends Controller
{
    public function index()
    {
        $doctors = Doctor::take(6)->get();
        return view('home', compact('doctors'));
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [
            ['name' => 'Ahmed Raza', 'specialization' => 'Cardiologist', 'email' => 'ahmed@medicare.com', 'phone' => '0300-1111111', 'experience' => 10, 'fee' => 1500],
            ['name' => 'Sara Khan', 'specialization' => 'Dermatologist', 'email' => 'sara@medicare.com', 'phone' => '0300-2222222', 'experience' => 7, 'fee' => 1200],
            ['name' => 'Ali Hassan', 'specialization' => 'Neurologist', 'email' => 'ali@medicare.com', 'phone' => '0300-3333333', 'experience' => 12, 'fee' => 2000],
            ['name' => 'Fatima Malik', 'specialization' => 'Pediatrician', 'email' => 'fatima@medicare.com', 'phone' => '0300-4444444', 'experience' => 8, 'fee' => 1000],
            ['name' => 'Usman Tariq', 'specialization' => 'Orthopedic', 'email' => 'usman@medicare.com', 'phone' => '0300-5555555', 'experience' => 15, 'fee' => 2500],
            ['name' => 'Ayesha Noor', 'specialization' => 'General Physician', 'email' => 'ayesha@medicare.com', 'phone' => '0300-6666666', 'experience' => 5, 'fee' => 800],
        ];

        foreach ($doctors as $doctor) {
            Doctor::create($doctor);
        }
    }
}

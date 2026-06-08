<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AIController;

Route::get('/', function() { return redirect('/login'); });

// AUTH
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// PATIENT
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AppointmentController::class, 'dashboard'])->name('dashboard');
    Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
    Route::get('/doctors/search', [DoctorController::class, 'search'])->name('doctors.search');
    Route::get('/book-appointment/{doctor}', [AppointmentController::class, 'create'])->name('appointment.create');
    Route::post('/book-appointment', [AppointmentController::class, 'store'])->name('appointment.store');
    Route::get('/my-appointments', [AppointmentController::class, 'myAppointments'])->name('appointments.my');
    Route::delete('/appointments/{id}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ADMIN
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/doctors', [AdminController::class, 'doctors'])->name('admin.doctors');
    Route::post('/admin/doctors', [AdminController::class, 'addDoctor'])->name('admin.doctors.add');
    Route::delete('/admin/doctors/{id}', [AdminController::class, 'deleteDoctor'])->name('admin.doctors.delete');
    Route::get('/admin/appointments', [AdminController::class, 'appointments'])->name('admin.appointments');
    Route::post('/admin/appointments/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.appointments.status');
Route::post('/ai/symptom-check', [AIController::class, 'symptomCheck'])->name('ai.symptom');
});
// DOCTOR
Route::get('/doctor/login', [DoctorAuthController::class, 'showLogin'])->name('doctor.login');
Route::post('/doctor/login', [DoctorAuthController::class, 'login'])->name('doctor.login.post');
Route::post('/doctor/logout', [DoctorAuthController::class, 'logout'])->name('doctor.logout');

Route::middleware(['auth.doctor'])->group(function () {
    Route::get('/doctor/dashboard', [DoctorAuthController::class, 'dashboard'])->name('doctor.dashboard');
    Route::post('/doctor/schedule', [DoctorAuthController::class, 'saveSchedule'])->name('doctor.schedule.save');
    Route::post('/doctor/appointments/{id}/approve', [DoctorAuthController::class, 'approveAppointment'])->name('doctor.appointment.approve');
    Route::post('/doctor/appointments/{id}/reject', [DoctorAuthController::class, 'rejectAppointment'])->name('doctor.appointment.reject');
});
Route::get('/test-login', function() {
    $email = 'admin@medicare.com';
    $password = 'admin123';
    
    $user = \App\Models\User::where('email', $email)->first();
    
    if (!$user) return "User not found!";
    
    $passCheck = app('hash')->check($password, $user->password);
    $isAdmin = $user->is_admin;
    
    return "User: {$user->name} | is_admin: {$isAdmin} | Password: " . ($passCheck ? 'CORRECT' : 'WRONG');
});
require __DIR__.'/auth.php';
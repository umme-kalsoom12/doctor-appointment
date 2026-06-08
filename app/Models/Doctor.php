<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Doctor extends Authenticatable
{
    protected $guard = 'doctor';

    protected $fillable = [
        'name', 'specialization', 'email',
        'phone', 'image', 'experience', 'fee', 'password', 'status'
    ];

    protected $hidden = ['password'];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function schedules()
{
    return $this->hasMany(DoctorSchedule::class);
}
}
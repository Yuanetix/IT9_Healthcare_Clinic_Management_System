<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // Add this import

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id', 'first_name', 'last_name', 'email', 'phone',
        'specialization', 'qualifications', 'experience',
        'clinic_assignment', 'consultation_fee', 'status'
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function getFullNameAttribute()
    {
        return "Dr. {$this->first_name} {$this->last_name}";
    }

    // Fix: Add type declarations for parameters
    public function isAvailable(\Carbon\Carbon|\DateTime $date, string $time): bool
    {
        $day = $date->format('l');
        $schedule = $this->schedules()->where('day', $day)->first();
        
        if (!$schedule) {
            return false;
        }
        
        $appointmentCount = $this->appointments()
            ->where('appointment_date', $date)
            ->where('appointment_time', $time)
            ->whereNotIn('status', ['Cancelled'])
            ->count();
            
        return $appointmentCount === 0;
    }
}
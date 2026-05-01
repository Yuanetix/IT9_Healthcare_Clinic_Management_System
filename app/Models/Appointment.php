<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_number', 'patient_id', 'doctor_id', 'appointment_date',
        'appointment_time', 'status', 'symptoms', 'notes', 'service_type',
        'consultation_fee'
    ];

    protected $casts = [
        'appointment_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function canBeCancelled()
    {
        return in_array($this->status, ['Pending', 'Confirmed']);
    }

    public function canBeRescheduled()
    {
        return in_array($this->status, ['Pending', 'Confirmed']);
    }
}
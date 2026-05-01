<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number', 'appointment_id', 'patient_id', 'consultation_fee',
        'additional_services_fee', 'total_amount', 'paid_amount',
        'outstanding_balance', 'payment_status', 'payment_method',
        'additional_services', 'payment_date'
    ];

    protected $casts = [
        'payment_date' => 'datetime',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    
    public function recordPayment(float $amount, string $method): self
    {
        $this->paid_amount += $amount;
        $this->outstanding_balance = $this->total_amount - $this->paid_amount;
        
        if ($this->outstanding_balance <= 0) {
            $this->payment_status = 'Paid';
            $this->paid_amount = $this->total_amount;
            $this->outstanding_balance = 0;
        } else {
            $this->payment_status = 'Partial';
        }
        
        $this->payment_method = $method;
        $this->payment_date = now();
        $this->save();
        
        return $this;
    }

    // Fix: Add return type declaration
    public function refund(): self
    {
        $this->payment_status = 'Refunded';
        $this->paid_amount = 0;
        $this->outstanding_balance = $this->total_amount;
        $this->save();
        
        return $this;
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'asc')
            ->paginate(10);
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::where('status', 'Active')->get();
        return view('appointments.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'service_type' => 'required|in:General Check-up,Specialist Consultation,Follow-up,Emergency',
            'symptoms' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Check for overlapping appointments
        $exists = Appointment::where('doctor_id', $validated['doctor_id'])
            ->where('appointment_date', $validated['appointment_date'])
            ->where('appointment_time', $validated['appointment_time'])
            ->whereNotIn('status', ['Cancelled'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'This time slot is already booked.')->withInput();
        }

        $doctor = Doctor::find($validated['doctor_id']);
        $validated['appointment_number'] = 'APT' . str_pad(Appointment::count() + 1, 6, '0', STR_PAD_LEFT);
        $validated['consultation_fee'] = $doctor->consultation_fee;
        $validated['status'] = 'Pending';

        $appointment = Appointment::create($validated);

        // Create invoice/transaction
        Transaction::create([
            'invoice_number' => 'INV' . str_pad(Transaction::count() + 1, 6, '0', STR_PAD_LEFT),
            'appointment_id' => $appointment->id,
            'patient_id' => $validated['patient_id'],
            'consultation_fee' => $doctor->consultation_fee,
            'additional_services_fee' => 0,
            'total_amount' => $doctor->consultation_fee,
            'paid_amount' => 0,
            'outstanding_balance' => $doctor->consultation_fee,
            'payment_status' => 'Unpaid'
        ]);

        return redirect()->route('appointments.index')->with('success', 'Appointment scheduled successfully.');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor', 'transaction']);
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::all();
        $doctors = Doctor::where('status', 'Active')->get();
        return view('appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'service_type' => 'required|in:General Check-up,Specialist Consultation,Follow-up,Emergency',
            'symptoms' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Check for overlapping (excluding current appointment)
        $exists = Appointment::where('doctor_id', $appointment->doctor_id)
            ->where('appointment_date', $validated['appointment_date'])
            ->where('appointment_time', $validated['appointment_time'])
            ->where('id', '!=', $appointment->id)
            ->whereNotIn('status', ['Cancelled'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'This time slot is already booked.')->withInput();
        }

        $appointment->update($validated);

        return redirect()->route('appointments.index')->with('success', 'Appointment rescheduled successfully.');
    }

    public function confirm(Appointment $appointment)
    {
        $appointment->update(['status' => 'Confirmed']);
        return redirect()->back()->with('success', 'Appointment confirmed.');
    }

    public function complete(Appointment $appointment)
    {
        $appointment->update(['status' => 'Completed']);
        return redirect()->back()->with('success', 'Appointment marked as completed.');
    }

    public function cancel(Appointment $appointment)
    {
        $appointment->update(['status' => 'Cancelled']);
        
        // Handle refund if payment was made
        $transaction = $appointment->transaction;
        if ($transaction && $transaction->payment_status == 'Paid') {
            $transaction->update(['payment_status' => 'Refunded']);
        }
        
        return redirect()->back()->with('success', 'Appointment cancelled.');
    }

    public function getAvailableSlots(Request $request)
    {
        $doctorId = $request->doctor_id;
        $date = $request->date;
        
        $bookedSlots = Appointment::where('doctor_id', $doctorId)
            ->where('appointment_date', $date)
            ->whereNotIn('status', ['Cancelled'])
            ->pluck('appointment_time')
            ->toArray();
        
        // Available time slots (30-minute intervals)
        $allSlots = [];
        for ($hour = 9; $hour < 17; $hour++) {
            $allSlots[] = sprintf("%02d:00", $hour);
            $allSlots[] = sprintf("%02d:30", $hour);
        }
        
        $availableSlots = array_diff($allSlots, $bookedSlots);
        
        return response()->json(['slots' => array_values($availableSlots)]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::orderBy('created_at', 'desc')->paginate(10);
        return view('doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('doctors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors',
            'phone' => 'required|string|max:20',
            'specialization' => 'required|string',
            'qualifications' => 'required|string',
            'experience' => 'nullable|string',
            'clinic_assignment' => 'required|string',
            'consultation_fee' => 'required|numeric|min:0',
            'status' => 'required|in:Active,Inactive,On Leave',
        ]);

        $validated['doctor_id'] = 'DOC' . str_pad(Doctor::count() + 1, 6, '0', STR_PAD_LEFT);
        
        Doctor::create($validated);

        return redirect()->route('doctors.index')->with('success', 'Doctor added successfully.');
    }

    public function edit(Doctor $doctor)
    {
        return view('doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email,' . $doctor->id,
            'phone' => 'required|string|max:20',
            'specialization' => 'required|string',
            'qualifications' => 'required|string',
            'experience' => 'nullable|string',
            'clinic_assignment' => 'required|string',
            'consultation_fee' => 'required|numeric|min:0',
            'status' => 'required|in:Active,Inactive,On Leave',
        ]);

        $doctor->update($validated);

        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully.');
    }

    public function schedules(Doctor $doctor)
    {
        $schedules = $doctor->schedules;
        return view('doctors.schedules', compact('doctor', 'schedules'));
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully.');
    }
}
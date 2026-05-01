<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPatients = Patient::count();
        $totalDoctors = Doctor::where('status', 'Active')->count();
        $todayAppointments = Appointment::whereDate('appointment_date', Carbon::today())->count();
        $pendingAppointments = Appointment::where('status', 'Pending')->count();
        
        $revenueToday = Transaction::whereDate('payment_date', Carbon::today())
            ->where('payment_status', 'Paid')
            ->sum('total_amount');
        
        $revenueThisMonth = Transaction::whereMonth('payment_date', Carbon::now()->month)
            ->where('payment_status', 'Paid')
            ->sum('total_amount');

        $todayAppointmentsList = Appointment::with(['patient', 'doctor'])
            ->whereDate('appointment_date', Carbon::today())
            ->orderBy('appointment_time')
            ->get();

        $availableDoctors = Doctor::where('status', 'Active')
            ->with(['schedules' => function($query) {
                $query->where('day', Carbon::today()->format('l'));
            }])
            ->get()
            ->filter(function($doctor) {
                return $doctor->schedules->isNotEmpty();
            });

        $upcomingAppointments = Appointment::with(['patient', 'doctor'])
            ->where('appointment_date', '>=', Carbon::today())
            ->whereIn('status', ['Pending', 'Confirmed'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->limit(10)
            ->get();

        // Calendar events
        $calendarEvents = Appointment::with(['patient', 'doctor'])
            ->whereIn('status', ['Pending', 'Confirmed'])
            ->get()
            ->map(function($appointment) {
                return [
                    'title' => $appointment->patient->full_name . ' - ' . $appointment->doctor->full_name,
                    'start' => $appointment->appointment_date . 'T' . $appointment->appointment_time,
                    'color' => $appointment->status == 'Confirmed' ? '#10B981' : '#F59E0B'
                ];
            });

        return view('dashboard', compact(
            'totalPatients', 'totalDoctors', 'todayAppointments', 'pendingAppointments',
            'revenueToday', 'revenueThisMonth', 'todayAppointmentsList', 
            'availableDoctors', 'upcomingAppointments', 'calendarEvents'
        ));
    }
}
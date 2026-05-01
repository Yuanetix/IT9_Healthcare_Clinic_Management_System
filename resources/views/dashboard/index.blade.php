@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Dashboard</h2>
    
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Patients</h5>
                    <h2>{{ $totalPatients ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Active Doctors</h5>
                    <h2>{{ $totalDoctors ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Today's Appointments</h5>
                    <h2>{{ $todayAppointments ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Today's Revenue</h5>
                    <h2>${{ number_format($revenueToday ?? 0, 2) }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Appointments -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Today's Appointments</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Patient</th>
                                    <th>Doctor</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($todayAppointmentsList ?? [] as $appointment)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                                    <td>{{ $appointment->patient->full_name }}</td>
                                    <td>{{ $appointment->doctor->full_name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $appointment->status == 'Confirmed' ? 'success' : ($appointment->status == 'Pending' ? 'warning' : 'secondary') }}">
                                            {{ $appointment->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-info">View</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No appointments today</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Doctor Availability -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Doctor Availability Today</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @forelse($availableDoctors ?? [] as $doctor)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $doctor->full_name }}
                            <span class="badge bg-success rounded-pill">{{ $doctor->specialization }}</span>
                        </li>
                        @empty
                        <li class="list-group-item text-center">No doctors available today</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
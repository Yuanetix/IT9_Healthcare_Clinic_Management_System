@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Patient Details</h2>
        <div>
            <a href="{{ route('patients.edit', $patient) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('patients.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="row">
        <!-- Patient Information -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5>Personal Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Patient ID:</strong> {{ $patient->patient_id }}</p>
                    <p><strong>Name:</strong> {{ $patient->full_name }}</p>
                    <p><strong>Email:</strong> {{ $patient->email }}</p>
                    <p><strong>Phone:</strong> {{ $patient->phone }}</p>
                    <p><strong>Date of Birth:</strong> {{ $patient->date_of_birth->format('M d, Y') }}</p>
                    <p><strong>Age:</strong> {{ $patient->age }} years</p>
                    <p><strong>Gender:</strong> {{ $patient->gender }}</p>
                    <p><strong>Blood Group:</strong> {{ $patient->blood_group ?? 'Not specified' }}</p>
                    <p><strong>Address:</strong> {{ $patient->address }}</p>
                </div>
            </div>
        </div>

        <!-- Medical Information -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>Medical Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Medical History:</strong></p>
                    <p>{{ $patient->medical_history ?? 'No medical history recorded' }}</p>
                    <hr>
                    <p><strong>Allergies:</strong></p>
                    <p>{{ $patient->allergies ?? 'No allergies recorded' }}</p>
                </div>
            </div>
        </div>

        <!-- Emergency Contact -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-warning">
                    <h5>Emergency Contact</h5>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $patient->emergency_contact_name }}</p>
                    <p><strong>Phone:</strong> {{ $patient->emergency_contact_phone }}</p>
                    <p><strong>Relationship:</strong> {{ $patient->emergency_contact_relationship }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Visit History -->
    <div class="card">
        <div class="card-header bg-success text-white">
            <h5>Visit History</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Doctor</th>
                            <th>Service</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patient->appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->appointment_date->format('M d, Y') }} at {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                            <td>{{ $appointment->doctor->full_name }}</td>
                            <td>{{ $appointment->service_type }}</td>
                            <td>
                                <span class="badge bg-{{ $appointment->status == 'Completed' ? 'success' : ($appointment->status == 'Confirmed' ? 'primary' : 'warning') }}">
                                    {{ $appointment->status }}
                                </span>
                            </td>
                            <td>${{ number_format($appointment->consultation_fee, 2) }}</td>
                            <td>
                                @if($appointment->transaction)
                                    {{ $appointment->transaction->payment_status }}
                                @else
                                    Pending
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No visit history</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
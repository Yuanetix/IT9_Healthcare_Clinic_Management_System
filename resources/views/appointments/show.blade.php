@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Appointment Details</h2>
        <div>
            <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Back to Appointments</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5>Appointment Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Appointment Number:</th>
                            <td>{{ $appointment->appointment_number }}</td>
                        </tr>
                        <tr>
                            <th>Date:</th>
                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}</td>
                        </tr>
                        <tr>
                            <th>Time:</th>
                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @if($appointment->status == 'Confirmed')
                                    <span class="badge bg-success">Confirmed</span>
                                @elseif($appointment->status == 'Pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($appointment->status == 'Completed')
                                    <span class="badge bg-info">Completed</span>
                                @else
                                    <span class="badge bg-danger">Cancelled</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Service Type:</th>
                            <td>{{ $appointment->service_type }}</td>
                        </tr>
                        <tr>
                            <th>Consultation Fee:</th>
                            <td>${{ number_format($appointment->consultation_fee, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Symptoms:</th>
                            <td>{{ $appointment->symptoms ?? 'None' }}</td>
                        </tr>
                        <tr>
                            <th>Notes:</th>
                            <td>{{ $appointment->notes ?? 'None' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5>Patient Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Patient ID:</th>
                            <td>{{ $appointment->patient->patient_id }}</td>
                        </tr>
                        <tr>
                            <th>Name:</th>
                            <td>{{ $appointment->patient->full_name }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $appointment->patient->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone:</th>
                            <td>{{ $appointment->patient->phone }}</td>
                        </tr>
                        <tr>
                            <th>Date of Birth:</th>
                            <td>{{ \Carbon\Carbon::parse($appointment->patient->date_of_birth)->format('F d, Y') }}</td>
                        </tr>
                        <tr>
                            <th>Age:</th>
                            <td>{{ $appointment->patient->age }} years</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-info text-white">
                    <h5>Doctor Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Doctor ID:</th>
                            <td>{{ $appointment->doctor->doctor_id }}</td>
                        </tr>
                        <tr>
                            <th>Name:</th>
                            <td>{{ $appointment->doctor->full_name }}</td>
                        </tr>
                        <tr>
                            <th>Specialization:</th>
                            <td>{{ $appointment->doctor->specialization }}</td>
                        </tr>
                        <tr>
                            <th>Clinic:</th>
                            <td>{{ $appointment->doctor->clinic_assignment }}</td>
                        </tr>
                        <tr>
                            <th>Qualification:</th>
                            <td>{{ Str::limit($appointment->doctor->qualifications, 50) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if($appointment->transaction)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning">
                    <h5>Payment Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Invoice Number:</strong><br>
                            {{ $appointment->transaction->invoice_number }}
                        </div>
                        <div class="col-md-3">
                            <strong>Total Amount:</strong><br>
                            ${{ number_format($appointment->transaction->total_amount, 2) }}
                        </div>
                        <div class="col-md-3">
                            <strong>Paid Amount:</strong><br>
                            ${{ number_format($appointment->transaction->paid_amount, 2) }}
                        </div>
                        <div class="col-md-3">
                            <strong>Payment Status:</strong><br>
                            @if($appointment->transaction->payment_status == 'Paid')
                                <span class="badge bg-success">Paid</span>
                            @elseif($appointment->transaction->payment_status == 'Partial')
                                <span class="badge bg-warning">Partial</span>
                            @else
                                <span class="badge bg-danger">Unpaid</span>
                            @endif
                        </div>
                    </div>
                    @if($appointment->transaction->payment_date)
                    <div class="row mt-3">
                        <div class="col-12">
                            <strong>Payment Date:</strong> {{ \Carbon\Carbon::parse($appointment->transaction->payment_date)->format('F d, Y h:i A') }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row mt-4">
        <div class="col-12">
            @if($appointment->status == 'Pending')
                <form action="{{ route('appointments.confirm', $appointment) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success">Confirm Appointment</button>
                </form>
            @endif
            
            @if($appointment->status == 'Confirmed')
                <form action="{{ route('appointments.complete', $appointment) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-info">Mark as Completed</button>
                </form>
            @endif
            
            @if($appointment->canBeCancelled())
                <form action="{{ route('appointments.cancel', $appointment) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this appointment?')">Cancel Appointment</button>
                </form>
            @endif
            
            @if($appointment->canBeRescheduled())
                <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-warning">Reschedule</a>
            @endif
        </div>
    </div>
</div>
@endsection
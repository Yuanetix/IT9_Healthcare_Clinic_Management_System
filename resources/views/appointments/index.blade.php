@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Appointment Desk</h2>
        <a href="{{ route('appointments.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Schedule Appointment
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Appointment #</th>
                            <th>Date & Time</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Service</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->appointment_number }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}<br>
                                <small>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</small>
                            </td>
                            <td>{{ $appointment->patient->full_name }}</td>
                            <td>{{ $appointment->doctor->full_name }}</td>
                            <td>{{ $appointment->service_type }}</td>
                            <td>₱{{ number_format($appointment->consultation_fee, 2) }}</td>
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
                            <td>
                                @if($appointment->transaction)
                                    @if($appointment->transaction->payment_status == 'Paid')
                                        <span class="badge bg-success">Paid</span>
                                    @elseif($appointment->transaction->payment_status == 'Partial')
                                        <span class="badge bg-warning">Partial</span>
                                    @else
                                        <span class="badge bg-danger">Unpaid</span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">No invoice</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-info">View</a>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No appointments scheduled</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $appointments->links() }}
        </div>
    </div>
</div>
@endsection
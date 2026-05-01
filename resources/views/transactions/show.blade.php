@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Invoice: {{ $transaction->invoice_number }}</h2>
        <div>
            <a href="{{ route('transactions.receipt', $transaction) }}" class="btn btn-success" target="_blank">
                <i class="fas fa-download"></i> Download Receipt (PDF)
            </a>
            <a href="{{ route('transactions.invoice', $transaction) }}" class="btn btn-info text-white" target="_blank">
                <i class="fas fa-file-invoice"></i> Download Invoice (PDF)
            </a>
            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Billing
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Invoice Details -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5>Invoice Details</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Patient Name:</th>
                            <td>{{ $transaction->patient->full_name }}</td>
                        </tr>
                        <tr>
                            <th>Patient ID:</th>
                            <td>{{ $transaction->patient->patient_id }}</td>
                        </tr>
                        <tr>
                            <th>Doctor:</th>
                            <td>{{ $transaction->appointment->doctor->full_name }}</td>
                        </tr>
                        <tr>
                            <th>Specialization:</th>
                            <td>{{ $transaction->appointment->doctor->specialization }}</td>
                        </tr>
                        <tr>
                            <th>Service Type:</th>
                            <td>{{ $transaction->appointment->service_type }}</td>
                        </tr>
                        <tr>
                            <th>Appointment Date:</th>
                            <td>{{ \Carbon\Carbon::parse($transaction->appointment->appointment_date)->format('F d, Y') }} at {{ \Carbon\Carbon::parse($transaction->appointment->appointment_time)->format('h:i A') }}</td>
                        </tr>
                        <tr>
                            <th>Consultation Fee:</th>
                            <td>₱{{ number_format($transaction->consultation_fee, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Additional Services:</th>
                            <td>₱{{ number_format($transaction->additional_services_fee, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Total Amount:</th>
                            <td><strong>₱{{ number_format($transaction->total_amount, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <th>Amount Paid:</th>
                            <td>₱{{ number_format($transaction->paid_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Outstanding Balance:</th>
                            <td>
                                <strong class="text-danger">₱{{ number_format($transaction->outstanding_balance, 2) }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <th>Payment Status:</th>
                            <td>
                                @if($transaction->payment_status == 'Paid')
                                    <span class="badge bg-success">Paid</span>
                                @elseif($transaction->payment_status == 'Partial')
                                    <span class="badge bg-warning">Partial</span>
                                @elseif($transaction->payment_status == 'Refunded')
                                    <span class="badge bg-info">Refunded</span>
                                @else
                                    <span class="badge bg-danger">Unpaid</span>
                                @endif
                            </td>
                        </tr>
                        @if($transaction->payment_date)
                        <tr>
                            <th>Payment Date:</th>
                            <td>{{ \Carbon\Carbon::parse($transaction->payment_date)->format('F d, Y h:i A') }}</td>
                        </tr>
                        @endif
                        @if($transaction->payment_method)
                        <tr>
                            <th>Payment Method:</th>
                            <td>{{ $transaction->payment_method }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        <!-- Payment Form -->
        @if($transaction->outstanding_balance > 0)
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5>Process Payment</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('transactions.payment', $transaction) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Payment Amount (₱) *</label>
                            <input type="number" step="0.01" name="amount" class="form-control" max="{{ $transaction->outstanding_balance }}" required>
                            <small class="text-muted">Outstanding Balance: ₱{{ number_format($transaction->outstanding_balance, 2) }}</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Payment Method *</label>
                            <select name="payment_method" class="form-control" required>
                                <option value="Cash">Cash</option>
                                <option value="Credit Card">Credit Card</option>
                                <option value="Debit Card">Debit Card</option>
                                <option value="Insurance">Insurance</option>
                                <option value="Online">Online</option>
                                <option value="GCash">GCash</option>
                                <option value="PayMaya">PayMaya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Additional Services</label>
                            <textarea name="additional_services" class="form-control" rows="2" placeholder="Lab tests, X-ray, etc."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Additional Services Fee (₱)</label>
                            <input type="number" step="0.01" name="additional_services_fee" class="form-control" value="0">
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-money-bill-wave me-1"></i> Process Payment
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Additional Services Details (if any) -->
    @if($transaction->additional_services && $transaction->additional_services != '[]')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>Additional Services Details</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Service</th>
                                    <th>Amount (₱)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $services = json_decode($transaction->additional_services, true);
                                @endphp
                                @if(is_array($services))
                                    @foreach($services as $service => $amount)
                                    <tr>
                                        <td>{{ $service }}</td>
                                        <td>₱{{ number_format($amount, 2) }}</td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Payment History -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5>Payment Summary</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <h6>Total Bill</h6>
                            <h3 class="text-primary">₱{{ number_format($transaction->total_amount, 2) }}</h3>
                        </div>
                        <div class="col-md-4 text-center">
                            <h6>Total Paid</h6>
                            <h3 class="text-success">₱{{ number_format($transaction->paid_amount, 2) }}</h3>
                        </div>
                        <div class="col-md-4 text-center">
                            <h6>Balance</h6>
                            <h3 class="text-danger">₱{{ number_format($transaction->outstanding_balance, 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
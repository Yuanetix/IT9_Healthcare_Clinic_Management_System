@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Billing Center</h2>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Invoice #</th>
                            <th>Patient</th>
                            <th>Date</th>
                            <th>Consultation</th>
                            <th>Additional</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Balance</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->invoice_number }}</td>
                            <td>{{ $transaction->patient->full_name }}</td>
                            <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                            <td>${{ number_format($transaction->consultation_fee, 2) }}</td>
                            <td>${{ number_format($transaction->additional_services_fee, 2) }}</td>
                            <td><strong>${{ number_format($transaction->total_amount, 2) }}</strong></td>
                            <td>${{ number_format($transaction->paid_amount, 2) }}</td>
                            <td>${{ number_format($transaction->outstanding_balance, 2) }}</td>
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
                            <td>
                                <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-sm btn-info">View</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">No transactions found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection
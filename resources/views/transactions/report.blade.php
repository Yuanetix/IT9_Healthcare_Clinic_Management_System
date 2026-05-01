@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-4">Revenue Report (Philippine Peso ₱)</h2>
        <a href="{{ route('reports.revenue-pdf', request()->query()) }}" class="btn btn-danger" target="_blank">
            <i class="fas fa-file-pdf me-1"></i> Download PDF Report
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Group By</label>
                    <select name="group_by" class="form-control">
                        <option value="doctor" {{ $groupBy == 'doctor' ? 'selected' : '' }}>By Doctor</option>
                        <option value="service" {{ $groupBy == 'service' ? 'selected' : '' }}>By Service Type</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i> Generate Report
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5>Revenue Summary ({{ \Carbon\Carbon::parse($startDate)->format('F d, Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('F d, Y') }})</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>{{ $groupBy == 'doctor' ? 'Doctor Name' : 'Service Type' }}</th>
                            <th class="text-center">Number of Transactions</th>
                            <th class="text-end">Total Revenue (₱)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($report as $name => $data)
                        <tr>
                            <td><strong>{{ $name }}</strong></td>
                            <td class="text-center">{{ $data['count'] }}</td>
                            <td class="text-end">₱{{ number_format($data['total'], 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">No transactions found in this period</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-secondary">
                        <tr>
                            <th><strong>TOTAL</strong></th>
                            <th class="text-center"><strong>{{ $totalTransactions }}</strong></th>
                            <th class="text-end"><strong>₱{{ number_format($totalRevenue, 2) }}</strong></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
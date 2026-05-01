@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Doctor Manager</h2>
        <a href="{{ route('doctors.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add New Doctor
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Specialization</th>
                            <th>Qualification</th>
                            <th>Clinic</th>
                            <th>Consultation Fee</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($doctors as $doctor)
                        <tr>
                            <td>{{ $doctor->doctor_id }}</td>
                            <td>{{ $doctor->full_name }}</td>
                            <td>{{ $doctor->specialization }}</td>
                            <td>{{ Str::limit($doctor->qualifications, 30) }}</td>
                            <td>{{ $doctor->clinic_assignment }}</td>
                            <td>₱{{ number_format($doctor->consultation_fee, 2) }}</td>
                            <td>
                                @if($doctor->status == 'Active')
                                    <span class="badge bg-success">Active</span>
                                @elseif($doctor->status == 'On Leave')
                                    <span class="badge bg-warning">On Leave</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('doctors.schedules', $doctor) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-clock"></i> Schedule
                                </a>
                                <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('doctors.destroy', $doctor) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No doctors registered</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $doctors->links() }}
        </div>
    </div>
</div>
@endsection
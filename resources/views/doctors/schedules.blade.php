@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Doctor Schedule: {{ $doctor->full_name }}</h2>
        <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Back to Doctors</a>
    </div>

    <div class="row">
        <!-- Add Schedule Form -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5>Add Schedule</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('schedules.store', $doctor) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Day</label>
                            <select name="day" class="form-control" required>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                                <option value="Sunday">Sunday</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Start Time</label>
                            <input type="time" name="start_time" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">End Time</label>
                            <input type="time" name="end_time" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Slot Duration (minutes)</label>
                            <select name="slot_duration" class="form-control">
                                <option value="15">15 minutes</option>
                                <option value="30" selected>30 minutes</option>
                                <option value="45">45 minutes</option>
                                <option value="60">60 minutes</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Add Schedule</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Schedules List -->
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5>Current Schedules</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Day</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Slot Duration</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($schedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->day }}</td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}</td>
                                    <td>{{ $schedule->slot_duration }} minutes</td>
                                    <td>
                                        <form action="{{ route('schedules.destroy', $schedule) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No schedules added</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
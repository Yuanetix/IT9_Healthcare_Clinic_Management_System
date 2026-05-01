@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Reschedule Appointment #{{ $appointment->appointment_number }}</h2>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('appointments.update', $appointment) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Patient</label>
                        <input type="text" class="form-control" value="{{ $appointment->patient->full_name }}" disabled>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Doctor</label>
                        <input type="text" class="form-control" value="{{ $appointment->doctor->full_name }}" disabled>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Current Time</label>
                        <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }} at {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}" disabled>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">New Appointment Date *</label>
                        <input type="date" name="appointment_date" id="appointment_date" class="form-control @error('appointment_date') is-invalid @enderror" value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d')) }}" required>
                        @error('appointment_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">New Appointment Time *</label>
                        <select name="appointment_time" id="appointment_time" class="form-control @error('appointment_time') is-invalid @enderror" required>
                            <option value="{{ $appointment->appointment_time }}">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</option>
                        </select>
                        @error('appointment_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Service Type *</label>
                        <select name="service_type" class="form-control @error('service_type') is-invalid @enderror" required>
                            <option value="General Check-up" {{ $appointment->service_type == 'General Check-up' ? 'selected' : '' }}>General Check-up</option>
                            <option value="Specialist Consultation" {{ $appointment->service_type == 'Specialist Consultation' ? 'selected' : '' }}>Specialist Consultation</option>
                            <option value="Follow-up" {{ $appointment->service_type == 'Follow-up' ? 'selected' : '' }}>Follow-up</option>
                            <option value="Emergency" {{ $appointment->service_type == 'Emergency' ? 'selected' : '' }}>Emergency</option>
                        </select>
                        @error('service_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Symptoms</label>
                        <textarea name="symptoms" class="form-control" rows="3">{{ old('symptoms', $appointment->symptoms) }}</textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="2">{{ old('notes', $appointment->notes) }}</textarea>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Reschedule Appointment</button>
                    <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#appointment_date').change(function() {
        var doctorId = {{ $appointment->doctor_id }};
        var date = $(this).val();
        
        if(doctorId && date) {
            $.get('{{ route("get.available.slots") }}', {doctor_id: doctorId, date: date}, function(data) {
                var timeSelect = $('#appointment_time');
                timeSelect.empty();
                timeSelect.append('<option value="">Select Time</option>');
                $.each(data.slots, function(key, slot) {
                    timeSelect.append('<option value="' + slot + '">' + slot + '</option>');
                });
            });
        }
    });
</script>
@endpush
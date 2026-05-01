@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Schedule New Appointment</h2>

    <div class="card">
        <div class="card-body">
            <form id="appointmentForm" action="{{ route('appointments.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Patient *</label>
                        <select name="patient_id" id="patient_id" class="form-control @error('patient_id') is-invalid @enderror" required>
                            <option value="">Select Patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->full_name }} ({{ $patient->patient_id }})</option>
                            @endforeach
                        </select>
                        @error('patient_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Doctor *</label>
                        <select name="doctor_id" id="doctor_id" class="form-control @error('doctor_id') is-invalid @enderror" required>
                            <option value="">Select Doctor</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->full_name }} - {{ $doctor->specialization }} (${{ number_format($doctor->consultation_fee, 2) }})</option>
                            @endforeach
                        </select>
                        @error('doctor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Appointment Date *</label>
                        <input type="date" name="appointment_date" id="appointment_date" class="form-control @error('appointment_date') is-invalid @enderror" required>
                        @error('appointment_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Appointment Time *</label>
                        <select name="appointment_time" id="appointment_time" class="form-control @error('appointment_time') is-invalid @enderror" required>
                            <option value="">Select Doctor and Date first</option>
                        </select>
                        @error('appointment_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Service Type *</label>
                        <select name="service_type" class="form-control @error('service_type') is-invalid @enderror" required>
                            <option value="General Check-up">General Check-up</option>
                            <option value="Specialist Consultation">Specialist Consultation</option>
                            <option value="Follow-up">Follow-up</option>
                            <option value="Emergency">Emergency</option>
                        </select>
                        @error('service_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Symptoms</label>
                        <textarea name="symptoms" class="form-control" rows="3">{{ old('symptoms') }}</textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Schedule Appointment</button>
                    <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#doctor_id, #appointment_date').change(function() {
        var doctorId = $('#doctor_id').val();
        var date = $('#appointment_date').val();
        
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
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Edit Doctor: {{ $doctor->full_name }}</h2>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('doctors.update', $doctor) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">First Name *</label>
                        <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', $doctor->first_name) }}" required>
                        @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Last Name *</label>
                        <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', $doctor->last_name) }}" required>
                        @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $doctor->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone *</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $doctor->phone) }}" required>
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Specialization *</label>
                        <select name="specialization" class="form-control @error('specialization') is-invalid @enderror" required>
                            <option value="General Physician" {{ $doctor->specialization == 'General Physician' ? 'selected' : '' }}>General Physician</option>
                            <option value="Cardiologist" {{ $doctor->specialization == 'Cardiologist' ? 'selected' : '' }}>Cardiologist</option>
                            <option value="Dentist" {{ $doctor->specialization == 'Dentist' ? 'selected' : '' }}>Dentist</option>
                            <option value="Dermatologist" {{ $doctor->specialization == 'Dermatologist' ? 'selected' : '' }}>Dermatologist</option>
                            <option value="Pediatrician" {{ $doctor->specialization == 'Pediatrician' ? 'selected' : '' }}>Pediatrician</option>
                            <option value="Orthopedic" {{ $doctor->specialization == 'Orthopedic' ? 'selected' : '' }}>Orthopedic</option>
                            <option value="Neurologist" {{ $doctor->specialization == 'Neurologist' ? 'selected' : '' }}>Neurologist</option>
                            <option value="Ophthalmologist" {{ $doctor->specialization == 'Ophthalmologist' ? 'selected' : '' }}>Ophthalmologist</option>
                        </select>
                        @error('specialization') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Clinic Assignment *</label>
                        <input type="text" name="clinic_assignment" class="form-control @error('clinic_assignment') is-invalid @enderror" value="{{ old('clinic_assignment', $doctor->clinic_assignment) }}" required>
                        @error('clinic_assignment') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Consultation Fee (₱) *</label>
                        <input type="number" step="0.01" name="consultation_fee" class="form-control @error('consultation_fee') is-invalid @enderror" value="{{ old('consultation_fee', $doctor->consultation_fee) }}" required>
                        @error('consultation_fee') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status *</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="Active" {{ $doctor->status == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ $doctor->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="On Leave" {{ $doctor->status == 'On Leave' ? 'selected' : '' }}>On Leave</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Qualifications *</label>
                        <textarea name="qualifications" class="form-control @error('qualifications') is-invalid @enderror" rows="3" required>{{ old('qualifications', $doctor->qualifications) }}</textarea>
                        @error('qualifications') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Experience</label>
                        <textarea name="experience" class="form-control" rows="2">{{ old('experience', $doctor->experience) }}</textarea>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Update Doctor</button>
                    <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
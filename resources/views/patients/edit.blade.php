@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Edit Patient: {{ $patient->full_name }}</h2>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('patients.update', $patient) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">First Name *</label>
                        <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', $patient->first_name) }}" required>
                        @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Last Name *</label>
                        <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', $patient->last_name) }}" required>
                        @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $patient->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone *</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $patient->phone) }}" required>
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Date of Birth *</label>
                        <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth', $patient->date_of_birth->format('Y-m-d')) }}" required>
                        @error('date_of_birth') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Gender *</label>
                        <select name="gender" class="form-control @error('gender') is-invalid @enderror" required>
                            <option value="Male" {{ $patient->gender == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ $patient->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ $patient->gender == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Blood Group</label>
                        <select name="blood_group" class="form-control">
                            <option value="">Select</option>
                            <option value="A+" {{ $patient->blood_group == 'A+' ? 'selected' : '' }}>A+</option>
                            <option value="A-" {{ $patient->blood_group == 'A-' ? 'selected' : '' }}>A-</option>
                            <option value="B+" {{ $patient->blood_group == 'B+' ? 'selected' : '' }}>B+</option>
                            <option value="B-" {{ $patient->blood_group == 'B-' ? 'selected' : '' }}>B-</option>
                            <option value="O+" {{ $patient->blood_group == 'O+' ? 'selected' : '' }}>O+</option>
                            <option value="O-" {{ $patient->blood_group == 'O-' ? 'selected' : '' }}>O-</option>
                            <option value="AB+" {{ $patient->blood_group == 'AB+' ? 'selected' : '' }}>AB+</option>
                            <option value="AB-" {{ $patient->blood_group == 'AB-' ? 'selected' : '' }}>AB-</option>
                        </select>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Address *</label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2" required>{{ old('address', $patient->address) }}</textarea>
                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Medical History</label>
                        <textarea name="medical_history" class="form-control" rows="3">{{ old('medical_history', $patient->medical_history) }}</textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Allergies</label>
                        <textarea name="allergies" class="form-control" rows="3">{{ old('allergies', $patient->allergies) }}</textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <h5>Emergency Contact</h5>
                        <hr>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Contact Name *</label>
                        <input type="text" name="emergency_contact_name" class="form-control @error('emergency_contact_name') is-invalid @enderror" value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}" required>
                        @error('emergency_contact_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Contact Phone *</label>
                        <input type="text" name="emergency_contact_phone" class="form-control @error('emergency_contact_phone') is-invalid @enderror" value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}" required>
                        @error('emergency_contact_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Relationship *</label>
                        <input type="text" name="emergency_contact_relationship" class="form-control @error('emergency_contact_relationship') is-invalid @enderror" value="{{ old('emergency_contact_relationship', $patient->emergency_contact_relationship) }}" required>
                        @error('emergency_contact_relationship') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Update Patient</button>
                    <a href="{{ route('patients.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
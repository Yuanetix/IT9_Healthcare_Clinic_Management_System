<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [
            [
                'doctor_id' => 'DOC001',
                'first_name' => 'John',
                'last_name' => 'Smith',
                'email' => 'john.smith@clinic.com',
                'phone' => '1234567890',
                'specialization' => 'General Physician',
                'qualifications' => 'MD, MBBS',
                'clinic_assignment' => 'Main Clinic',
                'consultation_fee' => 500,
                'status' => 'Active'
            ],
            [
                'doctor_id' => 'DOC002',
                'first_name' => 'Sarah',
                'last_name' => 'Johnson',
                'email' => 'sarah.johnson@clinic.com',
                'phone' => '1234567891',
                'specialization' => 'Cardiologist',
                'qualifications' => 'MD, DM Cardiology',
                'clinic_assignment' => 'Heart Center',
                'consultation_fee' => 1000,
                'status' => 'Active'
            ],
            [
                'doctor_id' => 'DOC003',
                'first_name' => 'Mike',
                'last_name' => 'Williams',
                'email' => 'mike.williams@clinic.com',
                'phone' => '1234567892',
                'specialization' => 'Dentist',
                'qualifications' => 'BDS, MDS',
                'clinic_assignment' => 'Dental Clinic',
                'consultation_fee' => 400,
                'status' => 'Active'
            ],
        ];

        foreach ($doctors as $doctor) {
            Doctor::create($doctor);
        }
    }
}
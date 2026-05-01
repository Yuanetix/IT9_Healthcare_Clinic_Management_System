<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Schedule;
use App\Models\Appointment;
use App\Models\Transaction;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. CREATE ADMIN USER
        // ==========================================
        $admin = User::updateOrCreate(
            ['email' => 'admin@clinic.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // ==========================================
        // 2. CREATE PATIENTS (10 sample patients)
        // ==========================================
        $patients = [
            [
                'patient_id' => 'PAT000001',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'phone' => '555-0101',
                'date_of_birth' => '1985-05-15',
                'gender' => 'Male',
                'address' => '123 Main Street, New York, NY 10001',
                'medical_history' => 'Hypertension, High cholesterol',
                'allergies' => 'Penicillin',
                'blood_group' => 'O+',
                'emergency_contact_name' => 'Jane Doe',
                'emergency_contact_phone' => '555-0201',
                'emergency_contact_relationship' => 'Spouse',
            ],
            [
                'patient_id' => 'PAT000002',
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '555-0102',
                'date_of_birth' => '1990-08-20',
                'gender' => 'Female',
                'address' => '456 Oak Avenue, Los Angeles, CA 90001',
                'medical_history' => 'Asthma',
                'allergies' => 'Peanuts',
                'blood_group' => 'A+',
                'emergency_contact_name' => 'Bob Smith',
                'emergency_contact_phone' => '555-0202',
                'emergency_contact_relationship' => 'Brother',
            ],
            [
                'patient_id' => 'PAT000003',
                'first_name' => 'Robert',
                'last_name' => 'Johnson',
                'email' => 'robert.johnson@example.com',
                'phone' => '555-0103',
                'date_of_birth' => '1978-03-10',
                'gender' => 'Male',
                'address' => '789 Pine Street, Chicago, IL 60601',
                'medical_history' => 'Diabetes Type 2',
                'allergies' => 'None',
                'blood_group' => 'B+',
                'emergency_contact_name' => 'Mary Johnson',
                'emergency_contact_phone' => '555-0203',
                'emergency_contact_relationship' => 'Wife',
            ],
            [
                'patient_id' => 'PAT000004',
                'first_name' => 'Emily',
                'last_name' => 'Brown',
                'email' => 'emily.brown@example.com',
                'phone' => '555-0104',
                'date_of_birth' => '1995-12-25',
                'gender' => 'Female',
                'address' => '321 Elm Street, Houston, TX 77001',
                'medical_history' => 'None',
                'allergies' => 'Latex',
                'blood_group' => 'AB+',
                'emergency_contact_name' => 'David Brown',
                'emergency_contact_phone' => '555-0204',
                'emergency_contact_relationship' => 'Father',
            ],
            [
                'patient_id' => 'PAT000005',
                'first_name' => 'Michael',
                'last_name' => 'Wilson',
                'email' => 'michael.wilson@example.com',
                'phone' => '555-0105',
                'date_of_birth' => '1982-07-08',
                'gender' => 'Male',
                'address' => '555 Cedar Road, Phoenix, AZ 85001',
                'medical_history' => 'Heart disease',
                'allergies' => 'Codeine',
                'blood_group' => 'O-',
                'emergency_contact_name' => 'Sarah Wilson',
                'emergency_contact_phone' => '555-0205',
                'emergency_contact_relationship' => 'Wife',
            ],
            [
                'patient_id' => 'PAT000006',
                'first_name' => 'Sarah',
                'last_name' => 'Martinez',
                'email' => 'sarah.martinez@example.com',
                'phone' => '555-0106',
                'date_of_birth' => '1988-04-18',
                'gender' => 'Female',
                'address' => '777 Birch Lane, Philadelphia, PA 19101',
                'medical_history' => 'Anxiety',
                'allergies' => 'Shellfish',
                'blood_group' => 'A-',
                'emergency_contact_name' => 'Carlos Martinez',
                'emergency_contact_phone' => '555-0206',
                'emergency_contact_relationship' => 'Husband',
            ],
            [
                'patient_id' => 'PAT000007',
                'first_name' => 'David',
                'last_name' => 'Anderson',
                'email' => 'david.anderson@example.com',
                'phone' => '555-0107',
                'date_of_birth' => '1975-11-30',
                'gender' => 'Male',
                'address' => '444 Willow Way, San Antonio, TX 78201',
                'medical_history' => 'Arthritis',
                'allergies' => 'Aspirin',
                'blood_group' => 'B-',
                'emergency_contact_name' => 'Linda Anderson',
                'emergency_contact_phone' => '555-0207',
                'emergency_contact_relationship' => 'Spouse',
            ],
            [
                'patient_id' => 'PAT000008',
                'first_name' => 'Lisa',
                'last_name' => 'Taylor',
                'email' => 'lisa.taylor@example.com',
                'phone' => '555-0108',
                'date_of_birth' => '1992-09-14',
                'gender' => 'Female',
                'address' => '888 Spruce Court, San Diego, CA 92101',
                'medical_history' => 'Migraines',
                'allergies' => 'Dust',
                'blood_group' => 'O+',
                'emergency_contact_name' => 'Mark Taylor',
                'emergency_contact_phone' => '555-0208',
                'emergency_contact_relationship' => 'Brother',
            ],
            [
                'patient_id' => 'PAT000009',
                'first_name' => 'James',
                'last_name' => 'Thomas',
                'email' => 'james.thomas@example.com',
                'phone' => '555-0109',
                'date_of_birth' => '1968-01-22',
                'gender' => 'Male',
                'address' => '123 Maple Drive, Dallas, TX 75201',
                'medical_history' => 'Hypertension, High cholesterol',
                'allergies' => 'Sulfa drugs',
                'blood_group' => 'AB-',
                'emergency_contact_name' => 'Patricia Thomas',
                'emergency_contact_phone' => '555-0209',
                'emergency_contact_relationship' => 'Wife',
            ],
            [
                'patient_id' => 'PAT000010',
                'first_name' => 'Maria',
                'last_name' => 'Garcia',
                'email' => 'maria.garcia@example.com',
                'phone' => '555-0110',
                'date_of_birth' => '2000-06-05',
                'gender' => 'Female',
                'address' => '555 Palm Street, San Jose, CA 95101',
                'medical_history' => 'None',
                'allergies' => 'None',
                'blood_group' => 'A+',
                'emergency_contact_name' => 'Jose Garcia',
                'emergency_contact_phone' => '555-0210',
                'emergency_contact_relationship' => 'Father',
            ],
        ];

        foreach ($patients as $patient) {
            Patient::updateOrCreate(['email' => $patient['email']], $patient);
        }

        // ==========================================
        // 3. CREATE DOCTORS (10 sample doctors)
        // ==========================================
        $doctors = [
            [
                'doctor_id' => 'DOC000001',
                'first_name' => 'Sarah',
                'last_name' => 'Johnson',
                'email' => 'sarah.johnson@clinic.com',
                'phone' => '555-1001',
                'specialization' => 'Cardiologist',
                'qualifications' => 'MD, DM Cardiology from Harvard Medical School',
                'experience' => '15 years of experience in interventional cardiology',
                'clinic_assignment' => 'Heart Center - Floor 3',
                'consultation_fee' => 1500.00,
                'status' => 'Active',
            ],
            [
                'doctor_id' => 'DOC000002',
                'first_name' => 'Michael',
                'last_name' => 'Williams',
                'email' => 'michael.williams@clinic.com',
                'phone' => '555-1002',
                'specialization' => 'General Physician',
                'qualifications' => 'MD, MBBS from Johns Hopkins University',
                'experience' => '10 years of experience in family medicine',
                'clinic_assignment' => 'Main Clinic - Floor 1',
                'consultation_fee' => 500.00,
                'status' => 'Active',
            ],
            [
                'doctor_id' => 'DOC000003',
                'first_name' => 'Emily',
                'last_name' => 'Davis',
                'email' => 'emily.davis@clinic.com',
                'phone' => '555-1003',
                'specialization' => 'Dentist',
                'qualifications' => 'BDS, MDS from New York University',
                'experience' => '8 years of experience in cosmetic dentistry',
                'clinic_assignment' => 'Dental Clinic - Floor 2',
                'consultation_fee' => 400.00,
                'status' => 'Active',
            ],
            [
                'doctor_id' => 'DOC000004',
                'first_name' => 'Robert',
                'last_name' => 'Brown',
                'email' => 'robert.brown@clinic.com',
                'phone' => '555-1004',
                'specialization' => 'Dermatologist',
                'qualifications' => 'MD, Dermatology from Stanford University',
                'experience' => '12 years of experience',
                'clinic_assignment' => 'Skin Care Center - Floor 4',
                'consultation_fee' => 800.00,
                'status' => 'Active',
            ],
            [
                'doctor_id' => 'DOC000005',
                'first_name' => 'Jennifer',
                'last_name' => 'Miller',
                'email' => 'jennifer.miller@clinic.com',
                'phone' => '555-1005',
                'specialization' => 'Pediatrician',
                'qualifications' => 'MD, Pediatrics from Boston Children\'s Hospital',
                'experience' => '10 years of experience',
                'clinic_assignment' => 'Children\'s Wing - Floor 1',
                'consultation_fee' => 600.00,
                'status' => 'Active',
            ],
            [
                'doctor_id' => 'DOC000006',
                'first_name' => 'William',
                'last_name' => 'Jones',
                'email' => 'william.jones@clinic.com',
                'phone' => '555-1006',
                'specialization' => 'Orthopedic',
                'qualifications' => 'MS, Orthopedics from Mayo Clinic',
                'experience' => '18 years of experience',
                'clinic_assignment' => 'Orthopedic Center - Floor 2',
                'consultation_fee' => 1200.00,
                'status' => 'Active',
            ],
            [
                'doctor_id' => 'DOC000007',
                'first_name' => 'Patricia',
                'last_name' => 'Garcia',
                'email' => 'patricia.garcia@clinic.com',
                'phone' => '555-1007',
                'specialization' => 'Neurologist',
                'qualifications' => 'MD, DM Neurology from UCSF',
                'experience' => '14 years of experience',
                'clinic_assignment' => 'Neuroscience Center - Floor 5',
                'consultation_fee' => 1300.00,
                'status' => 'Active',
            ],
            [
                'doctor_id' => 'DOC000008',
                'first_name' => 'Charles',
                'last_name' => 'Rodriguez',
                'email' => 'charles.rodriguez@clinic.com',
                'phone' => '555-1008',
                'specialization' => 'Ophthalmologist',
                'qualifications' => 'MD, Ophthalmology from Wilmer Eye Institute',
                'experience' => '9 years of experience',
                'clinic_assignment' => 'Eye Center - Floor 3',
                'consultation_fee' => 700.00,
                'status' => 'Active',
            ],
            [
                'doctor_id' => 'DOC000009',
                'first_name' => 'Elizabeth',
                'last_name' => 'Martinez',
                'email' => 'elizabeth.martinez@clinic.com',
                'phone' => '555-1009',
                'specialization' => 'Psychiatrist',
                'qualifications' => 'MD, Psychiatry from Columbia University',
                'experience' => '11 years of experience',
                'clinic_assignment' => 'Mental Health Center - Floor 6',
                'consultation_fee' => 900.00,
                'status' => 'On Leave',
            ],
            [
                'doctor_id' => 'DOC000010',
                'first_name' => 'Thomas',
                'last_name' => 'Anderson',
                'email' => 'thomas.anderson@clinic.com',
                'phone' => '555-1010',
                'specialization' => 'Urologist',
                'qualifications' => 'MD, Urology from Cleveland Clinic',
                'experience' => '13 years of experience',
                'clinic_assignment' => 'Urology Center - Floor 4',
                'consultation_fee' => 1100.00,
                'status' => 'Inactive',
            ],
        ];

        foreach ($doctors as $doctor) {
            Doctor::updateOrCreate(['email' => $doctor['email']], $doctor);
        }

        // ==========================================
        // 4. CREATE DOCTOR SCHEDULES
        // ==========================================
        $schedules = [
            ['doctor_id' => 1, 'day' => 'Monday', 'start_time' => '09:00', 'end_time' => '17:00', 'slot_duration' => 30],
            ['doctor_id' => 1, 'day' => 'Wednesday', 'start_time' => '09:00', 'end_time' => '17:00', 'slot_duration' => 30],
            ['doctor_id' => 1, 'day' => 'Friday', 'start_time' => '09:00', 'end_time' => '13:00', 'slot_duration' => 30],
            ['doctor_id' => 2, 'day' => 'Monday', 'start_time' => '08:00', 'end_time' => '16:00', 'slot_duration' => 30],
            ['doctor_id' => 2, 'day' => 'Tuesday', 'start_time' => '08:00', 'end_time' => '16:00', 'slot_duration' => 30],
            ['doctor_id' => 2, 'day' => 'Wednesday', 'start_time' => '08:00', 'end_time' => '16:00', 'slot_duration' => 30],
            ['doctor_id' => 2, 'day' => 'Thursday', 'start_time' => '08:00', 'end_time' => '16:00', 'slot_duration' => 30],
            ['doctor_id' => 2, 'day' => 'Friday', 'start_time' => '08:00', 'end_time' => '14:00', 'slot_duration' => 30],
            ['doctor_id' => 3, 'day' => 'Tuesday', 'start_time' => '10:00', 'end_time' => '18:00', 'slot_duration' => 30],
            ['doctor_id' => 3, 'day' => 'Thursday', 'start_time' => '10:00', 'end_time' => '18:00', 'slot_duration' => 30],
            ['doctor_id' => 3, 'day' => 'Saturday', 'start_time' => '09:00', 'end_time' => '13:00', 'slot_duration' => 30],
            ['doctor_id' => 4, 'day' => 'Monday', 'start_time' => '11:00', 'end_time' => '19:00', 'slot_duration' => 30],
            ['doctor_id' => 4, 'day' => 'Wednesday', 'start_time' => '11:00', 'end_time' => '19:00', 'slot_duration' => 30],
            ['doctor_id' => 4, 'day' => 'Friday', 'start_time' => '09:00', 'end_time' => '15:00', 'slot_duration' => 30],
            ['doctor_id' => 5, 'day' => 'Monday', 'start_time' => '09:00', 'end_time' => '17:00', 'slot_duration' => 30],
            ['doctor_id' => 5, 'day' => 'Tuesday', 'start_time' => '09:00', 'end_time' => '17:00', 'slot_duration' => 30],
            ['doctor_id' => 5, 'day' => 'Wednesday', 'start_time' => '09:00', 'end_time' => '17:00', 'slot_duration' => 30],
            ['doctor_id' => 5, 'day' => 'Thursday', 'start_time' => '09:00', 'end_time' => '17:00', 'slot_duration' => 30],
        ];

        foreach ($schedules as $schedule) {
            // Check if schedule already exists
            $exists = Schedule::where('doctor_id', $schedule['doctor_id'])
                ->where('day', $schedule['day'])
                ->exists();
            
            if (!$exists) {
                Schedule::create($schedule);
            }
        }

        // ==========================================
        // 5. CREATE APPOINTMENTS (with duplicate check)
        // ==========================================
        $appointments = [
            [
                'appointment_number' => 'APT000001',
                'patient_id' => 1,
                'doctor_id' => 2,
                'appointment_date' => Carbon::today()->format('Y-m-d'),
                'appointment_time' => '09:00',
                'status' => 'Confirmed',
                'symptoms' => 'Fever and cough for 3 days',
                'service_type' => 'General Check-up',
                'consultation_fee' => 500.00,
            ],
            [
                'appointment_number' => 'APT000002',
                'patient_id' => 2,
                'doctor_id' => 2,
                'appointment_date' => Carbon::today()->format('Y-m-d'),
                'appointment_time' => '10:30',
                'status' => 'Pending',
                'symptoms' => 'Headache and fatigue',
                'service_type' => 'General Check-up',
                'consultation_fee' => 500.00,
            ],
            [
                'appointment_number' => 'APT000003',
                'patient_id' => 3,
                'doctor_id' => 1,
                'appointment_date' => Carbon::tomorrow()->format('Y-m-d'),
                'appointment_time' => '11:00',
                'status' => 'Confirmed',
                'symptoms' => 'Chest pain, shortness of breath',
                'service_type' => 'Specialist Consultation',
                'consultation_fee' => 1500.00,
            ],
            [
                'appointment_number' => 'APT000004',
                'patient_id' => 4,
                'doctor_id' => 3,
                'appointment_date' => Carbon::tomorrow()->format('Y-m-d'),
                'appointment_time' => '14:00',
                'status' => 'Pending',
                'symptoms' => 'Tooth pain',
                'service_type' => 'General Check-up',
                'consultation_fee' => 400.00,
            ],
            [
                'appointment_number' => 'APT000005',
                'patient_id' => 5,
                'doctor_id' => 1,
                'appointment_date' => Carbon::today()->addDays(2)->format('Y-m-d'),
                'appointment_time' => '09:00',
                'status' => 'Confirmed',
                'symptoms' => 'Follow-up after heart surgery',
                'service_type' => 'Follow-up',
                'consultation_fee' => 1500.00,
            ],
            [
                'appointment_number' => 'APT000006',
                'patient_id' => 6,
                'doctor_id' => 4,
                'appointment_date' => Carbon::today()->addDays(2)->format('Y-m-d'),
                'appointment_time' => '13:00',
                'status' => 'Confirmed',
                'symptoms' => 'Skin rash on arms',
                'service_type' => 'Specialist Consultation',
                'consultation_fee' => 800.00,
            ],
            [
                'appointment_number' => 'APT000007',
                'patient_id' => 7,
                'doctor_id' => 5,
                'appointment_date' => Carbon::today()->addDays(3)->format('Y-m-d'),
                'appointment_time' => '10:00',
                'status' => 'Confirmed',
                'symptoms' => 'High fever, persistent cough',
                'service_type' => 'General Check-up',
                'consultation_fee' => 600.00,
            ],
            [
                'appointment_number' => 'APT000008',
                'patient_id' => 8,
                'doctor_id' => 2,
                'appointment_date' => Carbon::today()->addDays(3)->format('Y-m-d'),
                'appointment_time' => '15:00',
                'status' => 'Pending',
                'symptoms' => 'Annual physical checkup',
                'service_type' => 'General Check-up',
                'consultation_fee' => 500.00,
            ],
        ];

        foreach ($appointments as $appointment) {
            // Check if appointment already exists (based on doctor, date, time)
            $exists = Appointment::where('doctor_id', $appointment['doctor_id'])
                ->where('appointment_date', $appointment['appointment_date'])
                ->where('appointment_time', $appointment['appointment_time'])
                ->exists();
            
            if (!$exists) {
                Appointment::create($appointment);
            }
        }

        // ==========================================
        // 6. CREATE TRANSACTIONS (with duplicate check)
        // ==========================================
        $transactions = [
            [
                'invoice_number' => 'INV000001',
                'appointment_id' => 1,
                'patient_id' => 1,
                'consultation_fee' => 500.00,
                'additional_services_fee' => 150.00,
                'total_amount' => 650.00,
                'paid_amount' => 650.00,
                'outstanding_balance' => 0.00,
                'payment_status' => 'Paid',
                'payment_method' => 'Credit Card',
                'additional_services' => json_encode(['Blood Test' => 150.00]),
                'payment_date' => Carbon::now(),
            ],
            [
                'invoice_number' => 'INV000002',
                'appointment_id' => 2,
                'patient_id' => 2,
                'consultation_fee' => 500.00,
                'additional_services_fee' => 0.00,
                'total_amount' => 500.00,
                'paid_amount' => 0.00,
                'outstanding_balance' => 500.00,
                'payment_status' => 'Unpaid',
                'payment_method' => null,
                'additional_services' => null,
                'payment_date' => null,
            ],
            [
                'invoice_number' => 'INV000003',
                'appointment_id' => 3,
                'patient_id' => 3,
                'consultation_fee' => 1500.00,
                'additional_services_fee' => 300.00,
                'total_amount' => 1800.00,
                'paid_amount' => 1000.00,
                'outstanding_balance' => 800.00,
                'payment_status' => 'Partial',
                'payment_method' => 'Cash',
                'additional_services' => json_encode(['X-Ray' => 200.00, 'ECG' => 100.00]),
                'payment_date' => Carbon::now(),
            ],
            [
                'invoice_number' => 'INV000004',
                'appointment_id' => 5,
                'patient_id' => 5,
                'consultation_fee' => 1500.00,
                'additional_services_fee' => 0.00,
                'total_amount' => 1500.00,
                'paid_amount' => 1500.00,
                'outstanding_balance' => 0.00,
                'payment_status' => 'Paid',
                'payment_method' => 'Insurance',
                'additional_services' => null,
                'payment_date' => Carbon::now(),
            ],
            [
                'invoice_number' => 'INV000005',
                'appointment_id' => 6,
                'patient_id' => 6,
                'consultation_fee' => 800.00,
                'additional_services_fee' => 200.00,
                'total_amount' => 1000.00,
                'paid_amount' => 1000.00,
                'outstanding_balance' => 0.00,
                'payment_status' => 'Paid',
                'payment_method' => 'Debit Card',
                'additional_services' => json_encode(['Biopsy' => 200.00]),
                'payment_date' => Carbon::now(),
            ],
        ];

        foreach ($transactions as $transaction) {
            $exists = Transaction::where('invoice_number', $transaction['invoice_number'])->exists();
            
            if (!$exists) {
                Transaction::create($transaction);
            }
        }

        // ==========================================
        // 7. OUTPUT SUCCESS MESSAGE
        // ==========================================
        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('📊 Statistics:');
        $this->command->info('   - Users: ' . User::count());
        $this->command->info('   - Patients: ' . Patient::count());
        $this->command->info('   - Doctors: ' . Doctor::count());
        $this->command->info('   - Schedules: ' . Schedule::count());
        $this->command->info('   - Appointments: ' . Appointment::count());
        $this->command->info('   - Transactions: ' . Transaction::count());
        $this->command->info('');
        $this->command->info('🔑 Login Credentials:');
        $this->command->info('   Email: admin@clinic.com');
        $this->command->info('   Password: password');
    }
}
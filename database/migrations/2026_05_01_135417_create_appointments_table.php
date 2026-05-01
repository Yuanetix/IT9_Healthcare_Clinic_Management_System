<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('appointment_number')->unique();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->enum('status', ['Pending', 'Confirmed', 'Completed', 'Cancelled'])->default('Pending');
            $table->text('symptoms')->nullable();
            $table->text('notes')->nullable();
            $table->enum('service_type', ['General Check-up', 'Specialist Consultation', 'Follow-up', 'Emergency']);
            $table->decimal('consultation_fee', 10, 2);
            $table->timestamps();
            $table->unique(['doctor_id', 'appointment_date', 'appointment_time'], 'unique_appointment_slot');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
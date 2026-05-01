<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('appointment_id')->constrained('appointments')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->decimal('consultation_fee', 10, 2);
            $table->decimal('additional_services_fee', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('outstanding_balance', 10, 2);
            $table->enum('payment_status', ['Unpaid', 'Partial', 'Paid', 'Refunded'])->default('Unpaid');
            $table->enum('payment_method', ['Cash', 'Credit Card', 'Debit Card', 'Insurance', 'Online'])->nullable();
            $table->json('additional_services')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
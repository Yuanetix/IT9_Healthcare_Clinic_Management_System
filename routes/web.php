<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('patients', PatientController::class);
    Route::resource('doctors', DoctorController::class);
    Route::resource('appointments', AppointmentController::class);
    Route::resource('transactions', TransactionController::class);
    
    Route::post('doctors/{doctor}/schedules', [ScheduleController::class, 'store'])->name('schedules.store');
    Route::delete('schedules/{schedule}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');
    Route::get('doctors/{doctor}/schedules', [DoctorController::class, 'schedules'])->name('doctors.schedules');
    
    Route::patch('appointments/{appointment}/confirm', [AppointmentController::class, 'confirm'])->name('appointments.confirm');
    Route::patch('appointments/{appointment}/complete', [AppointmentController::class, 'complete'])->name('appointments.complete');
    Route::delete('appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::get('get-available-slots', [AppointmentController::class, 'getAvailableSlots'])->name('get.available.slots');
    
    Route::post('transactions/{transaction}/payment', [TransactionController::class, 'processPayment'])->name('transactions.payment');
    Route::get('reports/revenue', [TransactionController::class, 'revenueReport'])->name('reports.revenue');

   
    Route::get('transactions/{transaction}/receipt', [TransactionController::class, 'generateReceipt'])->name('transactions.receipt');
    Route::get('transactions/{transaction}/invoice', [TransactionController::class, 'generateInvoice'])->name('transactions.invoice');
    Route::get('reports/revenue-pdf', [TransactionController::class, 'generateRevenueReport'])->name('reports.revenue-pdf');
});
    

require __DIR__.'/auth.php';
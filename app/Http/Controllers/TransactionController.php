<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['patient', 'appointment'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['patient', 'appointment.doctor']);
        return view('transactions.show', compact('transaction'));
    }

    public function processPayment(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $transaction->outstanding_balance,
            'payment_method' => 'required|in:Cash,Credit Card,Debit Card,Insurance,Online,GCash,PayMaya',
            'additional_services' => 'nullable|array',
            'additional_services_fee' => 'nullable|numeric|min:0',
        ]);

        if (isset($validated['additional_services_fee']) && $validated['additional_services_fee'] > 0) {
            $transaction->additional_services_fee += $validated['additional_services_fee'];
            $transaction->total_amount += $validated['additional_services_fee'];
            $transaction->outstanding_balance += $validated['additional_services_fee'];
            $transaction->additional_services = json_encode($validated['additional_services'] ?? []);
            $transaction->save();
        }

        $transaction->paid_amount += $validated['amount'];
        $transaction->outstanding_balance = $transaction->total_amount - $transaction->paid_amount;
        
        if ($transaction->outstanding_balance <= 0) {
            $transaction->payment_status = 'Paid';
            $transaction->paid_amount = $transaction->total_amount;
            $transaction->outstanding_balance = 0;
        } else {
            $transaction->payment_status = 'Partial';
        }
        
        $transaction->payment_method = $validated['payment_method'];
        $transaction->payment_date = now();
        $transaction->save();

        return redirect()->route('transactions.show', $transaction)
            ->with('success', 'Payment recorded successfully.');
    }

    // Generate PDF Receipt for a single transaction
    public function generateReceipt(Transaction $transaction)
    {
        $transaction->load(['patient', 'appointment.doctor']);
        
        $pdf = Pdf::loadView('transactions.receipt', compact('transaction'));
        
        return $pdf->download('receipt-' . $transaction->invoice_number . '.pdf');
    }

    // Generate PDF Invoice
    public function generateInvoice(Transaction $transaction)
    {
        $transaction->load(['patient', 'appointment.doctor']);
        
        $pdf = Pdf::loadView('transactions.invoice', compact('transaction'));
        
        return $pdf->download('invoice-' . $transaction->invoice_number . '.pdf');
    }

    // Generate PDF Revenue Report
    public function generateRevenueReport(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $groupBy = $request->get('group_by', 'doctor');

        $transactions = Transaction::with(['appointment.doctor', 'appointment'])
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->where('payment_status', 'Paid')
            ->get();

        if ($groupBy == 'doctor') {
            $report = $transactions->groupBy(function ($transaction) {
                return $transaction->appointment->doctor->full_name ?? 'Unknown';
            })->map(function ($group) {
                return [
                    'total' => $group->sum('total_amount'),
                    'count' => $group->count()
                ];
            });
        } else {
            $report = $transactions->groupBy(function ($transaction) {
                return $transaction->appointment->service_type ?? 'Unknown';
            })->map(function ($group) {
                return [
                    'total' => $group->sum('total_amount'),
                    'count' => $group->count()
                ];
            });
        }

        $totalRevenue = $transactions->sum('total_amount');
        $totalTransactions = $transactions->count();

        $pdf = Pdf::loadView('transactions.report-pdf', compact('report', 'startDate', 'endDate', 'groupBy', 'totalRevenue', 'totalTransactions'));
        
        return $pdf->download('revenue-report-' . Carbon::now()->format('Y-m-d') . '.pdf');
    }

    // Generate PDF Appointment Report
    public function generateAppointmentReport(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $status = $request->get('status', 'all');

        $appointments = Appointment::with(['patient', 'doctor'])
            ->whereBetween('appointment_date', [$startDate, $endDate]);

        if ($status != 'all') {
            $appointments->where('status', $status);
        }

        $appointments = $appointments->get();

        $pdf = Pdf::loadView('reports.appointments', compact('appointments', 'startDate', 'endDate', 'status'));
        
        return $pdf->download('appointments-report-' . Carbon::now()->format('Y-m-d') . '.pdf');
    }

    public function revenueReport(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $groupBy = $request->get('group_by', 'doctor');

        $transactions = Transaction::with(['appointment.doctor', 'appointment'])
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->where('payment_status', 'Paid')
            ->get();

        if ($groupBy == 'doctor') {
            $report = $transactions->groupBy(function ($transaction) {
                return $transaction->appointment->doctor->full_name ?? 'Unknown';
            })->map(function ($group) {
                return [
                    'total' => $group->sum('total_amount'),
                    'count' => $group->count()
                ];
            });
        } else {
            $report = $transactions->groupBy(function ($transaction) {
                return $transaction->appointment->service_type ?? 'Unknown';
            })->map(function ($group) {
                return [
                    'total' => $group->sum('total_amount'),
                    'count' => $group->count()
                ];
            });
        }

        $totalRevenue = $transactions->sum('total_amount');
        $totalTransactions = $transactions->count();

        return view('transactions.report', compact('report', 'startDate', 'endDate', 'groupBy', 'totalRevenue', 'totalTransactions'));
    }
}
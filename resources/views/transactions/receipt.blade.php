<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Receipt - {{ $transaction->invoice_number }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background: white;
        }
        .receipt {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 30px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #e94560;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #e94560;
            margin: 0;
            font-size: 28px;
        }
        .header p {
            color: #666;
            margin: 5px 0;
        }
        .receipt-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin: 20px 0;
            color: #333;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .info-table td:first-child {
            font-weight: bold;
            width: 30%;
            background: #f5f5f5;
        }
        .amount-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .amount-table th, .amount-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: right;
        }
        .amount-table th {
            background: #f5f5f5;
            font-weight: bold;
            text-align: left;
        }
        .total-row {
            font-weight: bold;
            background: #e94560;
            color: white;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 12px;
        }
        .thankyou {
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            color: #e94560;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <h1>🏥 Healthcare Clinic</h1>
            <p>123 Health Street, Medical City</p>
            <p>Tel: (02) 1234-5678 | Email: info@healthcareclinic.com</p>
        </div>

        <div class="receipt-title">
            OFFICIAL RECEIPT
        </div>

        <table class="info-table">
            <tr>
                <td>Receipt Number:</td>
                <td>{{ $transaction->invoice_number }}</td>
            </tr>
            <tr>
                <td>Date:</td>
                <td>{{ now()->format('F d, Y h:i A') }}</td>
            </tr>
            <tr>
                <td>Patient Name:</td>
                <td>{{ $transaction->patient->full_name }}</td>
            </tr>
            <tr>
                <td>Doctor:</td>
                <td>{{ $transaction->appointment->doctor->full_name }}</td>
            </tr>
            <tr>
                <td>Service Type:</td>
                <td>{{ $transaction->appointment->service_type }}</td>
            </tr>
            <tr>
                <td>Appointment Date:</td>
                <td>{{ \Carbon\Carbon::parse($transaction->appointment->appointment_date)->format('F d, Y') }} at {{ \Carbon\Carbon::parse($transaction->appointment->appointment_time)->format('h:i A') }}</td>
            </tr>
        </table>

        <table class="amount-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Amount (₱)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Consultation Fee</td>
                    <td>₱{{ number_format($transaction->consultation_fee, 2) }}</td>
                </tr>
                @if($transaction->additional_services_fee > 0)
                <tr>
                    <td>Additional Services</td>
                    <td>₱{{ number_format($transaction->additional_services_fee, 2) }}</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td><strong>TOTAL AMOUNT</strong></td>
                    <td><strong>₱{{ number_format($transaction->total_amount, 2) }}</strong></td>
                </tr>
                <tr>
                    <td>Amount Paid</td>
                    <td>₱{{ number_format($transaction->paid_amount, 2) }}</td>
                </tr>
                @if($transaction->outstanding_balance > 0)
                <tr>
                    <td>Outstanding Balance</td>
                    <td>₱{{ number_format($transaction->outstanding_balance, 2) }}</td>
                </tr>
                @endif
                <tr>
                    <td>Payment Method</td>
                    <td>{{ $transaction->payment_method ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Payment Status</td>
                    <td>
                        @if($transaction->payment_status == 'Paid')
                            <span style="color: green;">PAID</span>
                        @elseif($transaction->payment_status == 'Partial')
                            <span style="color: orange;">PARTIAL</span>
                        @else
                            <span style="color: red;">UNPAID</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="thankyou">
            Thank you for choosing our clinic!
        </div>

        <div class="footer">
            This is a computer-generated receipt. No signature required.
            <br>For inquiries, please contact our billing department.
        </div>
    </div>
</body>
</html>
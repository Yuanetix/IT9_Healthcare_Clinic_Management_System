<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $transaction->invoice_number }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
        }
        .invoice {
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
        }
        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }
        .clinic-info, .patient-info {
            margin-bottom: 20px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .items-table th, .items-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .items-table th {
            background: #f5f5f5;
        }
        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="invoice">
        <div class="header">
            <h1>🏥 HEALTHCARE CLINIC</h1>
            <p>123 Health Street, Medical City | Tel: (02) 1234-5678</p>
        </div>

        <div class="invoice-title">
            TAX INVOICE
        </div>

        <div class="clinic-info">
            <table class="info-table">
                <tr>
                    <td width="50%"><strong>Invoice Number:</strong> {{ $transaction->invoice_number }}</td>
                    <td><strong>Date:</strong> {{ $transaction->created_at->format('F d, Y') }}</td>
                </tr>
                <tr>
                    <td><strong>Payment Status:</strong> {{ $transaction->payment_status }}</td>
                    <td><strong>Due Date:</strong> Upon Receipt</td>
                </tr>
            </table>
        </div>

        <div class="patient-info">
            <h3>Bill To:</h3>
            <table class="info-table">
                <tr>
                    <td width="30%"><strong>Patient Name:</strong></td>
                    <td>{{ $transaction->patient->full_name }}</td>
                </tr>
                <tr>
                    <td><strong>Patient ID:</strong></td>
                    <td>{{ $transaction->patient->patient_id }}</td>
                </tr>
                <tr>
                    <td><strong>Email:</strong></td>
                    <td>{{ $transaction->patient->email }}</td>
                </tr>
                <tr>
                    <td><strong>Phone:</strong></td>
                    <td>{{ $transaction->patient->phone }}</td>
                </tr>
            </table>
        </div>

        <h3>Services Rendered:</h3>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Price (₱)</th>
                    <th>Total (₱)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Consultation - {{ $transaction->appointment->service_type }} (Dr. {{ $transaction->appointment->doctor->last_name }})</td>
                    <td>1</td>
                    <td>₱{{ number_format($transaction->consultation_fee, 2) }}</td>
                    <td>₱{{ number_format($transaction->consultation_fee, 2) }}</td>
                </tr>
                @if($transaction->additional_services_fee > 0)
                <tr>
                    <td>Additional Services</td>
                    <td>1</td>
                    <td>₱{{ number_format($transaction->additional_services_fee, 2) }}</td>
                    <td>₱{{ number_format($transaction->additional_services_fee, 2) }}</td>
                </tr>
                @endif
            </tbody>
        </table>

        <div class="total">
            SUBTOTAL: ₱{{ number_format($transaction->total_amount, 2) }}<br>
            <strong>TOTAL DUE: ₱{{ number_format($transaction->outstanding_balance, 2) }}</strong>
        </div>

        <div class="footer">
            <p>Payment Terms: Due upon receipt. Thank you for your prompt payment.</p>
            <p>This is a system-generated invoice. For disputes, please contact billing within 7 days.</p>
        </div>
    </div>
</body>
</html>
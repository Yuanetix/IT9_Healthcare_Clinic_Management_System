<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Revenue Report</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
        }
        .report {
            max-width: 100%;
            margin: 0 auto;
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
        .report-title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }
        .summary {
            margin-bottom: 20px;
            padding: 10px;
            background: #f5f5f5;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }
        .summary-table td {
            padding: 8px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .data-table th, .data-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .data-table th {
            background: #e94560;
            color: white;
        }
        .total-row {
            font-weight: bold;
            background: #f5f5f5;
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
    <div class="report">
        <div class="header">
            <h1>🏥 HEALTHCARE CLINIC</h1>
            <p>Revenue Report</p>
        </div>

        <div class="report-title">
            {{ ucfirst($groupBy) }} Revenue Summary
        </div>

        <div class="summary">
            <table class="summary-table">
                <tr>
                    <td><strong>Report Period:</strong></td>
                    <td>{{ \Carbon\Carbon::parse($startDate)->format('F d, Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('F d, Y') }}</td>
                    <td><strong>Generated On:</strong></td>
                    <td>{{ now()->format('F d, Y h:i A') }}</td>
                </tr>
                <tr>
                    <td><strong>Total Revenue:</strong></td>
                    <td>₱{{ number_format($totalRevenue, 2) }}</td>
                    <td><strong>Total Transactions:</strong></td>
                    <td>{{ $totalTransactions }}</td>
                </tr>
            </table>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>{{ $groupBy == 'doctor' ? 'Doctor Name' : 'Service Type' }}</th>
                    <th>Number of Transactions</th>
                    <th>Total Revenue (₱)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($report as $name => $data)
                <tr>
                    <td><strong>{{ $name }}</strong></td>
                    <td>{{ $data['count'] }}</td>
                    <td>₱{{ number_format($data['total'], 2) }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td><strong>TOTAL</strong></td>
                    <td><strong>{{ $totalTransactions }}</strong></td>
                    <td><strong>₱{{ number_format($totalRevenue, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            This is a computer-generated report. For official use only.
        </div>
    </div>
</body>
</html>
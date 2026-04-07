<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $report->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #1f2937; margin: 0; padding: 0; background: #f8fafc; }
        .page { max-width: 900px; margin: 0 auto; padding: 28px; background: #ffffff; }
        .header { margin-bottom: 24px; }
        .header h1 { font-size: 28px; margin: 0 0 8px; }
        .header p { margin: 4px 0; color: #4b5563; }
        .section { margin-bottom: 28px; }
        .section-title { font-size: 18px; margin-bottom: 12px; color: #111827; }
        .summary-grid { display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
        .summary-card { flex: 1 1 220px; border: 1px solid #e5e7eb; border-radius: 18px; padding: 16px; background: #f9fafb; }
        .summary-card .label { font-size: 11px; letter-spacing: 0.14em; text-transform: uppercase; color: #6b7280; margin-bottom: 8px; }
        .summary-card .value { font-size: 24px; font-weight: 700; color: #111827; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
        th, td { border: 1px solid #e5e7eb; padding: 10px 12px; text-align: left; }
        th { background: #f3f4f6; color: #374151; font-weight: 700; }
        tr:nth-child(even) { background: #f9fafb; }
        pre { background: #f3f4f6; border-radius: 12px; padding: 16px; overflow-x: auto; }
    </style>
</head>
<body>
    <div class="page">
        <div class="header">
            <p style="font-size: 12px; letter-spacing: 0.2em; text-transform: uppercase; color: #6b7280; margin-bottom: 8px;">Report</p>
            <h1>{{ $report->name }}</h1>
            <p>{{ ucfirst($report->type) }} report generated on {{ $report->created_at->format('M d, Y H:i') }}.</p>
        </div>

        <div class="summary-grid section">
            <div class="summary-card">
                <p class="label">Created By</p>
                <p class="value">{{ $report->creator->name ?? 'N/A' }}</p>
            </div>
            <div class="summary-card">
                <p class="label">Report Type</p>
                <p class="value">{{ ucfirst($report->type) }}</p>
            </div>
            <div class="summary-card">
                <p class="label">Date Range</p>
                <p class="value">{{ $report->parameters['start_date'] ?? 'Any' }} — {{ $report->parameters['end_date'] ?? 'Any' }}</p>
            </div>
        </div>

        @if($report->type == 'patient')
            <div class="section">
                <p class="section-title">Patient Data</p>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($report->data as $patient)
                            <tr>
                                <td>{{ $patient['id'] }}</td>
                                <td>{{ $patient['first_name'] }} {{ $patient['last_name'] }}</td>
                                <td>{{ $patient['email'] }}</td>
                                <td>{{ $patient['phone'] }}</td>
                                <td>{{ $patient['created_at'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @elseif($report->type == 'financial')
            <div class="section">
                <p class="section-title">Financial Summary</p>
                <div class="summary-grid">
                    <div class="summary-card">
                        <p class="label">Total Invoiced</p>
                        <p class="value">${{ number_format($report->data['total_invoiced'], 2) }}</p>
                    </div>
                    <div class="summary-card">
                        <p class="label">Total Paid</p>
                        <p class="value">${{ number_format($report->data['total_paid'], 2) }}</p>
                    </div>
                    <div class="summary-card">
                        <p class="label">Outstanding</p>
                        <p class="value">${{ number_format(max($report->data['total_invoiced'] - $report->data['total_paid'], 0), 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="section">
                <p class="section-title">Invoices</p>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Patient</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($report->data['invoices'] as $invoice)
                            <tr>
                                <td>{{ $invoice['id'] }}</td>
                                <td>{{ $invoice['patient']['first_name'] }} {{ $invoice['patient']['last_name'] }}</td>
                                <td>${{ number_format($invoice['total_amount'], 2) }}</td>
                                <td>{{ ucfirst($invoice['status']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="section">
                <p class="section-title">Payments</p>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Invoice ID</th>
                            <th>Amount</th>
                            <th>Method</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($report->data['payments'] as $payment)
                            <tr>
                                <td>{{ $payment['id'] }}</td>
                                <td>{{ $payment['invoice_id'] }}</td>
                                <td>${{ number_format($payment['amount'], 2) }}</td>
                                <td>{{ $payment['payment_method'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @elseif($report->type == 'daily')
            <div class="section">
                <p class="section-title">Daily Metrics</p>
                <div class="summary-grid">
                    <div class="summary-card">
                        <p class="label">Date</p>
                        <p class="value">{{ $report->data['date'] }}</p>
                    </div>
                    <div class="summary-card">
                        <p class="label">Appointments</p>
                        <p class="value">{{ $report->data['appointments'] }}</p>
                    </div>
                    <div class="summary-card">
                        <p class="label">Admissions</p>
                        <p class="value">{{ $report->data['admissions'] }}</p>
                    </div>
                    <div class="summary-card">
                        <p class="label">Discharges</p>
                        <p class="value">{{ $report->data['discharges'] }}</p>
                    </div>
                </div>
            </div>
        @else
            <div class="section">
                <p class="section-title">Report Data</p>
                <pre>{{ json_encode($report->data, JSON_PRETTY_PRINT) }}</pre>
            </div>
        @endif
    </div>
</body>
</html>

<!-- Financial Report PDF Export -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .header { background: #1f2937; color: white; padding: 20px; text-align: center; }
        .title { font-size: 24px; font-weight: bold; margin: 0; }
        .subtitle { font-size: 14px; color: #ccc; margin: 5px 0 0 0; }
        .date { font-size: 12px; color: #ccc; margin-top: 10px; }
        .section { margin: 30px 0; page-break-inside: avoid; }
        .section-title { font-size: 18px; font-weight: bold; color: #1f2937; margin-bottom: 15px; border-bottom: 2px solid #10b981; padding-bottom: 10px; }
        .card { background: #f9fafb; padding: 15px; margin: 10px 0; border-left: 4px solid #10b981; }
        .card-label { font-size: 12px; text-transform: uppercase; color: #6b7280; font-weight: bold; }
        .card-value { font-size: 28px; font-weight: bold; color: #1f2937; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th { background: #f3f4f6; padding: 12px; text-align: left; font-weight: bold; border-bottom: 1px solid #d1d5db; }
        td { padding: 10px 12px; border-bottom: 1px solid #e5e7eb; }
        tr:nth-child(even) { background: #f9fafb; }
        .positive { color: #10b981; font-weight: bold; }
        .negative { color: #ef4444; font-weight: bold; }
        .footer { margin-top: 40px; padding-top: 20px; border-top: 1px solid #d1d5db; font-size: 12px; color: #6b7280; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">Financial Report</h1>
        <p class="subtitle">Revenue, Billing, and Payment Analysis</p>
        <p class="date">Generated on {{ now()->format('M d, Y H:i') }}</p>
    </div>

    <div class="section">
        <h2 class="section-title">Financial Summary</h2>
        <div class="card">
            <div class="card-label">Total Revenue</div>
            <div class="card-value positive">${{ number_format($report['summary']['total_revenue'], 2) }}</div>
        </div>
        <div class="card">
            <div class="card-label">Outstanding Bills</div>
            <div class="card-value negative">${{ number_format($report['summary']['outstanding_bills'], 2) }}</div>
        </div>
        <div class="card">
            <div class="card-label">Paid Bills</div>
            <div class="card-value positive">${{ number_format($report['summary']['paid_bills'], 2) }}</div>
        </div>
        <div class="card">
            <div class="card-label">Payment Rate</div>
            <div class="card-value">{{ number_format($report['summary']['paid_percentage'], 1) }}%</div>
        </div>
    </div>

    <div class="section">
        <h2 class="section-title">Key Metrics</h2>
        <table>
            <tr>
                <th>Metric</th>
                <th>Value</th>
            </tr>
            <tr>
                <td>Average Invoice Amount</td>
                <td>${{ number_format($report['summary']['average_invoice_amount'], 2) }}</td>
            </tr>
            <tr>
                <td>Total Invoices</td>
                <td>{{ number_format($report['summary']['invoice_count']) }}</td>
            </tr>
            <tr>
                <td>Net Profit</td>
                <td class="positive">${{ number_format($report['summary']['net_profit'], 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} HospitEx - Hospital Management System. All rights reserved.</p>
    </div>
</body>
</html>

<!-- Daily Report PDF Export -->
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
        .section-title { font-size: 18px; font-weight: bold; color: #1f2937; margin-bottom: 15px; border-bottom: 2px solid #a855f7; padding-bottom: 10px; }
        .card { background: #f9fafb; padding: 15px; margin: 10px 0; border-left: 4px solid #a855f7; }
        .card-label { font-size: 12px; text-transform: uppercase; color: #6b7280; font-weight: bold; }
        .card-value { font-size: 28px; font-weight: bold; color: #1f2937; margin: 10px 0; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th { background: #f3f4f6; padding: 12px; text-align: left; font-weight: bold; border-bottom: 1px solid #d1d5db; }
        td { padding: 10px 12px; border-bottom: 1px solid #e5e7eb; }
        tr:nth-child(even) { background: #f9fafb; }
        .footer { margin-top: 40px; padding-top: 20px; border-top: 1px solid #d1d5db; font-size: 12px; color: #6b7280; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">Daily Hospital Summary</h1>
        <p class="subtitle">{{ date('l, F j, Y') }}</p>
        <p class="date">Generated on {{ now()->format('H:i') }}</p>
    </div>

    <div class="section">
        <h2 class="section-title">Daily Operations</h2>
        <div class="grid">
            <div class="card">
                <div class="card-label">Today's Patients</div>
                <div class="card-value">{{ number_format($report['summary']['today_patients']) }}</div>
            </div>
            <div class="card">
                <div class="card-label">Admissions</div>
                <div class="card-value">{{ number_format($report['summary']['today_admissions']) }}</div>
            </div>
            <div class="card">
                <div class="card-label">Discharges</div>
                <div class="card-value">{{ number_format($report['summary']['today_discharges']) }}</div>
            </div>
            <div class="card">
                <div class="card-label">Appointments</div>
                <div class="card-value">{{ number_format($report['summary']['today_appointments']) }}</div>
            </div>
            <div class="card">
                <div class="card-label">Revenue</div>
                <div class="card-value">${{ number_format($report['summary']['today_revenue'], 2) }}</div>
            </div>
            <div class="card">
                <div class="card-label">Emergency Cases</div>
                <div class="card-value">{{ number_format($report['summary']['emergency_cases']) }}</div>
            </div>
        </div>
    </div>

    <div class="section">
        <h2 class="section-title">Active Hospital Status</h2>
        <table>
            <tr>
                <th>Metric</th>
                <th>Count</th>
            </tr>
            <tr>
                <td>Currently Admitted Patients</td>
                <td>{{ number_format($report['summary']['active_patients']) }}</td>
            </tr>
            <tr>
                <td>Emergency Admissions Today</td>
                <td>{{ number_format($report['summary']['emergency_cases']) }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} HospitEx - Hospital Management System. All rights reserved.</p>
        <p>This report was automatically generated on {{ now()->format('Y-m-d H:i:s') }}</p>
    </div>
</body>
</html>

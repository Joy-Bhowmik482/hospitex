<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Duty Roster Print</title>
    <style>
        body { font-family: Arial, sans-serif; color: #111827; margin: 0; padding: 24px; }
        .header { margin-bottom: 24px; }
        .header h1 { font-size: 28px; margin: 0 0 8px 0; }
        .header p { margin: 0; color: #4b5563; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { padding: 10px 12px; border: 1px solid #d1d5db; text-align: left; vertical-align: top; }
        th { background: #f9fafb; font-weight: 700; }
        tbody tr:nth-child(odd) { background: #ffffff; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        .badge { display: inline-block; padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 700; color: #fff; }
        .badge-active { background: #22c55e; }
        .badge-inactive { background: #ef4444; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Duty Roster</h1>
        <p>Generated roster for active assignments. Use this print view to create a PDF or hardcopy report.</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Day</th>
                <th>Shift</th>
                <th>Time</th>
                <th>Doctor</th>
                <th>Staff</th>
                <th>Location</th>
                <th>Task</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rosters as $roster)
            <tr>
                <td>{{ ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'][$roster->day_of_week] ?? 'Unknown' }}</td>
                <td>{{ $roster->shift->name ?? 'N/A' }}</td>
                <td>{{ \Carbon\Carbon::parse($roster->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($roster->end_time)->format('g:i A') }}</td>
                <td>{{ $roster->doctor->name ?? 'N/A' }}</td>
                <td>{{ $roster->staff->name ?? 'N/A' }}</td>
                <td>{{ optional($roster->ward)->name ?? 'N/A' }} {{ optional($roster->room)->room_no ? '• ' . $roster->room->room_no : '' }}</td>
                <td>{{ $roster->task_description ?? 'N/A' }}</td>
                <td><span class="badge {{ $roster->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $roster->is_active ? 'Active' : 'Inactive' }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

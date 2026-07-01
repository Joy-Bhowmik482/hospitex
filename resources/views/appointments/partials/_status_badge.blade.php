@php
    $statusColors = [
        'Pending' => 'bg-slate-100 text-slate-800',
        'Confirmed' => 'bg-blue-100 text-blue-800',
        'Checked In' => 'bg-purple-100 text-purple-800',
        'Waiting' => 'bg-yellow-100 text-yellow-800',
        'In Consultation' => 'bg-indigo-100 text-indigo-800',
        'Completed' => 'bg-green-100 text-green-800',
        'Cancelled' => 'bg-red-100 text-red-800',
        'No Show' => 'bg-orange-100 text-orange-800',
        'Rescheduled' => 'bg-cyan-100 text-cyan-800',
    ];

    $statusIcons = [
        'Pending' => '⏳',
        'Confirmed' => '✅',
        'Checked In' => '📋',
        'Waiting' => '👥',
        'In Consultation' => '🩺',
        'Completed' => '✔️',
        'Cancelled' => '❌',
        'No Show' => '🚫',
        'Rescheduled' => '🔄',
    ];
@endphp

<span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$status] ?? 'bg-slate-100 text-slate-800' }}">
    {{ $statusIcons[$status] ?? '📌' }} {{ $status }}
</span>

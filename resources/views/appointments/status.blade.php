@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">

    <!-- Page Header -->
    @include('appointments.partials._header', [
        'title' => 'Appointment Status',
        'subtitle' => 'View and manage appointments by status',
        'actions' => [
            [
                'label' => '➕ New Appointment',
                'url' => route('appointments.create'),
                'color' => 'from-blue-500 to-blue-600',
            ],
        ]
    ])

    <!-- Statistics -->
    @include('appointments.partials._stats', [
        'stats' => [
            [
                'label' => 'Total Appointments',
                'value' => $totalCount,
                'icon' => '📊',
            ],
            [
                'label' => 'Pending',
                'value' => $statusCounts['Pending'] ?? 0,
                'icon' => '⏳',
            ],
            [
                'label' => 'In Progress',
                'value' => ($statusCounts['Confirmed'] ?? 0) + ($statusCounts['Checked In'] ?? 0) + ($statusCounts['In Consultation'] ?? 0) + ($statusCounts['Waiting'] ?? 0),
                'icon' => '🔄',
            ],
            [
                'label' => 'Completed',
                'value' => $statusCounts['Completed'] ?? 0,
                'icon' => '✔️',
            ],
        ]
    ])

    <!-- Search -->
    @include('appointments.partials._search', [
        'searchAction' => route('appointments.status'),
    ])

    <!-- Status Filter -->
    <div class="bg-white rounded-xl shadow-md border border-slate-200 p-4 mb-6">
        <form action="{{ route('appointments.status') }}" method="GET" class="flex flex-wrap items-center gap-4">
            
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-2">Filter by Status</label>
                <select name="status" class="border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Statuses</option>
                    <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Confirmed" {{ request('status') === 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="Checked In" {{ request('status') === 'Checked In' ? 'selected' : '' }}>Checked In</option>
                    <option value="Waiting" {{ request('status') === 'Waiting' ? 'selected' : '' }}>Waiting</option>
                    <option value="In Consultation" {{ request('status') === 'In Consultation' ? 'selected' : '' }}>In Consultation</option>
                    <option value="Completed" {{ request('status') === 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="Cancelled" {{ request('status') === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="No Show" {{ request('status') === 'No Show' ? 'selected' : '' }}>No Show</option>
                    <option value="Rescheduled" {{ request('status') === 'Rescheduled' ? 'selected' : '' }}>Rescheduled</option>
                </select>
            </div>

            <div class="flex gap-2 pt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-lg text-sm transition">
                    ✓ Filter
                </button>
                <a href="{{ route('appointments.status') }}" class="bg-slate-300 hover:bg-slate-400 text-slate-800 font-semibold px-4 py-2 rounded-lg text-sm transition">
                    ✕ Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Tab Navigation -->
    <div class="flex gap-2 mb-6 overflow-x-auto pb-2">
        <a href="{{ route('appointments.status') }}" 
           class="px-4 py-2 font-semibold rounded-lg {{ !request('status') ? 'bg-blue-500 text-white' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50' }} transition whitespace-nowrap">
            All ({{ $totalCount }})
        </a>
        @php
            $statuses = ['Pending' => '⏳', 'Confirmed' => '✅', 'Checked In' => '📋', 'Waiting' => '👥', 'In Consultation' => '🩺', 'Completed' => '✔️', 'Cancelled' => '❌', 'No Show' => '🚫', 'Rescheduled' => '🔄'];
        @endphp
        @foreach($statuses as $status => $icon)
            <a href="{{ route('appointments.status', ['status' => $status]) }}" 
               class="px-4 py-2 font-semibold rounded-lg {{ request('status') === $status ? 'bg-blue-500 text-white' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50' }} transition whitespace-nowrap">
                {{ $icon }} {{ $status }} ({{ $statusCounts[$status] ?? 0 }})
            </a>
        @endforeach
    </div>

    <!-- Content: Table or Empty State -->
    @if($appointments->count() > 0)

        <!-- Status Timeline View Option (Optional) -->
        <div class="mb-6 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-slate-800">Appointments Timeline</h3>
            <button onclick="toggleView()" class="bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold py-2 px-4 rounded-lg text-sm transition">
                📊 Toggle View
            </button>
        </div>

        <!-- Data Table -->
        <div id="tableView">
            @include('appointments.partials._table', [
                'items' => $appointments,
                'columns' => [
                    ['label' => 'Appointment No', 'field' => 'appointment_no', 'type' => 'text'],
                    ['label' => 'Patient', 'field' => 'patient', 'type' => 'avatar'],
                    ['label' => 'Doctor', 'field' => 'doctor.name', 'type' => 'text'],
                    ['label' => 'Appointment Date', 'field' => 'appointment_date', 'timeField' => 'appointment_time', 'type' => 'date'],
                    ['label' => 'Current Status', 'field' => 'status', 'type' => 'status'],
                ],
                'showActions' => true,
                'showStatusChange' => true,
            ])
        </div>

    @else

        <!-- Empty State -->
        @include('appointments.partials._empty', [
            'icon' => '🔍',
            'title' => 'No Appointments Found',
            'message' => 'No appointments match your current filter.' . (request('status') ? ' Try selecting a different status.' : ''),
            'action' => [
                'label' => '➕ Create Appointment',
                'url' => route('appointments.create'),
            ],
        ])

    @endif

</div>

<script>
    function toggleView() {
        const tableView = document.getElementById('tableView');
        // Can be extended to show Kanban or timeline view
        alert('Additional views coming soon!');
    }
</script>

<style>
    @media print {
        .no-print { display: none !important; }
    }
</style>

@endsection

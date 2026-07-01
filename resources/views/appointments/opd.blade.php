@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">

    <!-- Page Header -->
    @include('appointments.partials._header', [
        'title' => 'OPD Appointments',
        'subtitle' => 'Manage out-patient department appointments',
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
                'label' => 'Today\'s Appointments',
                'value' => $todayCount,
                'icon' => '📅',
                'trend' => 12,
            ],
            [
                'label' => 'Pending',
                'value' => $pendingCount,
                'icon' => '⏳',
                'trend' => -5,
            ],
            [
                'label' => 'Confirmed',
                'value' => $confirmedCount,
                'icon' => '✅',
                'trend' => 8,
            ],
            [
                'label' => 'Completed This Month',
                'value' => $completedCount,
                'icon' => '✔️',
                'trend' => 25,
            ],
        ]
    ])

    <!-- Search -->
    @include('appointments.partials._search', [
        'searchAction' => route('appointments.opd'),
    ])

    <!-- Filters -->
    @include('appointments.partials._filters', [
        'filterAction' => route('appointments.opd'),
        'showStatusFilter' => true,
        'showDateFilter' => true,
        'showDepartmentFilter' => true,
        'showDoctorFilter' => true,
    ])

    <!-- Content: Table or Empty State -->
    @if($appointments->count() > 0)

        <!-- Data Table -->
        @include('appointments.partials._table', [
            'items' => $appointments,
            'columns' => [
                ['label' => 'Appointment No', 'field' => 'appointment_no', 'type' => 'text'],
                ['label' => 'Patient', 'field' => 'patient', 'type' => 'avatar'],
                ['label' => 'Doctor', 'field' => 'doctor.name', 'type' => 'text'],
                ['label' => 'Department', 'field' => 'department.name', 'type' => 'text'],
                ['label' => 'Date & Time', 'field' => 'appointment_date', 'timeField' => 'appointment_time', 'type' => 'date'],
                ['label' => 'Status', 'field' => 'status', 'type' => 'status'],
            ],
            'showActions' => true,
            'showStatusChange' => true,
        ])

    @else

        <!-- Empty State -->
        @include('appointments.partials._empty', [
            'icon' => '📋',
            'title' => 'No OPD Appointments Found',
            'message' => 'No appointments match your current filters.',
            'action' => [
                'label' => '➕ Create OPD Appointment',
                'url' => route('appointments.create'),
            ],
        ])

    @endif

</div>

<style>
    @media print {
        .no-print { display: none !important; }
    }
</style>

@endsection

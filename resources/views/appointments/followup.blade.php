@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">

    <!-- Page Header -->
    @include('appointments.partials._header', [
        'title' => 'Follow-up Appointments',
        'subtitle' => 'Schedule and manage follow-up appointments',
        'actions' => [
            [
                'label' => '➕ Schedule Follow-up',
                'url' => route('appointments.create'),
                'color' => 'from-blue-500 to-blue-600',
            ],
        ]
    ])

    <!-- Statistics -->
    @include('appointments.partials._stats', [
        'stats' => [
            [
                'label' => 'Pending Follow-ups',
                'value' => $pendingFollowups,
                'icon' => '⏳',
                'trend' => 18,
            ],
            [
                'label' => 'Due This Week',
                'value' => $dueThisWeek,
                'icon' => '📅',
                'trend' => 5,
            ],
            [
                'label' => 'Completed Follow-ups',
                'value' => $completedFollowups,
                'icon' => '✔️',
                'trend' => 30,
            ],
            [
                'label' => 'With Reminders',
                'value' => $withReminders,
                'icon' => '🔔',
                'trend' => 12,
            ],
        ]
    ])

    <!-- Search -->
    @include('appointments.partials._search', [
        'searchAction' => route('appointments.followup'),
    ])

    <!-- Filters -->
    @include('appointments.partials._filters', [
        'filterAction' => route('appointments.followup'),
        'showStatusFilter' => true,
        'showDateFilter' => true,
        'showDepartmentFilter' => true,
        'showDoctorFilter' => true,
    ])

    <!-- Content: Table or Empty State -->
    @if($appointments->count() > 0)

        <!-- Data Table with Follow-up Details -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full">

                    <thead>
                        <tr class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-slate-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Patient</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Last Doctor</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Previous Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Days Since</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Next Follow-up</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Reminder</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200">
                        @foreach($appointments as $appointment)
                            <tr class="hover:bg-slate-50 transition duration-150">

                                <!-- Patient -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold text-sm">
                                            {{ substr($appointment->patient->first_name, 0, 1) }}{{ substr($appointment->patient->last_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-800">
                                                {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
                                            </p>
                                            <p class="text-xs text-slate-500">{{ $appointment->patient->patient_no }}</p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Last Doctor -->
                                <td class="px-6 py-4 text-sm text-slate-700">
                                    {{ $appointment->doctor->name }}
                                </td>

                                <!-- Previous Date -->
                                <td class="px-6 py-4 text-sm text-slate-700">
                                    {{ $appointment->appointment_date->format('d M Y') }}
                                </td>

                                <!-- Days Since -->
                                <td class="px-6 py-4">
                                    @php
                                        $daysSince = now()->diffInDays($appointment->appointment_date);
                                        $color = $daysSince > 30 ? 'text-red-600 font-semibold' : 'text-slate-700';
                                    @endphp
                                    <span class="text-sm {{ $color }}">{{ $daysSince }} days</span>
                                </td>

                                <!-- Next Follow-up -->
                                <td class="px-6 py-4 text-sm text-slate-700">
                                    @if($appointment->next_followup_date)
                                        {{ $appointment->next_followup_date->format('d M Y') }}
                                    @else
                                        <span class="text-slate-400">Not scheduled</span>
                                    @endif
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 text-center">
                                    @include('appointments.partials._status_badge', ['status' => $appointment->status])
                                </td>

                                <!-- Reminder -->
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                        🔔 Pending
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        <a href="{{ route('appointments.show', $appointment) }}"
                                           class="inline-block bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold py-1.5 px-3 rounded-md transition text-xs">
                                            👁️ View
                                        </a>

                                        <form action="{{ route('appointments.changeStatus', $appointment) }}" method="POST" class="inline-block">
                                            @csrf
                                            <input type="hidden" name="status" value="Completed">
                                            <button type="submit"
                                                    class="inline-block bg-green-50 hover:bg-green-100 text-green-700 font-semibold py-1.5 px-3 rounded-md transition text-xs"
                                                    onclick="return confirm('Mark this follow-up as completed?');">
                                                ✔️ Complete
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            <!-- Pagination Footer -->
            <div class="bg-slate-50 border-t border-slate-200 px-6 py-4 flex items-center justify-between">
                <p class="text-sm text-slate-600">
                    Showing <span class="font-semibold text-slate-800">{{ $appointments->total() }}</span> follow-ups
                </p>
                {{ $appointments->links() }}
            </div>

        </div>

    @else

        <!-- Empty State -->
        @include('appointments.partials._empty', [
            'icon' => '🔄',
            'title' => 'No Follow-up Appointments Found',
            'message' => 'No follow-up appointments match your current filters.',
            'action' => [
                'label' => '➕ Schedule Follow-up',
                'url' => route('appointments.create'),
            ],
        ])

    @endif

</div>

@endsection

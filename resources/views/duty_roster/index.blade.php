@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">
    <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Duty Roster</h2>
            <p class="text-slate-600">Review the weekly duty roster for active doctor schedules.</p>
        </div>
        <a href="{{ route('doctor-schedules.index') }}" class="bg-blue-500 text-white px-5 py-3 rounded-xl hover:bg-blue-600 transition">Manage Doctor Schedules</a>
    </div>

    <div class="grid gap-6 md:grid-cols-3 mb-8">
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="text-5xl mb-4">📅</div>
            <h3 class="text-xl font-semibold text-slate-800 mb-2">Weekly Schedule</h3>
            <p class="text-slate-600">View roster entries grouped by day of the week from current doctor schedules.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="text-5xl mb-4">👨‍⚕️</div>
            <h3 class="text-xl font-semibold text-slate-800 mb-2">Team Coverage</h3>
            <p class="text-slate-600">See which doctors and support staff are assigned to each shift.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="text-5xl mb-4">🗂️</div>
            <h3 class="text-xl font-semibold text-slate-800 mb-2">Shift details</h3>
            <p class="text-slate-600">Track schedule times, rooms, and active roster entries for the week.</p>
        </div>
    </div>

    @if ($schedules->isEmpty())
        <div class="bg-white rounded-3xl shadow-lg border border-slate-200 p-12 text-center">
            <div class="text-6xl mb-4">📭</div>
            <h3 class="text-xl font-semibold text-slate-800 mb-2">No active duty roster entries</h3>
            <p class="text-slate-600 mb-6">There are no active doctor schedules available for the roster. Add schedule entries to populate the roster.</p>
            <a href="{{ route('doctor-schedules.create') }}" class="bg-blue-500 text-white px-6 py-3 rounded-xl hover:bg-blue-600 transition">Add Doctor Schedule</a>
        </div>
    @else
        <div class="space-y-8">
            @foreach ($daysOfWeek as $dayIndex => $dayName)
                @if (isset($schedules[$dayIndex]) && $schedules[$dayIndex]->isNotEmpty())
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                        <div class="mb-6 flex items-center justify-between gap-4">
                            <div>
                                <h3 class="text-2xl font-semibold text-slate-800">{{ $dayName }}</h3>
                                <p class="text-slate-600">{{ $schedules[$dayIndex]->count() }} roster entries</p>
                            </div>
                            <span class="rounded-full bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700">Active</span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-6 py-4 text-xs font-semibold uppercase text-slate-700">Doctor</th>
                                        <th class="px-6 py-4 text-xs font-semibold uppercase text-slate-700">Staff</th>
                                        <th class="px-6 py-4 text-xs font-semibold uppercase text-slate-700">Department</th>
                                        <th class="px-6 py-4 text-xs font-semibold uppercase text-slate-700">Shift</th>
                                        <th class="px-6 py-4 text-xs font-semibold uppercase text-slate-700">Room</th>
                                        <th class="px-6 py-4 text-xs font-semibold uppercase text-slate-700">Task</th>
                                        <th class="px-6 py-4 text-xs font-semibold uppercase text-slate-700">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200">
                                    @foreach ($schedules[$dayIndex] as $schedule)
                                        <tr class="hover:bg-slate-50 transition duration-150">
                                            <td class="px-6 py-4 text-slate-800 font-semibold">{{ $schedule->doctor->name ?? 'Unknown Doctor' }}</td>
                                            <td class="px-6 py-4 text-slate-700">{{ optional($schedule->staff)->name ?? 'None' }}</td>
                                            <td class="px-6 py-4 text-slate-700">{{ $schedule->doctor->department->name ?? 'General' }}</td>
                                            <td class="px-6 py-4 text-slate-700">{{ date('g:i A', strtotime($schedule->start_time)) }} - {{ date('g:i A', strtotime($schedule->end_time)) }}</td>
                                            <td class="px-6 py-4 text-slate-700">{{ $schedule->room_no ?? 'TBD' }}</td>
                                            <td class="px-6 py-4 text-slate-700">{{ $schedule->task_description ?? 'General duties' }}</td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $schedule->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $schedule->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>

@endsection

@extends('includePage')

@section('content')

@php
    function format_time($time)
    {
        if (!$time) return 'N/A';

        try {
            return \Carbon\Carbon::createFromFormat('H:i:s', $time)->format('g:i A');
        } catch (\Throwable $e) {
            try {
                return \Carbon\Carbon::createFromFormat('H:i', $time)->format('g:i A');
            } catch (\Throwable $e) {
                return $time;
            }
        }
    }

    $days = [
        0 => 'Sunday',
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
    ];
@endphp

<div class="max-w-7xl mx-auto py-8">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Doctor Schedules</h1>
            <p class="text-slate-500 mt-1">Manage doctor availability and working time slots</p>
        </div>

        <a href="{{ route('doctor-schedules.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-semibold shadow-md transition">
            + Add Schedule
        </a>
    </div>

    <!-- Success -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <!-- Empty State -->
    @if($schedules->isEmpty())
        <div class="bg-white border rounded-2xl p-10 text-center shadow-sm">
            <div class="text-5xl mb-3">📅</div>
            <h2 class="text-xl font-semibold text-slate-800">No schedules found</h2>
            <p class="text-slate-500 mt-2 mb-6">Start by creating your first doctor schedule.</p>

            <a href="{{ route('doctor-schedules.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl">
                Create Schedule
            </a>
        </div>
    @else

        <!-- Table -->
        <div class="bg-white rounded-2xl shadow border overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full text-sm">

                    <!-- Header -->
                    <thead class="bg-slate-100 text-slate-700">
                        <tr>
                            <th class="p-4 text-left">ID</th>
                            <th class="p-4 text-left">Doctor</th>
                            <th class="p-4 text-left">Support Staff</th>
                            <th class="p-4 text-left">Day</th>
                            <th class="p-4 text-left">Shift</th>
                            <th class="p-4 text-left">Task</th>
                            <th class="p-4 text-left">Room</th>
                            <th class="p-4 text-left">Status</th>
                            <th class="p-4 text-center">Actions</th>
                        </tr>
                    </thead>

                    <!-- Body -->
                    <tbody class="divide-y">

                        @foreach($schedules as $schedule)
                            <tr class="hover:bg-slate-50 transition">

                                <!-- ID -->
                                <td class="p-4 font-medium text-slate-700">
                                    #{{ str_pad($schedule->id, 3, '0', STR_PAD_LEFT) }}
                                </td>

                                <!-- Doctor -->
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">
                                            {{ strtoupper(substr($schedule->doctor->name ?? 'D', 0, 1)) }}
                                        </div>

                                        <div>
                                            <p class="font-semibold text-slate-800">
                                                {{ $schedule->doctor->name ?? 'Unknown' }}
                                            </p>
                                            <p class="text-xs text-slate-500">
                                                {{ $schedule->doctor->specialization ?? 'No specialization' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Support Staff -->
                                <td class="p-4">
                                    <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-semibold">
                                        {{ optional($schedule->staff)->name ?? 'None' }}
                                    </span>
                                </td>

                                <!-- Day -->
                                <td class="p-4">
                                    <span class="px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-semibold">
                                        {{ $days[$schedule->day_of_week] ?? 'Unknown' }}
                                    </span>
                                </td>

                                <!-- Time -->
                                <td class="p-4">{{ format_time($schedule->start_time) }} - {{ format_time($schedule->end_time) }}</td>
                                <td class="p-4">{{ $schedule->task_description ?? 'General duties' }}</td>

                                <!-- Room -->
                                <td class="p-4">
                                    <span class="px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-semibold">
                                        {{ $schedule->room_no ?? 'N/A' }}
                                    </span>
                                </td>

                                <!-- Status -->
                                <td class="p-4">
                                    @if($schedule->is_active)
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                            Active
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="p-4">
                                    <div class="flex justify-center gap-2">

                                        <a href="{{ route('doctor-schedules.show', $schedule) }}"
                                           class="px-3 py-1 bg-blue-500 text-white rounded-lg text-xs hover:bg-blue-600">
                                            View
                                        </a>

                                        <a href="{{ route('doctor-schedules.edit', $schedule) }}"
                                           class="px-3 py-1 bg-yellow-500 text-white rounded-lg text-xs hover:bg-yellow-600">
                                            Edit
                                        </a>

                                        <form action="{{ route('doctor-schedules.destroy', $schedule) }}"
                                              method="POST"
                                              onsubmit="return confirm('Delete this schedule?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="px-3 py-1 bg-red-500 text-white rounded-lg text-xs hover:bg-red-600">
                                                Delete
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>
    @endif

</div>

@endsection
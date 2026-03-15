@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">

<!-- Page Header -->
<div class="mb-8 flex items-center justify-between">
    <div>
        <h2 class="text-3xl font-bold text-slate-800 mb-2">Appointments Queue</h2>
        <p class="text-slate-600">View today's appointment queue and track patient flow.</p>
    </div>

    <form action="{{ route('appointments.queue') }}" method="GET" class="flex items-center gap-3">
        <input 
            type="date" 
            name="date" 
            value="{{ $date }}"
            class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none text-sm"
        >

        <button 
            type="submit"
            class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-2 px-5 rounded-lg hover:shadow-md transition">
            🔍 Search
        </button>
    </form>
</div>


<!-- Date Info Card -->
<div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 mb-6">

    <div class="grid grid-cols-2 gap-6 text-center">

        <div>
            <p class="text-sm text-slate-500 font-semibold mb-1">📅 Date</p>
            <p class="text-lg font-bold text-slate-800">
                {{ \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d M Y (l)') }}
            </p>
        </div>

        <div>
            <p class="text-sm text-slate-500 font-semibold mb-1">📊 Total Appointments</p>
            <p class="text-lg font-bold text-slate-800">
                {{ $appointments->count() }}
            </p>
        </div>

    </div>

</div>


@if($appointments->count() > 0)

<!-- Queue Table -->
<div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden mb-8">

    <div class="overflow-x-auto">

        <table class="w-full">

            <!-- Table Header -->
            <thead>
                <tr class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-slate-200">
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Time</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Queue</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Patient</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Doctor</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Department</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Actions</th>
                </tr>
            </thead>


            <!-- Table Body -->
            <tbody class="divide-y divide-slate-200">

                @foreach($appointments as $index => $appointment)

                <tr class="hover:bg-slate-50 transition duration-150 border-b border-slate-100">

                    <!-- Time -->
                    <td class="px-6 py-4 text-sm font-semibold text-slate-800">
                        {{ $appointment->appointment_time->format('H:i') }}
                    </td>

                    <!-- Queue -->
                    <td class="px-6 py-4">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                            #{{ $index + 1 }}
                        </span>
                    </td>

                    <!-- Patient -->
                    <td class="px-6 py-4 text-sm font-semibold text-slate-800">
                        {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
                    </td>

                    <!-- Doctor -->
                    <td class="px-6 py-4 text-sm text-slate-700">
                        {{ $appointment->doctor->name }}
                    </td>

                    <!-- Status -->
                    <td class="px-6 py-4">

                        @php
                            $statusColors = [
                                'Completed' => 'bg-green-100 text-green-800',
                                'Cancelled' => 'bg-red-100 text-red-800',
                                'Confirmed' => 'bg-blue-100 text-blue-800',
                                'NoShow' => 'bg-yellow-100 text-yellow-800',
                                'Pending' => 'bg-slate-100 text-slate-800',
                            ];
                        @endphp

                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$appointment->status] ?? 'bg-slate-100 text-slate-800' }}">
                            {{ $appointment->status }}
                        </span>

                    </td>

                    <!-- Department -->
                    <td class="px-6 py-4 text-sm text-slate-700">
                        {{ $appointment->department->name }}
                    </td>

                    <!-- Actions -->
                    <td class="px-6 py-4">

                        <div class="flex items-center justify-center">

                            <a href="{{ route('appointments.show', $appointment) }}"
                               class="inline-block bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold py-1.5 px-3 rounded-md transition text-xs">
                                👁️ View
                            </a>

                        </div>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>


<!-- Status Summary -->
<div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">

    <h4 class="text-lg font-bold text-slate-800 mb-6">📊 Status Summary</h4>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-center">

        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
            <p class="text-xs font-semibold text-slate-500 mb-1">Pending</p>
            <p class="text-2xl font-bold text-slate-800">{{ $appointments->where('status','Pending')->count() }}</p>
        </div>

        <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
            <p class="text-xs font-semibold text-blue-600 mb-1">Confirmed</p>
            <p class="text-2xl font-bold text-blue-700">{{ $appointments->where('status','Confirmed')->count() }}</p>
        </div>

        <div class="bg-green-50 rounded-xl p-4 border border-green-200">
            <p class="text-xs font-semibold text-green-600 mb-1">Completed</p>
            <p class="text-2xl font-bold text-green-700">{{ $appointments->where('status','Completed')->count() }}</p>
        </div>

        <div class="bg-red-50 rounded-xl p-4 border border-red-200">
            <p class="text-xs font-semibold text-red-600 mb-1">Cancelled</p>
            <p class="text-2xl font-bold text-red-700">{{ $appointments->where('status','Cancelled')->count() }}</p>
        </div>

        <div class="bg-yellow-50 rounded-xl p-4 border border-yellow-200">
            <p class="text-xs font-semibold text-yellow-600 mb-1">No Show</p>
            <p class="text-2xl font-bold text-yellow-700">{{ $appointments->where('status','NoShow')->count() }}</p>
        </div>

    </div>

</div>

@else

<!-- Empty State -->

<div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-12 text-center">

    <div class="text-6xl mb-4">📅</div>

    <h3 class="text-xl font-semibold text-slate-800 mb-2">
        No appointments scheduled for this date
    </h3>

    <p class="text-slate-600 mb-6">
        Try selecting another date or create a new appointment.
    </p>

    <a href="{{ route('appointments.create') }}"
       class="inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:shadow-lg transition">
        ➕ Create Appointment
    </a>

</div>

@endif

</div>

@endsection

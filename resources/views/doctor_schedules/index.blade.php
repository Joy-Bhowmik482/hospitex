@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Doctor Schedules</h2>
            <p class="text-slate-600">Manage doctor working schedules and availability.</p>
        </div>
        <a href="{{ route('doctor-schedules.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
            + Add New Schedule
        </a>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
            <span class="text-xl">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- No Schedules Message -->
    @if ($schedules->isEmpty())
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-12 text-center">
            <div class="text-6xl mb-4">📅</div>
            <h3 class="text-xl font-semibold text-slate-800 mb-2">No Schedules Found</h3>
            <p class="text-slate-600 mb-6">There are no doctor schedules in the system yet. Click the button below to add a new schedule.</p>
            <a href="{{ route('doctor-schedules.create') }}" class="inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:shadow-lg transition">
                Add Your First Schedule
            </a>
        </div>
    @else
        <!-- Schedules List Table -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <!-- Table Header -->
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-slate-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Doctor</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Day</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Start Time</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">End Time</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Room</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Actions</th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($schedules as $schedule)
                            <tr class="hover:bg-slate-50 transition duration-150 border-b border-slate-100">
                                <!-- ID -->
                                <td class="px-6 py-4">
                                    <span class="text-sm font-semibold text-slate-800">#{{ str_pad($schedule->id, 3, '0', STR_PAD_LEFT) }}</span>
                                </td>

                                <!-- Doctor -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold text-xs">
                                            {{ strtoupper(substr($schedule->doctor->name ?? 'D', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-800">{{ $schedule->doctor->name }}</p>
                                            <p class="text-xs text-slate-600">{{ $schedule->doctor->specialization }}</p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Day -->
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">
                                        {{ ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][$schedule->day_of_week] }}
                                    </span>
                                </td>

                                <!-- Start Time -->
                                <td class="px-6 py-4">
                                    <p class="text-sm text-slate-700">{{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->start_time)->format('g:i A') }}</p>
                                </td>

                                <!-- End Time -->
                                <td class="px-6 py-4">
                                    <p class="text-sm text-slate-700">{{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->end_time)->format('g:i A') }}</p>
                                </td>

                                <!-- Room -->
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800">
                                        {{ $schedule->room_no ?? 'N/A' }}
                                    </span>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $schedule->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $schedule->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('doctor-schedules.show', $schedule) }}" class="bg-blue-500 text-white px-3 py-1 rounded-lg text-xs font-semibold hover:bg-blue-600 transition">
                                            View
                                        </a>
                                        <a href="{{ route('doctor-schedules.edit', $schedule) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg text-xs font-semibold hover:bg-yellow-600 transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('doctor-schedules.destroy', $schedule) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this schedule?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-lg text-xs font-semibold hover:bg-red-600 transition">
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
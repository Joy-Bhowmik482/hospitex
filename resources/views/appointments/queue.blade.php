@extends('includePage')

@section('content')
<div class="w-full">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-600 to-purple-800 px-8 py-6 flex justify-between items-center">
            <h3 class="text-2xl font-bold text-white">Appointments Queue</h3>
            <form action="{{ route('appointments.queue') }}" method="GET" class="flex gap-2">
                <input type="date" name="date" class="px-4 py-2 rounded-lg border-2 border-gray-300 focus:border-purple-500" value="{{ $date }}">
                <button type="submit" class="bg-white hover:bg-gray-100 text-purple-700 font-semibold py-2 px-4 rounded-lg transition">
                    🔍 Search
                </button>
            </form>
        </div>

        <!-- Content -->
        <div class="p-8">
            <!-- Date Info -->
            <div class="bg-purple-50 border-2 border-purple-200 rounded-lg p-4 mb-6">
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div>
                        <p class="text-sm text-purple-600 font-semibold">📅 Date</p>
                        <p class="text-lg font-bold text-purple-800">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d M Y (l)') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-purple-600 font-semibold">📊 Total Appointments</p>
                        <p class="text-lg font-bold text-purple-800">{{ $appointments->count() }}</p>
                    </div>
                </div>
            </div>

            @if($appointments->count() > 0)
                <!-- Queue Table -->
                <div class="overflow-x-auto mb-8">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-100 border-b-2 border-gray-300">
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 w-12">⏰</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 w-16">🎫 Queue</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">👤 Patient</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">👨‍⚕️ Doctor</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">📋 Status</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">🏥 Department</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($appointments as $index => $appointment)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 font-bold text-gray-900">{{ $appointment->appointment_time->format('H:i') }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-bold">
                                            #{{ $index + 1 }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-700 font-semibold">
                                        {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-700">
                                        {{ $appointment->doctor->name }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $statusColors = [
                                                'Completed' => 'bg-green-100 text-green-800',
                                                'Cancelled' => 'bg-red-100 text-red-800',
                                                'Confirmed' => 'bg-blue-100 text-blue-800',
                                                'NoShow' => 'bg-yellow-100 text-yellow-800',
                                                'Pending' => 'bg-gray-100 text-gray-800',
                                            ];
                                        @endphp
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$appointment->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $appointment->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-700">
                                        {{ $appointment->department->name }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <a href="{{ route('appointments.show', $appointment) }}" class="inline-flex items-center justify-center w-9 h-9 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition" title="View Details">
                                            👁️
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Status Summary -->
                <div class="bg-gray-50 border-2 border-gray-200 rounded-lg p-6">
                    <h5 class="text-lg font-bold text-gray-800 mb-4">📊 Status Summary</h5>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-center">
                        <div class="bg-white rounded-lg p-4 border-2 border-gray-100">
                            <p class="text-xs font-semibold text-gray-600 mb-1">Pending</p>
                            <p class="text-2xl font-bold text-gray-700">{{ $appointments->where('status', 'Pending')->count() }}</p>
                        </div>
                        <div class="bg-white rounded-lg p-4 border-2 border-blue-100">
                            <p class="text-xs font-semibold text-blue-600 mb-1">Confirmed</p>
                            <p class="text-2xl font-bold text-blue-700">{{ $appointments->where('status', 'Confirmed')->count() }}</p>
                        </div>
                        <div class="bg-white rounded-lg p-4 border-2 border-green-100">
                            <p class="text-xs font-semibold text-green-600 mb-1">Completed</p>
                            <p class="text-2xl font-bold text-green-700">{{ $appointments->where('status', 'Completed')->count() }}</p>
                        </div>
                        <div class="bg-white rounded-lg p-4 border-2 border-red-100">
                            <p class="text-xs font-semibold text-red-600 mb-1">Cancelled</p>
                            <p class="text-2xl font-bold text-red-700">{{ $appointments->where('status', 'Cancelled')->count() }}</p>
                        </div>
                        <div class="bg-white rounded-lg p-4 border-2 border-yellow-100">
                            <p class="text-xs font-semibold text-yellow-600 mb-1">No Show</p>
                            <p class="text-2xl font-bold text-yellow-700">{{ $appointments->where('status', 'NoShow')->count() }}</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-blue-50 border-2 border-blue-200 rounded-lg py-12 text-center">
                    <p class="text-gray-700 font-semibold mb-4 text-lg">📅 No appointments scheduled for this date</p>
                    <a href="{{ route('appointments.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                        ➕ Create an appointment
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

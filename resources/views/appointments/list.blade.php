@extends('includePage')

@section('content')
<div class="w-full">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-8 py-6 flex justify-between items-center">
            <h3 class="text-2xl font-bold text-white">Appointments List</h3>
            <div class="flex gap-3">
                <a href="{{ route('appointments.queue') }}" class="bg-white hover:bg-gray-100 text-blue-700 font-semibold py-2 px-4 rounded-lg transition">
                    📊 View Queue
                </a>
                <a href="{{ route('appointments.create') }}" class="bg-white hover:bg-gray-100 text-blue-700 font-semibold py-2 px-4 rounded-lg transition">
                    ➕ New Appointment
                </a>
            </div>
        </div>

        <!-- Content -->
        <div class="p-8">
            @if($appointments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-100 border-b-2 border-gray-300">
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Appointment No</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Patient Name</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Doctor</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Department</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Date & Time</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($appointments as $appointment)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-bold text-gray-900">
                                        {{ $appointment->appointment_no }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">
                                        {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">
                                        {{ $appointment->doctor->name }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">
                                        {{ $appointment->department->name }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 text-sm">
                                        <div>{{ $appointment->appointment_date->format('d M Y') }}</div>
                                        <div class="text-gray-500">{{ $appointment->appointment_time->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
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
                                    <td class="px-6 py-4 text-center space-x-2 flex">
                                        <a href="{{ route('appointments.show', $appointment) }}" class="inline-flex items-center justify-center w-9 h-9 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition" title="View">
                                            👁️
                                        </a>
                                        <a href="{{ route('appointments.edit', $appointment) }}" class="inline-flex items-center justify-center w-9 h-9 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-lg transition" title="Edit">
                                            ✏️
                                        </a>
                                        <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center w-9 h-9 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition" title="Delete">
                                                🗑️
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-8 flex justify-center">
                    {{ $appointments->links() }}
                </div>
            @else
                <div class="bg-blue-50 border-2 border-blue-200 rounded-lg py-12 text-center">
                    <p class="text-gray-700 font-semibold mb-4">No appointments found</p>
                    <a href="{{ route('appointments.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                        Create one now
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

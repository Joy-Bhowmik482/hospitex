@extends('includePage')

@section('content')
<div class="w-full max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-8 py-6 flex justify-between items-center">
            <h3 class="text-2xl font-bold text-white">Appointment Details</h3>
            <div class="flex gap-3">
                <a href="{{ route('appointments.edit', $appointment) }}" class="bg-white hover:bg-gray-100 text-blue-700 font-semibold py-2 px-4 rounded-lg transition">
                    ✏️ Edit
                </a>
                <a href="{{ route('appointments.index') }}" class="bg-white hover:bg-gray-100 text-blue-700 font-semibold py-2 px-4 rounded-lg transition">
                    ← Back
                </a>
            </div>
        </div>

        <!-- Content -->
        <div class="p-8">
            @if(session('success'))
                <div class="bg-green-100 border-2 border-green-300 rounded-lg p-4 mb-6 flex justify-between items-center">
                    <p class="text-green-700 font-semibold">✓ {{ session('success') }}</p>
                    <button onclick="this.parentElement.style.display='none'" class="text-green-700 font-bold">✕</button>
                </div>
            @endif

            <!-- Appointment Details Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <!-- Left Column -->
                <div class="space-y-6">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 mb-1">Appointment Number</p>
                        <p class="text-lg font-bold text-gray-900">{{ $appointment->appointment_no }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-600 mb-1">Patient</p>
                        <a href="{{ route('patients.show', $appointment->patient) }}" class="text-lg font-bold text-blue-600 hover:underline">
                            {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
                        </a>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-600 mb-1">Patient ID</p>
                        <p class="text-lg font-bold text-gray-900">#{{ $appointment->patient->id }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-600 mb-1">Doctor</p>
                        <a href="{{ route('doctors.show', $appointment->doctor) }}" class="text-lg font-bold text-blue-600 hover:underline">
                            {{ $appointment->doctor->name }}
                        </a>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-600 mb-1">Doctor Specialization</p>
                        <p class="text-lg font-bold text-gray-900">{{ $appointment->doctor->specialization }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-600 mb-1">Department</p>
                        <p class="text-lg font-bold text-gray-900">{{ $appointment->department->name }}</p>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 mb-1">Appointment Date</p>
                        <p class="text-lg font-bold text-gray-900">{{ $appointment->appointment_date->format('d M Y (l)') }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-600 mb-1">Appointment Time</p>
                        <p class="text-lg font-bold text-gray-900">{{ $appointment->appointment_time->format('H:i') }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-600 mb-1">Status</p>
                        @php
                            $statusColors = [
                                'Completed' => 'bg-green-100 text-green-800',
                                'Cancelled' => 'bg-red-100 text-red-800',
                                'Confirmed' => 'bg-blue-100 text-blue-800',
                                'NoShow' => 'bg-yellow-100 text-yellow-800',
                                'Pending' => 'bg-gray-100 text-gray-800',
                            ];
                        @endphp
                        <span class="inline-block px-4 py-2 rounded-full text-sm font-bold {{ $statusColors[$appointment->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $appointment->status }}
                        </span>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-600 mb-1">Token Number</p>
                        <p class="text-lg font-bold text-gray-900">{{ $appointment->token_no ?? '—' }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-600 mb-1">Created By</p>
                        <p class="text-lg font-bold text-gray-900">{{ $appointment->createdBy->name ?? 'System' }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-600 mb-1">Created Date</p>
                        <p class="text-lg font-bold text-gray-900">{{ $appointment->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>

            @if($appointment->notes)
                <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-6 mb-8">
                    <p class="text-sm font-semibold text-gray-600 mb-2">Notes</p>
                    <p class="text-gray-700">{{ $appointment->notes }}</p>
                </div>
            @endif

            <!-- Divider -->
            <div class="border-t-2 border-gray-200 my-8"></div>

            <!-- Action Buttons -->
            <div class="space-y-4">
                <div class="flex gap-3">
                    <a href="{{ route('appointments.edit', $appointment) }}" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 px-6 rounded-lg transition text-center">
                        ✏️ Edit Appointment
                    </a>
                </div>

                <div class="flex gap-3">
                    <form action="{{ route('appointments.changeStatus', $appointment) }}" method="POST" class="flex-1 flex gap-2">
                        @csrf
                        <select name="status" class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 font-semibold" required>
                            <option value="">📊 Change Status to...</option>
                            <option value="Pending" {{ $appointment->status === 'Pending' ? 'disabled' : '' }}>Pending</option>
                            <option value="Confirmed" {{ $appointment->status === 'Confirmed' ? 'disabled' : '' }}>Confirmed</option>
                            <option value="Completed" {{ $appointment->status === 'Completed' ? 'disabled' : '' }}>Completed</option>
                            <option value="Cancelled" {{ $appointment->status === 'Cancelled' ? 'disabled' : '' }}>Cancelled</option>
                            <option value="NoShow" {{ $appointment->status === 'NoShow' ? 'disabled' : '' }}>No Show</option>
                        </select>
                        <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition" type="submit">
                            ✓ Update
                        </button>
                    </form>
                </div>

                <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this appointment?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-lg transition">
                        🗑️ Delete Appointment
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

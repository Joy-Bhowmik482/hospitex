@extends('includePage')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Appointments List</h2>
            <p class="text-slate-600">View and manage patient appointments.</p>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('appointments.queue') }}"
               class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                📊 View Queue
            </a>

            <a href="{{ route('appointments.create') }}"
               class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                ➕ New Appointment
            </a>
        </div>
    </div>

    @if($appointments->count() > 0)
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-slate-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Appointment No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Patient</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Doctor</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Department</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Date & Time</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200">
                        @foreach($appointments as $appointment)
                            @php
                                $statusColors = [
                                    'Completed' => 'bg-green-100 text-green-800',
                                    'Cancelled' => 'bg-red-100 text-red-800',
                                    'Confirmed' => 'bg-blue-100 text-blue-800',
                                    'NoShow' => 'bg-yellow-100 text-yellow-800',
                                    'Pending' => 'bg-slate-100 text-slate-800',
                                ];

                                $currentStatus = $appointment->status;
                            @endphp

                            <tr class="hover:bg-slate-50 transition duration-150 border-b border-slate-100">
                                <td class="px-6 py-4">
                                    <span class="text-sm font-semibold text-slate-800">
                                        {{ $appointment->appointment_no }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold text-sm">
                                            {{ substr($appointment->patient?->first_name ?? '', 0, 1) }}{{ substr($appointment->patient?->last_name ?? '', 0, 1) }}
                                        </div>

                                        <div>
                                            <p class="text-sm font-semibold text-slate-800">
                                                {{ $appointment->patient?->first_name ?? 'N/A' }}
                                                {{ $appointment->patient?->last_name ?? '' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-700">
                                    {{ $appointment->doctor?->name ?? 'N/A' }}
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-700">
                                    {{ $appointment->department?->name ?? 'N/A' }}
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-700">
                                    <div>
                                        {{ $appointment->appointment_date?->format('d M Y') ?? $appointment->appointment_date }}
                                    </div>
                                    <div class="text-slate-500 text-xs">
                                        {{ $appointment->appointment_time?->format('H:i') ?? $appointment->appointment_time }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center">
                                   <form action="{{ route('appointments.changeStatus', $appointment) }}"
                                          method="POST"
                                          class="inline-block">
                                        @csrf
                                        

                                        <select name="status"
                                                class="text-xs font-semibold rounded-full px-3 py-1 border-0 {{ $statusColors[$currentStatus] ?? 'bg-slate-100 text-slate-800' }}"
                                                onchange="this.form.submit()">
                                            <option value="Pending" {{ $currentStatus === 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Confirmed" {{ $currentStatus === 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                                            <option value="Completed" {{ $currentStatus === 'Completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="Cancelled" {{ $currentStatus === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            <option value="NoShow" {{ $currentStatus === 'NoShow' ? 'selected' : '' }}>NoShow</option>
                                        </select>
                                    </form>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('appointments.show', $appointment) }}"
                                           class="inline-block bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold py-1.5 px-3 rounded-md transition text-xs">
                                            👁️ View
                                        </a>

                                        <a href="{{ route('appointments.edit', $appointment) }}"
                                           class="inline-block bg-amber-50 hover:bg-amber-100 text-amber-700 font-semibold py-1.5 px-3 rounded-md transition text-xs">
                                            ✏️ Edit
                                        </a>

                                        <form action="{{ route('appointments.destroy', $appointment) }}"
                                              method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('Are you sure you want to delete this appointment?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="bg-red-50 hover:bg-red-100 text-red-700 font-semibold py-1.5 px-3 rounded-md transition text-xs">
                                                🗑️ Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-slate-50 border-t border-slate-200 px-6 py-4 flex items-center justify-between">
                <p class="text-sm text-slate-600">
                    Showing
                    <span class="font-semibold text-slate-800">{{ $appointments->count() }}</span> appointments
                </p>

                {{ $appointments->links() }}
            </div>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-12 text-center">
            <div class="text-6xl mb-4">📅</div>

            <h3 class="text-xl font-semibold text-slate-800 mb-2">
                No Appointments Found
            </h3>

            <p class="text-slate-600 mb-6">
                There are no appointments scheduled yet.
            </p>

            <a href="{{ route('appointments.create') }}"
               class="inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:shadow-lg transition">
                Create Appointment
            </a>
        </div>
    @endif
</div>
@endsection

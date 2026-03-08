@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800 mb-2">Doctor Details</h2>
        <p class="text-slate-600">View detailed information about this doctor.</p>
    </div>

    <!-- Card Container -->
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-8">

        <!-- Doctor Information -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-slate-800 mb-6">Doctor Information</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="bg-slate-50 rounded-lg p-4">
                    <div class="text-sm font-semibold text-slate-600 mb-1">Doctor Name</div>
                    <div class="text-lg font-medium text-slate-800">{{ $doctor->name }}</div>
                </div>

                <!-- Department -->
                <div class="bg-slate-50 rounded-lg p-4">
                    <div class="text-sm font-semibold text-slate-600 mb-1">Department</div>
                    <div class="text-lg font-medium text-slate-800">{{ $doctor->department->name ?? 'N/A' }}</div>
                </div>

                <!-- Registration Number -->
                <div class="bg-slate-50 rounded-lg p-4">
                    <div class="text-sm font-semibold text-slate-600 mb-1">Registration Number</div>
                    <div class="text-lg font-medium text-slate-800">{{ $doctor->reg_no }}</div>
                </div>

                <!-- Specialization -->
                <div class="bg-slate-50 rounded-lg p-4">
                    <div class="text-sm font-semibold text-slate-600 mb-1">Specialization</div>
                    <div class="text-lg font-medium text-slate-800">{{ $doctor->specialization }}</div>
                </div>

                <!-- Fee -->
                <div class="bg-slate-50 rounded-lg p-4">
                    <div class="text-sm font-semibold text-slate-600 mb-1">Consultation Fee</div>
                    <div class="text-lg font-medium text-slate-800">${{ number_format($doctor->fee, 2) }}</div>
                </div>

                <!-- Status -->
                <div class="bg-slate-50 rounded-lg p-4">
                    <div class="text-sm font-semibold text-slate-600 mb-1">Status</div>
                    <div class="text-lg font-medium">
                        @if($doctor->is_active)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                Inactive
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Created At -->
                <div class="bg-slate-50 rounded-lg p-4">
                    <div class="text-sm font-semibold text-slate-600 mb-1">Created At</div>
                    <div class="text-lg font-medium text-slate-800">{{ $doctor->created_at->format('M d, Y H:i') }}</div>
                </div>
            </div>
        </div>

        <!-- Doctor Schedules -->
        @if($doctor->schedules->count() > 0)
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-slate-800 mb-6">Doctor Schedules</h3>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-slate-200 rounded-lg">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Day</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Start Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">End Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @foreach($doctor->schedules as $schedule)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">{{ $schedule->day }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $schedule->start_time }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $schedule->end_time }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($schedule->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex items-center justify-between pt-6 border-t border-slate-200">
            <a href="{{ route('doctors.index') }}" class="bg-slate-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-slate-600 transition">
                Back to Doctors
            </a>
            <div class="space-x-3">
                <a href="{{ route('doctors.edit', $doctor) }}" class="bg-blue-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-blue-600 transition">
                    Edit Doctor
                </a>
                <form action="{{ route('doctors.destroy', $doctor) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this doctor?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-red-600 transition">
                        Delete Doctor
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
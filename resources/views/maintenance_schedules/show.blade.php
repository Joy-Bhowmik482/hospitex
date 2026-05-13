@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('maintenance-schedules.index') }}" class="text-slate-600 hover:text-slate-800 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h2 class="text-3xl font-bold text-slate-800">Maintenance Details</h2>
                <p class="text-slate-600">View maintenance schedule information</p>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
            <span class="text-xl">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Action Buttons -->
    <div class="mb-6 flex gap-3">
        @if($maintenanceSchedule->status !== 'completed' && $maintenanceSchedule->status !== 'cancelled')
            <form action="{{ route('maintenance-schedules.complete', $maintenanceSchedule) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-green-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Mark as Completed
                </button>
            </form>
        @endif
        <a href="{{ route('maintenance-schedules.edit', $maintenanceSchedule) }}"
           class="bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit Schedule
        </a>
        <button onclick="printMaintenanceDetails()" class="bg-slate-100 text-slate-700 font-semibold py-2 px-4 rounded-lg hover:bg-slate-200 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            Print
        </button>
    </div>

    <!-- Maintenance Details Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden mb-6">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-4 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center
                        @if($maintenanceSchedule->priority === 'critical') bg-red-100
                        @elseif($maintenanceSchedule->priority === 'high') bg-orange-100
                        @elseif($maintenanceSchedule->priority === 'medium') bg-yellow-100
                        @else bg-green-100 @endif">
                        <svg class="w-6 h-6
                            @if($maintenanceSchedule->priority === 'critical') text-red-600
                            @elseif($maintenanceSchedule->priority === 'high') text-orange-600
                            @elseif($maintenanceSchedule->priority === 'medium') text-yellow-600
                            @else text-green-600 @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">{{ $maintenanceSchedule->asset->name ?? 'Unknown Equipment' }}</h3>
                        <p class="text-sm text-slate-600">{{ $maintenanceSchedule->asset->asset_code ?? '' }} • {{ ucfirst($maintenanceSchedule->maintenance_type) }}</p>
                    </div>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($maintenanceSchedule->status === 'completed') bg-green-100 text-green-800
                    @elseif($maintenanceSchedule->status === 'in_progress') bg-blue-100 text-blue-800
                    @elseif($maintenanceSchedule->status === 'overdue') bg-red-100 text-red-800
                    @elseif($maintenanceSchedule->status === 'cancelled') bg-gray-100 text-gray-800
                    @else bg-orange-100 text-orange-800 @endif">
                    {{ ucfirst(str_replace('_', ' ', $maintenanceSchedule->status)) }}
                </span>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Basic Information -->
                <div class="space-y-4">
                    <h4 class="font-semibold text-slate-800 border-b border-slate-200 pb-2">Basic Information</h4>

                    <div>
                        <label class="text-sm font-medium text-slate-600">Priority</label>
                        <p class="text-sm text-slate-800 capitalize">{{ $maintenanceSchedule->priority }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-slate-600">Department</label>
                        <p class="text-sm text-slate-800">{{ $maintenanceSchedule->department ?? 'Not specified' }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-slate-600">Maintenance Type</label>
                        <p class="text-sm text-slate-800">{{ ucfirst($maintenanceSchedule->maintenance_type) }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-slate-600">Created By</label>
                        <p class="text-sm text-slate-800">{{ $maintenanceSchedule->creator->name ?? 'Unknown' }}</p>
                    </div>
                </div>

                <!-- Schedule Information -->
                <div class="space-y-4">
                    <h4 class="font-semibold text-slate-800 border-b border-slate-200 pb-2">Schedule</h4>

                    <div>
                        <label class="text-sm font-medium text-slate-600">Scheduled Date</label>
                        <p class="text-sm text-slate-800">{{ $maintenanceSchedule->scheduled_date->format('M d, Y \a\t H:i') }}</p>
                    </div>

                    @if($maintenanceSchedule->scheduled_end_date)
                    <div>
                        <label class="text-sm font-medium text-slate-600">End Date</label>
                        <p class="text-sm text-slate-800">{{ $maintenanceSchedule->scheduled_end_date->format('M d, Y \a\t H:i') }}</p>
                    </div>
                    @endif

                    @if($maintenanceSchedule->completed_date)
                    <div>
                        <label class="text-sm font-medium text-slate-600">Completed Date</label>
                        <p class="text-sm text-slate-800">{{ $maintenanceSchedule->completed_date->format('M d, Y \a\t H:i') }}</p>
                    </div>
                    @endif

                    <div>
                        <label class="text-sm font-medium text-slate-600">Created</label>
                        <p class="text-sm text-slate-800">{{ $maintenanceSchedule->created_at->format('M d, Y \a\t H:i') }}</p>
                    </div>
                </div>

                <!-- Technician & Cost Information -->
                <div class="space-y-4">
                    <h4 class="font-semibold text-slate-800 border-b border-slate-200 pb-2">Technician & Cost</h4>

                    @if($maintenanceSchedule->technician_name)
                    <div>
                        <label class="text-sm font-medium text-slate-600">Technician</label>
                        <p class="text-sm text-slate-800">{{ $maintenanceSchedule->technician_name }}</p>
                        @if($maintenanceSchedule->technician_contact)
                        <p class="text-xs text-slate-500">{{ $maintenanceSchedule->technician_contact }}</p>
                        @endif
                    </div>
                    @endif

                    @if($maintenanceSchedule->estimated_cost)
                    <div>
                        <label class="text-sm font-medium text-slate-600">Estimated Cost</label>
                        <p class="text-sm text-slate-800">${{ number_format($maintenanceSchedule->estimated_cost, 2) }}</p>
                    </div>
                    @endif

                    @if($maintenanceSchedule->actual_cost)
                    <div>
                        <label class="text-sm font-medium text-slate-600">Actual Cost</label>
                        <p class="text-sm text-slate-800">${{ number_format($maintenanceSchedule->actual_cost, 2) }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Description -->
            @if($maintenanceSchedule->description)
            <div class="mt-6">
                <h4 class="font-semibold text-slate-800 border-b border-slate-200 pb-2 mb-3">Description</h4>
                <p class="text-sm text-slate-700 bg-slate-50 p-3 rounded-lg">{{ $maintenanceSchedule->description }}</p>
            </div>
            @endif

            <!-- Work Performed -->
            @if($maintenanceSchedule->work_performed)
            <div class="mt-6">
                <h4 class="font-semibold text-slate-800 border-b border-slate-200 pb-2 mb-3">Work Performed</h4>
                <p class="text-sm text-slate-700 bg-slate-50 p-3 rounded-lg">{{ $maintenanceSchedule->work_performed }}</p>
            </div>
            @endif

            <!-- Parts Used -->
            @if($maintenanceSchedule->parts_used)
            <div class="mt-6">
                <h4 class="font-semibold text-slate-800 border-b border-slate-200 pb-2 mb-3">Parts Used</h4>
                <p class="text-sm text-slate-700 bg-slate-50 p-3 rounded-lg">{{ $maintenanceSchedule->parts_used }}</p>
            </div>
            @endif

            <!-- Notes -->
            @if($maintenanceSchedule->notes)
            <div class="mt-6">
                <h4 class="font-semibold text-slate-800 border-b border-slate-200 pb-2 mb-3">Notes</h4>
                <p class="text-sm text-slate-700 bg-slate-50 p-3 rounded-lg">{{ $maintenanceSchedule->notes }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Asset Information -->
    @if($maintenanceSchedule->asset)
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
        <h4 class="font-semibold text-slate-800 mb-4">Asset Information</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-medium text-slate-600">Asset Name</label>
                <p class="text-sm text-slate-800">{{ $maintenanceSchedule->asset->name }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-slate-600">Asset Code</label>
                <p class="text-sm text-slate-800">{{ $maintenanceSchedule->asset->asset_code }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-slate-600">Category</label>
                <p class="text-sm text-slate-800">{{ $maintenanceSchedule->asset->category ?? 'Not specified' }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-slate-600">Status</label>
                <p class="text-sm text-slate-800">{{ $maintenanceSchedule->asset->status }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-slate-600">Location</label>
                <p class="text-sm text-slate-800">{{ $maintenanceSchedule->asset->location ?? 'Not specified' }}</p>
            </div>
            @if($maintenanceSchedule->asset->cost)
            <div>
                <label class="text-sm font-medium text-slate-600">Purchase Cost</label>
                <p class="text-sm text-slate-800">${{ number_format($maintenanceSchedule->asset->cost, 2) }}</p>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>

<script>
function printMaintenanceDetails() {
    window.print();
}
</script>

@endsection
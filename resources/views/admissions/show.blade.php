@extends('includePage')

@section('content')

<div class="max-w-6xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">{{ $admission->admission_no }}</h2>
            <p class="text-slate-600">Admission Details</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admissions.edit', $admission) }}" class="bg-amber-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-amber-600 transition">
                Edit Admission
            </a>
            <a href="{{ route('admissions.index') }}" class="bg-slate-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-slate-600 transition">
                Back to List
            </a>
        </div>
    </div>

    <!-- Admission Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Patient Info -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">Patient Information</h3>
            
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-slate-600">Patient Name</p>
                    <p class="font-semibold text-slate-800">{{ $admission->patient->first_name ?? 'N/A' }} {{ $admission->patient->last_name ?? '' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Email</p>
                    <p class="font-semibold text-slate-800">{{ $admission->patient->email ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Phone</p>
                    <p class="font-semibold text-slate-800">{{ $admission->patient->phone ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Blood Type</p>
                    <p class="font-semibold text-slate-800">{{ $admission->patient->blood_type ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Medical Info -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">Medical Information</h3>
            
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-slate-600">Doctor</p>
                    <p class="font-semibold text-slate-800">{{ $admission->doctor->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Department</p>
                    <p class="font-semibold text-slate-800">{{ $admission->department->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Status</p>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold 
                        {{ $admission->status === 'Admitted' ? 'bg-green-100 text-green-800' : ($admission->status === 'Discharged' ? 'bg-slate-100 text-slate-800' : 'bg-red-100 text-red-800') }}">
                        {{ $admission->status }}
                    </span>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Created By</p>
                    <p class="font-semibold text-slate-800">{{ $admission->createdBy->name ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Admission Timeline -->
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 mb-8">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">Admission Timeline</h3>
        
        <div class="space-y-4">
            <div class="flex items-center gap-4">
                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                <div class="flex-1">
                    <p class="text-sm text-slate-600">Admitted At</p>
                    <p class="font-semibold text-slate-800">{{ $admission->admitted_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
            
            @if ($admission->discharge_at)
                <div class="flex items-center gap-4">
                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                    <div class="flex-1">
                        <p class="text-sm text-slate-600">Discharged At</p>
                        <p class="font-semibold text-slate-800">{{ $admission->discharge_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Diagnosis & Remarks -->
    @if ($admission->diagnosis || $admission->remarks)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            @if ($admission->diagnosis)
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Diagnosis</h3>
                    <p class="text-slate-700">{{ $admission->diagnosis }}</p>
                </div>
            @endif

            @if ($admission->remarks)
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Remarks</h3>
                    <p class="text-slate-700">{{ $admission->remarks }}</p>
                </div>
            @endif
        </div>
    @endif

    <!-- Bed Allocations -->
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-6">Bed Allocations</h3>

        @if ($admission->bedAllocations->count() > 0)
            <div class="space-y-4">
                @foreach ($admission->bedAllocations as $allocation)
                    <div class="border border-slate-200 rounded-lg p-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-slate-600">Bed</p>
                            <p class="font-semibold text-slate-800">{{ $allocation->bed->bed_no }} (Room {{ $allocation->bed->room->room_no }}, {{ $allocation->bed->room->ward->name }})</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-600">Allocated Period</p>
                            <p class="text-sm text-slate-800">{{ $allocation->allocated_at->format('M d, Y H:i') }}</p>
                            @if ($allocation->released_at)
                                <p class="text-xs text-slate-600">to {{ $allocation->released_at->format('M d, Y H:i') }}</p>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm text-slate-600">Status</p>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $allocation->allocation_status === 'Active' ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-800' }}">
                                {{ $allocation->allocation_status }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-slate-600">No beds allocated for this admission yet</p>
            </div>
        @endif
    </div>
</div>

@endsection

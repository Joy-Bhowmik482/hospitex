@extends('includePage')

@section('content')

<div class="max-w-6xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Bed Allocation Details</h2>
            <p class="text-slate-600">Admission {{ $bedAllocation->admission->admission_no ?? 'N/A' }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('bed-allocations.edit', $bedAllocation) }}" class="bg-amber-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-amber-600 transition">
                Edit Allocation
            </a>
            <a href="{{ route('bed-allocations.index') }}" class="bg-slate-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-slate-600 transition">
                Back to List
            </a>
        </div>
    </div>

    <!-- Allocation Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Patient & Admission Info -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">Patient & Admission</h3>
            
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-slate-600">Admission Number</p>
                    <p class="font-semibold text-slate-800">{{ $bedAllocation->admission->admission_no ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Patient Name</p>
                    <p class="font-semibold text-slate-800">
                        {{ $bedAllocation->admission->patient->first_name ?? 'N/A' }} {{ $bedAllocation->admission->patient->last_name ?? '' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Doctor</p>
                    <p class="font-semibold text-slate-800">{{ $bedAllocation->admission->doctor->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Department</p>
                    <p class="font-semibold text-slate-800">{{ $bedAllocation->admission->department->name ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Bed & Room Info -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">Bed & Room Information</h3>
            
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-slate-600">Bed Number</p>
                    <p class="font-semibold text-slate-800">{{ $bedAllocation->bed->bed_no }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Room Number</p>
                    <p class="font-semibold text-slate-800">{{ $bedAllocation->bed->room->room_no }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Ward</p>
                    <p class="font-semibold text-slate-800">{{ $bedAllocation->bed->room->ward->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Daily Rate</p>
                    <p class="font-semibold text-slate-800">${{ number_format($bedAllocation->bed->room->daily_rate, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Allocation Timeline -->
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 mb-8">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">Allocation Timeline</h3>
        
        <div class="space-y-4">
            <div class="flex items-center gap-4">
                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                <div class="flex-1">
                    <p class="text-sm text-slate-600">Allocated At</p>
                    <p class="font-semibold text-slate-800">{{ $bedAllocation->allocated_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
            
            @if ($bedAllocation->released_at)
                <div class="flex items-center gap-4">
                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                    <div class="flex-1">
                        <p class="text-sm text-slate-600">Released At</p>
                        <p class="font-semibold text-slate-800">{{ $bedAllocation->released_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Allocation Status & Notes -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">Allocation Status</h3>
            
            <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold {{ $bedAllocation->allocation_status === 'Active' ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-800' }}">
                {{ $bedAllocation->allocation_status }}
            </span>
        </div>

        @if ($bedAllocation->notes)
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Notes</h3>
                <p class="text-slate-700">{{ $bedAllocation->notes }}</p>
            </div>
        @endif
    </div>
</div>

@endsection

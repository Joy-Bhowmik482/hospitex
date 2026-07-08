@extends('includePage')

@section('content')
@php
    use Carbon\Carbon;

    $patient = $admission->patient;
    $doctor = $admission->doctor;
    $department = $admission->department;
    $createdBy = $admission->createdBy;
    $bedAllocations = $admission->bedAllocations ?? collect();

    $status = strtolower(trim((string) $admission->status));
    $statusClass = match ($status) {
        'admitted' => 'bg-green-100 text-green-800',
        'discharged' => 'bg-slate-100 text-slate-800',
        'pending' => 'bg-amber-100 text-amber-800',
        default => 'bg-red-100 text-red-800',
    };

    $admittedAt = $admission->admitted_at ? Carbon::parse($admission->admitted_at)->format('M d, Y H:i') : 'N/A';
    $dischargeAt = $admission->discharge_at ? Carbon::parse($admission->discharge_at)->format('M d, Y H:i') : null;
@endphp

<div class="min-h-screen bg-slate-50 py-8">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-slate-800">
                    Admission #{{ $admission->admission_no }}
                </h2>
                <p class="mt-1 text-sm text-slate-500">Admission details and patient information</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admissions.edit', $admission) }}"
                   class="inline-flex items-center rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-400">
                    Edit Admission
                </a>
                <a href="{{ route('admissions.index') }}"
                   class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-300">
                    Back to List
                </a>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Patient Information -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-semibold text-slate-800">Patient Information</h3>

                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-slate-500">Patient Name</p>
                        <p class="font-medium text-slate-800">
                            {{ trim(($patient->first_name ?? '') . ' ' . ($patient->last_name ?? '')) ?: 'N/A' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Email</p>
                        <p class="font-medium text-slate-800">{{ $patient->email ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Phone</p>
                        <p class="font-medium text-slate-800">{{ $patient->phone ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Blood Type</p>
                        <p class="font-medium text-slate-800">{{ $patient->blood_type ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Medical Information -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-semibold text-slate-800">Medical Information</h3>

                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-slate-500">Doctor</p>
                        <p class="font-medium text-slate-800">{{ $doctor->name ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Department</p>
                        <p class="font-medium text-slate-800">{{ $department->name ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Status</p>
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                            {{ $admission->status ?? 'N/A' }}
                        </span>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Created By</p>
                        <p class="font-medium text-slate-800">{{ $createdBy->name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admission Timeline -->
        <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-lg font-semibold text-slate-800">Admission Timeline</h3>

            <div class="space-y-4">
                <div class="flex items-start gap-3">
                    <div class="mt-2 h-2.5 w-2.5 rounded-full bg-green-500"></div>
                    <div>
                        <p class="text-sm text-slate-500">Admitted At</p>
                        <p class="font-medium text-slate-800">{{ $admittedAt }}</p>
                    </div>
                </div>

                @if ($dischargeAt)
                    <div class="flex items-start gap-3">
                        <div class="mt-2 h-2.5 w-2.5 rounded-full bg-red-500"></div>
                        <div>
                            <p class="text-sm text-slate-500">Discharged At</p>
                            <p class="font-medium text-slate-800">{{ $dischargeAt }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Diagnosis & Remarks -->
        @if ($admission->diagnosis || $admission->remarks)
            <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                @if ($admission->diagnosis)
                    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="mb-3 text-lg font-semibold text-slate-800">Diagnosis</h3>
                        <p class="leading-relaxed text-slate-700">{{ $admission->diagnosis }}</p>
                    </div>
                @endif

                @if ($admission->remarks)
                    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="mb-3 text-lg font-semibold text-slate-800">Remarks</h3>
                        <p class="leading-relaxed text-slate-700">{{ $admission->remarks }}</p>
                    </div>
                @endif
            </div>
        @endif

        <!-- Bed Allocations -->
        <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-lg font-semibold text-slate-800">Bed Allocations</h3>

            @if ($bedAllocations->count() > 0)
                <div class="space-y-4">
                    @foreach ($bedAllocations as $allocation)
                        @php
                            $bed = $allocation->bed;
                            $room = $bed->room ?? null;
                            $ward = $room->ward ?? null;
                            $allocatedAt = $allocation->allocated_at ? Carbon::parse($allocation->allocated_at)->format('M d, Y H:i') : 'N/A';
                            $releasedAt = $allocation->released_at ? Carbon::parse($allocation->released_at)->format('M d, Y H:i') : null;
                            $allocationStatus = strtolower(trim((string) $allocation->allocation_status));
                            $allocationClass = $allocationStatus === 'active'
                                ? 'bg-green-100 text-green-800'
                                : 'bg-slate-100 text-slate-800';
                        @endphp

                        <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <div>
                                    <p class="text-sm text-slate-500">Bed</p>
                                    <p class="font-medium text-slate-800">
                                        {{ $bed->bed_no ?? 'N/A' }}
                                        @if ($room)
                                            (Room {{ $room->room_no ?? 'N/A' }},
                                            {{ $ward->name ?? 'N/A' }})
                                        @endif
                                    </p>
                                </div>

                                <div>
                                    <p class="text-sm text-slate-500">Allocated Period</p>
                                    <p class="font-medium text-slate-800">{{ $allocatedAt }}</p>
                                    @if ($releasedAt)
                                        <p class="text-xs text-slate-500">to {{ $releasedAt }}</p>
                                    @endif
                                </div>

                                <div>
                                    <p class="text-sm text-slate-500">Status</p>
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $allocationClass }}">
                                        {{ $allocation->allocation_status ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-8 text-center">
                    <p class="text-sm text-slate-500">No beds allocated for this admission yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

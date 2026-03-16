@extends('includePage')

@section('content')

<div class="max-w-6xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Bed {{ $bed->bed_no }}</h2>
            <p class="text-slate-600">{{ $bed->room->room_no }} - {{ $bed->room->ward->name }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('beds.edit', $bed) }}" class="bg-amber-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-amber-600 transition">
                Edit Bed
            </a>
            <a href="{{ route('beds.index') }}" class="bg-slate-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-slate-600 transition">
                Back to List
            </a>
        </div>
    </div>

    <!-- Bed Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Bed Info -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">Bed Information</h3>
            
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-slate-600">Bed Number</p>
                    <p class="font-semibold text-slate-800 text-lg">{{ $bed->bed_no }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Status</p>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold 
                        {{ $bed->status === 'Available' ? 'bg-green-100 text-green-800' : ($bed->status === 'Occupied' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800') }}">
                        {{ $bed->status }}
                    </span>
                </div>
                <div class="pt-2 border-t border-slate-200">
                    <p class="text-xs text-slate-600">Created: {{ $bed->created_at->format('M d, Y H:i') }}</p>
                    <p class="text-xs text-slate-600">Updated: {{ $bed->updated_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Room Info -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">Room & Ward Information</h3>
            
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-slate-600">Room Number</p>
                    <p class="font-semibold text-slate-800">{{ $bed->room->room_no }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Room Type</p>
                    <p class="font-semibold text-slate-800">{{ $bed->room->room_type }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Ward</p>
                    <p class="font-semibold text-slate-800">{{ $bed->room->ward->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Daily Rate</p>
                    <p class="font-semibold text-slate-800">${{ number_format($bed->room->daily_rate, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Allocation History -->
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-6">Allocation History</h3>

        @if ($bed->allocations->count() > 0)
            <div class="space-y-4">
                @foreach ($bed->allocations->sortByDesc('allocated_at') as $allocation)
                    <div class="border border-slate-200 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Patient Info -->
                            <div>
                                <p class="text-sm text-slate-600">Patient</p>
                                <p class="font-semibold text-slate-800">
                                    @if ($allocation->admission && $allocation->admission->patient)
                                        {{ $allocation->admission->patient->first_name }} {{ $allocation->admission->patient->last_name }}
                                    @else
                                        N/A
                                    @endif
                                </p>
                                <p class="text-xs text-slate-500">
                                    Admission: {{ $allocation->admission->admission_no ?? 'N/A' }}
                                </p>
                            </div>

                            <!-- Allocation Period -->
                            <div>
                                <p class="text-sm text-slate-600">Allocated Period</p>
                                <p class="font-semibold text-slate-800">{{ $allocation->allocated_at->format('M d, Y H:i') }}</p>
                                @if ($allocation->released_at)
                                    <p class="text-xs text-slate-600">Released: {{ $allocation->released_at->format('M d, Y H:i') }}</p>
                                @else
                                    <p class="text-xs text-orange-600 font-semibold">Still Allocated</p>
                                @endif
                            </div>

                            <!-- Status -->
                            <div>
                                <p class="text-sm text-slate-600">Allocation Status</p>
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $allocation->allocation_status === 'Active' ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-800' }}">
                                    {{ $allocation->allocation_status }}
                                </span>
                                @if ($allocation->notes)
                                    <p class="text-xs text-slate-600 mt-2">{{ $allocation->notes }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-slate-600">No allocation history for this bed</p>
            </div>
        @endif
    </div>
</div>

@endsection

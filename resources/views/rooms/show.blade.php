@extends('includePage')

@section('content')

<div class="max-w-6xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Room {{ $room->room_no }}</h2>
            <p class="text-slate-600">{{ $room->ward->name }} - Room Details</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('rooms.edit', $room) }}" class="bg-amber-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-amber-600 transition">
                Edit Room
            </a>
            <a href="{{ route('rooms.index') }}" class="bg-slate-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-slate-600 transition">
                Back to List
            </a>
        </div>
    </div>

    <!-- Room Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Basic Info -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">Room Information</h3>
            
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-slate-600">Room Number</p>
                    <p class="font-semibold text-slate-800 text-lg">{{ $room->room_no }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Room Type</p>
                    <p class="font-semibold text-slate-800">{{ $room->room_type }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Daily Rate</p>
                    <p class="font-semibold text-slate-800 text-lg">${{ number_format($room->daily_rate, 2) }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Status</p>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $room->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $room->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Ward Info -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">Ward Information</h3>
            
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-slate-600">Ward Name</p>
                    <p class="font-semibold text-slate-800">{{ $room->ward->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Ward Code</p>
                    <p class="font-semibold text-slate-800">{{ $room->ward->code }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Floor</p>
                    <p class="font-semibold text-slate-800">{{ $room->ward->floor ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Gender Policy</p>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold 
                        {{ $room->ward->gender_policy === 'Male' ? 'bg-blue-100 text-blue-800' : ($room->ward->gender_policy === 'Female' ? 'bg-pink-100 text-pink-800' : 'bg-slate-100 text-slate-800') }}">
                        {{ $room->ward->gender_policy }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">Bed Statistics</h3>
            
            <div class="space-y-2">
                @php
                    $totalBeds = $room->beds->count();
                    $availableBeds = $room->beds->where('status', 'Available')->count();
                    $occupiedBeds = $room->beds->where('status', 'Occupied')->count();
                    $maintenanceBeds = $room->beds->where('status', 'Maintenance')->count();
                @endphp
                
                <div class="bg-blue-50 p-3 rounded">
                    <p class="text-xs text-slate-600">Total Beds</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $totalBeds }}</p>
                </div>
                <div class="bg-green-50 p-3 rounded">
                    <p class="text-xs text-slate-600">Available</p>
                    <p class="text-2xl font-bold text-green-600">{{ $availableBeds }}</p>
                </div>
                <div class="bg-orange-50 p-3 rounded">
                    <p class="text-xs text-slate-600">Occupied</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $occupiedBeds }}</p>
                </div>
                <div class="bg-red-50 p-3 rounded">
                    <p class="text-xs text-slate-600">Maintenance</p>
                    <p class="text-2xl font-bold text-red-600">{{ $maintenanceBeds }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Beds Section -->
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-slate-800">Beds in this Room</h3>
            <a href="{{ route('beds.create') }}" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 transition text-sm">
                + Add Bed
            </a>
        </div>

        @if ($room->beds->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($room->beds as $bed)
                    <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h4 class="font-semibold text-slate-800">Bed {{ $bed->bed_no }}</h4>
                                <p class="text-sm text-slate-600">ID: #{{ $bed->id }}</p>
                            </div>
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold 
                                {{ $bed->status === 'Available' ? 'bg-green-100 text-green-800' : ($bed->status === 'Occupied' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800') }}">
                                {{ $bed->status }}
                            </span>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('beds.edit', $bed) }}" class="text-sm px-3 py-1 bg-amber-100 text-amber-700 rounded hover:bg-amber-200 transition">
                                Edit
                            </a>
                            <a href="{{ route('beds.show', $bed) }}" class="text-sm px-3 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 transition">
                                View
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-slate-600 mb-4">No beds in this room yet</p>
                <a href="{{ route('beds.create') }}" class="inline-block bg-blue-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-blue-600 transition">
                    Add First Bed
                </a>
            </div>
        @endif
    </div>
</div>

@endsection

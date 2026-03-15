@extends('includePage')

@section('content')

<div class="max-w-6xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">{{ $ward->name }}</h2>
            <p class="text-slate-600">Ward Details & Management</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('wards.edit', $ward) }}" class="bg-amber-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-amber-600 transition">
                Edit Ward
            </a>
            <a href="{{ route('wards.index') }}" class="bg-slate-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-slate-600 transition">
                Back to List
            </a>
        </div>
    </div>

    <!-- Ward Details Card -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Basic Info -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">Basic Information</h3>
            
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-slate-600">Ward Code</p>
                    <p class="font-semibold text-slate-800">{{ $ward->code }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Floor</p>
                    <p class="font-semibold text-slate-800">{{ $ward->floor ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Gender Policy</p>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold 
                        {{ $ward->gender_policy === 'Male' ? 'bg-blue-100 text-blue-800' : ($ward->gender_policy === 'Female' ? 'bg-pink-100 text-pink-800' : 'bg-slate-100 text-slate-800') }}">
                        {{ $ward->gender_policy }}
                    </span>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Created Date</p>
                    <p class="font-semibold text-slate-800">{{ $ward->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">Statistics</h3>
            
            <div class="space-y-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm text-slate-600">Total Rooms</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $ward->rooms->count() }}</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <p class="text-sm text-slate-600">Total Beds</p>
                    <p class="text-3xl font-bold text-green-600">{{ $ward->rooms->sum(function($r) { return $r->beds->count(); }) }}</p>
                </div>
                <div class="bg-orange-50 p-4 rounded-lg">
                    <p class="text-sm text-slate-600">Available Beds</p>
                    <p class="text-3xl font-bold text-orange-600">
                        {{ $ward->rooms->sum(function($r) { 
                            return $r->beds->where('status', 'Available')->count(); 
                        }) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Active Rooms -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">Active Rooms</h3>
            
            <div class="space-y-2">
                @if ($ward->rooms->count() > 0)
                    @foreach ($ward->rooms->take(5) as $room)
                        <div class="flex justify-between items-center p-2 bg-slate-50 rounded">
                            <span class="text-sm font-semibold text-slate-800">{{ $room->room_no }}</span>
                            <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">
                                {{ $room->beds->count() }} beds
                            </span>
                        </div>
                    @endforeach
                    @if ($ward->rooms->count() > 5)
                        <p class="text-sm text-slate-600 pt-2">+{{ $ward->rooms->count() - 5 }} more rooms</p>
                    @endif
                @else
                    <p class="text-sm text-slate-600">No rooms available</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Rooms Section -->
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-slate-800">Rooms in this Ward</h3>
            <a href="{{ route('rooms.create') }}" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 transition text-sm">
                + Add Room
            </a>
        </div>

        @if ($ward->rooms->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-slate-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Room No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Type</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Daily Rate</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Beds</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($ward->rooms as $room)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-semibold text-slate-800">{{ $room->room_no }}</td>
                                <td class="px-6 py-4 text-slate-700">{{ $room->room_type }}</td>
                                <td class="px-6 py-4 text-slate-700">${{ number_format($room->daily_rate, 2) }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                        {{ $room->beds->count() }} beds
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $room->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $room->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('rooms.show', $room) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-slate-600 mb-4">No rooms in this ward yet</p>
                <a href="{{ route('rooms.create') }}" class="inline-block bg-blue-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-blue-600 transition">
                    Add First Room
                </a>
            </div>
        @endif
    </div>
</div>

@endsection

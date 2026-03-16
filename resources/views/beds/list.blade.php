@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Bed Management</h2>
            <p class="text-slate-600">Manage all beds and their availability status.</p>
        </div>
        <a href="{{ route('beds.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
            + Add New Bed
        </a>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
            <span class="text-xl">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- No Beds Message -->
    @if ($beds->isEmpty())
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-12 text-center">
            <div class="text-6xl mb-4">🛏️</div>
            <h3 class="text-xl font-semibold text-slate-800 mb-2">No Beds Found</h3>
            <p class="text-slate-600 mb-6">There are no beds in the system yet. Click the button below to add a new bed.</p>
            <a href="{{ route('beds.create') }}" class="inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:shadow-lg transition">
                Add Your First Bed
            </a>
        </div>
    @else
        <!-- Beds Table -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-slate-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Bed No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Room</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Ward</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Current Patient</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($beds as $bed)
                            @php
                                $activeAllocation = $bed->allocations->where('allocation_status', 'Active')->first();
                            @endphp
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-semibold text-slate-800">{{ $bed->bed_no }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                        {{ $bed->room->room_no }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-700">{{ $bed->room->ward->name }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold 
                                        {{ $bed->status === 'Available' ? 'bg-green-100 text-green-800' : ($bed->status === 'Occupied' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800') }}">
                                        {{ $bed->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-700">
                                    @if ($activeAllocation && $activeAllocation->admission)
                                        {{ $activeAllocation->admission->patient->first_name ?? 'N/A' }} {{ $activeAllocation->admission->patient->last_name ?? '' }}
                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex gap-2 justify-center">
                                        <a href="{{ route('beds.show', $bed) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">View</a>
                                        <a href="{{ route('beds.edit', $bed) }}" class="text-amber-600 hover:text-amber-800 font-semibold text-sm">Edit</a>
                                        <form action="{{ route('beds.destroy', $bed) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-sm">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

@endsection

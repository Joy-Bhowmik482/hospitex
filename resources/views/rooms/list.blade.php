@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Room Management</h2>
            <p class="text-slate-600">Manage hospital rooms and their configurations.</p>
        </div>
        <a href="{{ route('rooms.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
            + Add New Room
        </a>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
            <span class="text-xl">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- No Rooms Message -->
    @if ($rooms->isEmpty())
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-12 text-center">
            <div class="text-6xl mb-4">🏨</div>
            <h3 class="text-xl font-semibold text-slate-800 mb-2">No Rooms Found</h3>
            <p class="text-slate-600 mb-6">There are no rooms in the system yet. Click the button below to add a new room.</p>
            <a href="{{ route('rooms.create') }}" class="inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:shadow-lg transition">
                Add Your First Room
            </a>
        </div>
    @else
        <!-- Rooms Table -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-slate-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Room No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Ward</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Type</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Daily Rate</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Beds</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($rooms as $room)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-semibold text-slate-800">{{ $room->room_no }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                        {{ $room->ward->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-700">{{ $room->room_type }}</td>
                                <td class="px-6 py-4 text-slate-800 font-semibold">${{ number_format($room->daily_rate, 2) }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                        {{ $room->beds->count() }} beds
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $room->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $room->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex gap-2 justify-center">
                                        <a href="{{ route('rooms.show', $room) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">View</a>
                                        <a href="{{ route('rooms.edit', $room) }}" class="text-amber-600 hover:text-amber-800 font-semibold text-sm">Edit</a>
                                        <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
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

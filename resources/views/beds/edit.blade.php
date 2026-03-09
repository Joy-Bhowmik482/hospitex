@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800 mb-2">Edit Bed</h2>
        <p class="text-slate-600">Update the bed information below.</p>
    </div>

    <!-- Card Container -->
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-8">
        
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                <strong class="block mb-2">Errors:</strong>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('beds.update', $bed) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Bed Information Section -->
            <div class="border-b border-slate-200 pb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Bed Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Room -->
                    <div>
                        <label for="room_id" class="block text-sm font-semibold text-slate-700 mb-2">Room *</label>
                        <select id="room_id" name="room_id" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('room_id') border-red-500 @enderror"
                            required>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('room_id', $bed->room_id) == $room->id ? 'selected' : '' }}>
                                    {{ $room->room_no }} ({{ $room->ward->name }})
                                </option>
                            @endforeach
                        </select>
                        @error('room_id')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Bed Number -->
                    <div>
                        <label for="bed_no" class="block text-sm font-semibold text-slate-700 mb-2">Bed Number *</label>
                        <input type="text" id="bed_no" name="bed_no" value="{{ old('bed_no', $bed->bed_no) }}" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('bed_no') border-red-500 @enderror"
                            required>
                        @error('bed_no')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="md:col-span-2">
                        <label for="status" class="block text-sm font-semibold text-slate-700 mb-2">Bed Status *</label>
                        <select id="status" name="status" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('status') border-red-500 @enderror"
                            required>
                            <option value="Available" {{ old('status', $bed->status) === 'Available' ? 'selected' : '' }}>Available</option>
                            <option value="Occupied" {{ old('status', $bed->status) === 'Occupied' ? 'selected' : '' }}>Occupied</option>
                            <option value="Maintenance" {{ old('status', $bed->status) === 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                        @error('status')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex gap-4 pt-6">
                <button type="submit" class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                    Update Bed
                </button>
                <a href="{{ route('beds.index') }}" class="flex-1 text-center bg-slate-200 text-slate-800 font-semibold py-3 px-6 rounded-lg hover:bg-slate-300 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

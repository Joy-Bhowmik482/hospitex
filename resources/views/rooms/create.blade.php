@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800 mb-2">Add New Room</h2>
        <p class="text-slate-600">Fill in the room information below to add a new room to the system.</p>
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

        <form action="{{ route('rooms.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Room Information Section -->
            <div class="border-b border-slate-200 pb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Room Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Ward -->
                    <div>
                        <label for="ward_id" class="block text-sm font-semibold text-slate-700 mb-2">Ward *</label>
                        <select id="ward_id" name="ward_id" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('ward_id') border-red-500 @enderror"
                            required>
                            <option value="">Select Ward</option>
                            @foreach ($wards as $ward)
                                <option value="{{ $ward->id }}" {{ old('ward_id') == $ward->id ? 'selected' : '' }}>{{ $ward->name }}</option>
                            @endforeach
                        </select>
                        @error('ward_id')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Room Number -->
                    <div>
                        <label for="room_no" class="block text-sm font-semibold text-slate-700 mb-2">Room Number *</label>
                        <input type="text" id="room_no" name="room_no" value="{{ old('room_no') }}" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('room_no') border-red-500 @enderror"
                            placeholder="e.g., 101, 102" required>
                        @error('room_no')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Room Type -->
                    <div>
                        <label for="room_type" class="block text-sm font-semibold text-slate-700 mb-2">Room Type *</label>
                        <input type="text" id="room_type" name="room_type" value="{{ old('room_type') }}" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('room_type') border-red-500 @enderror"
                            placeholder="e.g., Single, Double, Deluxe" required>
                        @error('room_type')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Daily Rate -->
                    <div>
                        <label for="daily_rate" class="block text-sm font-semibold text-slate-700 mb-2">Daily Rate ($) *</label>
                        <input type="number" id="daily_rate" name="daily_rate" value="{{ old('daily_rate') }}" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('daily_rate') border-red-500 @enderror"
                            placeholder="e.g., 100.00" step="0.01" min="0" required>
                        @error('daily_rate')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Active Status -->
                    <div class="md:col-span-2">
                        <label for="is_active" class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" id="is_active" name="is_active" value="1" 
                                class="w-5 h-5 border border-slate-300 rounded focus:ring-2 focus:ring-blue-500 cursor-pointer"
                                {{ old('is_active', true) ? 'checked' : '' }}>
                            <span class="text-sm font-semibold text-slate-700">Room is Active</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex gap-4 pt-6">
                <button type="submit" class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                    Add Room
                </button>
                <a href="{{ route('rooms.index') }}" class="flex-1 text-center bg-slate-200 text-slate-800 font-semibold py-3 px-6 rounded-lg hover:bg-slate-300 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800 mb-2">Add New Ward</h2>
        <p class="text-slate-600">Fill in the ward information below to add a new ward to the system.</p>
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

        <form action="{{ route('wards.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Ward Information Section -->
            <div class="border-b border-slate-200 pb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Ward Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Ward Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Ward Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('name') border-red-500 @enderror"
                            placeholder="e.g., ICU, General Ward, Pediatrics" required>
                        @error('name')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Ward Code -->
                    <div>
                        <label for="code" class="block text-sm font-semibold text-slate-700 mb-2">Ward Code *</label>
                        <input type="text" id="code" name="code" value="{{ old('code') }}" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('code') border-red-500 @enderror"
                            placeholder="e.g., ICU-01, GW-02" required>
                        @error('code')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Floor -->
                    <div>
                        <label for="floor" class="block text-sm font-semibold text-slate-700 mb-2">Floor (Optional)</label>
                        <input type="number" id="floor" name="floor" value="{{ old('floor') }}" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('floor') border-red-500 @enderror"
                            placeholder="e.g., 1, 2, 3" min="0">
                        @error('floor')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Gender Policy -->
                    <div>
                        <label for="gender_policy" class="block text-sm font-semibold text-slate-700 mb-2">Gender Policy *</label>
                        <select id="gender_policy" name="gender_policy" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('gender_policy') border-red-500 @enderror"
                            required>
                            <option value="">Select Gender Policy</option>
                            <option value="Male" {{ old('gender_policy') === 'Male' ? 'selected' : '' }}>Male Only</option>
                            <option value="Female" {{ old('gender_policy') === 'Female' ? 'selected' : '' }}>Female Only</option>
                            <option value="Any" {{ old('gender_policy') === 'Any' ? 'selected' : '' }}>Any Gender</option>
                        </select>
                        @error('gender_policy')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex gap-4 pt-6">
                <button type="submit" class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                    Add Ward
                </button>
                <a href="{{ route('wards.index') }}" class="flex-1 text-center bg-slate-200 text-slate-800 font-semibold py-3 px-6 rounded-lg hover:bg-slate-300 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

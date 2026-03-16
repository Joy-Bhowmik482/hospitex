@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800 mb-2">Allocate Bed to Patient</h2>
        <p class="text-slate-600">Assign an available bed to an admitted patient.</p>
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

        <form action="{{ route('bed-allocations.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Admission & Bed Section -->
            <div class="border-b border-slate-200 pb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Admission & Bed Selection</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Admission -->
                    <div>
                        <label for="admission_id" class="block text-sm font-semibold text-slate-700 mb-2">Admission *</label>
                        <select id="admission_id" name="admission_id" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('admission_id') border-red-500 @enderror"
                            required>
                            <option value="">Select Admission</option>
                            @foreach ($admissions as $admission)
                                <option value="{{ $admission->id }}" {{ old('admission_id') == $admission->id ? 'selected' : '' }}>
                                    {{ $admission->admission_no }} - {{ $admission->patient->first_name }} {{ $admission->patient->last_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('admission_id')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Bed -->
                    <div>
                        <label for="bed_id" class="block text-sm font-semibold text-slate-700 mb-2">Available Bed *</label>
                        <select id="bed_id" name="bed_id" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('bed_id') border-red-500 @enderror"
                            required>
                            <option value="">Select Bed</option>
                            @foreach ($beds as $bed)
                                <option value="{{ $bed->id }}" {{ old('bed_id') == $bed->id ? 'selected' : '' }}>
                                    Bed {{ $bed->bed_no }} ({{ $bed->room->room_no }}, {{ $bed->room->ward->name }}) - ${{ number_format($bed->room->daily_rate, 2) }}
                                </option>
                            @endforeach
                        </select>
                        @error('bed_id')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Allocation Details Section -->
            <div class="border-b border-slate-200 pb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Allocation Details</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Allocated At -->
                    <div>
                        <label for="allocated_at" class="block text-sm font-semibold text-slate-700 mb-2">Allocated At *</label>
                        <input type="datetime-local" id="allocated_at" name="allocated_at" value="{{ old('allocated_at') }}" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('allocated_at') border-red-500 @enderror"
                            required>
                        @error('allocated_at')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Released At (Optional) -->
                    <div>
                        <label for="released_at" class="block text-sm font-semibold text-slate-700 mb-2">Released At (Optional)</label>
                        <input type="datetime-local" id="released_at" name="released_at" value="{{ old('released_at') }}" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('released_at') border-red-500 @enderror"
                            placeholder="Leave empty if not releasing yet">
                        @error('released_at')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Allocation Status -->
                    <div>
                        <label for="allocation_status" class="block text-sm font-semibold text-slate-700 mb-2">Status *</label>
                        <select id="allocation_status" name="allocation_status" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('allocation_status') border-red-500 @enderror"
                            required>
                            <option value="Active" {{ old('allocation_status') === 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Released" {{ old('allocation_status') === 'Released' ? 'selected' : '' }}>Released</option>
                        </select>
                        @error('allocation_status')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-semibold text-slate-700 mb-2">Notes (Optional)</label>
                        <textarea id="notes" name="notes" rows="3" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                            placeholder="Add any notes about this allocation...">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex gap-4 pt-6">
                <button type="submit" class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                    Allocate Bed
                </button>
                <a href="{{ route('bed-allocations.index') }}" class="flex-1 text-center bg-slate-200 text-slate-800 font-semibold py-3 px-6 rounded-lg hover:bg-slate-300 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

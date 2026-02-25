@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800 mb-2">Edit Patient Information</h2>
        <p class="text-slate-600">Update the patient information below.</p>
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

        <form action="{{ route('patients.update', $patient->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Personal Information Section -->
            <div class="border-b border-slate-200 pb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Personal Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block text-sm font-semibold text-slate-700 mb-2">First Name *</label>
                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $patient->first_name) }}" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('first_name') border-red-500 @enderror"
                            required>
                        @error('first_name')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block text-sm font-semibold text-slate-700 mb-2">Last Name *</label>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $patient->last_name) }}" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('last_name') border-red-500 @enderror"
                            required>
                        @error('last_name')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email *</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $patient->email) }}" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('email') border-red-500 @enderror"
                            required>
                        @error('email')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-slate-700 mb-2">Phone *</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone', $patient->phone) }}" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('phone') border-red-500 @enderror"
                            required>
                        @error('phone')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label for="date_of_birth" class="block text-sm font-semibold text-slate-700 mb-2">Date of Birth *</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $patient->date_of_birth->format('Y-m-d')) }}" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('date_of_birth') border-red-500 @enderror"
                            required>
                        @error('date_of_birth')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Gender -->
                    <div>
                        <label for="gender" class="block text-sm font-semibold text-slate-700 mb-2">Gender *</label>
                        <select id="gender" name="gender" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('gender') border-red-500 @enderror"
                            required>
                            <option value="Male" {{ old('gender', $patient->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $patient->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $patient->gender) === 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Address Information Section -->
            <div class="border-b border-slate-200 pb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Address Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-semibold text-slate-700 mb-2">Address</label>
                        <textarea id="address" name="address" rows="2" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">{{ old('address', $patient->address) }}</textarea>
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-semibold text-slate-700 mb-2">City</label>
                        <input type="text" id="city" name="city" value="{{ old('city', $patient->city) }}" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                    </div>

                    <!-- State -->
                    <div>
                        <label for="state" class="block text-sm font-semibold text-slate-700 mb-2">State</label>
                        <input type="text" id="state" name="state" value="{{ old('state', $patient->state) }}" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                    </div>

                    <!-- Postal Code -->
                    <div>
                        <label for="postal_code" class="block text-sm font-semibold text-slate-700 mb-2">Postal Code</label>
                        <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $patient->postal_code) }}" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                    </div>
                </div>
            </div>

            <!-- Medical Information Section -->
            <div class="border-b border-slate-200 pb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Medical Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Blood Type -->
                    <div>
                        <label for="blood_type" class="block text-sm font-semibold text-slate-700 mb-2">Blood Type</label>
                        <input type="text" id="blood_type" name="blood_type" value="{{ old('blood_type', $patient->blood_type) }}" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                    </div>

                    <!-- Date Admitted -->
                    <div>
                        <label for="date_admitted" class="block text-sm font-semibold text-slate-700 mb-2">Date Admitted</label>
                        <input type="date" id="date_admitted" name="date_admitted" value="{{ old('date_admitted', $patient->date_admitted?->format('Y-m-d')) }}" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                    </div>

                    <!-- Allergies -->
                    <div class="md:col-span-2">
                        <label for="allergies" class="block text-sm font-semibold text-slate-700 mb-2">Allergies</label>
                        <textarea id="allergies" name="allergies" rows="2" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">{{ old('allergies', $patient->allergies) }}</textarea>
                    </div>

                    <!-- Medical Conditions -->
                    <div class="md:col-span-2">
                        <label for="medical_conditions" class="block text-sm font-semibold text-slate-700 mb-2">Medical Conditions</label>
                        <textarea id="medical_conditions" name="medical_conditions" rows="2" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">{{ old('medical_conditions', $patient->medical_conditions) }}</textarea>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                        <select id="status" name="status" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                            <option value="In" {{ old('status', $patient->status) === 'In' ? 'selected' : '' }}>In</option>
                            <option value="Out" {{ old('status', $patient->status) === 'Out' ? 'selected' : '' }}>Out</option>
                            <option value="Discharged" {{ old('status', $patient->status) === 'Discharged' ? 'selected' : '' }}>Discharged</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Emergency Contact Section -->
            <div class="pb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Emergency Contact</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Emergency Contact Name -->
                    <div>
                        <label for="emergency_contact_name" class="block text-sm font-semibold text-slate-700 mb-2">Contact Name</label>
                        <input type="text" id="emergency_contact_name" name="emergency_contact_name" value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                    </div>

                    <!-- Emergency Contact Phone -->
                    <div>
                        <label for="emergency_contact_phone" class="block text-sm font-semibold text-slate-700 mb-2">Contact Phone</label>
                        <input type="tel" id="emergency_contact_phone" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                    </div>

                    <!-- Insurance Provider -->
                    <div>
                        <label for="insurance_provider" class="block text-sm font-semibold text-slate-700 mb-2">Insurance Provider</label>
                        <input type="text" id="insurance_provider" name="insurance_provider" value="{{ old('insurance_provider', $patient->insurance_provider) }}" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                    </div>

                    <!-- Insurance ID -->
                    <div>
                        <label for="insurance_id" class="block text-sm font-semibold text-slate-700 mb-2">Insurance ID</label>
                        <input type="text" id="insurance_id" name="insurance_id" value="{{ old('insurance_id', $patient->insurance_id) }}" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6 border-t border-slate-200">
                <button type="submit" class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                    Update Patient
                </button>
                <a href="{{ route('patients.index') }}" class="flex-1 bg-slate-200 text-slate-800 font-semibold py-3 px-6 rounded-lg hover:bg-slate-300 transition text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    input:focus, textarea:focus, select:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
</style>

@endsection

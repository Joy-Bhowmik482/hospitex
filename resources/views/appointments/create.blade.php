@extends('includePage')

@section('content')
<div class="w-full max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-8 py-6">
            <h3 class="text-2xl font-bold text-white">Create New Appointment</h3>
        </div>

        <!-- Content -->
        <div class="p-8">
            @if ($errors->any())
                <div class="bg-red-50 border-2 border-red-300 rounded-lg p-4 mb-6">
                    <p class="text-red-700 font-semibold mb-2">⚠️ Please fix the following errors:</p>
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="text-red-600 text-sm">• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('appointments.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Patient Selection -->
                <div>
                    <label for="patient_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Patient <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-200 transition @error('patient_id') border-red-500 @enderror" 
                            id="patient_id" name="patient_id" required>
                        <option value="">-- Select Patient --</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                {{ $patient->first_name }} {{ $patient->last_name }} (ID: {{ $patient->id }})
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Doctor Selection -->
                <div>
                    <label for="doctor_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Doctor <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-200 transition @error('doctor_id') border-red-500 @enderror" 
                            id="doctor_id" name="doctor_id" required>
                        <option value="">-- Select Doctor --</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                {{ $doctor->name }} ({{ $doctor->specialization }})
                            </option>
                        @endforeach
                    </select>
                    @error('doctor_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Department Selection -->
                <div>
                    <label for="department_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Department <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-200 transition @error('department_id') border-red-500 @enderror" 
                            id="department_id" name="department_id" required>
                        <option value="">-- Select Department --</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date and Time -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="appointment_date" class="block text-sm font-semibold text-gray-700 mb-2">
                            Appointment Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-200 transition @error('appointment_date') border-red-500 @enderror" 
                               id="appointment_date" name="appointment_date" value="{{ old('appointment_date') }}" required>
                        @error('appointment_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="appointment_time" class="block text-sm font-semibold text-gray-700 mb-2">
                            Appointment Time <span class="text-red-500">*</span>
                        </label>
                        <input type="time" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-200 transition @error('appointment_time') border-red-500 @enderror" 
                               id="appointment_time" name="appointment_time" value="{{ old('appointment_time') }}" required>
                        @error('appointment_time')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-200 transition @error('status') border-red-500 @enderror" 
                            id="status" name="status" required>
                        <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Confirmed" {{ old('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled" {{ old('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="NoShow" {{ old('status') == 'NoShow' ? 'selected' : '' }}>No Show</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">Notes</label>
                    <textarea class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-200 transition @error('notes') border-red-500 @enderror" 
                              id="notes" name="notes" rows="4" placeholder="Enter any additional notes...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-6 border-t border-slate-200">
                <button type="submit" class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                    Add Appointment
                </button>
                <a href="{{ route('appointments.index') }}" class="flex-1 bg-slate-200 text-slate-800 font-semibold py-3 px-6 rounded-lg hover:bg-slate-300 transition text-center">
                    Cancel
                </a>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection

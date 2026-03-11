@extends('includePage')

@section('content')
<div class="w-full max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-8 py-6">
            <h3 class="text-2xl font-bold text-white">Edit Appointment - {{ $appointment->appointment_no }}</h3>
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

            <form action="{{ route('appointments.update', $appointment) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Appointment Number (Read-only) -->
                <div>
                    <label for="appointment_no" class="block text-sm font-semibold text-gray-700 mb-2">Appointment No</label>
                    <input type="text" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed" 
                           id="appointment_no" value="{{ $appointment->appointment_no }}" disabled>
                    <p class="text-gray-500 text-xs mt-1">Read-only field</p>
                </div>

                <!-- Patient Selection -->
                <div>
                    <label for="patient_id" class="block text-sm font-semibold text-gray-700 mb-2">Patient <span class="text-red-500">*</span></label>
                    <select class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('patient_id') border-red-500 @enderror" 
                            id="patient_id" name="patient_id" required>
                        <option value="">-- Select Patient --</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id', $appointment->patient_id) == $patient->id ? 'selected' : '' }}>
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
                    <label for="doctor_id" class="block text-sm font-semibold text-gray-700 mb-2">Doctor <span class="text-red-500">*</span></label>
                    <select class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('doctor_id') border-red-500 @enderror" 
                            id="doctor_id" name="doctor_id" required>
                        <option value="">-- Select Doctor --</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ old('doctor_id', $appointment->doctor_id) == $doctor->id ? 'selected' : '' }}>
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
                    <label for="department_id" class="block text-sm font-semibold text-gray-700 mb-2">Department <span class="text-red-500">*</span></label>
                    <select class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('department_id') border-red-500 @enderror" 
                            id="department_id" name="department_id" required>
                        <option value="">-- Select Department --</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id', $appointment->department_id) == $department->id ? 'selected' : '' }}>
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
                        <label for="appointment_date" class="block text-sm font-semibold text-gray-700 mb-2">Appointment Date <span class="text-red-500">*</span></label>
                        <input type="date" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('appointment_date') border-red-500 @enderror" 
                               id="appointment_date" name="appointment_date" value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d')) }}" required>
                        @error('appointment_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="appointment_time" class="block text-sm font-semibold text-gray-700 mb-2">Appointment Time <span class="text-red-500">*</span></label>
                        <input type="time" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('appointment_time') border-red-500 @enderror" 
                               id="appointment_time" name="appointment_time" value="{{ old('appointment_time', $appointment->appointment_time->format('H:i')) }}" required>
                        @error('appointment_time')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                    <select class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('status') border-red-500 @enderror" 
                            id="status" name="status" required>
                        <option value="Pending" {{ old('status', $appointment->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Confirmed" {{ old('status', $appointment->status) == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="Completed" {{ old('status', $appointment->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled" {{ old('status', $appointment->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="NoShow" {{ old('status', $appointment->status) == 'NoShow' ? 'selected' : '' }}>No Show</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">Notes</label>
                    <textarea class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('notes') border-red-500 @enderror" 
                              id="notes" name="notes" rows="4">{{ old('notes', $appointment->notes) }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 pt-6 border-t border-gray-200">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition">
                        ✓ Update Appointment
                    </button>
                    <a href="{{ route('appointments.show', $appointment) }}" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg transition text-center">
                        ✕ Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

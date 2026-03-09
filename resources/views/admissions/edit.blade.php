@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800 mb-2">Edit Admission</h2>
        <p class="text-slate-600">Update the admission information below.</p>
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

        <form action="{{ route('admissions.update', $admission) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information Section -->
            <div class="border-b border-slate-200 pb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Basic Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Admission Number -->
                    <div>
                        <label for="admission_no" class="block text-sm font-semibold text-slate-700 mb-2">Admission Number *</label>
                        <input type="text" id="admission_no" name="admission_no" value="{{ old('admission_no', $admission->admission_no) }}" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('admission_no') border-red-500 @enderror"
                            required>
                        @error('admission_no')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Patient -->
                    <div>
                        <label for="patient_id" class="block text-sm font-semibold text-slate-700 mb-2">Patient *</label>
                        <select id="patient_id" name="patient_id" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('patient_id') border-red-500 @enderror"
                            required>
                            @foreach ($patients as $patient)
                                <option value="{{ $patient->id }}" {{ old('patient_id', $admission->patient_id) == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->first_name }} {{ $patient->last_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Doctor -->
                    <div>
                        <label for="doctor_id" class="block text-sm font-semibold text-slate-700 mb-2">Doctor (Primary Consultant) *</label>
                        <select id="doctor_id" name="doctor_id" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('doctor_id') border-red-500 @enderror"
                            required>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id', $admission->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->name ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Department -->
                    <div>
                        <label for="department_id" class="block text-sm font-semibold text-slate-700 mb-2">Department *</label>
                        <select id="department_id" name="department_id" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('department_id') border-red-500 @enderror"
                            required>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id', $admission->department_id) == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Admission Dates Section -->
            <div class="border-b border-slate-200 pb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Admission Dates</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Admitted At -->
                    <div>
                        <label for="admitted_at" class="block text-sm font-semibold text-slate-700 mb-2">Admitted At *</label>
                        <input type="datetime-local" id="admitted_at" name="admitted_at" value="{{ old('admitted_at', $admission->admitted_at->format('Y-m-d\TH:i')) }}" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('admitted_at') border-red-500 @enderror"
                            required>
                        @error('admitted_at')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Discharge At -->
                    <div>
                        <label for="discharge_at" class="block text-sm font-semibold text-slate-700 mb-2">Discharge At (Optional)</label>
                        <input type="datetime-local" id="discharge_at" name="discharge_at" value="{{ old('discharge_at', $admission->discharge_at?->format('Y-m-d\TH:i')) }}" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('discharge_at') border-red-500 @enderror">
                        @error('discharge_at')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Medical Information Section -->
            <div class="border-b border-slate-200 pb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Medical Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-semibold text-slate-700 mb-2">Status *</label>
                        <select id="status" name="status" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('status') border-red-500 @enderror"
                            required>
                            <option value="Admitted" {{ old('status', $admission->status) === 'Admitted' ? 'selected' : '' }}>Admitted</option>
                            <option value="Discharged" {{ old('status', $admission->status) === 'Discharged' ? 'selected' : '' }}>Discharged</option>
                            <option value="Cancelled" {{ old('status', $admission->status) === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Created By -->
                    <div>
                        <label for="created_by" class="block text-sm font-semibold text-slate-700 mb-2">Created By *</label>
                        <select id="created_by" name="created_by" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('created_by') border-red-500 @enderror"
                            required>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('created_by', $admission->created_by) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('created_by')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Diagnosis -->
                    <div class="md:col-span-2">
                        <label for="diagnosis" class="block text-sm font-semibold text-slate-700 mb-2">Diagnosis (Optional)</label>
                        <textarea id="diagnosis" name="diagnosis" rows="3" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">{{ old('diagnosis', $admission->diagnosis) }}</textarea>
                    </div>

                    <!-- Remarks -->
                    <div class="md:col-span-2">
                        <label for="remarks" class="block text-sm font-semibold text-slate-700 mb-2">Remarks (Optional)</label>
                        <textarea id="remarks" name="remarks" rows="3" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">{{ old('remarks', $admission->remarks) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex gap-4 pt-6">
                <button type="submit" class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                    Update Admission
                </button>
                <a href="{{ route('admissions.index') }}" class="flex-1 text-center bg-slate-200 text-slate-800 font-semibold py-3 px-6 rounded-lg hover:bg-slate-300 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

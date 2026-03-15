@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800 mb-2">Edit Doctor</h2>
        <p class="text-slate-600">Update the doctor information below.</p>
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

        <form action="{{ route('doctors.update', $doctor) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Doctor Information Section -->
            <div class="border-b border-slate-200 pb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Doctor Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Doctor Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $doctor->name) }}"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('name') border-red-500 @enderror"
                            placeholder="e.g., Dr. John Smith" required>
                        @error('name')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Department -->
                    <div>
                        <label for="department_id" class="block text-sm font-semibold text-slate-700 mb-2">Department *</label>
                        <select id="department_id" name="department_id"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('department_id') border-red-500 @enderror"
                            required>
                            <option value="">Select Department</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id', $doctor->department_id) == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Registration Number -->
                    <div>
                        <label for="reg_no" class="block text-sm font-semibold text-slate-700 mb-2">Registration Number *</label>
                        <input type="text" id="reg_no" name="reg_no" value="{{ old('reg_no', $doctor->reg_no) }}"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('reg_no') border-red-500 @enderror"
                            placeholder="e.g., DOC-001, MD-12345" required>
                        @error('reg_no')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Specialization -->
                    <div class="relative z-10" style="min-height: 60px;">
                        <label for="specialization" class="block text-sm font-semibold text-slate-700 mb-2">Specialization *</label>
                        <select id="specialization" name="specialization"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('specialization') border-red-500 @enderror"
                            style="position: relative; z-index: 1;"
                            required>
                            <option value="">Select Specialization</option>
                            @php
                                $specializations = [
                                    'Cardiology', 'Dermatology', 'Emergency Medicine', 'Endocrinology',
                                    'Gastroenterology', 'General Medicine', 'Hematology', 'Infectious Diseases',
                                    'Nephrology', 'Neurology', 'Obstetrics & Gynecology', 'Oncology',
                                    'Ophthalmology', 'Orthopedics', 'Otolaryngology (ENT)', 'Pediatrics',
                                    'Psychiatry', 'Pulmonology', 'Radiology', 'Rheumatology',
                                    'Surgery', 'Urology', 'Dentistry', 'Anesthesiology'
                                ];
                            @endphp
                            @foreach ($specializations as $spec)
                                <option value="{{ $spec }}" {{ old('specialization', $doctor->specialization) == $spec ? 'selected' : '' }}>
                                    {{ $spec }}
                                </option>
                            @endforeach
                        </select>
                        @error('specialization')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <script>
                        document.getElementById('specialization').addEventListener('focus', function() {
                            // Small delay to ensure dropdown opens after focus
                            setTimeout(() => {
                                // Force scroll to ensure dropdown appears below
                                this.scrollIntoView({ block: 'center', behavior: 'smooth' });
                            }, 10);
                        });
                    </script>

                    <!-- Fee -->
                    <div>
                        <label for="fee" class="block text-sm font-semibold text-slate-700 mb-2">Consultation Fee *</label>
                        <input type="number" id="fee" name="fee" value="{{ old('fee', $doctor->fee) }}" step="0.01" min="0"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('fee') border-red-500 @enderror"
                            placeholder="0.00" required>
                        @error('fee')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Is Active -->
                    <div class="md:col-span-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $doctor->is_active) ? 'checked' : '' }}
                                class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm font-semibold text-slate-700">Active Doctor</span>
                        </label>
                        <p class="text-xs text-slate-500 mt-1">Uncheck if this doctor is currently inactive</p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6">
                <a href="{{ route('doctors.index') }}" class="bg-slate-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-slate-600 transition">
                    Cancel
                </a>
                <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                    Update Doctor
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
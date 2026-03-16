@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800 mb-2">Edit Staff Member</h2>
        <p class="text-slate-600">Update the staff member information below.</p>
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

        <form action="{{ route('staff.update', $staff) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Staff Information Section -->
            <div class="border-b border-slate-200 pb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Staff Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $staff->name) }}"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('name') border-red-500 @enderror"
                            placeholder="Full name" required>
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
                                <option value="{{ $department->id }}" {{ old('department_id', $staff->department_id) == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Designation -->
                    <div>
                        <label for="designation" class="block text-sm font-semibold text-slate-700 mb-2">Designation *</label>
                        <select id="designation" name="designation"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('designation') border-red-500 @enderror"
                            required>
                            <option value="">Select Designation</option>
                            @php
                                $designations = [
                                    'Nurse', 'Senior Nurse', 'Lab Technician', 'X-Ray Technician', 'Pharmacist', 'Assistant Pharmacist',
                                    'Receptionist', 'Accountant', 'Administrator', 'Cleaner', 'Security Guard', 'Driver',
                                    'Ward Boy', 'Attendant', 'Medical Records Officer', 'Paramedic'
                                ];
                            @endphp
                            @foreach ($designations as $desig)
                                <option value="{{ $desig }}" {{ old('designation', $staff->designation) == $desig ? 'selected' : '' }}>
                                    {{ $desig }}
                                </option>
                            @endforeach
                        </select>
                        @error('designation')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Joining Date -->
                    <div>
                        <label for="joining_date" class="block text-sm font-semibold text-slate-700 mb-2">Joining Date *</label>
                        <input type="date" id="joining_date" name="joining_date" value="{{ old('joining_date', $staff->joining_date->format('Y-m-d')) }}"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('joining_date') border-red-500 @enderror"
                            required>
                        @error('joining_date')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Salary -->
                    <div>
                        <label for="salary" class="block text-sm font-semibold text-slate-700 mb-2">Salary *</label>
                        <input type="number" id="salary" name="salary" value="{{ old('salary', $staff->salary) }}" step="0.01" min="0"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('salary') border-red-500 @enderror"
                            placeholder="0.00" required>
                        @error('salary')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Is Active -->
                    <div class="md:col-span-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $staff->is_active) ? 'checked' : '' }}
                                class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm font-semibold text-slate-700">Active Staff Member</span>
                        </label>
                        <p class="text-xs text-slate-500 mt-1">Uncheck if this staff member is currently inactive</p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6">
                <a href="{{ route('staff.index') }}" class="bg-slate-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-slate-600 transition">
                    Cancel
                </a>
                <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                    Update Staff Member
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
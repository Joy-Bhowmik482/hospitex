@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800 mb-2">Add New Department</h2>
        <p class="text-slate-600">Create a new department for the hospital.</p>
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

        <form action="{{ route('departments.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Department Information Section -->
            <div class="border-b border-slate-200 pb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Department Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Department Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('name') border-red-500 @enderror"
                            placeholder="e.g., Cardiology, Emergency" required>
                        @error('name')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Code -->
                    <div>
                        <label for="code" class="block text-sm font-semibold text-slate-700 mb-2">Department Code</label>
                        <input type="text" id="code" name="code" value="{{ old('code') }}"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('code') border-red-500 @enderror"
                            placeholder="e.g., CARD, EMER">
                        @error('code')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                        <p class="text-xs text-slate-500 mt-1">Optional short code for the department</p>
                    </div>

                    <!-- Is Active -->
                    <div class="md:col-span-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm font-semibold text-slate-700">Active Department</span>
                        </label>
                        <p class="text-xs text-slate-500 mt-1">Uncheck if this department is currently inactive</p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6">
                <a href="{{ route('departments.index') }}" class="bg-slate-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-slate-600 transition">
                    Cancel
                </a>
                <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                    Create Department
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
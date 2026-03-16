@extends('includePage')

@section('content')

<div class="max-w-2xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800">Add New Service</h2>
        <p class="text-slate-500 mt-1">Create a new hospital service</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('services.store') }}" method="POST">
            @csrf

            <!-- Service Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Service Name *</label>
                <input type="text" id="name" name="name" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror" value="{{ old('name') }}">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Service Code -->
            <div class="mb-4">
                <label for="code" class="block text-sm font-medium text-slate-700 mb-2">Service Code *</label>
                <input type="text" id="code" name="code" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('code') border-red-500 @enderror" value="{{ old('code') }}">
                @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Department -->
            <div class="mb-4">
                <label for="department_id" class="block text-sm font-medium text-slate-700 mb-2">Department</label>
                <select id="department_id" name="department_id" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Department (Optional)</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Price -->
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-slate-700 mb-2">Price *</label>
                <input type="number" id="price" name="price" required step="0.01" min="0" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('price') border-red-500 @enderror" value="{{ old('price') }}">
                @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Active Status -->
            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" class="w-4 h-4 text-blue-600 rounded" {{ old('is_active', true) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-slate-700">Active</span>
                </label>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition">
                    Create Service
                </button>
                <a href="{{ route('services.index') }}" class="bg-slate-300 hover:bg-slate-400 text-slate-800 font-medium py-2 px-6 rounded-lg transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

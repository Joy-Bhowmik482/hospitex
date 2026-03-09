@extends('includePage')

@section('content')

<div class="max-w-2xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800">Edit Insurance Provider</h2>
        <p class="text-slate-500 mt-1">Update insurance provider information</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('insurance-providers.update', $insuranceProvider) }}" method="POST">
            @csrf @method('PUT')

            <!-- Provider Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Provider Name *</label>
                <input type="text" id="name" name="name" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror" value="{{ old('name', $insuranceProvider->name) }}">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Policy Rules -->
            <div class="mb-6">
                <label for="policy_rules" class="block text-sm font-medium text-slate-700 mb-2">Policy Rules / Notes</label>
                <textarea id="policy_rules" name="policy_rules" rows="5" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('policy_rules', $insuranceProvider->policy_rules) }}</textarea>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition">
                    Update Provider
                </button>
                <a href="{{ route('insurance-providers.index') }}" class="bg-slate-300 hover:bg-slate-400 text-slate-800 font-medium py-2 px-6 rounded-lg transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

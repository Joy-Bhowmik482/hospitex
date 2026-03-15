@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800">Insurance Provider Details</h2>
            <p class="text-slate-500 mt-1">View provider information</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('insurance-providers.edit', $insuranceProvider) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition">
                ✏️ Edit
            </a>
            <a href="{{ route('insurance-providers.index') }}" class="bg-slate-600 hover:bg-slate-700 text-white font-medium py-2 px-4 rounded-lg transition">
                ← Back
            </a>
        </div>
    </div>

    <!-- Details Card -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- Name -->
        <div class="mb-6">
            <p class="text-sm text-slate-600 font-medium">Provider Name</p>
            <p class="text-2xl text-slate-800 font-bold mt-2">{{ $insuranceProvider->name }}</p>
        </div>

        <!-- Policy Rules -->
        @if($insuranceProvider->policy_rules)
        <div class="mb-6 border-t border-slate-200 pt-6">
            <p class="text-sm text-slate-600 font-medium mb-2">Policy Rules / Notes</p>
            <div class="bg-slate-50 p-4 rounded-lg text-slate-700 whitespace-pre-line">{{ $insuranceProvider->policy_rules }}</div>
        </div>
        @endif

        <!-- Created Date -->
        <div class="border-t border-slate-200 pt-6 mt-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-slate-600 font-medium">Created Date</p>
                    <p class="text-lg text-slate-800 font-semibold mt-1">{{ $insuranceProvider->created_at->format('d M Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600 font-medium">Last Updated</p>
                    <p class="text-lg text-slate-800 font-semibold mt-1">{{ $insuranceProvider->updated_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Button -->
    <div class="mt-6">
        <form action="{{ route('insurance-providers.destroy', $insuranceProvider) }}" method="POST">
            @csrf @method('DELETE')
            <button type="submit" onclick="return confirm('Are you sure you want to delete this provider?')" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition">
                🗑️ Delete Provider
            </button>
        </form>
    </div>
</div>

@endsection

@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800">Service Details</h2>
            <p class="text-slate-500 mt-1">View service information</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('services.edit', $service) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition">
                ✏️ Edit
            </a>
            <a href="{{ route('services.index') }}" class="bg-slate-600 hover:bg-slate-700 text-white font-medium py-2 px-4 rounded-lg transition">
                ← Back
            </a>
        </div>
    </div>

    <!-- Details Card -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <p class="text-sm text-slate-600 font-medium">Service Name</p>
                <p class="text-lg text-slate-800 font-semibold mt-1">{{ $service->name }}</p>
            </div>

            <!-- Code -->
            <div>
                <p class="text-sm text-slate-600 font-medium">Service Code</p>
                <p class="text-lg text-slate-800 font-semibold mt-1">{{ $service->code }}</p>
            </div>

            <!-- Department -->
            <div>
                <p class="text-sm text-slate-600 font-medium">Department</p>
                <p class="text-lg text-slate-800 font-semibold mt-1">{{ $service->department?->name ?? 'N/A' }}</p>
            </div>

            <!-- Price -->
            <div>
                <p class="text-sm text-slate-600 font-medium">Price</p>
                <p class="text-lg text-slate-800 font-semibold mt-1">{{ number_format($service->price, 2) }}</p>
            </div>

            <!-- Status -->
            <div>
                <p class="text-sm text-slate-600 font-medium">Status</p>
                <p class="mt-1">
                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $service->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $service->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </p>
            </div>

            <!-- Created Date -->
            <div>
                <p class="text-sm text-slate-600 font-medium">Created Date</p>
                <p class="text-lg text-slate-800 font-semibold mt-1">{{ $service->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Delete Button -->
    <div class="mt-6">
        <form action="{{ route('services.destroy', $service) }}" method="POST">
            @csrf @method('DELETE')
            <button type="submit" onclick="return confirm('Are you sure you want to delete this service?')" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition">
                🗑️ Delete Service
            </button>
        </form>
    </div>
</div>

@endsection

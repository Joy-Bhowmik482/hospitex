@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Asset Details</h2>
            <p class="text-slate-600">View detailed information about this asset.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('assets.edit', $asset) }}" class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white font-semibold py-2 px-4 rounded-lg hover:shadow-lg transition">
                Edit Asset
            </a>
            <a href="{{ route('assets.index') }}" class="px-4 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition">
                Back to List
            </a>
        </div>
    </div>

    <!-- Asset Details Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Asset Code -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Asset Code</label>
                <p class="text-lg text-slate-900">{{ $asset->asset_code }}</p>
            </div>

            <!-- Name -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Asset Name</label>
                <p class="text-lg text-slate-900">{{ $asset->name }}</p>
            </div>

            <!-- Category -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Category</label>
                <p class="text-lg text-slate-900">{{ $asset->category }}</p>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($asset->status === 'Active') bg-green-100 text-green-800
                    @elseif($asset->status === 'Maintenance') bg-yellow-100 text-yellow-800
                    @else bg-red-100 text-red-800 @endif">
                    {{ $asset->status }}
                </span>
            </div>

            <!-- Purchase Date -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Purchase Date</label>
                <p class="text-lg text-slate-900">{{ $asset->purchase_date ? $asset->purchase_date->format('M d, Y') : 'N/A' }}</p>
            </div>

            <!-- Cost -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Cost</label>
                <p class="text-lg text-slate-900">{{ $asset->cost ? '$' . number_format($asset->cost, 2) : 'N/A' }}</p>
            </div>

            <!-- Location -->
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Location</label>
                <p class="text-lg text-slate-900">{{ $asset->location ?? 'N/A' }}</p>
            </div>

            <!-- Created At -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Created At</label>
                <p class="text-lg text-slate-900">{{ $asset->created_at->format('M d, Y H:i') }}</p>
            </div>

            <!-- Updated At -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Last Updated</label>
                <p class="text-lg text-slate-900">{{ $asset->updated_at->format('M d, Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>

@endsection
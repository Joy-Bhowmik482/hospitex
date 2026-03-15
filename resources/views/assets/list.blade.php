@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Assets List</h2>
            <p class="text-slate-600">Manage hospital assets, equipment, and fixed items.</p>
        </div>
        <a href="{{ route('assets.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
            + Add New Asset
        </a>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
            <span class="text-xl">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- No Assets Message -->
    @if ($assets->isEmpty())
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-12 text-center">
            <div class="text-6xl mb-4">🏥</div>
            <h3 class="text-xl font-semibold text-slate-800 mb-2">No Assets Found</h3>
            <p class="text-slate-600 mb-6">There are no assets in the system yet. Click the button below to add a new asset.</p>
            <a href="{{ route('assets.create') }}" class="inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:shadow-lg transition">
                Add Your First Asset
            </a>
        </div>
    @else
        <!-- Assets List Table -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <!-- Table Header -->
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-slate-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Asset Code</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Name</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Category</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Purchase Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Cost</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Location</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Actions</th>
                        </tr>
                    </thead>
                    <!-- Table Body -->
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($assets as $asset)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $asset->asset_code }}</td>
                                <td class="px-6 py-4 text-sm text-slate-700">{{ $asset->name }}</td>
                                <td class="px-6 py-4 text-sm text-slate-700">{{ $asset->category }}</td>
                                <td class="px-6 py-4 text-sm text-slate-700">{{ $asset->purchase_date ? $asset->purchase_date->format('M d, Y') : 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-slate-700">{{ $asset->cost ? '$' . number_format($asset->cost, 2) : 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-slate-700">{{ $asset->location ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($asset->status === 'Active') bg-green-100 text-green-800
                                        @elseif($asset->status === 'Maintenance') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $asset->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('assets.show', $asset) }}" class="text-blue-600 hover:text-blue-800 p-1 rounded transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('assets.edit', $asset) }}" class="text-yellow-600 hover:text-yellow-800 p-1 rounded transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('assets.destroy', $asset) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this asset?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 p-1 rounded transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

@endsection
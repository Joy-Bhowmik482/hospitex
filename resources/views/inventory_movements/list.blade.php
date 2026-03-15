@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Inventory Movements</h2>
            <p class="text-slate-600">View all stock movements across the inventory system.</p>
        </div>
        <a href="{{ route('inventory-movements.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
            + Record Movement
        </a>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
            <span class="text-xl">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- No Movements Message -->
    @if ($movements->isEmpty())
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-12 text-center">
            <div class="text-6xl mb-4">📊</div>
            <h3 class="text-xl font-semibold text-slate-800 mb-2">No Movements Found</h3>
            <p class="text-slate-600 mb-6">There are no inventory movements in the system yet. Click the button below to record a new movement.</p>
            <a href="{{ route('inventory-movements.create') }}" class="inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:shadow-lg transition">
                Record First Movement
            </a>
        </div>
    @else
        <!-- Movements List Table -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <!-- Table Header -->
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-slate-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Item</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Type</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Quantity</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Reason</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Reference</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Created By</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Actions</th>
                        </tr>
                    </thead>
                    <!-- Table Body -->
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($movements as $movement)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-sm text-slate-700">{{ $movement->created_at->format('M d, Y H:i') }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $movement->inventoryItem->name }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($movement->type === 'IN') bg-green-100 text-green-800
                                        @elseif($movement->type === 'OUT') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ $movement->type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-slate-700">{{ $movement->qty }}</td>
                                <td class="px-6 py-4 text-sm text-slate-700">{{ $movement->reason ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-slate-700">
                                    @if($movement->ref_type && $movement->ref_id)
                                        {{ $movement->ref_type }}: {{ $movement->ref_id }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-700">{{ $movement->createdByUser->name ?? 'Unknown' }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('inventory-movements.show', $movement) }}" class="text-blue-600 hover:text-blue-800 p-1 rounded transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
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
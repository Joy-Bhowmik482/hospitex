@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-slate-800 mb-2">Stock Movements</h2>
                <p class="text-slate-600">Track all inventory transactions and stock movements across the hospital</p>
            </div>
            <div class="flex gap-3">
                <button class="bg-slate-100 text-slate-700 font-semibold py-3 px-4 rounded-lg hover:bg-slate-200 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export
                </button>
                <button class="bg-slate-100 text-slate-700 font-semibold py-3 px-4 rounded-lg hover:bg-slate-200 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print
                </button>
                <a href="{{ route('inventory-movements.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Record Movement
                </a>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Total Movements</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $movements->count() }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Stock In</p>
                    <p class="text-2xl font-bold text-green-600">{{ $movements->where('type', 'IN')->count() }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Stock Out</p>
                    <p class="text-2xl font-bold text-red-600">{{ $movements->where('type', 'OUT')->count() }}</p>
                </div>
                <div class="bg-red-100 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">This Month</p>
                    <p class="text-2xl font-bold text-indigo-600">{{ $movements->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
                </div>
                <div class="bg-indigo-100 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Timeline -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">Recent Activity</h3>
        <div class="space-y-4">
            @forelse($movements->take(5) as $movement)
            <div class="flex items-start gap-4 pb-4 border-b border-slate-100 last:border-b-0">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center
                        @if($movement->type === 'IN') bg-green-100
                        @elseif($movement->type === 'OUT') bg-red-100
                        @else bg-yellow-100 @endif">
                        @if($movement->type === 'IN')
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                            </svg>
                        @elseif($movement->type === 'OUT')
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            </svg>
                        @else
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        @endif
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                            @if($movement->type === 'IN') bg-green-100 text-green-800
                            @elseif($movement->type === 'OUT') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ $movement->type }}
                        </span>
                        <span class="text-sm text-slate-500">{{ $movement->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-slate-700">
                        <span class="font-medium">{{ $movement->qty }}</span> units of
                        <span class="font-medium">{{ $movement->inventoryItem->name ?? 'Unknown Item' }}</span>
                        @if($movement->reason) - {{ $movement->reason }} @endif
                    </p>
                    @if($movement->ref_type && $movement->ref_id)
                    <p class="text-xs text-slate-500 mt-1">Ref: {{ $movement->ref_type }}: {{ $movement->ref_id }}</p>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                </svg>
                <p class="text-slate-500">No recent movements</p>
            </div>
            @endforelse
        </div>
        @if($movements->count() > 5)
        <div class="mt-4 text-center">
            <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">View All Movements</button>
        </div>
        @endif
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Search Movements</label>
                <input type="text" placeholder="Item name, reference, or reason..." class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Movement Type</label>
                <select class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option>All Types</option>
                    <option>IN</option>
                    <option>OUT</option>
                    <option>Transfer</option>
                    <option>Adjustment</option>
                    <option>Return</option>
                    <option>Damaged</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Date Range</label>
                <select class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option>All Time</option>
                    <option>Today</option>
                    <option>This Week</option>
                    <option>This Month</option>
                    <option>Last 3 Months</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Department</label>
                <select class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option>All Departments</option>
                    <option>Emergency</option>
                    <option>Surgery</option>
                    <option>Radiology</option>
                    <option>Laboratory</option>
                </select>
            </div>
        </div>
        <div class="flex gap-3 mt-4">
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Apply Filters</button>
            <button class="bg-slate-100 text-slate-700 px-4 py-2 rounded-lg hover:bg-slate-200 transition">Clear Filters</button>
        </div>
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
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-800">Movement History</h3>
                <p class="text-sm text-slate-600">Complete audit trail of all inventory transactions</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <!-- Table Header -->
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-slate-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Date & Time</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Item</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Type</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Quantity</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Reason</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Reference</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Department</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Created By</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Actions</th>
                        </tr>
                    </thead>
                    <!-- Table Body -->
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($movements as $movement)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-sm text-slate-700">
                                    <div>
                                        <div class="font-medium">{{ $movement->created_at->format('M d, Y') }}</div>
                                        <div class="text-xs text-slate-500">{{ $movement->created_at->format('H:i') }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-700">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center
                                            @if($movement->type === 'IN') bg-green-100
                                            @elseif($movement->type === 'OUT') bg-red-100
                                            @else bg-yellow-100 @endif">
                                            @if($movement->type === 'IN')
                                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                                </svg>
                                            @elseif($movement->type === 'OUT')
                                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-medium">{{ $movement->inventoryItem->name ?? 'Unknown Item' }}</div>
                                            <div class="text-xs text-slate-500">{{ $movement->inventoryItem->sku ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($movement->type === 'IN') bg-green-100 text-green-800
                                        @elseif($movement->type === 'OUT') bg-red-100 text-red-800
                                        @elseif($movement->type === 'transfer') bg-blue-100 text-blue-800
                                        @elseif($movement->type === 'adjustment') bg-yellow-100 text-yellow-800
                                        @elseif($movement->type === 'return') bg-purple-100 text-purple-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $movement->type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-medium
                                        @if($movement->type === 'IN') text-green-600
                                        @elseif($movement->type === 'OUT') text-red-600
                                        @else text-slate-700 @endif">
                                        @if($movement->type === 'IN')+@endif
                                        @if($movement->type === 'OUT')-@endif
                                        {{ $movement->qty }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-700">{{ $movement->reason ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm font-mono text-slate-700">
                                    @if($movement->ref_type && $movement->ref_id)
                                        {{ $movement->ref_type }}: {{ $movement->ref_id }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-700">{{ $movement->department ?? 'General' }}</td>
                                <td class="px-6 py-4 text-sm text-slate-700">{{ $movement->createdByUser->name ?? 'Unknown' }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('inventory-movements.show', $movement) }}" class="text-blue-600 hover:text-blue-800 p-1 rounded transition" title="View Details">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <button class="text-slate-600 hover:text-slate-800 p-1 rounded transition" title="Print Receipt">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                            </svg>
                                        </button>
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
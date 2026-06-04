@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-slate-800 mb-2">Consumables</h2>
                <p class="text-slate-600">Manage disposable and regularly used medical items inventory</p>
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
                <a href="{{ route('inventory-items.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Item
                </a>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Total Items</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $inventoryItems->count() }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Low Stock Items</p>
                    <p class="text-2xl font-bold text-red-600">{{ $inventoryItems->where('qty_on_hand', '<=', 'reorder_level')->count() }}</p>
                </div>
                <div class="bg-red-100 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Expiring Soon</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $inventoryItems->where('expiry_date', '<=', now()->addDays(30))->count() }}</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Total Value</p>
                    <p class="text-2xl font-bold text-slate-800">${{ number_format($inventoryItems->sum(function($item) { return $item->qty_on_hand * ($item->unit_cost ?? 0); }), 0) }}</p>
                </div>
                <div class="bg-indigo-100 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock Alert -->
    @if($inventoryItems->where('qty_on_hand', '<=', 'reorder_level')->count() > 0)
    <div class="bg-red-50 border border-red-200 rounded-xl p-6 mb-6">
        <div class="flex items-start gap-4">
            <div class="bg-red-100 p-2 rounded-lg">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-red-800 mb-2">Low Stock Alert</h3>
                <p class="text-red-700 mb-3">{{ $inventoryItems->where('qty_on_hand', '<=', 'reorder_level')->count() }} items are running low on stock and need to be reordered.</p>
                <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">View Low Stock Items</button>
            </div>
        </div>
    </div>
    @endif

    <!-- Expiring Items Alert -->
    @if($inventoryItems->where('expiry_date', '<=', now()->addDays(30))->count() > 0)
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-6">
        <div class="flex items-start gap-4">
            <div class="bg-yellow-100 p-2 rounded-lg">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-yellow-800 mb-2">Items Expiring Soon</h3>
                <p class="text-yellow-700 mb-3">{{ $inventoryItems->where('expiry_date', '<=', now()->addDays(30))->count() }} items will expire within the next 30 days.</p>
                <button class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition">View Expiring Items</button>
            </div>
        </div>
    </div>
    @endif

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Search Items</label>
                <input type="text" placeholder="Item name, SKU, or supplier..." class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Category</label>
                <select class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option>All Categories</option>
                    <option>Medical Supplies</option>
                    <option>Pharmaceuticals</option>
                    <option>Laboratory</option>
                    <option>Surgical</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Stock Status</label>
                <select class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option>All Items</option>
                    <option>In Stock</option>
                    <option>Low Stock</option>
                    <option>Out of Stock</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Expiry Status</label>
                <select class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option>All Items</option>
                    <option>Expiring Soon</option>
                    <option>Expired</option>
                    <option>Valid</option>
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

    <!-- No Items Message -->
    @if ($inventoryItems->isEmpty())
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-12 text-center">
            <div class="text-6xl mb-4">📦</div>
            <h3 class="text-xl font-semibold text-slate-800 mb-2">No Inventory Items Found</h3>
            <p class="text-slate-600 mb-6">There are no inventory items in the system yet. Click the button below to add a new item.</p>
            <a href="{{ route('inventory-items.create') }}" class="inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:shadow-lg transition">
                Add Your First Item
            </a>
        </div>
    @else
        <!-- Inventory Items List Table -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-800">Inventory Items</h3>
                <p class="text-sm text-slate-600">Complete list of all consumable items</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <!-- Table Header -->
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-slate-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Item Name</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">SKU</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Category</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Qty on Hand</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Reorder Level</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Unit</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Supplier</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Expiry Date</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Actions</th>
                        </tr>
                    </thead>
                    <!-- Table Body -->
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($inventoryItems as $item)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-sm text-slate-700">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                        </div>
                                        {{ $item->name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-900 font-mono">{{ $item->sku ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-slate-700">{{ $item->category ?? 'General' }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-sm font-medium
                                        @if($item->qty_on_hand <= $item->reorder_level) text-red-600
                                        @elseif($item->qty_on_hand <= $item->reorder_level * 1.5) text-yellow-600
                                        @else text-green-600 @endif">
                                        {{ $item->qty_on_hand }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-slate-700">{{ $item->reorder_level ?? 0 }}</td>
                                <td class="px-6 py-4 text-sm text-slate-700">{{ $item->unit ?? 'Each' }}</td>
                                <td class="px-6 py-4 text-sm text-slate-700">{{ $item->supplier ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-slate-700">
                                    @if($item->expiry_date)
                                        <span class="@if($item->expiry_date <= now()) text-red-600 @elseif($item->expiry_date <= now()->addDays(30)) text-yellow-600 @else text-slate-700 @endif">
                                            {{ $item->expiry_date->format('M d, Y') }}
                                        </span>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($item->qty_on_hand <= 0) bg-red-100 text-red-800
                                        @elseif($item->qty_on_hand <= $item->reorder_level) bg-yellow-100 text-yellow-800
                                        @else bg-green-100 text-green-800 @endif">
                                        @if($item->qty_on_hand <= 0) Out of Stock
                                        @elseif($item->qty_on_hand <= $item->reorder_level) Low Stock
                                        @else In Stock @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('inventory-items.show', $item) }}" class="text-blue-600 hover:text-blue-800 p-1 rounded transition" title="View Details">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('inventory-items.edit', $item) }}" class="text-yellow-600 hover:text-yellow-800 p-1 rounded transition" title="Edit Item">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <button class="text-green-600 hover:text-green-800 p-1 rounded transition" title="Add Stock">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </button>
                                        <form action="{{ route('inventory-items.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this item?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 p-1 rounded transition" title="Delete Item">
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
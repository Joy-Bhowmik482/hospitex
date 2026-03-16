@extends('includePage')

@section('content')

<div class="max-w-6xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">{{ $inventoryItem->name }}</h2>
            <p class="text-slate-600">View item details and manage stock movements.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('inventory-items.edit', $inventoryItem) }}" class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white font-semibold py-2 px-4 rounded-lg hover:shadow-lg transition">
                Edit Item
            </a>
            <a href="{{ route('inventory-items.index') }}" class="px-4 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition">
                Back to List
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Item Details -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Item Details</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Name</label>
                        <p class="text-slate-900">{{ $inventoryItem->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">SKU</label>
                        <p class="text-slate-900">{{ $inventoryItem->sku ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Unit</label>
                        <p class="text-slate-900">{{ $inventoryItem->unit }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Quantity on Hand</label>
                        <p class="text-2xl font-bold text-slate-900">{{ $inventoryItem->qty_on_hand }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Reorder Level</label>
                        <p class="text-slate-900">{{ $inventoryItem->reorder_level }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Status</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($inventoryItem->qty_on_hand <= $inventoryItem->reorder_level) bg-red-100 text-red-800
                            @elseif($inventoryItem->qty_on_hand <= $inventoryItem->reorder_level * 1.5) bg-yellow-100 text-yellow-800
                            @else bg-green-100 text-green-800 @endif">
                            @if($inventoryItem->qty_on_hand <= $inventoryItem->reorder_level) Low Stock
                            @elseif($inventoryItem->qty_on_hand <= $inventoryItem->reorder_level * 1.5) Medium
                            @else In Stock @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Movement Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Add Stock Movement</h3>

                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                        <strong class="block mb-2">Errors:</strong>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('inventory-items.add-movement', $inventoryItem) }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Type -->
                        <div>
                            <label for="type" class="block text-sm font-semibold text-slate-700 mb-2">Movement Type *</label>
                            <select id="type" name="type" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('type') border-red-500 @enderror" required>
                                <option value="">Select Type</option>
                                <option value="IN" {{ old('type') === 'IN' ? 'selected' : '' }}>Stock In</option>
                                <option value="OUT" {{ old('type') === 'OUT' ? 'selected' : '' }}>Stock Out</option>
                                <option value="ADJUST" {{ old('type') === 'ADJUST' ? 'selected' : '' }}>Adjustment</option>
                            </select>
                            @error('type')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Quantity -->
                        <div>
                            <label for="qty" class="block text-sm font-semibold text-slate-700 mb-2">Quantity *</label>
                            <input type="number" id="qty" name="qty" value="{{ old('qty') }}" min="1"
                                class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('qty') border-red-500 @enderror"
                                required>
                            @error('qty')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Reason -->
                        <div>
                            <label for="reason" class="block text-sm font-semibold text-slate-700 mb-2">Reason</label>
                            <input type="text" id="reason" name="reason" value="{{ old('reason') }}"
                                class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('reason') border-red-500 @enderror"
                                placeholder="Purchase, Usage, etc.">
                            @error('reason')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Ref Type -->
                        <div>
                            <label for="ref_type" class="block text-sm font-semibold text-slate-700 mb-2">Reference Type</label>
                            <input type="text" id="ref_type" name="ref_type" value="{{ old('ref_type') }}"
                                class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('ref_type') border-red-500 @enderror"
                                placeholder="Purchase Order, Invoice, etc.">
                            @error('ref_type')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Ref ID -->
                        <div>
                            <label for="ref_id" class="block text-sm font-semibold text-slate-700 mb-2">Reference ID</label>
                            <input type="text" id="ref_id" name="ref_id" value="{{ old('ref_id') }}"
                                class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('ref_id') border-red-500 @enderror"
                                placeholder="PO-001, INV-123, etc.">
                            @error('ref_id')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                        Record Movement
                    </button>
                </form>
            </div>

            <!-- Movement History -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Movement History</h3>

                @if ($inventoryItem->movements->isEmpty())
                    <p class="text-slate-600">No movements recorded yet.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200">
                                    <th class="px-4 py-2 text-left text-xs font-semibold uppercase text-slate-700">Date</th>
                                    <th class="px-4 py-2 text-left text-xs font-semibold uppercase text-slate-700">Type</th>
                                    <th class="px-4 py-2 text-center text-xs font-semibold uppercase text-slate-700">Qty</th>
                                    <th class="px-4 py-2 text-left text-xs font-semibold uppercase text-slate-700">Reason</th>
                                    <th class="px-4 py-2 text-left text-xs font-semibold uppercase text-slate-700">By</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @foreach ($inventoryItem->movements->sortByDesc('created_at') as $movement)
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-4 py-2 text-sm text-slate-700">{{ $movement->created_at->format('M d, Y H:i') }}</td>
                                        <td class="px-4 py-2 text-sm">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                @if($movement->type === 'IN') bg-green-100 text-green-800
                                                @elseif($movement->type === 'OUT') bg-red-100 text-red-800
                                                @else bg-yellow-100 text-yellow-800 @endif">
                                                {{ $movement->type }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2 text-center text-sm text-slate-700">{{ $movement->qty }}</td>
                                        <td class="px-4 py-2 text-sm text-slate-700">{{ $movement->reason ?? 'N/A' }}</td>
                                        <td class="px-4 py-2 text-sm text-slate-700">{{ $movement->createdByUser->name ?? 'Unknown' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
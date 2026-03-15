@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800 mb-2">Record Inventory Movement</h2>
        <p class="text-slate-600">Record a new stock movement for an inventory item.</p>
    </div>

    <!-- Card Container -->
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-8">

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                <strong class="block mb-2">Errors:</strong>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('inventory-movements.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Movement Information Section -->
            <div class="border-b border-slate-200 pb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Movement Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Inventory Item -->
                    <div>
                        <label for="inventory_item_id" class="block text-sm font-semibold text-slate-700 mb-2">Inventory Item *</label>
                        <select id="inventory_item_id" name="inventory_item_id"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('inventory_item_id') border-red-500 @enderror"
                            required>
                            <option value="">Select Item</option>
                            @foreach ($inventoryItems as $item)
                                <option value="{{ $item->id }}" {{ old('inventory_item_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }} ({{ $item->sku ?? 'No SKU' }})
                                </option>
                            @endforeach
                        </select>
                        @error('inventory_item_id')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-sm font-semibold text-slate-700 mb-2">Movement Type *</label>
                        <select id="type" name="type"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('type') border-red-500 @enderror"
                            required>
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
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('qty') border-red-500 @enderror"
                            required>
                        @error('qty')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Reason -->
                    <div>
                        <label for="reason" class="block text-sm font-semibold text-slate-700 mb-2">Reason</label>
                        <input type="text" id="reason" name="reason" value="{{ old('reason') }}"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('reason') border-red-500 @enderror"
                            placeholder="Purchase, Usage, etc.">
                        @error('reason')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Ref Type -->
                    <div>
                        <label for="ref_type" class="block text-sm font-semibold text-slate-700 mb-2">Reference Type</label>
                        <input type="text" id="ref_type" name="ref_type" value="{{ old('ref_type') }}"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('ref_type') border-red-500 @enderror"
                            placeholder="Purchase Order, Invoice, etc.">
                        @error('ref_type')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Ref ID -->
                    <div>
                        <label for="ref_id" class="block text-sm font-semibold text-slate-700 mb-2">Reference ID</label>
                        <input type="text" id="ref_id" name="ref_id" value="{{ old('ref_id') }}"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('ref_id') border-red-500 @enderror"
                            placeholder="PO-001, INV-123, etc.">
                        @error('ref_id')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 pt-6">
                <a href="{{ route('inventory-movements.index') }}" class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition">
                    Cancel
                </a>
                <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                    Record Movement
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
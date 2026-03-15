@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800 mb-2">Add New Inventory Item</h2>
        <p class="text-slate-600">Fill in the inventory item information below to add a new consumable to the system.</p>
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

        <form action="{{ route('inventory-items.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Item Information Section -->
            <div class="border-b border-slate-200 pb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Item Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Item Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('name') border-red-500 @enderror"
                            placeholder="Surgical Gloves" required>
                        @error('name')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- SKU -->
                    <div>
                        <label for="sku" class="block text-sm font-semibold text-slate-700 mb-2">SKU</label>
                        <input type="text" id="sku" name="sku" value="{{ old('sku') }}"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('sku') border-red-500 @enderror"
                            placeholder="SG-001">
                        @error('sku')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Unit -->
                    <div>
                        <label for="unit" class="block text-sm font-semibold text-slate-700 mb-2">Unit *</label>
                        <input type="text" id="unit" name="unit" value="{{ old('unit') }}"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('unit') border-red-500 @enderror"
                            placeholder="Box" required>
                        @error('unit')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Qty on Hand -->
                    <div>
                        <label for="qty_on_hand" class="block text-sm font-semibold text-slate-700 mb-2">Quantity on Hand *</label>
                        <input type="number" id="qty_on_hand" name="qty_on_hand" value="{{ old('qty_on_hand', 0) }}" min="0"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('qty_on_hand') border-red-500 @enderror"
                            required>
                        @error('qty_on_hand')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Reorder Level -->
                    <div>
                        <label for="reorder_level" class="block text-sm font-semibold text-slate-700 mb-2">Reorder Level *</label>
                        <input type="number" id="reorder_level" name="reorder_level" value="{{ old('reorder_level') }}" min="0"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('reorder_level') border-red-500 @enderror"
                            placeholder="10" required>
                        @error('reorder_level')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 pt-6">
                <a href="{{ route('inventory-items.index') }}" class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition">
                    Cancel
                </a>
                <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                    Create Item
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
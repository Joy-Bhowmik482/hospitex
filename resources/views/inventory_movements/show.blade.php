@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Movement Details</h2>
            <p class="text-slate-600">View detailed information about this inventory movement.</p>
        </div>
        <a href="{{ route('inventory-movements.index') }}" class="px-4 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition">
            Back to List
        </a>
    </div>

    <!-- Movement Details Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Movement Date -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Movement Date</label>
                <p class="text-lg text-slate-900">{{ $inventoryMovement->created_at->format('M d, Y H:i') }}</p>
            </div>

            <!-- Inventory Item -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Inventory Item</label>
                <p class="text-lg text-slate-900">{{ $inventoryMovement->inventoryItem->name }}</p>
            </div>

            <!-- Type -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Movement Type</label>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($inventoryMovement->type === 'IN') bg-green-100 text-green-800
                    @elseif($inventoryMovement->type === 'OUT') bg-red-100 text-red-800
                    @else bg-yellow-100 text-yellow-800 @endif">
                    {{ $inventoryMovement->type }}
                </span>
            </div>

            <!-- Quantity -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Quantity</label>
                <p class="text-lg text-slate-900">{{ $inventoryMovement->qty }}</p>
            </div>

            <!-- Reason -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Reason</label>
                <p class="text-lg text-slate-900">{{ $inventoryMovement->reason ?? 'N/A' }}</p>
            </div>

            <!-- Reference -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Reference</label>
                <p class="text-lg text-slate-900">
                    @if($inventoryMovement->ref_type && $inventoryMovement->ref_id)
                        {{ $inventoryMovement->ref_type }}: {{ $inventoryMovement->ref_id }}
                    @else
                        N/A
                    @endif
                </p>
            </div>

            <!-- Created By -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Created By</label>
                <p class="text-lg text-slate-900">{{ $inventoryMovement->createdByUser->name ?? 'Unknown' }}</p>
            </div>

            <!-- Created At -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Created At</label>
                <p class="text-lg text-slate-900">{{ $inventoryMovement->created_at->format('M d, Y H:i:s') }}</p>
            </div>
        </div>
    </div>
</div>

@endsection
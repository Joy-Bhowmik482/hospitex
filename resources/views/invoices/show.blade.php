@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800">Invoice Details</h2>
            <p class="text-slate-500 mt-1">{{ $invoice->invoice_no }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('invoices.edit', $invoice) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition">
                ✏️ Edit
            </a>
            <a href="{{ route('invoices.index') }}" class="bg-slate-600 hover:bg-slate-700 text-white font-medium py-2 px-4 rounded-lg transition">
                ← Back
            </a>
        </div>
    </div>

    <!-- Invoice Card -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Patient -->
            <div>
                <p class="text-sm text-slate-600 font-medium">Patient</p>
                <p class="text-lg text-slate-800 font-semibold mt-1">{{ $invoice->patient?->first_name }} {{ $invoice->patient?->last_name }}</p>
            </div>

            <!-- Invoice Date -->
            <div>
                <p class="text-sm text-slate-600 font-medium">Invoice Date</p>
                <p class="text-lg text-slate-800 font-semibold mt-1">{{ $invoice->invoice_date->format('d M Y') }}</p>
            </div>

            <!-- Status -->
            <div>
                <p class="text-sm text-slate-600 font-medium">Status</p>
                <p class="mt-1">
                    <span class="px-3 py-1 rounded-full text-xs font-medium 
                        {{ $invoice->status === 'Paid' ? 'bg-green-100 text-green-800' : ($invoice->status === 'Partial' ? 'bg-yellow-100 text-yellow-800' : ($invoice->status === 'Unpaid' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                        {{ $invoice->status }}
                    </span>
                </p>
            </div>
        </div>

        <!-- Invoice Amounts -->
        <div class="border-t border-slate-200 pt-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <p class="text-sm text-slate-600 font-medium">Subtotal</p>
                    <p class="text-lg text-slate-800 font-semibold mt-1">{{ number_format($invoice->subtotal, 2) }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600 font-medium">Discount</p>
                    <p class="text-lg text-slate-800 font-semibold mt-1">{{ number_format($invoice->discount, 2) }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600 font-medium">Tax</p>
                    <p class="text-lg text-slate-800 font-semibold mt-1">{{ number_format($invoice->tax, 2) }}</p>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm text-blue-600 font-medium">Net Total</p>
                    <p class="text-lg text-blue-800 font-bold mt-1">{{ number_format($invoice->net_total, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Notes -->
        @if($invoice->notes)
        <div class="border-t border-slate-200 mt-6 pt-6">
            <p class="text-sm text-slate-600 font-medium mb-2">Notes</p>
            <p class="text-slate-700">{{ $invoice->notes }}</p>
        </div>
        @endif
    </div>

    <!-- Delete Button -->
    <div>
        <form action="{{ route('invoices.destroy', $invoice) }}" method="POST">
            @csrf @method('DELETE')
            <button type="submit" onclick="return confirm('Are you sure you want to delete this invoice?')" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition">
                🗑️ Delete Invoice
            </button>
        </form>
    </div>
</div>

@endsection

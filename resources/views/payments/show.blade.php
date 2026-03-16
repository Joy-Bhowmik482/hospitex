@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800">Payment Details</h2>
            <p class="text-slate-500 mt-1">View payment information</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('payments.edit', $payment) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition">
                ✏️ Edit
            </a>
            <a href="{{ route('payments.index') }}" class="bg-slate-600 hover:bg-slate-700 text-white font-medium py-2 px-4 rounded-lg transition">
                ← Back
            </a>
        </div>
    </div>

    <!-- Payment Card -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Invoice -->
            <div>
                <p class="text-sm text-slate-600 font-medium">Invoice</p>
                <p class="text-lg text-slate-800 font-semibold mt-1">{{ $payment->invoice?->invoice_no }}</p>
            </div>

            <!-- Amount -->
            <div>
                <p class="text-sm text-slate-600 font-medium">Amount</p>
                <p class="text-lg text-slate-800 font-semibold mt-1">{{ number_format($payment->amount, 2) }}</p>
            </div>

            <!-- Method -->
            <div>
                <p class="text-sm text-slate-600 font-medium">Payment Method</p>
                <p class="text-lg text-slate-800 font-semibold mt-1">{{ $payment->method }}</p>
            </div>

            <!-- Paid Date -->
            <div>
                <p class="text-sm text-slate-600 font-medium">Paid Date</p>
                <p class="text-lg text-slate-800 font-semibold mt-1">{{ $payment->paid_at->format('d M Y H:i') }}</p>
            </div>

            <!-- Transaction ID -->
            @if($payment->trx_id)
            <div>
                <p class="text-sm text-slate-600 font-medium">Transaction ID</p>
                <p class="text-lg text-slate-800 font-semibold mt-1">{{ $payment->trx_id }}</p>
            </div>
            @endif

            <!-- Received By -->
            <div>
                <p class="text-sm text-slate-600 font-medium">Received By</p>
                <p class="text-lg text-slate-800 font-semibold mt-1">{{ $payment->receivedByUser?->name }}</p>
            </div>
        </div>

        <!-- Notes -->
        @if($payment->notes)
        <div class="border-t border-slate-200 mt-6 pt-6">
            <p class="text-sm text-slate-600 font-medium mb-2">Notes</p>
            <p class="text-slate-700">{{ $payment->notes }}</p>
        </div>
        @endif
    </div>

    <!-- Delete Button -->
    <div class="mt-6">
        <form action="{{ route('payments.destroy', $payment) }}" method="POST">
            @csrf @method('DELETE')
            <button type="submit" onclick="return confirm('Are you sure you want to delete this payment?')" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition">
                🗑️ Delete Payment
            </button>
        </form>
    </div>
</div>

@endsection

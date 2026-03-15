@extends('includePage')

@section('content')

<div class="max-w-2xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800">Record Payment</h2>
        <p class="text-slate-500 mt-1">Record a new payment for an invoice</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('payments.store') }}" method="POST">
            @csrf

            <!-- Invoice -->
            <div class="mb-4">
                <label for="invoice_id" class="block text-sm font-medium text-slate-700 mb-2">Invoice *</label>
                <select id="invoice_id" name="invoice_id" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('invoice_id') border-red-500 @enderror">
                    <option value="">Select Invoice</option>
                    @foreach($invoices as $invoice)
                        <option value="{{ $invoice->id }}" {{ old('invoice_id') == $invoice->id ? 'selected' : '' }}>{{ $invoice->invoice_no }} - {{ number_format($invoice->net_total, 2) }}</option>
                    @endforeach
                </select>
                @error('invoice_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Paid Date -->
            <div class="mb-4">
                <label for="paid_at" class="block text-sm font-medium text-slate-700 mb-2">Paid Date *</label>
                <input type="date" id="paid_at" name="paid_at" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('paid_at') border-red-500 @enderror" value="{{ old('paid_at', now()->format('Y-m-d')) }}">
                @error('paid_at') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Amount -->
            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-slate-700 mb-2">Amount *</label>
                <input type="number" id="amount" name="amount" required step="0.01" min="0.01" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('amount') border-red-500 @enderror" value="{{ old('amount') }}">
                @error('amount') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Method -->
            <div class="mb-4">
                <label for="method" class="block text-sm font-medium text-slate-700 mb-2">Payment Method *</label>
                <select id="method" name="method" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="Cash" {{ old('method') === 'Cash' ? 'selected' : '' }}>Cash</option>
                    <option value="Card" {{ old('method') === 'Card' ? 'selected' : '' }}>Card</option>
                    <option value="bKash" {{ old('method') === 'bKash' ? 'selected' : '' }}>bKash</option>
                    <option value="Bank" {{ old('method') === 'Bank' ? 'selected' : '' }}>Bank Transfer</option>
                    <option value="Other" {{ old('method') === 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <!-- Transaction ID -->
            <div class="mb-4">
                <label for="trx_id" class="block text-sm font-medium text-slate-700 mb-2">Transaction ID (Optional)</label>
                <input type="text" id="trx_id" name="trx_id" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('trx_id') }}" placeholder="TRX123456">
            </div>

            <!-- Received By -->
            <div class="mb-4">
                <label for="received_by" class="block text-sm font-medium text-slate-700 mb-2">Received By *</label>
                <select id="received_by" name="received_by" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('received_by') border-red-500 @enderror">
                    <option value="">Select User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('received_by') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('received_by') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Notes -->
            <div class="mb-6">
                <label for="notes" class="block text-sm font-medium text-slate-700 mb-2">Notes</label>
                <textarea id="notes" name="notes" rows="3" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes') }}</textarea>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition">
                    Record Payment
                </button>
                <a href="{{ route('payments.index') }}" class="bg-slate-300 hover:bg-slate-400 text-slate-800 font-medium py-2 px-6 rounded-lg transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

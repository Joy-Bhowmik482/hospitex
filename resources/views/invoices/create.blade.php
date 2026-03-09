@extends('includePage')

@section('content')

<div class="max-w-2xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800">Create Invoice</h2>
        <p class="text-slate-500 mt-1">Create a new patient billing invoice</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('invoices.store') }}" method="POST">
            @csrf

            <!-- Invoice No -->
            <div class="mb-4">
                <label for="invoice_no" class="block text-sm font-medium text-slate-700 mb-2">Invoice No *</label>
                <input type="text" id="invoice_no" name="invoice_no" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('invoice_no') border-red-500 @enderror" value="{{ old('invoice_no') }}" placeholder="INV-2026-001">
                @error('invoice_no') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Patient -->
            <div class="mb-4">
                <label for="patient_id" class="block text-sm font-medium text-slate-700 mb-2">Patient *</label>
                <select id="patient_id" name="patient_id" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('patient_id') border-red-500 @enderror">
                    <option value="">Select Patient</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>{{ $patient->first_name }} {{ $patient->last_name }}</option>
                    @endforeach
                </select>
                @error('patient_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Admission -->
            <div class="mb-4">
                <label for="admission_id" class="block text-sm font-medium text-slate-700 mb-2">Admission (Optional)</label>
                <select id="admission_id" name="admission_id" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Admission</option>
                    @foreach($admissions as $admission)
                        <option value="{{ $admission->id }}" {{ old('admission_id') == $admission->id ? 'selected' : '' }}>{{ $admission->admission_no }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Invoice Date -->
            <div class="mb-4">
                <label for="invoice_date" class="block text-sm font-medium text-slate-700 mb-2">Invoice Date *</label>
                <input type="date" id="invoice_date" name="invoice_date" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('invoice_date') border-red-500 @enderror" value="{{ old('invoice_date', now()->format('Y-m-d')) }}">
                @error('invoice_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-slate-700 mb-2">Status *</label>
                <select id="status" name="status" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="Unpaid" {{ old('status') === 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                    <option value="Partial" {{ old('status') === 'Partial' ? 'selected' : '' }}>Partial</option>
                    <option value="Paid" {{ old('status') === 'Paid' ? 'selected' : '' }}>Paid</option>
                    <option value="Cancelled" {{ old('status') === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <!-- Subtotal -->
            <div class="mb-4">
                <label for="subtotal" class="block text-sm font-medium text-slate-700 mb-2">Subtotal *</label>
                <input type="number" id="subtotal" name="subtotal" required step="0.01" min="0" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('subtotal') border-red-500 @enderror" value="{{ old('subtotal') }}">
                @error('subtotal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Discount -->
            <div class="mb-4">
                <label for="discount" class="block text-sm font-medium text-slate-700 mb-2">Discount</label>
                <input type="number" id="discount" name="discount" step="0.01" min="0" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('discount', 0) }}">
            </div>

            <!-- Tax -->
            <div class="mb-4">
                <label for="tax" class="block text-sm font-medium text-slate-700 mb-2">Tax</label>
                <input type="number" id="tax" name="tax" step="0.01" min="0" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('tax', 0) }}">
            </div>

            <!-- Net Total -->
            <div class="mb-4">
                <label for="net_total" class="block text-sm font-medium text-slate-700 mb-2">Net Total *</label>
                <input type="number" id="net_total" name="net_total" required step="0.01" min="0" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('net_total') border-red-500 @enderror" value="{{ old('net_total') }}">
                @error('net_total') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Notes -->
            <div class="mb-6">
                <label for="notes" class="block text-sm font-medium text-slate-700 mb-2">Notes</label>
                <textarea id="notes" name="notes" rows="3" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes') }}</textarea>
            </div>

            <!-- Created By -->
            <div class="mb-6">
                <label for="created_by" class="block text-sm font-medium text-slate-700 mb-2">Created By *</label>
                <select id="created_by" name="created_by" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('created_by') border-red-500 @enderror">
                    <option value="">Select User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('created_by') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('created_by') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition">
                    Create Invoice
                </button>
                <a href="{{ route('invoices.index') }}" class="bg-slate-300 hover:bg-slate-400 text-slate-800 font-medium py-2 px-6 rounded-lg transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

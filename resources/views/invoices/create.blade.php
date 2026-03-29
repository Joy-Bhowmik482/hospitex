@extends('includePage')

@section('content')

<div class="min-h-screen bg-gray-100 py-10 px-4">

    <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-lg p-10">

        <form action="{{ route('invoices.store') }}" method="POST">
            @csrf

            <!-- Header -->
            <div class="flex justify-between items-start border-b pb-6 mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">INVOICE</h1>
                    <p class="text-sm text-gray-500 mt-1">Hospital Billing System</p>
                </div>

                <div class="text-right">
                    <label class="text-sm text-gray-500">Invoice No</label>
                    <input type="text" name="invoice_no" required
                        value="{{ old('invoice_no') }}"
                        class="block border-b border-gray-300 focus:outline-none text-right font-semibold text-gray-800">

                    <label class="text-sm text-gray-500 mt-2 block">Date</label>
                    <input type="date" name="invoice_date" required
                        value="{{ old('invoice_date', now()->format('Y-m-d')) }}"
                        class="block border-b border-gray-300 focus:outline-none text-right">
                </div>
            </div>

            <!-- Patient Info -->
            <div class="grid grid-cols-2 gap-6 mb-6">

                <div>
                    <h3 class="text-sm font-semibold text-gray-500 mb-2">Bill To</h3>
                    <select name="patient_id" required
                        class="w-full border-b border-gray-300 focus:outline-none py-1">
                        <option value="">Select Patient</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">
                                {{ $patient->first_name }} {{ $patient->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="text-right">
                    <h3 class="text-sm font-semibold text-gray-500 mb-2">Created By</h3>
                    <select name="created_by" required
                        class="w-full border-b border-gray-300 focus:outline-none py-1 text-right">
                        <option value="">Select User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <!-- Admission -->
            <div class="mb-6">
                <label class="text-sm text-gray-500">Admission</label>
                <select name="admission_id"
                    class="w-full border-b border-gray-300 focus:outline-none py-1">
                    <option value="">Select Admission</option>
                    @foreach($admissions as $admission)
                        <option value="{{ $admission->id }}">{{ $admission->admission_no }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Billing Table -->
            <div class="mb-6">
                <table class="w-full text-sm border">
                    <thead class="bg-gray-100 text-gray-600">
                        <tr>
                            <th class="p-2 text-left">Description</th>
                            <th class="p-2 text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="p-2">Subtotal</td>
                            <td class="p-2 text-right">
                                <input type="number" id="subtotal" name="subtotal" step="0.01"
                                    class="text-right w-32 border-b focus:outline-none calc">
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2">Discount</td>
                            <td class="p-2 text-right">
                                <input type="number" id="discount" name="discount" step="0.01"
                                    value="0"
                                    class="text-right w-32 border-b focus:outline-none calc">
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2">Tax</td>
                            <td class="p-2 text-right">
                                <input type="number" id="tax" name="tax" step="0.01"
                                    value="0"
                                    class="text-right w-32 border-b focus:outline-none calc">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Total Section -->
            <div class="flex justify-end mb-6">
                <div class="w-64">
                    <div class="flex justify-between py-2 border-t">
                        <span class="font-semibold">Net Total</span>
                        <input type="number" id="net_total" name="net_total" readonly
                            class="text-right font-bold text-lg border-b focus:outline-none w-32">
                    </div>

                    <div class="mt-4">
                        <label class="text-sm text-gray-500">Status</label>
                        <select name="status"
                            class="w-full border-b border-gray-300 focus:outline-none">
                            <option value="Unpaid">Unpaid</option>
                            <option value="Partial">Partial</option>
                            <option value="Paid">Paid</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="mb-6">
                <label class="text-sm text-gray-500">Notes</label>
                <textarea name="notes" rows="2"
                    class="w-full border border-gray-300 rounded p-2 focus:outline-none"></textarea>
            </div>

            <!-- Footer -->
            <div class="flex justify-between items-center border-t pt-6">
                <a href="{{ route('invoices.index') }}"
                   class="text-gray-600 hover:underline">Cancel</a>

                <button type="submit"
                    class="bg-gray-800 hover:bg-black text-white px-6 py-2 rounded shadow">
                    Save Invoice
                </button>
            </div>

        </form>
    </div>
</div>

<!-- Auto Calculation -->
<script>
    const inputs = document.querySelectorAll('.calc');
    const netTotal = document.getElementById('net_total');

    function calc() {
        let subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
        let discount = parseFloat(document.getElementById('discount').value) || 0;
        let tax = parseFloat(document.getElementById('tax').value) || 0;

        netTotal.value = (subtotal - discount + tax).toFixed(2);
    }

    inputs.forEach(i => i.addEventListener('input', calc));
    window.onload = calc;
</script>

@endsection
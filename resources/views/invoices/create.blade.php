@extends('includePage')

@section('content')

<!-- STYLE -->
<style>
@media print {
    @page { size: A4; margin: 20mm; }
    
    body {
        margin:0;
        padding:0;
        background:#fff !important;
        color:#000 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    /* Hide everything */
    body * {
        visibility: hidden;
    }

    /* Show only invoice */
    #invoiceArea, #invoiceArea * {
        visibility: visible;
    }

    /* Position invoice */
    #invoiceArea {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        box-shadow: none !important;
        border-radius: 0 !important;
        background: #fff !important;
    }

    /* ✅ FORCE HEADER COLORS (FIX) */
    #invoiceArea .bg-slate-900 {
        background: #0f172a !important;
        color: #fff !important;
    }

    #invoiceArea .bg-slate-900 input {
        color: #fff !important;
        border-color: #cbd5f5 !important;
    }

    #invoiceArea .bg-slate-900 p {
        color: #cbd5f5 !important;
    }

    /* Table styling */
    table { width: 100%; border-collapse: collapse; }
    table, th, td { border: 1px solid #000 !important; }
    thead { background: #000 !important; color: #fff !important; }
    th, td { padding: 8px !important; text-align: left; }

    /* Hide buttons */
    button, a {
        display: none !important;
    }

    /* Inputs → text */
    input, textarea, select {
        border: none !important;
        background: transparent !important;
        pointer-events: none;
        font-weight: 500;
        appearance: none;
        color: #000;
    }

    /* ✅ Keep header inputs WHITE (override above rule) */
    #invoiceArea .bg-slate-900 input {
        color: #fff !important;
    }
}
</style>

<!-- PAGE CONTENT -->
<div class="min-h-screen bg-slate-100 py-10 px-4">
    <div id="invoiceArea" class="max-w-5xl mx-auto bg-white shadow-xl rounded-2xl overflow-hidden">
        <form action="{{ route('invoices.store') }}" method="POST">
            @csrf

            <!-- HEADER -->
            <div class="flex justify-between items-center bg-slate-900 text-white px-10 py-6">
                <div>
                    <h1 class="text-2xl font-bold tracking-wide">HOSPITAL INVOICE</h1>
                    <p class="text-sm text-slate-300">Premium Healthcare Billing</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-slate-400">Invoice No</p>
                    <input type="text" id="invoice_no" name="invoice_no" readonly
                        class="bg-transparent border-b border-slate-500 text-right font-semibold focus:outline-none">

                    <p class="text-sm text-slate-400 mt-2">Date</p>
                    <input type="date" name="invoice_date" value="{{ now()->format('Y-m-d') }}"
                        class="bg-transparent border-b border-slate-500 text-right focus:outline-none">
                </div>
            </div>

            <!-- BODY -->
            <div class="p-10">

                <!-- Patient + Staff -->
                <div class="grid grid-cols-2 gap-10 mb-10">
                    <div>
                        <h3 class="text-xs uppercase tracking-wider text-gray-500 mb-2">Bill To</h3>
                        <select name="patient_id" required
                            class="w-full border-b border-gray-300 focus:outline-none py-2 text-gray-800">
                            <option value="">Select Patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">
                                    {{ $patient->first_name }} {{ $patient->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="text-right">
                        <h3 class="text-xs uppercase tracking-wider text-gray-500 mb-2">Created By</h3>
                        <select name="created_by" required
                            class="w-full border-b border-gray-300 focus:outline-none py-2 text-right text-gray-800">
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Admission -->
                <div class="mb-10">
                    <h3 class="text-xs uppercase tracking-wider text-gray-500 mb-2">Admission</h3>
                    <select name="admission_id"
                        class="w-full border-b border-gray-300 focus:outline-none py-2 text-gray-800">
                        <option value="">Select Admission</option>
                        @foreach($admissions as $admission)
                            <option value="{{ $admission->id }}">{{ $admission->admission_no }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Billing Table -->
                <div class="mb-10">
                    <table class="w-full text-sm border border-gray-200">
                        <thead>
                            <tr class="border-b text-gray-500 uppercase text-xs tracking-wider">
                                <th class="py-3 text-left">Description</th>
                                <th class="py-3 text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800">
                            <tr class="border-b">
                                <td class="py-3">Subtotal</td>
                                <td class="py-3 text-right">
                                    <input type="number" id="subtotal" name="subtotal"
                                        class="w-32 text-right border-b focus:outline-none calc">
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="py-3">Discount</td>
                                <td class="py-3 text-right">
                                    <input type="number" id="discount" name="discount" value="0"
                                        class="w-32 text-right border-b focus:outline-none calc">
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="py-3">Tax</td>
                                <td class="py-3 text-right">
                                    <input type="number" id="tax" name="tax" value="0"
                                        class="w-32 text-right border-b focus:outline-none calc">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Total -->
                <div class="flex justify-end mb-10">
                    <div class="w-72 border-t pt-4">
                        <div class="flex justify-between items-center text-lg font-semibold">
                            <span>Total</span>
                            <input type="number" id="net_total" name="net_total" readonly
                                class="w-32 text-right border-b focus:outline-none font-bold">
                        </div>

                        <div class="mt-6">
                            <label class="text-xs text-gray-500">Status</label>
                            <select name="status"
                                class="w-full border-b border-gray-300 focus:outline-none py-2">
                                <option>Unpaid</option>
                                <option>Partial</option>
                                <option>Paid</option>
                                <option>Cancelled</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="mb-10">
                    <label class="text-xs text-gray-500">Notes</label>
                    <textarea name="notes" rows="2"
                        class="w-full border border-gray-200 rounded-lg p-3 focus:outline-none"></textarea>
                </div>

                <!-- Footer -->
                <div class="flex justify-between items-center border-t pt-6">
                    <div class="flex gap-3">
                        <a href="{{ route('invoices.index') }}" class="text-gray-500 hover:text-gray-800">Cancel</a>

                        <button type="button" onclick="window.print()"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">
                            Print
                        </button>
                    </div>

                    <button type="submit"
                        class="bg-slate-900 hover:bg-black text-white px-6 py-2 rounded-lg shadow">
                        Save Invoice
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<!-- SCRIPT -->
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

function generateInvoiceNo() {
    const now = new Date();
    const unique = now.getFullYear().toString().slice(2) +
                   String(now.getMonth()+1).padStart(2,'0') +
                   String(now.getDate()).padStart(2,'0') +
                   String(now.getHours()).padStart(2,'0') +
                   String(now.getMinutes()).padStart(2,'0') +
                   String(now.getSeconds()).padStart(2,'0');

    document.getElementById('invoice_no').value = 'INV-' + unique;
}

window.onload = function() {
    calc();
    generateInvoiceNo();
};
</script>

@endsection

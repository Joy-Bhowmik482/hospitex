@extends('includePage')

@section('content')

<style>
body {
    font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial;
    background: #f1f5f9;
}

/* PRINT */
@media print {
    @page { size: A4; margin: 18mm; }

    body {
        background: #fff !important;
        color: #000 !important;
    }

    body * { visibility: hidden; }

    #invoiceArea, #invoiceArea * {
        visibility: visible;
    }

    #invoiceArea {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        background: #fff !important;
    }

    button, a { display: none !important; }

    input, select, textarea {
        border: none !important;
        background: transparent !important;
    }

    table, th, td {
        border: 1px solid #000 !important;
    }
}

/* MAIN CARD */
#invoiceArea {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    background: #fff;
}

/* HEADER */
.invoice-header {
    background: linear-gradient(135deg, #0f172a, #1e293b);
    color: #fff;
    padding: 24px 32px;
}

/* INPUT GLOBAL */
input, select, textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    outline: none;
    transition: 0.2s;
}

input:focus, select:focus, textarea:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
}

/* HEADER INPUT FIX */
.header-box input {
    height: 40px;
    text-align: right;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.25);
    color: #fff;
    border-radius: 10px;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    overflow: hidden;
    border-radius: 12px;
}

thead {
    background: #f8fafc;
}

th {
    font-size: 11px;
    text-transform: uppercase;
    color: #64748b;
    padding: 12px;
}

td {
    padding: 12px;
    border-top: 1px solid #e2e8f0;
}

tbody tr:hover {
    background: #f8fafc;
}

/* BUTTONS */
.btn-add {
    background: #16a34a;
    color: #fff;
    padding: 8px 14px;
    border-radius: 10px;
    font-size: 13px;
}

.btn-remove {
    background: #ef4444;
    color: #fff;
    padding: 6px 10px;
    border-radius: 8px;
}

.btn-primary {
    background: #0f172a;
    color: #fff;
    padding: 10px 18px;
    border-radius: 10px;
}

.btn-blue {
    background: #2563eb;
    color: #fff;
    padding: 10px 18px;
    border-radius: 10px;
}

/* BILL BOX */
.bill-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    padding: 18px;
    border-radius: 14px;
}

.bill-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.bill-row span {
    font-size: 14px;
    color: #475569;
}

.bill-row input {
    width: 140px;
    height: 40px;
    text-align: right;
}
</style>

<div class="min-h-screen bg-slate-100 py-10 px-4">

<div id="invoiceArea" class="max-w-5xl mx-auto">

<form action="{{ route('invoices.store') }}" method="POST">
@csrf

<!-- HEADER -->
<div class="invoice-header flex justify-between items-center">

    <div>
        <h1 class="text-xl font-bold tracking-wide">HOSPITAL INVOICE</h1>
        <p class="text-sm text-slate-300">Premium Healthcare Billing System</p>
    </div>

    <!-- FIXED HEADER BOX -->
    <div class="header-box w-56 space-y-3">

        <div>
            <p class="text-xs text-slate-300">Invoice No</p>
            <input type="text" id="invoice_no" name="invoice_no" readonly>
        </div>

        <div>
            <p class="text-xs text-slate-300">Date</p>
            <input type="date" name="invoice_date"
                value="{{ now()->format('Y-m-d') }}">
        </div>

    </div>

</div>

<div class="p-10">

<!-- PATIENT -->
<div class="grid grid-cols-2 gap-8 mb-8">

    <div>
        <label class="text-xs text-gray-500">Patient</label>
        <select name="patient_id">
            <option value="">Select Patient</option>
            @foreach($patients as $patient)
                <option value="{{ $patient->id }}">
                    {{ $patient->first_name }} {{ $patient->last_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="text-right">
        <p class="text-xs text-gray-500">Created By</p>
        <p class="font-medium">{{ auth()->user()->name ?? 'Unknown' }}</p>
    </div>

</div>

<!-- ADMISSION -->
<div class="mb-8">
    <label class="text-xs text-gray-500">Admission</label>
    <select name="admission_id">
        <option value="">Select Admission</option>
        @foreach($admissions as $admission)
            <option value="{{ $admission->id }}">
                {{ $admission->admission_no }}
            </option>
        @endforeach
    </select>
</div>

<!-- SERVICE LIST -->
<div class="mb-8">
    <div class="flex justify-between items-center mb-3">
        <h3 class="font-semibold">Service List</h3>
        <button type="button" onclick="addRow()" class="btn-add">
            + Add Service
        </button>
    </div>

    <table>
        <thead>
            <tr>
                <th>Service</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
                <th></th>
            </tr>
        </thead>

        <tbody id="serviceBody"></tbody>
    </table>
</div>

<!-- BILL -->
<div class="flex justify-end mb-6">

<div class="bill-box w-80">

    <div class="bill-row">
        <span>Subtotal</span>
        <input id="subtotal" name="subtotal" readonly>
    </div>

    <div class="bill-row">
        <span>Discount</span>
        <input id="discount" name="discount" value="0" class="calc">
    </div>

    <div class="bill-row">
        <span>Tax</span>
        <input id="tax" name="tax" value="0" class="calc">
    </div>

    <hr class="my-3">

    <div class="bill-row font-bold text-lg">
        <span>Total</span>
        <input id="net_total" name="net_total" readonly>
    </div>

</div>

</div>

<!-- STATUS -->
<div class="mb-6">
    <select name="status">
        <option>Unpaid</option>
        <option>Partial</option>
        <option>Paid</option>
        <option>Cancelled</option>
    </select>
</div>

<!-- NOTES -->
<div class="mb-6">
    <textarea name="notes" rows="3" placeholder="Notes..."></textarea>
</div>

<!-- FOOTER -->
<div class="flex justify-between">

    <a href="{{ route('invoices.index') }}">Cancel</a>

    <div class="flex gap-3">
        <button type="button" onclick="window.print()" class="btn-blue">
            Print
        </button>

        <button type="submit" class="btn-primary">
            Save Invoice
        </button>
    </div>

</div>

</div>
</form>

</div>
</div>

<script>
let services = @json($services);

function addRow(){
    let row = document.createElement('tr');

    let options = services.map(s =>
        `<option value="${s.id}" data-price="${s.price}">${s.name}</option>`
    ).join('');

    row.innerHTML = `
        <td>
            <select onchange="setPrice(this)">
                <option value="">Select</option>
                ${options}
            </select>
        </td>

        <td><input class="price" readonly></td>

        <td><input value="1" class="qty" oninput="calcRow(this)"></td>

        <td><input class="rowTotal" readonly></td>

        <td><button type="button" class="btn-remove" onclick="removeRow(this)">X</button></td>
    `;

    document.getElementById('serviceBody').appendChild(row);
}

function setPrice(el){
    let price = el.options[el.selectedIndex].dataset.price;
    let row = el.closest('tr');

    row.querySelector('.price').value = price;
    calcRow(el);
}

function calcRow(el){
    let row = el.closest('tr');

    let price = parseFloat(row.querySelector('.price').value) || 0;
    let qty = parseFloat(row.querySelector('.qty').value) || 0;

    row.querySelector('.rowTotal').value = (price * qty).toFixed(2);

    calcAll();
}

function removeRow(btn){
    btn.closest('tr').remove();
    calcAll();
}

function calcAll(){
    let sum = 0;

    document.querySelectorAll('.rowTotal').forEach(i=>{
        sum += parseFloat(i.value) || 0;
    });

    document.getElementById('subtotal').value = sum.toFixed(2);

    let discount = parseFloat(document.getElementById('discount').value) || 0;
    let tax = parseFloat(document.getElementById('tax').value) || 0;

    document.getElementById('net_total').value =
        (sum - discount + tax).toFixed(2);
}

document.querySelectorAll('.calc').forEach(i=>{
    i.addEventListener('input', calcAll);
});

function generateInvoiceNo(){
    let now = new Date();
    document.getElementById('invoice_no').value =
        "INV-" + now.getTime();
}

window.onload = function(){
    generateInvoiceNo();
    addRow();
    calcAll();
};
</script>

@endsection
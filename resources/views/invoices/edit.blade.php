@extends('includePage')

@section('content')

<style>
:root {
    --ink:#0b1220;
    --muted:#64748b;
    --line:#e5e7eb;
    --soft:#f8fafc;
    --brand:#0f766e;
    --brand-2:#0d9488;
    --accent:#0ea5e9;
    --bg:#eef2f7;
}

body {
    font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial;
    background: var(--bg);
}

/* MAIN CARD */
#invoiceArea {
    max-width: 1080px;
    margin: 32px auto;
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 20px 50px -20px rgba(0,0,0,.15);
}

/* HEADER */
.letterhead {
    display:grid;
    grid-template-columns: 1.4fr 1fr;
    gap: 24px;
    padding: 28px 40px;
    background: linear-gradient(135deg, var(--brand), var(--brand-2));
    color:#fff;
}

.brand {
    display:flex;
    gap:14px;
    align-items:center;
}

.brand-logo {
    width:54px;
    height:54px;
    border-radius:14px;
    background: rgba(255,255,255,.15);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:24px;
    font-weight:800;
}

.brand-title { font-size:22px; font-weight:800; }
.brand-sub { font-size:12px; opacity:.85; }

.meta-grid {
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:10px;
}

.meta-grid input {
    height:36px;
    border-radius:8px;
    border:1px solid rgba(255,255,255,.25);
    background: rgba(255,255,255,.12);
    color:#fff;
    padding:0 10px;
}

/* BODY */
.invoice-body {
    padding: 28px 40px;
}

.row-2 {
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:24px;
}

.panel {
    border:1px solid var(--line);
    border-radius:12px;
    padding:16px;
}

.panel-title {
    font-size:11px;
    text-transform:uppercase;
    color:var(--muted);
    margin-bottom:10px;
    letter-spacing:.1em;
}

label {
    font-size:12px;
    color:var(--muted);
    margin-bottom:6px;
    display:block;
}

input, select, textarea {
    width:100%;
    padding:10px;
    border:1px solid var(--line);
    border-radius:10px;
}

/* TABLE */
.table-wrap {
    border:1px solid var(--line);
    border-radius:12px;
    overflow:hidden;
    margin-top:12px;
}

table {
    width:100%;
    border-collapse:collapse;
}

thead {
    background: var(--soft);
}

th {
    font-size:11px;
    text-transform:uppercase;
    padding:12px;
    text-align:left;
    color:var(--muted);
}

td {
    padding:10px;
    border-top:1px solid var(--line);
}

.row-index {
    text-align:center;
}

/* BUTTONS */
.btn {
    padding:8px 12px;
    border-radius:10px;
    border:none;
    cursor:pointer;
    font-weight:600;
}

.btn-add { background: var(--brand); color:#fff; }
.btn-remove { background:#fee2e2; color:#b91c1c; }

/* SUMMARY */
.summary {
    margin-top:24px;
    display:grid;
    grid-template-columns:1fr 340px;
    gap:24px;
}

.totals {
    border:1px solid var(--line);
    border-radius:12px;
    padding:16px;
}

.totals-row {
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:8px 0;
}

.totals-row input {
    width:160px;
    text-align:right;
}

.totals-row.grand {
    border-top:1px dashed var(--line);
    margin-top:10px;
    padding-top:10px;
    font-weight:800;
}

/* ACTIONS */
.actions {
    display:flex;
    justify-content:flex-end;
    gap:10px;
    padding:20px 40px;
    border-top:1px solid var(--line);
}

.btn-primary { background:#111827; color:#fff; }
.btn-blue { background: var(--accent); color:#fff; }
.btn-ghost { background:#eef2f7; }
</style>

<div id="invoiceArea">

<form method="POST" action="{{ route('invoices.update', $invoice) }}">
@csrf
@method('PUT')

<!-- HEADER -->
<div class="letterhead">

    <div class="brand">
        <div class="brand-logo">+</div>
        <div>
            <div class="brand-title">HOSPITEX</div>
            <div class="brand-sub">Edit Invoice System</div>
        </div>
    </div>

    <div class="meta-grid">
        <input name="invoice_no" value="{{ $invoice->invoice_no }}">
        <input type="date" name="invoice_date"
               value="{{ $invoice->invoice_date->format('Y-m-d') }}">
    </div>

</div>

<div class="invoice-body">

<!-- PATIENT -->
<div class="row-2">

    <div class="panel">
        <div class="panel-title">Bill To</div>

        <label>Patient</label>
        <select name="patient_id">
            @foreach($patients as $p)
                <option value="{{ $p->id }}"
                    {{ $invoice->patient_id == $p->id ? 'selected' : '' }}>
                    {{ $p->first_name }} {{ $p->last_name }}
                </option>
            @endforeach
        </select>

        <label style="margin-top:10px;">Admission</label>
        <select name="admission_id">
            <option value="">None</option>
            @foreach($admissions as $a)
                <option value="{{ $a->id }}"
                    {{ $invoice->admission_id == $a->id ? 'selected' : '' }}>
                    {{ $a->admission_no }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="panel">
        <div class="panel-title">Invoice Info</div>

        <label>Status</label>
        <select name="status">
            @foreach(['Unpaid','Partial','Paid','Cancelled'] as $s)
                <option value="{{ $s }}"
                    {{ $invoice->status == $s ? 'selected' : '' }}>
                    {{ $s }}
                </option>
            @endforeach
        </select>

        <label style="margin-top:10px;">Department</label>
        <input name="department" value="{{ $invoice->department }}">
    </div>

</div>

<!-- SERVICES -->
<div style="margin-top:24px;">
    <div style="display:flex;justify-content:space-between;align-items:center;">
        <h3 style="font-size:14px;font-weight:800;">Service List</h3>
        <button type="button" class="btn btn-add" onclick="addRow()">+ Add Service</button>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
            <tr>
                <th>#</th>
                <th>Service</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
                <th></th>
            </tr>
            </thead>

            <tbody id="serviceBody">

            @foreach($invoice->items ?? [] as $i => $item)
                <tr>
                    <td class="row-index">{{ $i+1 }}</td>

                    <td>
                        <select name="services[{{ $i }}][id]" onchange="setPrice(this)">
                            <option value="">Select</option>
                            @foreach($services as $s)
                                <option value="{{ $s->id }}"
                                        data-price="{{ $s->price }}"
                                        {{ $item->ref_id == $s->id ? 'selected' : '' }}>
                                    {{ $s->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>

                    <td>
                        <input class="price"
                               name="services[{{ $i }}][price]"
                               value="{{ $item->rate }}" readonly>
                    </td>

                    <td>
                        <input class="qty"
                               name="services[{{ $i }}][qty]"
                               value="{{ $item->qty }}"
                               oninput="calcRow(this)">
                    </td>

                    <td>
                        <input class="rowTotal"
                               value="{{ $item->rate * $item->qty }}"
                               readonly>
                    </td>

                    <td>
                        <button type="button" class="btn-remove" onclick="removeRow(this)">X</button>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
</div>

<!-- SUMMARY -->
<div class="summary">

    <div class="panel">
        <div class="panel-title">Notes</div>
        <textarea name="notes">{{ $invoice->notes }}</textarea>
    </div>

    <div class="totals">

        <div class="totals-row">
            <span>Subtotal</span>
            <input id="subtotal" name="subtotal" value="{{ $invoice->subtotal }}" readonly>
        </div>

        <div class="totals-row">
            <span>Discount</span>
            <input id="discount" name="discount" value="{{ $invoice->discount }}" class="calc">
        </div>

        <div class="totals-row">
            <span>Tax</span>
            <input id="tax" name="tax" value="{{ $invoice->tax }}" class="calc">
        </div>

        <div class="totals-row grand">
            <span>Total</span>
            <input id="net_total" name="net_total" value="{{ $invoice->net_total }}" readonly>
        </div>

    </div>

</div>

</div>

<div class="actions">
    <a href="{{ route('invoices.index') }}" class="btn btn-ghost">Cancel</a>
    <button class="btn btn-blue">Update</button>
</div>

</form>

</div>

<script>
let index = {{ count($invoice->items ?? []) }};

function addRow() {
    const tbody = document.getElementById('serviceBody');

    const row = document.createElement('tr');

    const options = @json($services).map(s =>
        `<option value="${s.id}" data-price="${s.price}">${s.name}</option>`
    ).join('');

    row.innerHTML = `
        <td class="row-index">${index+1}</td>
        <td>
            <select name="services[${index}][id]" onchange="setPrice(this)">
                <option value="">Select</option>
                ${options}
            </select>
        </td>
        <td><input class="price" name="services[${index}][price]" readonly></td>
        <td><input class="qty" name="services[${index}][qty]" value="1" oninput="calcRow(this)"></td>
        <td><input class="rowTotal" readonly></td>
        <td><button type="button" class="btn-remove" onclick="removeRow(this)">X</button></td>
    `;

    tbody.appendChild(row);
    index++;
}

function setPrice(el) {
    const price = el.selectedOptions[0].dataset.price || 0;
    const row = el.closest('tr');

    row.querySelector('.price').value = price;
    calcRow(el);
}

function calcRow(el) {
    const row = el.closest('tr');
    const price = parseFloat(row.querySelector('.price').value) || 0;
    const qty = parseFloat(row.querySelector('.qty').value) || 0;

    row.querySelector('.rowTotal').value = (price * qty).toFixed(2);

    calcAll();
}

function removeRow(btn) {
    btn.closest('tr').remove();
    calcAll();
}

function calcAll() {
    let sum = 0;

    document.querySelectorAll('.rowTotal').forEach(el => {
        sum += parseFloat(el.value) || 0;
    });

    document.getElementById('subtotal').value = sum.toFixed(2);

    const discount = parseFloat(document.getElementById('discount').value) || 0;
    const tax = parseFloat(document.getElementById('tax').value) || 0;

    document.getElementById('net_total').value =
        (sum - discount + tax).toFixed(2);
}

document.addEventListener('input', e => {
    if (e.target.classList.contains('calc')) calcAll();
});
</script>

@endsection
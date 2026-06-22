@extends('includePage')

@section('content')

<style>
    body {
        font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
        background: #f1f5f9;
    }

    /* ---------- SCREEN STYLES ---------- */
    #invoiceArea {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        background: #fff;
        max-width: 1100px;
        margin: 30px auto;
    }

    .invoice-header {
        background: linear-gradient(135deg, #0f172a, #1e293b);
        color: #fff;
        padding: 28px 36px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }

    .invoice-header h1 { font-size: 26px; font-weight: 800; letter-spacing: .3px; }
    .invoice-header p  { font-size: 13px; opacity: .8; margin-top: 4px; }

    .header-box { display: flex; flex-direction: column; gap: 8px; min-width: 240px; }
    .header-box label { font-size: 11px; text-transform: uppercase; opacity:.75; }
    .header-box input {
        height: 38px; text-align: right;
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.25);
        color: #fff; border-radius: 10px; padding: 0 12px;
    }

    .invoice-body { padding: 28px 36px; }

    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    .grid-3 { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 18px; }

    .field label { display:block; font-size: 12px; color:#475569; margin-bottom:6px; font-weight:600; }
    input, select, textarea {
        width: 100%; padding: 10px 12px;
        border: 1px solid #e2e8f0; border-radius: 10px;
        outline: none; transition: .2s; background:#fff;
    }
    input:focus, select:focus, textarea:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
    }

    .section-title {
        display:flex; justify-content:space-between; align-items:center;
        margin: 24px 0 12px;
    }
    .section-title h3 { font-size: 16px; font-weight:700; color:#0f172a; }

    table { width: 100%; border-collapse: collapse; border-radius: 12px; overflow:hidden; }
    thead { background: #f8fafc; }
    th { font-size: 11px; text-transform: uppercase; color:#64748b; padding:12px; text-align:left; }
    td { padding: 10px 12px; border-top: 1px solid #e2e8f0; vertical-align: middle; }
    tbody tr:hover { background: #f8fafc; }

    .btn-add    { background:#16a34a; color:#fff; padding:8px 14px; border-radius:10px; font-size:13px; border:none; cursor:pointer; }
    .btn-remove { background:#ef4444; color:#fff; padding:6px 10px;  border-radius:8px;  border:none; cursor:pointer; }
    .btn-primary{ background:#0f172a; color:#fff; padding:10px 18px; border-radius:10px; border:none; cursor:pointer; }
    .btn-blue   { background:#2563eb; color:#fff; padding:10px 18px; border-radius:10px; border:none; cursor:pointer; }
    .btn-ghost  { background:#e2e8f0; color:#0f172a; padding:10px 18px; border-radius:10px; border:none; cursor:pointer; }

    .summary {
        margin-top: 24px;
        display: grid; grid-template-columns: 1fr 320px; gap: 24px;
    }
    .bill-box {
        background:#f8fafc; border:1px solid #e2e8f0;
        padding:18px; border-radius:14px;
    }
    .bill-row {
        display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;
    }
    .bill-row span { font-size:14px; color:#475569; }
    .bill-row input { width:150px; height:38px; text-align:right; }
    .bill-row.total {
        border-top: 2px dashed #cbd5e1; padding-top:12px; margin-top:12px;
    }
    .bill-row.total span { font-size:16px; font-weight:800; color:#0f172a; }
    .bill-row.total input{ font-size:16px; font-weight:800; color:#0f172a; }

    .actions {
        display:flex; justify-content:flex-end; gap:10px;
        padding: 20px 36px 28px; background:#fff;
    }

    /* Hospital identity that's hidden on screen, shown only when printing */
    .print-only { display: none; }

    /* ---------- PRINT STYLES ---------- */
    @media print {
        /* Hide everything from the host layout (sidebar, navbar, footer) */
        body * { visibility: hidden !important; }

        /* Then reveal only the invoice */
        #printArea, #printArea * { visibility: visible !important; }

        /* Position the invoice as the whole page */
        #printArea {
            position: absolute;
            inset: 0;
            margin: 0;
            padding: 24px 28px;
            width: 100%;
            background: #fff !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            color:#000;
        }

        /* Strip screen-only chrome inside the invoice */
        .no-print { display: none !important; }
        .invoice-header {
            background: #fff !important;
            color: #000 !important;
            border-bottom: 2px solid #000;
            padding: 0 0 12px 0 !important;
            display: block !important;
        }
        .invoice-body { padding: 12px 0 !important; }
        .actions     { display: none !important; }

        .print-only { display: block !important; text-align:center; margin-bottom: 8px; }
        .print-only .hospital-name { font-size: 26px; font-weight: 800; }
        .print-only .hospital-sub  { font-size: 12px; color:#333; }
        .print-only .invoice-title {
            margin-top: 10px; font-size: 20px; font-weight: 800;
            text-decoration: underline; letter-spacing:.5px;
        }

        /* Flatten inputs to plain text so the print looks like a real document */
        input, select, textarea {
            border: none !important;
            background: transparent !important;
            padding: 2px 0 !important;
            color: #000 !important;
            box-shadow: none !important;
            -webkit-appearance: none; appearance: none;
            text-align: left !important;
        }
        .bill-row input { text-align: right !important; }
        select { appearance: none; }

        table, th, td { border: 1px solid #000 !important; }
        thead { background: #f1f1f1 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        th { color:#000 !important; }

        .summary { grid-template-columns: 1fr 300px !important; }
        .bill-box { background:#fff !important; border:1px solid #000 !important; }

        @page { size: A4; margin: 14mm; }
    }
</style>

<div id="printArea">
    <div id="invoiceArea">

        {{-- Shown only on print --}}
        <div class="print-only">
            <div class="hospital-name">PREMIUM HEALTHCARE HOSPITAL</div>
            <div class="hospital-sub">123 Wellness Avenue · Phone: +000 000 000 · info@hospital.com</div>
            <div class="invoice-title">PATIENT INVOICE</div>
        </div>

        {{-- HEADER (screen) --}}
        <div class="invoice-header">
            <div>
                <h1>HOSPITAL INVOICE</h1>
                <p>Premium Healthcare Billing System</p>
            </div>

            <div style="display:flex; gap:16px; flex-wrap:wrap;">
                <div class="header-box">
                    <label>Invoice No</label>
                    <input type="text" id="invoice_no" readonly>
                </div>
                <div class="header-box">
                    <label>Date</label>
                    <input type="date" id="invoice_date" value="{{ date('Y-m-d') }}">
                </div>
            </div>
        </div>

        <form id="invoiceForm" method="POST" action="">
            @csrf
            <div class="invoice-body">

                {{-- PATIENT / USER --}}
                <div class="grid-2">
                    <div class="field">
                        <label>Patient</label>
                        <select name="patient_id" required>
                            <option value="">Select Patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">
                                    {{ $patient->first_name }} {{ $patient->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label>Created By</label>
                        <input type="text" value="{{ auth()->user()->name ?? 'Unknown' }}" readonly>
                    </div>
                </div>

                {{-- ADMISSION --}}
                <div class="field" style="margin-top:18px;">
                    <label>Admission</label>
                    <select name="admission_id">
                        <option value="">Select Admission</option>
                        @foreach($admissions as $admission)
                            <option value="{{ $admission->id }}">{{ $admission->admission_no }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- SERVICES --}}
                <div class="section-title">
                    <h3>Service List</h3>
                    <button type="button" class="btn-add no-print" onclick="addRow()">+ Add Service</button>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th style="width:45%">Service</th>
                            <th style="width:15%">Price</th>
                            <th style="width:10%">Qty</th>
                            <th style="width:20%">Total</th>
                            <th style="width:10%" class="no-print"></th>
                        </tr>
                    </thead>
                    <tbody id="serviceBody"></tbody>
                </table>

                {{-- SUMMARY --}}
                <div class="summary">
                    <div class="field">
                        <label>Notes</label>
                        <textarea name="notes" rows="5" placeholder="Optional notes..."></textarea>

                        <div style="margin-top:14px;">
                            <label style="font-size:12px; color:#475569; font-weight:600;">Payment Status</label>
                            <select name="payment_status">
                                <option value="unpaid">Unpaid</option>
                                <option value="partial">Partial</option>
                                <option value="paid">Paid</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>

                    <div class="bill-box">
                        <div class="bill-row">
                            <span>Subtotal</span>
                            <input id="subtotal" readonly>
                        </div>
                        <div class="bill-row">
                            <span>Discount</span>
                            <input id="discount" class="calc" value="0">
                        </div>
                        <div class="bill-row">
                            <span>Tax</span>
                            <input id="tax" class="calc" value="0">
                        </div>
                        <div class="bill-row total">
                            <span>Total</span>
                            <input id="net_total" readonly>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ACTIONS (screen only) --}}
            <div class="actions no-print">
                <button type="button" class="btn-ghost" onclick="history.back()">Cancel</button>
                <button type="button" class="btn-blue" onclick="window.print()">🖨 Print Invoice</button>
                <button type="submit" class="btn-primary">Save Invoice</button>
            </div>
        </form>
    </div>
</div>

<script>
    const services = @json($services);

    function addRow() {
        const row = document.createElement('tr');
        const options = services.map(s =>
            `<option value="${s.id}" data-price="${s.price}">${s.name}</option>`
        ).join('');

        row.innerHTML = `
            <td>
                <select name="services[][id]" onchange="setPrice(this)">
                    <option value="">Select Service</option>
                    ${options}
                </select>
            </td>
            <td><input class="price" name="services[][price]" readonly></td>
            <td><input class="qty"   name="services[][qty]" value="1" oninput="calcRow(this)"></td>
            <td><input class="rowTotal" readonly></td>
            <td class="no-print">
                <button type="button" class="btn-remove" onclick="removeRow(this)">X</button>
            </td>
        `;
        document.getElementById('serviceBody').appendChild(row);
    }

    function setPrice(el) {
        const price = el.options[el.selectedIndex].dataset.price || 0;
        const row = el.closest('tr');
        row.querySelector('.price').value = price;
        calcRow(el);
    }

    function calcRow(el) {
        const row = el.closest('tr');
        const price = parseFloat(row.querySelector('.price').value) || 0;
        const qty   = parseFloat(row.querySelector('.qty').value)   || 0;
        row.querySelector('.rowTotal').value = (price * qty).toFixed(2);
        calcAll();
    }

    function removeRow(btn) {
        btn.closest('tr').remove();
        calcAll();
    }

    function calcAll() {
        let sum = 0;
        document.querySelectorAll('.rowTotal').forEach(i => sum += parseFloat(i.value) || 0);
        document.getElementById('subtotal').value = sum.toFixed(2);

        const discount = parseFloat(document.getElementById('discount').value) || 0;
        const tax      = parseFloat(document.getElementById('tax').value) || 0;
        document.getElementById('net_total').value = (sum - discount + tax).toFixed(2);
    }

    document.addEventListener('input', e => {
        if (e.target.classList.contains('calc')) calcAll();
    });

    function generateInvoiceNo() {
        document.getElementById('invoice_no').value = "INV-" + Date.now();
    }

    window.onload = function () {
        generateInvoiceNo();
        addRow();
        calcAll();
    };
</script>

@endsection

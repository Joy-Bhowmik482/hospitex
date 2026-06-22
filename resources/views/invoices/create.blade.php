@extends('includePage')

@section('content')

<style>
    :root {
        --ink:#0b1220;
        --ink-2:#1f2937;
        --muted:#64748b;
        --line:#e5e7eb;
        --soft:#f8fafc;
        --brand:#0f766e;       /* deep teal — medical, trustworthy */
        --brand-2:#0d9488;
        --accent:#0ea5e9;
        --bg:#eef2f7;
    }

    body {
        font-family: "Inter", ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
        background: var(--bg);
        color: var(--ink);
    }

    /* ---------- CARD ---------- */
    #invoiceArea {
        max-width: 1080px;
        margin: 32px auto;
        background: #fff;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 20px 50px -20px rgba(2,12,27,.18), 0 2px 6px rgba(2,12,27,.05);
    }

    /* ---------- LETTERHEAD ---------- */
    .letterhead {
        display:grid;
        grid-template-columns: 1.4fr 1fr;
        gap: 24px;
        padding: 28px 40px;
        background: linear-gradient(135deg, var(--brand) 0%, var(--brand-2) 100%);
        color:#fff;
    }
    .brand {
        display:flex; align-items:center; gap:14px;
    }
    .brand-logo {
        width:54px; height:54px; border-radius:14px;
        background: rgba(255,255,255,.15);
        display:flex; align-items:center; justify-content:center;
        font-size:26px; font-weight:800; letter-spacing:.5px;
        border:1px solid rgba(255,255,255,.3);
    }
    .brand-title { font-size: 22px; font-weight: 800; letter-spacing:.3px; }
    .brand-sub   { font-size: 12px; opacity:.85; margin-top:2px; }

    .meta-grid {
        display:grid; grid-template-columns: 1fr 1fr; gap:10px 16px;
        align-self:center;
    }
    .meta-grid label {
        font-size: 10px; text-transform: uppercase; letter-spacing:.08em; opacity:.8;
        display:block; margin-bottom:4px;
    }
    .meta-grid input, .meta-grid select {
        height: 36px; padding: 0 12px;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.25);
        color: #fff; border-radius: 8px; width:100%;
        font-size: 13px;
    }
    .meta-grid input::placeholder { color: rgba(255,255,255,.6); }

    /* ---------- BODY ---------- */
    .invoice-body { padding: 28px 40px 8px; }

    .row-2 { display:grid; grid-template-columns: 1fr 1fr; gap: 28px; }
    .row-3 { display:grid; grid-template-columns: 2fr 1fr 1fr; gap: 18px; }

    .panel-title {
        font-size: 11px; text-transform: uppercase; letter-spacing:.1em;
        color: var(--muted); font-weight: 700; margin-bottom: 10px;
    }
    .panel {
        border: 1px solid var(--line);
        border-radius: 12px;
        padding: 16px 18px;
        background: #fff;
    }

    .field label {
        display:block; font-size: 12px; color:var(--muted);
        margin-bottom:6px; font-weight:600;
    }
    input, select, textarea {
        width: 100%; padding: 10px 12px;
        border: 1px solid var(--line); border-radius: 10px;
        background:#fff; color: var(--ink); font-size: 14px;
        outline: none; transition: border-color .15s, box-shadow .15s;
    }
    input:focus, select:focus, textarea:focus {
        border-color: var(--brand);
        box-shadow: 0 0 0 3px color-mix(in oklab, var(--brand) 18%, transparent);
    }

    /* ---------- SECTION TITLE ---------- */
    .section-title {
        display:flex; justify-content:space-between; align-items:center;
        margin: 28px 0 12px;
    }
    .section-title h3 {
        font-size: 14px; font-weight: 800;
        text-transform: uppercase; letter-spacing:.08em; color: var(--ink);
    }

    /* ---------- TABLE ---------- */
    .table-wrap {
        border: 1px solid var(--line);
        border-radius: 12px; overflow: hidden;
    }
    table { width: 100%; border-collapse: collapse; }
    thead { background: var(--soft); }
    th {
        font-size: 11px; text-transform: uppercase; letter-spacing:.08em;
        color: var(--muted); padding: 12px 14px; text-align: left; font-weight: 700;
    }
    td { padding: 10px 14px; border-top: 1px solid var(--line); vertical-align: middle; }
    tbody tr:nth-child(even) { background: #fbfdff; }
    tbody tr:hover { background: #f4f8fb; }
    td input, td select { border: 1px solid transparent; background: transparent; }
    td input:hover, td select:hover { border-color: var(--line); background:#fff; }
    td input.rowTotal { font-weight: 700; color: var(--ink); }

    /* ---------- BUTTONS ---------- */
    .btn        { padding:10px 16px; border-radius:10px; font-size:13px; font-weight:600; border:none; cursor:pointer; transition: transform .05s ease, filter .15s ease; }
    .btn:hover  { filter: brightness(1.05); }
    .btn:active { transform: translateY(1px); }
    .btn-add    { background: var(--brand); color:#fff; }
    .btn-remove { background:#fee2e2; color:#b91c1c; padding:6px 10px; border-radius:8px; font-size:12px; }
    .btn-primary{ background: var(--ink); color:#fff; }
    .btn-blue   { background: var(--accent); color:#fff; }
    .btn-ghost  { background: #eef2f7; color: var(--ink-2); }

    /* ---------- SUMMARY ---------- */
    .summary {
        margin-top: 24px;
        display: grid; grid-template-columns: 1fr 340px; gap: 28px;
    }
    .totals {
        background: linear-gradient(180deg, #f8fafc, #fff);
        border: 1px solid var(--line);
        border-radius: 14px; padding: 18px 20px;
    }
    .totals-row {
        display:flex; justify-content:space-between; align-items:center;
        padding: 8px 0; font-size: 14px; color: var(--ink-2);
    }
    .totals-row input { width: 140px; height: 36px; text-align: right; }
    .totals-row.grand {
        margin-top: 8px; padding-top: 14px;
        border-top: 1px dashed #cbd5e1;
    }
    .totals-row.grand span { font-size: 15px; font-weight: 800; color: var(--ink); text-transform: uppercase; letter-spacing:.06em; }
    .totals-row.grand input {
        height: 44px; font-size: 18px; font-weight: 800; color: var(--brand);
        border-color: color-mix(in oklab, var(--brand) 30%, var(--line));
        background: #fff;
    }

    .status-badge {
        display:inline-flex; align-items:center; gap:6px;
        padding: 4px 10px; border-radius: 999px;
        font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing:.06em;
        background: #fef3c7; color:#92400e;
    }

    /* ---------- ACTIONS ---------- */
    .actions {
        display:flex; justify-content:flex-end; gap:10px;
        padding: 18px 40px 28px;
        border-top: 1px solid var(--line); background: #fff;
    }

    .print-only { display: none; }

    /* ---------- PRINT ---------- */
    @media print {
        @page { size: A4; margin: 14mm; }

        body * { visibility: hidden !important; }
        #printArea, #printArea * { visibility: visible !important; }

        body { background:#fff !important; }
        #printArea {
            position: absolute; inset: 0;
            margin: 0; padding: 0; width: 100%;
            background:#fff !important;
        }
        #invoiceArea {
            margin: 0; box-shadow: none !important;
            border-radius: 0 !important; max-width: 100%;
        }

        .no-print, .actions { display: none !important; }

        /* Replace gradient header with a clean print letterhead */
        .letterhead { display: none !important; }
        .print-only {
            display: block !important;
            padding: 0 0 14px 0;
            border-bottom: 2px solid var(--ink);
            margin-bottom: 18px;
        }
        .print-only .ph-top {
            display:flex; justify-content:space-between; align-items:flex-start; gap:24px;
        }
        .print-only .ph-name { font-size: 22px; font-weight: 800; letter-spacing:.3px; }
        .print-only .ph-sub  { font-size: 11px; color:#555; margin-top: 2px; }
        .print-only .ph-meta { font-size: 12px; text-align: right; line-height: 1.6; }
        .print-only .ph-meta b { display:inline-block; min-width: 88px; color:#000; }
        .print-only .ph-title {
            text-align:center; margin-top: 14px;
            font-size: 16px; font-weight: 800; letter-spacing:.18em;
            text-transform: uppercase;
        }

        .invoice-body { padding: 0 !important; }
        .panel { border:1px solid #cbd5e1 !important; box-shadow:none !important; }

        /* Flatten inputs to printed text */
        input, select, textarea {
            border: none !important; background: transparent !important;
            padding: 2px 0 !important; color: #000 !important;
            box-shadow: none !important; -webkit-appearance: none; appearance: none;
            font-size: 13px !important;
        }
        td input, td select {
            border: none !important; background: transparent !important;
        }

        .table-wrap { border:1px solid #000 !important; border-radius: 0 !important; }
        table, th, td { border: 1px solid #000 !important; }
        thead { background:#f1f1f1 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        th { color:#000 !important; }
        tbody tr:nth-child(even) { background:#fafafa !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }

        .summary { grid-template-columns: 1fr 320px !important; gap: 18px !important; margin-top: 18px !important; }
        .totals { background:#fff !important; border:1px solid #000 !important; border-radius: 0 !important; }
        .totals-row.grand input { color:#000 !important; border:none !important; }

        .section-title h3 { color:#000 !important; }

        .footer-print {
            display:block !important;
            margin-top: 28px; padding-top: 14px;
            border-top: 1px solid #999;
            font-size: 11px; color:#333; text-align:center;
        }
    }
    .footer-print { display: none; }
</style>

<div id="printArea">
    <div id="invoiceArea">

        {{-- ===== PRINT-ONLY LETTERHEAD ===== --}}
        <div class="print-only">
            <div class="ph-top">
                <div>
                    <div class="ph-name">HOSPITEX</div>
                    <div class="ph-sub">123 Wellness Avenue, City · Tel: +000 000 0000 · info@hospital.com</div>
                    <div class="ph-sub">License No: HC-998877 · Tax ID: 12-3456789</div>
                </div>
                <div class="ph-meta">
                    <div><b>Invoice No:</b> <span id="print_invoice_no"></span></div>
                    <div><b>Date:</b> <span id="print_invoice_date"></span></div>
                    <div><b>Issued By:</b> {{ auth()->user()->name ?? 'Unknown' }}</div>
                </div>
            </div>
            <div class="ph-title">Patient Invoice</div>
        </div>
 <form id="invoiceForm" method="POST" action="{{ route('invoices.store') }}">
    @csrf
        {{-- ===== SCREEN LETTERHEAD ===== --}}
        <div class="letterhead no-print">
            <div class="brand">
                <div class="brand-logo">+</div>
                <div>
                    <div class="brand-title">HOSPITEX</div>
                    <div class="brand-sub">Patient Billing &amp; Invoicing System</div>
                </div>
            </div>
            <div class="meta-grid">
                <div>
                    <label>Invoice No</label>
                    <input type="text" id="invoice_no" name="invoice_no" readonly>
                </div>
                <div>
                    <label>Date</label>
                    <input type="date" id="invoice_date" name="invoice_date" value="{{ date('Y-m-d') }}" required>
                </div>
            </div>
        </div>

       
           

            <div class="invoice-body">

                {{-- ===== PATIENT / ADMISSION ===== --}}
                <div class="row-2">
                    <div class="panel">
                        <div class="panel-title">Bill To</div>
                        <div class="field" style="margin-bottom:12px;">
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
                            <label>Admission</label>
                            <select name="admission_id">
                                <option value="">Select Admission</option>
                                @foreach($admissions as $admission)
                                    <option value="{{ $admission->id }}">{{ $admission->admission_no }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-title">Invoice Info</div>
                        <div class="row-2" style="gap:12px;">
                            <div class="field">
                                <label>Issued By</label>
                                <input type="text" value="{{ auth()->user()->name ?? 'Unknown' }}" readonly>
                            </div>
                            <div class="field">
                                <label>Payment Status</label>
                                <select name="status" id="payment_status">
                                    <option value="unpaid">Unpaid</option>
                                    <option value="partial">Partial</option>
                                    <option value="paid">Paid</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>
                        <div class="field" style="margin-top:12px;">
                            <label>Department</label>
                            <input type="text" name="department" placeholder="e.g. Cardiology">
                        </div>
                    </div>
                </div>

                {{-- ===== SERVICES ===== --}}
                <div class="section-title">
                    <h3>Service List</h3>
                    <button type="button" class="btn btn-add no-print" onclick="addRow()">+ Add Service</button>
                </div>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:8%">#</th>
                                <th style="width:42%">Service Description</th>
                                <th style="width:14%; text-align:right;">Unit Price</th>
                                <th style="width:10%; text-align:center;">Qty</th>
                                <th style="width:18%; text-align:right;">Amount</th>
                                <th style="width:8%" class="no-print"></th>
                            </tr>
                        </thead>
                        <tbody id="serviceBody"></tbody>
                    </table>
                </div>

                {{-- ===== SUMMARY ===== --}}
                <div class="summary">
                    <div class="panel">
                        <div class="panel-title">Notes</div>
                        <textarea name="notes" rows="6" placeholder="Optional notes, instructions, or remarks..."></textarea>
                    </div>

                    <div class="totals">
                        <div class="totals-row">
                            <span>Subtotal</span>
                            <input name="subtotal" id="subtotal" readonly>
                        </div>
                        <div class="totals-row">
                            <span>Discount</span>
                            <input name="discount" id="discount" class="calc" value="0">
                        </div>
                        <div class="totals-row">
                            <span>Tax</span>
                            <input name="tax" id="tax" class="calc" value="0">
                        </div>
                        <div class="totals-row grand">
                            <span>Total Due</span>
                            <input name="net_total" id="net_total" readonly>
                        </div>
                    </div>
                </div>

                <div class="footer-print">
                    Thank you for choosing Premium Healthcare Hospital · This is a computer-generated invoice and does not require a signature.
                </div>
            </div>

            {{-- ===== ACTIONS ===== --}}
            <div class="actions no-print">
                <button type="button" class="btn btn-ghost" onclick="history.back()">Cancel</button>
                <button type="button" class="btn btn-blue" onclick="printInvoice()">🖨 Print Invoice</button>
                <button type="submit" class="btn btn-primary">Save Invoice</button>
            </div>
        </form>
    </div>
</div>

<script>
    const services = @json($services);

    function addRow() {
        const tbody = document.getElementById('serviceBody');
        const idx = tbody.children.length + 1;
        const row = document.createElement('tr');

        const options = services.map(s =>
            `<option value="${s.id}" data-price="${s.price}">${s.name}</option>`
        ).join('');

        row.innerHTML = `
            <td class="row-index">${idx}</td>
            <td>
                <select name="services[${idx}][id]" onchange="setPrice(this)">
                    <option value="">Select service</option>
                    ${options}
                </select>
            </td>
            <td><input class="price" name="services[${idx}][price]" style="text-align:right;" readonly></td>
            <td><input class="qty" name="services[${idx}][qty]" value="1" style="text-align:center;" oninput="calcRow(this)"></td>
            <td><input class="rowTotal" style="text-align:right;" readonly></td>
            <td class="no-print">
                <button type="button" class="btn-remove" onclick="removeRow(this)">Remove</button>
            </td>
        `;
        tbody.appendChild(row);
    }

    function setPrice(el) {
        const price = el.options[el.selectedIndex].dataset.price || 0;
        const row = el.closest('tr');
        row.querySelector('.price').value = parseFloat(price).toFixed(2);
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
        reindexRows();
        calcAll();
    }

    function reindexRows() {
        document.querySelectorAll('#serviceBody tr').forEach((tr, i) => {
            const cell = tr.querySelector('.row-index');
            if (cell) cell.textContent = i + 1;
        });
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
        const n = "INV-" + Date.now();
        document.getElementById('invoice_no').value = n;
    }

    function syncPrintHeader() {
        document.getElementById('print_invoice_no').textContent   = document.getElementById('invoice_no').value;
        document.getElementById('print_invoice_date').textContent = document.getElementById('invoice_date').value;
    }

    function printInvoice() {
        syncPrintHeader();
        window.print();
    }

    window.onload = function () {
        generateInvoiceNo();
        addRow();
        calcAll();
        syncPrintHeader();
    };
</script>

@endsection

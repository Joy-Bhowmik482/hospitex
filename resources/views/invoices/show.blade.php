@extends('includePage')

@section('content')

<style>
:root{
    --ink:#0b1220;
    --ink-2:#1f2937;
    --muted:#64748b;
    --line:#e5e7eb;
    --soft:#f8fafc;
    --brand:#0f766e;
    --brand-2:#0d9488;
    --accent:#0ea5e9;
    --bg:#eef2f7;
}

body{
    font-family:"Inter",ui-sans-serif,system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif;
    background:var(--bg);
    color:var(--ink);
}

#printArea{
    max-width:1080px;
    margin:32px auto;
}

#invoiceArea{
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 20px 50px rgba(2,12,27,.15);
}

.letterhead{
    display:grid;
    grid-template-columns:1.5fr 1fr;
    gap:24px;
    padding:28px 40px;
    background:linear-gradient(135deg,var(--brand),var(--brand-2));
    color:#fff;
}

.brand{
    display:flex;
    align-items:center;
    gap:16px;
}

.brand-logo{
    width:58px;
    height:58px;
    border-radius:14px;
    background:rgba(255,255,255,.15);
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:28px;
    font-weight:800;
}

.brand-title{
    font-size:24px;
    font-weight:800;
}

.brand-sub{
    font-size:13px;
    opacity:.9;
    margin-top:3px;
}

.meta{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:14px;
    align-self:center;
}

.meta-box{
    background:rgba(255,255,255,.12);
    border:1px solid rgba(255,255,255,.25);
    border-radius:10px;
    padding:10px 12px;
}

.meta-box small{
    display:block;
    text-transform:uppercase;
    letter-spacing:.08em;
    opacity:.8;
    font-size:10px;
}

.meta-box strong{
    display:block;
    margin-top:4px;
    font-size:14px;
}

.invoice-body{
    padding:30px 40px;
}

.grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:24px;
}

.panel{
    border:1px solid var(--line);
    border-radius:14px;
    padding:18px;
    background:#fff;
}

.panel-title{
    font-size:11px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.08em;
    color:var(--muted);
    margin-bottom:14px;
}

.info-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:8px 0;
    border-bottom:1px dashed #e5e7eb;
    font-size:14px;
}

.info-row:last-child{
    border-bottom:none;
}

.label{
    color:var(--muted);
    font-weight:500;
}

.value{
    color:var(--ink);
    font-weight:600;
}

.badge{
    display:inline-block;
    padding:5px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
    text-transform:uppercase;
}

.badge.paid{
    background:#dcfce7;
    color:#166534;
}

.badge.unpaid{
    background:#fee2e2;
    color:#991b1b;
}

.badge.partial{
    background:#fef3c7;
    color:#92400e;
}

.badge.cancelled{
    background:#e5e7eb;
    color:#374151;
}

.section-title{
    margin:30px 0 15px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.section-title h3{
    font-size:14px;
    font-weight:800;
    letter-spacing:.08em;
    text-transform:uppercase;
    color:var(--ink);
}

.table-wrap{
    border:1px solid var(--line);
    border-radius:14px;
    overflow:hidden;
}

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:var(--soft);
}

th{
    padding:14px;
    text-align:left;
    font-size:11px;
    text-transform:uppercase;
    letter-spacing:.08em;
    color:var(--muted);
}

td{
    padding:14px;
    border-top:1px solid var(--line);
    font-size:14px;
}

tbody tr:nth-child(even){
    background:#fbfdff;
}

tbody tr:hover{
    background:#f4f8fb;
}

.summary{
    display:grid;
    grid-template-columns:1fr 340px;
    gap:24px;
    margin-top:30px;
}

.notes{
    border:1px solid var(--line);
    border-radius:14px;
    padding:18px;
    background:#fff;
}

.notes-title{
    font-size:11px;
    font-weight:700;
    color:var(--muted);
    text-transform:uppercase;
    letter-spacing:.08em;
    margin-bottom:12px;
}

.notes-content{
    min-height:120px;
    line-height:1.8;
    color:var(--ink-2);
}

.totals{
    border:1px solid var(--line);
    border-radius:14px;
    padding:20px;
    background:linear-gradient(180deg,#f8fafc,#fff);
}

.total-row{
    display:flex;
    justify-content:space-between;
    padding:10px 0;
    border-bottom:1px solid #eef2f7;
    font-size:14px;
}

.total-row:last-child{
    border-bottom:none;
}

.grand-total{
    margin-top:10px;
    padding-top:16px;
    border-top:2px dashed #cbd5e1;
    font-size:18px;
    font-weight:800;
    color:var(--brand);
}

.actions{
    display:flex;
    justify-content:flex-end;
    gap:12px;
    padding:24px 40px 30px;
    border-top:1px solid var(--line);
}

.btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:10px 18px;
    border-radius:10px;
    text-decoration:none;
    font-size:14px;
    font-weight:600;
    border:none;
    cursor:pointer;
    transition:.2s;
}

.btn:hover{
    transform:translateY(-1px);
}

.btn-back{
    background:#64748b;
    color:#fff;
}

.btn-edit{
    background:#facc15;
    color:#111827;
}

.btn-print{
    background:#0ea5e9;
    color:#fff;
}

.btn-delete{
    background:#dc2626;
    color:#fff;
}

.print-only{
    display:none;
}

.footer-print{
    display:none;
}

@media print{

@page{
    size:A4;
    margin:14mm;
}

body *{
    visibility:hidden !important;
}

#printArea,
#printArea *{
    visibility:visible !important;
}

#printArea{
    position:absolute;
    left:0;
    top:0;
    width:100%;
    background:#fff;
}

#invoiceArea{
    box-shadow:none !important;
    border-radius:0 !important;
    margin:0;
}

.no-print,
.actions{
    display:none !important;
}

.letterhead{
    display:none !important;
}

.print-only{
    display:block !important;
    margin-bottom:20px;
    border-bottom:2px solid #000;
    padding-bottom:15px;
}

.print-top{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
}

.print-name{
    font-size:24px;
    font-weight:800;
}

.print-address{
    font-size:12px;
    color:#444;
    line-height:1.8;
}

.print-meta{
    text-align:right;
    font-size:12px;
    line-height:1.8;
}

.print-title{
    text-align:center;
    margin-top:18px;
    font-size:18px;
    font-weight:800;
    letter-spacing:.18em;
}

.table-wrap{
    border:1px solid #000;
}

table,
th,
td{
    border:1px solid #000;
}

thead{
    background:#f3f4f6 !important;
}

.footer-print{
    display:block;
    margin-top:30px;
    padding-top:15px;
    border-top:1px solid #999;
    text-align:center;
    font-size:11px;
}

}
</style>

@php
    $invoiceDate = $invoice->invoice_date
        ? \Illuminate\Support\Carbon::parse($invoice->invoice_date)->format('d M Y')
        : '-';

    $patientName = trim(($invoice->patient?->first_name ?? '') . ' ' . ($invoice->patient?->last_name ?? '')) ?: '-';

    $status = strtolower(trim($invoice->status ?? 'unknown'));
    $statusClass = in_array($status, ['paid', 'unpaid', 'partial', 'cancelled']) ? $status : 'unpaid';
@endphp

<div id="printArea">
    <div id="invoiceArea">

        <div class="print-only">
            <div class="print-top">
                <div>
                    <div class="print-name">HOSPITEX</div>
                    <div class="print-address">
                        123 Wellness Avenue<br>
                        Phone : +000 000000000<br>
                        Email : info@hospital.com
                    </div>
                </div>

                <div class="print-meta">
                    <div><strong>Invoice :</strong> {{ $invoice->invoice_no }}</div>
                    <div><strong>Date :</strong> {{ $invoiceDate }}</div>
                    <div><strong>Issued By :</strong> {{ $invoice->createdBy?->name ?? 'Unknown' }}</div>
                </div>
            </div>

            <div class="print-title">PATIENT INVOICE</div>
        </div>

        <div class="letterhead">
            <div class="brand">
                <div class="brand-logo">+</div>
                <div>
                    <div class="brand-title">HOSPITEX</div>
                    <div class="brand-sub">Patient Billing & Invoicing System</div>
                </div>
            </div>

            <div class="meta">
                <div class="meta-box">
                    <small>Invoice No</small>
                    <strong>{{ $invoice->invoice_no }}</strong>
                </div>

                <div class="meta-box">
                    <small>Date</small>
                    <strong>{{ $invoiceDate }}</strong>
                </div>
            </div>
        </div>

        <div class="invoice-body">
            <div class="grid">
                <div class="panel">
                    <div class="panel-title">Patient Information</div>

                    <div class="info-row">
                        <span class="label">Patient</span>
                        <span class="value">{{ $patientName }}</span>
                    </div>

                    <div class="info-row">
                        <span class="label">Admission</span>
                        <span class="value">{{ $invoice->admission?->admission_no ?? '-' }}</span>
                    </div>

                    <div class="info-row">
                        <span class="label">Appointment</span>
                        <span class="value">{{ $invoice->appointment?->id ?? '-' }}</span>
                    </div>

                    <div class="info-row">
                        <span class="label">Department</span>
                        <span class="value">{{ $invoice->department ?? '-' }}</span>
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-title">Invoice Information</div>

                    <div class="info-row">
                        <span class="label">Invoice No</span>
                        <span class="value">{{ $invoice->invoice_no }}</span>
                    </div>

                    <div class="info-row">
                        <span class="label">Invoice Date</span>
                        <span class="value">{{ $invoiceDate }}</span>
                    </div>

                    <div class="info-row">
                        <span class="label">Issued By</span>
                        <span class="value">{{ $invoice->createdBy?->name ?? '-' }}</span>
                    </div>

                    <div class="info-row">
                        <span class="label">Status</span>
                        <span class="value">
                            <span class="badge {{ $statusClass }}">
                                {{ ucfirst($statusClass) }}
                            </span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="section-title">
                <h3>Service Details</h3>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th width="8%">#</th>
                            <th width="42%">Service</th>
                            <th width="15%" style="text-align:right;">Rate</th>
                            <th width="10%" style="text-align:center;">Qty</th>
                            <th width="25%" style="text-align:right;">Amount</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($invoice->items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->description ?? $item->service?->name ?? '-' }}</td>
                                <td style="text-align:right;">৳ {{ number_format((float) ($item->rate ?? 0), 2) }}</td>
                                <td style="text-align:center;">{{ $item->qty ?? 0 }}</td>
                                <td style="text-align:right;font-weight:700;">
                                    ৳ {{ number_format((float) ($item->subtotal ?? (($item->rate ?? 0) * ($item->qty ?? 0))), 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center;padding:30px;color:#64748b;">
                                    No services found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="summary">
                <div class="notes">
                    <div class="notes-title">Notes</div>
                    <div class="notes-content">
                        {{ $invoice->notes ?? 'No additional notes available.' }}
                    </div>
                </div>

                <div class="totals">
                    <div class="total-row">
                        <span>Subtotal</span>
                        <span>৳ {{ number_format((float) ($invoice->subtotal ?? 0), 2) }}</span>
                    </div>
                    <div class="total-row">
                        <span>Discount</span>
                        <span>৳ {{ number_format((float) ($invoice->discount ?? 0), 2) }}</span>
                    </div>
                    <div class="total-row">
                        <span>Paid</span>
                        <span>৳ {{ number_format((float) ($invoice->paid_amount ?? 0), 2) }}</span>
                    </div>
                    <div class="total-row grand-total">
                        <span>Grand Total</span>
                        <span>৳ {{ number_format((float) ($invoice->total ?? 0), 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-print">
            Thank you for choosing HOSPITEX
        </div>

        <div class="actions no-print">
            <a href="{{ url()->previous() }}" class="btn btn-back">Back</a>
            <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-edit">Edit</a>
            <button type="button" class="btn btn-print" onclick="window.print()">Print</button>
        </div>
    </div>
</div>

@endsection

@extends('includePage')

@section('content')

<style>
:root{
    --ink:#0b1220;
    --muted:#64748b;
    --line:#e5e7eb;
    --soft:#f8fafc;
    --brand:#0f766e;
    --brand-2:#0d9488;
    --bg:#eef2f7;
}

body{
    font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial;
    background: var(--bg);
    color: var(--ink);
}

/* PAGE WRAP */
.page {
    max-width: 1050px;
    margin: 30px auto;
}

/* HEADER BAR */
.header {
    background: linear-gradient(135deg, var(--brand), var(--brand-2));
    color:#fff;
    padding: 26px 30px;
    border-radius: 16px 16px 0 0;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.header h2{
    font-size:20px;
    font-weight:800;
    margin:0;
}

.header small{
    opacity:.85;
    font-size:13px;
}

/* CARD */
.card{
    background:#fff;
    border-radius:0 0 16px 16px;
    box-shadow: 0 18px 40px rgba(0,0,0,.08);
    padding: 26px 30px;
}

/* TOP GRID */
.grid{
    display:grid;
    grid-template-columns: repeat(3, 1fr);
    gap:16px;
    margin-bottom:22px;
}

.info-box{
    background: var(--soft);
    border:1px solid var(--line);
    border-radius:12px;
    padding:14px;
}

.label{
    font-size:11px;
    letter-spacing:.08em;
    text-transform:uppercase;
    color:var(--muted);
}

.value{
    margin-top:6px;
    font-size:15px;
    font-weight:700;
    color:var(--ink);
}

/* STATUS BADGE */
.badge{
    display:inline-block;
    padding:5px 10px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}

.paid{ background:#dcfce7; color:#166534; }
.unpaid{ background:#fee2e2; color:#991b1b; }
.partial{ background:#fef9c3; color:#854d0e; }
.cancelled{ background:#e5e7eb; color:#374151; }

/* SECTION TITLE */
.section-title{
    font-size:13px;
    font-weight:800;
    margin:18px 0 10px;
    letter-spacing:.05em;
    text-transform:uppercase;
    color:var(--ink);
}

/* TABLE */
.table{
    width:100%;
    border-collapse:separate;
    border-spacing:0;
    overflow:hidden;
    border-radius:12px;
    border:1px solid var(--line);
}

.table thead{
    background: var(--soft);
}

.table th{
    text-align:left;
    padding:12px;
    font-size:11px;
    text-transform:uppercase;
    color:var(--muted);
}

.table td{
    padding:12px;
    border-top:1px solid var(--line);
    font-size:14px;
}

/* SUMMARY */
.summary{
    display:grid;
    grid-template-columns: 1fr 320px;
    gap:18px;
    margin-top:20px;
}

.notes{
    background: var(--soft);
    border:1px solid var(--line);
    border-radius:12px;
    padding:14px;
}

.notes h4{
    font-size:12px;
    text-transform:uppercase;
    color:var(--muted);
    margin-bottom:8px;
}

.totals{
    border:1px solid var(--line);
    border-radius:12px;
    padding:16px;
    background:#fff;
}

.row{
    display:flex;
    justify-content:space-between;
    padding:7px 0;
    font-size:14px;
    color:var(--ink);
}

.grand{
    border-top:1px dashed var(--line);
    margin-top:8px;
    padding-top:10px;
    font-weight:800;
    color:var(--brand);
    font-size:15px;
}

/* ACTIONS */
.actions{
    display:flex;
    justify-content:flex-end;
    gap:10px;
    margin-top:20px;
}

.btn{
    padding:9px 14px;
    border-radius:10px;
    border:none;
    font-weight:600;
    cursor:pointer;
}

.edit{ background:#facc15; }
.back{ background:#64748b; color:#fff; }
.print{ background:#0ea5e9; color:#fff; }
.delete{ background:#dc2626; color:#fff; }
</style>

<div class="page">

    <!-- HEADER -->
    <div class="header">
        <div>
            <h2>Invoice Details</h2>
            <small>{{ $invoice->invoice_no }}</small>
        </div>

        <div class="actions">
            <a href="{{ route('invoices.edit', $invoice) }}" class="btn edit">✏ Edit</a>
            <a href="{{ route('invoices.index') }}" class="btn back">Back</a>
        </div>
    </div>

    <!-- CARD -->
    <div class="card">

        <!-- INFO -->
        <div class="grid">

            <div class="info-box">
                <div class="label">Patient</div>
                <div class="value">
                    {{ $invoice->patient?->first_name }} {{ $invoice->patient?->last_name }}
                </div>
            </div>

            <div class="info-box">
                <div class="label">Date</div>
                <div class="value">
                    {{ $invoice->invoice_date->format('d M Y') }}
                </div>
            </div>

            <div class="info-box">
                <div class="label">Status</div>
                <div class="value">
                    <span class="badge {{ strtolower($invoice->status) }}">
                        {{ $invoice->status }}
                    </span>
                </div>
            </div>

        </div>

        <!-- SERVICES -->
        <div class="section-title">Service Details</div>

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Service</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
            @forelse($invoice->items ?? [] as $i => $item)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $item->description ?? $item->service?->name ?? '-' }}</td>
                    <td>{{ number_format($item->rate,2) }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ number_format($item->rate * $item->qty,2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;color:#64748b;">
                        No services found
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <!-- SUMMARY -->
        <div class="summary">

            <!-- NOTES -->
            <div class="notes">
                <h4>Notes</h4>
                <div>{{ $invoice->notes ?? '—' }}</div>
            </div>

            <!-- TOTALS -->
            <div class="totals">

                <div class="row">
                    <span>Subtotal</span>
                    <span>{{ number_format($invoice->subtotal,2) }}</span>
                </div>

                <div class="row">
                    <span>Discount</span>
                    <span>{{ number_format($invoice->discount,2) }}</span>
                </div>

                <div class="row">
                    <span>Tax</span>
                    <span>{{ number_format($invoice->tax,2) }}</span>
                </div>

                <div class="row grand">
                    <span>Total</span>
                    <span>{{ number_format($invoice->net_total,2) }}</span>
                </div>

            </div>

        </div>

        <!-- ACTIONS -->
        <div class="actions">

            <button onclick="window.print()" class="btn print">🖨 Print</button>

            <form method="POST" action="{{ route('invoices.destroy', $invoice) }}">
                @csrf @method('DELETE')
                <button class="btn delete" onclick="return confirm('Delete invoice?')">
                    🗑 Delete
                </button>
            </form>

        </div>

    </div>
</div>

@endsection
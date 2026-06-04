@extends('includePage')

@section('content')

<style>
    @media print {
        .no-print { display: none; }
        body { background: white; }
    }
</style>

<div class="min-h-screen bg-slate-50 py-10 px-4">
    <div class="max-w-7xl mx-auto space-y-8">
        <!-- Header -->
        <div class="no-print">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-4xl font-bold text-slate-900">Financial Reports</h1>
                    <p class="mt-2 text-slate-600">Revenue, expenses, billing, and payment analytics</p>
                </div>
                <div class="flex gap-3">
                    @include('components.report.export-buttons', [
                        'pdfExportUrl' => route('reports.export-financial-pdf', request()->query())
                    ])
                </div>
            </div>

            <!-- Filters -->
            @include('components.report.filters', [
                'additionalFilters' => [
                    [
                        'name' => 'department_id',
                        'label' => 'Department',
                        'options' => $departments->pluck('name', 'id')->toArray()
                    ]
                ]
            ])
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-report.summary-card 
                label="Total Revenue"
                value="${{ number_format($report['summary']['total_revenue'], 2) }}"
                icon="💰"
                description="All invoiced amounts"
            />
            <x-report.summary-card 
                label="Outstanding Bills"
                value="${{ number_format($report['summary']['outstanding_bills'], 2) }}"
                icon="📋"
                description="Pending payments"
            />
            <x-report.summary-card 
                label="Paid Bills"
                value="${{ number_format($report['summary']['paid_bills'], 2) }}"
                icon="✅"
                description="Completed payments"
            />
            <x-report.summary-card 
                label="Payment Rate"
                value="{{ number_format($report['summary']['paid_percentage'], 1) }}%"
                icon="📊"
                description="Collections efficiency"
            />
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <x-report.chart 
                chartId="revenue-trend"
                title="Revenue Trend"
                type="line"
                :data="$report['charts']['revenue_trend']"
            />
            <x-report.chart 
                chartId="daily-revenue"
                title="Daily Revenue Distribution"
                type="bar"
                :data="$report['charts']['daily_revenue']"
            />
            <x-report.chart 
                chartId="payment-status"
                title="Payment Status Breakdown"
                type="doughnut"
                :data="$report['charts']['payment_status']"
            />
            <x-report.chart 
                chartId="department-revenue"
                title="Department Revenue Comparison"
                type="bar"
                :data="$report['charts']['department_revenue']"
            />
        </div>

        <!-- Financial Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-report.summary-card 
                label="Average Invoice"
                value="${{ number_format($report['summary']['average_invoice_amount'], 2) }}"
                icon="💵"
            />
            <x-report.summary-card 
                label="Total Invoices"
                value="{{ number_format($report['summary']['invoice_count']) }}"
                icon="📄"
            />
            <x-report.summary-card 
                label="Net Profit"
                value="${{ number_format($report['summary']['net_profit'], 2) }}"
                icon="📈"
            />
        </div>

        <!-- Invoice Details Table -->
        <div>
            <h2 class="text-2xl font-bold text-slate-900 mb-6">Recent Invoices</h2>
            <x-report.table 
                :columns="[
                    ['key' => 'id', 'label' => 'Invoice ID'],
                    ['key' => 'patient_id', 'label' => 'Patient'],
                    ['key' => 'total_amount', 'label' => 'Amount', 'render' => fn($row) => '$' . number_format($row->total_amount, 2)],
                    ['key' => 'payment_status', 'label' => 'Status', 'render' => fn($row) => '<span class="px-3 py-1 rounded-full text-xs font-semibold ' . ($row->payment_status === 'Paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700') . '">' . $row->payment_status . '</span>'],
                    ['key' => 'created_at', 'label' => 'Date', 'render' => fn($row) => $row->created_at->format('M d, Y')],
                ]"
                :rows="$report['data']['invoices']->items()"
                :pagination="$report['data']['invoices']"
            />
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

@endsection

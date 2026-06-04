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
                    <h1 class="text-4xl font-bold text-slate-900">Pharmacy Reports</h1>
                    <p class="mt-2 text-slate-600">Medicine inventory, sales, and stock management analytics</p>
                </div>
                <div class="flex gap-3">
                    @include('components.report.export-buttons', [
                        'pdfExportUrl' => '#'
                    ])
                </div>
            </div>

            <!-- Filters -->
            @include('components.report.filters')
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-report.summary-card 
                label="Total Medicines Sold"
                value="{{ number_format($report['summary']['total_medicines_sold']) }}"
                icon="💊"
                description="Units sold in period"
            />
            <x-report.summary-card 
                label="Revenue Generated"
                value="${{ number_format($report['summary']['revenue_generated'], 2) }}"
                icon="💰"
                description="Total sales revenue"
            />
            <x-report.summary-card 
                label="Low Stock Items"
                value="{{ number_format($report['summary']['low_stock_medicines']) }}"
                icon="📉"
                description="Need reordering"
            />
            <x-report.summary-card 
                label="Expired Items"
                value="{{ number_format($report['summary']['expired_medicines']) }}"
                icon="⚠️"
                description="Require disposal"
            />
        </div>

        <!-- Additional Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-report.summary-card 
                label="Near Expiry"
                value="{{ number_format($report['summary']['near_expiry_medicines']) }}"
                icon="🕐"
                description="Expiring soon"
            />
            <x-report.summary-card 
                label="Inventory Value"
                value="${{ number_format($report['summary']['total_inventory_value'], 2) }}"
                icon="📊"
            />
            <x-report.summary-card 
                label="Active Items"
                value="{{ number_format($report['summary']['active_items']) }}"
                icon="📦"
            />
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <x-report.chart 
                chartId="sales-trend"
                title="Medicine Sales Trend"
                type="line"
                :data="$report['charts']['sales_trend']"
            />
            <x-report.chart 
                chartId="top-medicines"
                title="Top Selling Medicines"
                type="bar"
                :data="$report['charts']['top_medicines']"
            />
            <x-report.chart 
                chartId="inventory-status"
                title="Inventory Status"
                type="doughnut"
                :data="$report['charts']['inventory_status']"
            />
        </div>

        <!-- Inventory Table -->
        <div>
            <h2 class="text-2xl font-bold text-slate-900 mb-6">Inventory Items</h2>
            <x-report.table 
                :columns="[
                    ['key' => 'id', 'label' => 'Item ID'],
                    ['key' => 'name', 'label' => 'Medicine Name'],
                    ['key' => 'category', 'label' => 'Category'],
                    ['key' => 'quantity', 'label' => 'Quantity'],
                    ['key' => 'unit_cost', 'label' => 'Unit Cost'],
                    ['key' => 'status', 'label' => 'Status'],
                ]"
                :rows="$report['data']['items']->items()"
                :pagination="$report['data']['items']"
            />
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

@endsection

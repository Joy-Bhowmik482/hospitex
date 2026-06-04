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
                    <h1 class="text-4xl font-bold text-slate-900">Lab Reports</h1>
                    <p class="mt-2 text-slate-600">Laboratory test statistics, trends, and analysis</p>
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
                label="Total Tests"
                value="{{ number_format($report['summary']['total_tests']) }}"
                icon="🔬"
                description="All performed tests"
            />
            <x-report.summary-card 
                label="Pending Tests"
                value="{{ number_format($report['summary']['pending_tests']) }}"
                icon="⏳"
                description="Awaiting results"
            />
            <x-report.summary-card 
                label="Completed Tests"
                value="{{ number_format($report['summary']['completed_tests']) }}"
                icon="✅"
                description="Results available"
            />
            <x-report.summary-card 
                label="Critical Results"
                value="{{ number_format($report['summary']['critical_results']) }}"
                icon="⚠️"
                description="Require attention"
            />
        </div>

        <!-- Additional Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-report.summary-card 
                label="Revenue from Lab"
                value="${{ number_format($report['summary']['revenue_from_lab'], 2) }}"
                icon="💰"
            />
            <x-report.summary-card 
                label="Avg Processing Time"
                value="{{ $report['summary']['average_processing_time'] }}"
                icon="⏱️"
            />
            <x-report.summary-card 
                label="Test Types"
                value="{{ number_format($report['summary']['test_types_count']) }}"
                icon="📊"
            />
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <x-report.chart 
                chartId="test-volume-trend"
                title="Test Volume Trend"
                type="line"
                :data="$report['charts']['test_volume_trend']"
            />
            <x-report.chart 
                chartId="revenue-trend"
                title="Revenue Trend"
                type="line"
                :data="$report['charts']['revenue_trend']"
            />
            <x-report.chart 
                chartId="test-status"
                title="Test Status Overview"
                type="doughnut"
                :data="$report['charts']['test_status']"
            />
        </div>

        <!-- Coming Soon Message -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-8 text-center">
            <svg class="mx-auto h-12 w-12 text-blue-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="text-lg font-semibold text-blue-900 mb-2">Lab Module Coming Soon</h3>
            <p class="text-blue-700">Detailed lab test reports and analysis features are being developed and will be available soon.</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

@endsection

@extends('includePage')

@section('content')

<style>
@media print {
    @page { size: A4; margin: 20mm; }
    body {
        margin: 0;
        padding: 0;
        background: #fff !important;
        color: #000 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    body * {
        visibility: hidden;
    }
    #reportArea, #reportArea * {
        visibility: visible;
    }
    #reportArea {
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
    #reportArea .bg-slate-900 {
        background: #0f172a !important;
        color: #fff !important;
    }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    table, th, td { border: 1px solid #000 !important; }
    thead { background: #000 !important; color: #fff !important; }
    th, td { padding: 8px !important; text-align: left; }
    button, a {
        display: none !important;
    }
}
</style>

<div class="min-h-screen bg-slate-100 py-10 px-4">
    <div id="reportArea" class="max-w-7xl mx-auto bg-white shadow-xl rounded-2xl overflow-hidden">
        <div class="flex flex-col gap-6 md:flex-row md:items-center justify-between bg-slate-900 text-white px-10 py-8">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Report</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight">{{ $report->name }}</h1>
                <p class="mt-2 text-sm text-slate-300">{{ ucfirst($report->type) }} report details and key metrics.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('reports.index') }}" class="inline-flex items-center justify-center rounded-2xl bg-slate-700 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">Back</a>
                <a href="{{ route('reports.export', $report) }}" class="inline-flex items-center justify-center rounded-2xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700">Export PDF</a>
                <button onclick="window.print()" class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700">Print</button>
            </div>
        </div>

        <div class="px-10 py-6 bg-slate-50 border-b border-slate-200">
            <div class="grid gap-4 md:grid-cols-4 text-sm">
                <div class="rounded-xl border border-slate-200 bg-white p-4">
                    <p class="text-xs uppercase tracking-wide text-slate-500">Created By</p>
                    <p class="mt-2 font-semibold text-slate-900">{{ $report->creator->name ?? 'N/A' }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-4">
                    <p class="text-xs uppercase tracking-wide text-slate-500">Created At</p>
                    <p class="mt-2 font-semibold text-slate-900">{{ $report->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-4">
                    <p class="text-xs uppercase tracking-wide text-slate-500">Report Type</p>
                    <p class="mt-2 font-semibold text-slate-900">{{ ucfirst($report->type) }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-4">
                    <p class="text-xs uppercase tracking-wide text-slate-500">Date Range</p>
                    <p class="mt-2 font-semibold text-slate-900">{{ $report->parameters['start_date'] ?? 'Any' }} — {{ $report->parameters['end_date'] ?? 'Any' }}</p>
                </div>
            </div>
        </div>

        <div class="px-10 py-8">
            @if($report->type == 'patient')
                <h2 class="text-xl font-bold text-gray-800 mb-6">Patient Data</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">ID</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Email</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Phone</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Created At</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($report->data as $patient)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $patient['id'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $patient['first_name'] }} {{ $patient['last_name'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $patient['email'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $patient['phone'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $patient['created_at'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @elseif($report->type == 'financial')
                <h2 class="text-xl font-bold text-gray-800 mb-6">Financial Summary</h2>
                <div class="grid gap-6 lg:grid-cols-3 mb-8">
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Total Invoiced</p>
                        <p class="mt-4 text-3xl font-semibold text-slate-900">${{ number_format($report->data['total_invoiced'], 2) }}</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Total Paid</p>
                        <p class="mt-4 text-3xl font-semibold text-slate-900">${{ number_format($report->data['total_paid'], 2) }}</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Outstanding</p>
                        <p class="mt-4 text-3xl font-semibold text-slate-900">${{ number_format(max($report->data['total_invoiced'] - $report->data['total_paid'], 0), 2) }}</p>
                    </div>
                </div>

                <div class="grid gap-6 lg:grid-cols-2 mb-8">
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Latest Invoices</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach(array_slice($report->data['invoices'], 0, 5) as $invoice)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 text-sm text-gray-900">{{ $invoice['id'] }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-900">{{ $invoice['patient']['first_name'] }} {{ $invoice['patient']['last_name'] }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-500">${{ number_format($invoice['total_amount'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Payments</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach(array_slice($report->data['payments'], 0, 5) as $payment)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 text-sm text-gray-900">{{ $payment['id'] }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-500">{{ $payment['invoice_id'] }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-500">${{ number_format($payment['amount'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Invoice Details</h3>
                    <div class="overflow-x-auto mb-2">
                        <table class="min-w-full bg-white border border-slate-200 rounded-lg">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($report->data['invoices'] as $invoice)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $invoice['id'] }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $invoice['patient']['first_name'] }} {{ $invoice['patient']['last_name'] }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-500">${{ number_format($invoice['total_amount'], 2) }}</td>
                                        <td class="px-4 py-3 text-sm">
                                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold 
                                                @if($invoice['status'] == 'paid') bg-emerald-100 text-emerald-800
                                                @else bg-amber-100 text-amber-800
                                                @endif">
                                                {{ ucfirst($invoice['status']) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @elseif($report->type == 'daily')
                <h2 class="text-xl font-bold text-gray-800 mb-6">Daily Overview for {{ $report->data['date'] }}</h2>
                <div class="grid gap-6 md:grid-cols-3">
                    <div class="bg-blue-50 rounded-3xl border border-blue-100 p-6 shadow-sm">
                        <p class="text-sm uppercase tracking-[0.3em] text-blue-700">Appointments</p>
                        <p class="mt-4 text-4xl font-semibold text-blue-900">{{ $report->data['appointments'] }}</p>
                    </div>
                    <div class="bg-emerald-50 rounded-3xl border border-emerald-100 p-6 shadow-sm">
                        <p class="text-sm uppercase tracking-[0.3em] text-emerald-700">Admissions</p>
                        <p class="mt-4 text-4xl font-semibold text-emerald-900">{{ $report->data['admissions'] }}</p>
                    </div>
                    <div class="bg-rose-50 rounded-3xl border border-rose-100 p-6 shadow-sm">
                        <p class="text-sm uppercase tracking-[0.3em] text-rose-700">Discharges</p>
                        <p class="mt-4 text-4xl font-semibold text-rose-900">{{ $report->data['discharges'] }}</p>
                    </div>
                </div>
            @else
                <div class="rounded-3xl border border-amber-200 bg-amber-50 p-6 shadow-sm">
                    <h2 class="text-xl font-semibold text-amber-900 mb-3">{{ ucfirst($report->type) }} Report</h2>
                    <p class="text-slate-700">{{ $report->data['message'] ?? 'Report data not available for this type yet.' }}</p>
                    @if(isset($report->data) && is_array($report->data))
                        <pre class="mt-4 overflow-x-auto rounded-2xl bg-white p-4 text-sm text-slate-700">{{ json_encode($report->data, JSON_PRETTY_PRINT) }}</pre>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

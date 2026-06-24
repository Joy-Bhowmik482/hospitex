@extends('includePage')

@section('content')

<div class="min-h-screen bg-slate-100 py-10 px-4">
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="bg-white shadow-xl rounded-3xl overflow-hidden">
            <div class="bg-green-900 px-10 py-8 text-white">
                <div class="flex flex-col gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-green-300">Financial Reports</p>
                        <h1 class="mt-3 text-3xl font-bold tracking-tight">Generate Financial Report</h1>
                        <p class="mt-3 max-w-2xl text-green-100">Analyze your hospital's financial performance with invoices, payments, and revenue summaries for a specific period.</p>
                    </div>
                </div>
            </div>

            <div class="px-10 py-8 bg-green-50 border-b border-green-200">
                @if($errors->any())
                    <div class="rounded-3xl border border-red-200 bg-red-50 p-5 mb-6 text-sm text-red-700">
                        <p class="font-semibold">Please fix the following errors:</p>
                        <ul class="mt-3 list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="rounded-3xl border border-green-200 bg-white p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.3em] text-green-600 font-semibold">Financial Metrics Included</p>
                    <ul class="mt-4 space-y-2 text-sm text-slate-700">
                        <li>✓ Total invoices issued during the period</li>
                        <li>✓ Total payments received and processed</li>
                        <li>✓ Outstanding balance and amounts due</li>
                        <li>✓ Payment method breakdown (cash, card, insurance, etc.)</li>
                        <li>✓ Professional PDF export with summary tables</li>
                    </ul>
                </div>
            </div>

            <form action="{{ route('reports.store') }}" method="POST" class="px-10 py-8 bg-white">
                @csrf
                <input type="hidden" name="type" value="financial">

                <div class="grid gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Report Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-green-500 focus:ring-green-500" placeholder="Example: December 2024 Financial Summary" required>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-slate-700 mb-2">Start Date <span class="text-red-500">*</span></label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-green-500 focus:ring-green-500" required>
                            <p class="mt-1 text-xs text-slate-500">Beginning of the reporting period</p>
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-medium text-slate-700 mb-2">End Date <span class="text-red-500">*</span></label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-green-500 focus:ring-green-500" required>
                            <p class="mt-1 text-xs text-slate-500">End of the reporting period</p>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-green-200 bg-green-50 p-5">
                        <p class="text-sm font-semibold text-green-900">Financial Report Tips</p>
                        <p class="mt-2 text-sm text-green-800">Select the date range to analyze invoices, payments, and revenue for that period. Monthly or quarterly reports are recommended for better financial tracking.</p>
                    </div>

                    <div class="rounded-3xl border border-yellow-200 bg-yellow-50 p-5">
                        <p class="text-sm font-semibold text-yellow-900">⚠️ Date Range Required</p>
                        <p class="mt-2 text-sm text-yellow-800">Financial reports require both start and end dates for accurate revenue and payment calculations.</p>
                    </div>
                </div>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <a href="{{ route('reports.index') }}" class="inline-flex items-center justify-center rounded-3xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">Cancel</a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-3xl bg-green-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-green-700">Generate Financial Report</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

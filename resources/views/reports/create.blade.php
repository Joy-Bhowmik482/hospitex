@extends('includePage')

@section('content')

<div class="min-h-screen bg-slate-100 py-10 px-4">
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="bg-white shadow-xl rounded-3xl overflow-hidden">
            <div class="bg-slate-900 px-10 py-8 text-white">
                <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Create Report</p>
                        <h1 class="mt-3 text-3xl font-bold tracking-tight">Generate a new report</h1>
                        <p class="mt-3 max-w-2xl text-slate-300">Build a professional report for patient, financial, daily, lab, or pharmacy data with an easy export path.</p>
                    </div>
                    <div class="rounded-3xl border border-slate-700 bg-slate-800 px-5 py-4 text-sm">
                        <p class="text-slate-300">Need a quick setup?</p>
                        <p class="mt-2 text-white">Choose a report type and enter the date range.</p>
                    </div>
                </div>
            </div>

            <div class="px-10 py-8 bg-slate-50 border-b border-slate-200">
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

                <div class="grid gap-4 md:grid-cols-3">
                    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Patient Reports</p>
                        <p class="mt-3 text-sm text-slate-700">Generate a list of patients created during the selected period.</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Financial Reports</p>
                        <p class="mt-3 text-sm text-slate-700">Review invoice totals, payments, and outstanding balances.</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Daily Reports</p>
                        <p class="mt-3 text-sm text-slate-700">Capture appointment, admission, and discharge metrics for a specific day.</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('reports.store') }}" method="POST" class="px-10 py-8 bg-white">
                @csrf

                <div class="grid gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Report Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Example: Monthly Financial Summary" required>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        <div>
                            <label for="type" class="block text-sm font-medium text-slate-700 mb-2">Report Type</label>
                            <select id="type" name="type" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="">Select report type</option>
                                <option value="patient" {{ old('type') == 'patient' ? 'selected' : '' }}>Patient Report</option>
                                <option value="financial" {{ old('type') == 'financial' ? 'selected' : '' }}>Financial Report</option>
                                <option value="daily" {{ old('type') == 'daily' ? 'selected' : '' }}>Daily Report</option>
                                <option value="lab" {{ old('type') == 'lab' ? 'selected' : '' }}>Lab Report</option>
                                <option value="pharmacy" {{ old('type') == 'pharmacy' ? 'selected' : '' }}>Pharmacy Report</option>
                            </select>
                        </div>

                        <div>
                            <label for="start_date" class="block text-sm font-medium text-slate-700 mb-2">Start Date</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-medium text-slate-700 mb-2">End Date</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                        <p class="text-sm font-semibold text-slate-900">Report inputs</p>
                        <p class="mt-2 text-sm text-slate-500">If no dates are selected, the report will include all available data. Daily reports default to today.</p>
                    </div>
                </div>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <a href="{{ route('reports.index') }}" class="inline-flex items-center justify-center rounded-3xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">Cancel</a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-3xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">Generate Report</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

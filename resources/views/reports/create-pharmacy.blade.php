@extends('includePage')

@section('content')

<div class="min-h-screen bg-slate-100 py-10 px-4">
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="bg-white shadow-xl rounded-3xl overflow-hidden">
            <div class="bg-orange-900 px-10 py-8 text-white">
                <div class="flex flex-col gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-orange-300">Pharmacy Reports</p>
                        <h1 class="mt-3 text-3xl font-bold tracking-tight">Generate Pharmacy Report</h1>
                        <p class="mt-3 max-w-2xl text-orange-100">Monitor medication usage, inventory levels, pharmaceutical dispensing, and drug management across your hospital pharmacy.</p>
                    </div>
                </div>
            </div>

            <div class="px-10 py-8 bg-orange-50 border-b border-orange-200">
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

                <div class="rounded-3xl border border-orange-200 bg-white p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.3em] text-orange-600 font-semibold">Pharmacy Inventory & Usage</p>
                    <ul class="mt-4 space-y-2 text-sm text-slate-700">
                        <li>✓ Total medication dispensed and issued</li>
                        <li>✓ Current inventory levels and stock status</li>
                        <li>✓ Expiry tracking and waste management</li>
                        <li>✓ Drug interactions and patient safety metrics</li>
                        <li>✓ Pharmaceutical cost analysis and trends</li>
                    </ul>
                </div>
            </div>

            <form action="{{ route('reports.store') }}" method="POST" class="px-10 py-8 bg-white">
                @csrf
                <input type="hidden" name="type" value="pharmacy">

                <div class="grid gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Report Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-orange-500 focus:ring-orange-500" placeholder="Example: Monthly Pharmaceutical Inventory Report" required>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-slate-700 mb-2">Start Date (Optional)</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-orange-500 focus:ring-orange-500">
                            <p class="mt-1 text-xs text-slate-500">Beginning of reporting period</p>
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-medium text-slate-700 mb-2">End Date (Optional)</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-orange-500 focus:ring-orange-500">
                            <p class="mt-1 text-xs text-slate-500">End of reporting period</p>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-orange-200 bg-orange-50 p-5">
                        <p class="text-sm font-semibold text-orange-900">Pharmacy Report Information</p>
                        <p class="mt-2 text-sm text-orange-800">This comprehensive report covers medication inventory, usage patterns, expiry dates, and pharmaceutical spending. Essential for inventory management and cost control.</p>
                    </div>

                    <div class="rounded-3xl border border-blue-200 bg-blue-50 p-5">
                        <p class="text-sm font-semibold text-blue-900">Optional Date Range</p>
                        <p class="mt-2 text-sm text-blue-800">Filter by date to analyze specific periods, or leave blank to get a complete pharmacy overview across all time periods.</p>
                    </div>
                </div>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <a href="{{ route('reports.index') }}" class="inline-flex items-center justify-center rounded-3xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">Cancel</a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-3xl bg-orange-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-orange-700">Generate Pharmacy Report</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

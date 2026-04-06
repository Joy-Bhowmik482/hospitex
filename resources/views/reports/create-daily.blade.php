@extends('includePage')

@section('content')

<div class="min-h-screen bg-slate-100 py-10 px-4">
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="bg-white shadow-xl rounded-3xl overflow-hidden">
            <div class="bg-purple-900 px-10 py-8 text-white">
                <div class="flex flex-col gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-purple-300">Daily Reports</p>
                        <h1 class="mt-3 text-3xl font-bold tracking-tight">Generate Daily Report</h1>
                        <p class="mt-3 max-w-2xl text-purple-100">Get a snapshot of your hospital's daily operations including admissions, discharges, and appointments for a specific date.</p>
                    </div>
                </div>
            </div>

            <div class="px-10 py-8 bg-purple-50 border-b border-purple-200">
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

                <div class="rounded-3xl border border-purple-200 bg-white p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.3em] text-purple-600 font-semibold">Daily Operations Summary</p>
                    <ul class="mt-4 space-y-2 text-sm text-slate-700">
                        <li>✓ Total new patient admissions for the day</li>
                        <li>✓ Patient discharges completed today</li>
                        <li>✓ Scheduled appointments and check-ups</li>
                        <li>✓ Bed utilization statistics</li>
                        <li>✓ Quick view of hospital activity metrics</li>
                    </ul>
                </div>
            </div>

            <form action="{{ route('reports.store') }}" method="POST" class="px-10 py-8 bg-white">
                @csrf
                <input type="hidden" name="type" value="daily">

                <div class="grid gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Report Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-purple-500 focus:ring-purple-500" placeholder="Example: Daily Operations Summary - Jan 15" required>
                    </div>

                    <div>
                        <label for="start_date" class="block text-sm font-medium text-slate-700 mb-2">Report Date <span class="text-red-500">*</span></label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date', now()->format('Y-m-d')) }}" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-purple-500 focus:ring-purple-500" required>
                        <p class="mt-1 text-xs text-slate-500">The date for which you want to view daily operations</p>
                    </div>

                    <div class="rounded-3xl border border-purple-200 bg-purple-50 p-5">
                        <p class="text-sm font-semibold text-purple-900">Daily Report Information</p>
                        <p class="mt-2 text-sm text-purple-800">This report provides a quick operational overview for the selected date. Ideal for end-of-day briefings and monitoring hospital department performance.</p>
                    </div>

                    <div class="rounded-3xl border border-blue-200 bg-blue-50 p-5">
                        <p class="text-sm font-semibold text-blue-900">✓ Today's Date Pre-selected</p>
                        <p class="mt-2 text-sm text-blue-800">The report date defaults to today. Change it if you need to review data from a previous date.</p>
                    </div>
                </div>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <a href="{{ route('reports.index') }}" class="inline-flex items-center justify-center rounded-3xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">Cancel</a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-3xl bg-purple-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-purple-700">Generate Daily Report</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

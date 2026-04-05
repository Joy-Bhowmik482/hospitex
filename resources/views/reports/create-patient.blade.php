@extends('includePage')

@section('content')

<div class="min-h-screen bg-slate-100 py-10 px-4">
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="bg-white shadow-xl rounded-3xl overflow-hidden">
            <div class="bg-blue-900 px-10 py-8 text-white">
                <div class="flex flex-col gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-blue-300">Patient Reports</p>
                        <h1 class="mt-3 text-3xl font-bold tracking-tight">Generate Patient Report</h1>
                        <p class="mt-3 max-w-2xl text-blue-100">Create a comprehensive report of all patients registered during a specific date range. Includes patient names, contact information, and registration dates.</p>
                    </div>
                </div>
            </div>

            <div class="px-10 py-8 bg-blue-50 border-b border-blue-200">
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

                <div class="rounded-3xl border border-blue-200 bg-white p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.3em] text-blue-600 font-semibold">What You'll Get</p>
                    <ul class="mt-4 space-y-2 text-sm text-slate-700">
                        <li>✓ Complete list of all patients registered in your system</li>
                        <li>✓ Patient names, email addresses, and phone numbers</li>
                        <li>✓ Registration dates and timestamps</li>
                        <li>✓ Exportable PDF format for sharing and archiving</li>
                    </ul>
                </div>
            </div>

            <form action="{{ route('reports.store') }}" method="POST" class="px-10 py-8 bg-white">
                @csrf
                <input type="hidden" name="type" value="patient">

                <div class="grid gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Report Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Example: Q1 Patient Registration Report" required>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-slate-700 mb-2">Start Date (Optional)</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-blue-500 focus:ring-blue-500">
                            <p class="mt-1 text-xs text-slate-500">Leave blank to include all patients from the beginning</p>
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-medium text-slate-700 mb-2">End Date (Optional)</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-blue-500 focus:ring-blue-500">
                            <p class="mt-1 text-xs text-slate-500">Leave blank to include patients to today</p>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-blue-200 bg-blue-50 p-5">
                        <p class="text-sm font-semibold text-blue-900">Date Range Tips</p>
                        <p class="mt-2 text-sm text-blue-800">Select both dates to filter patients registered during a specific period, or leave blank to include all patients in the system.</p>
                    </div>
                </div>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <a href="{{ route('reports.index') }}" class="inline-flex items-center justify-center rounded-3xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">Cancel</a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-3xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">Generate Patient Report</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

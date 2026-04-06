@extends('includePage')

@section('content')

<div class="min-h-screen bg-slate-100 py-12 px-4">
    <div class="max-w-6xl mx-auto">

        <!-- MAIN CARD -->
        <div class="bg-white border border-slate-200 rounded-2xl shadow-lg overflow-hidden">

            <!-- HEADER -->
            <div class="px-10 py-8 border-b border-slate-200 bg-white">
                <div class="flex items-start justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-slate-800">
                            Laboratory Report Generator
                        </h1>
                        <p class="mt-1 text-sm text-slate-500 max-w-xl">
                            Create structured laboratory reports including diagnostic results,
                            specimen tracking, and operational performance insights.
                        </p>
                    </div>

                    <!-- Badge -->
                    <span class="px-4 py-1 text-xs font-medium bg-indigo-50 text-indigo-700 rounded-full border border-indigo-200">
                        LAB MODULE
                    </span>
                </div>
            </div>

            <!-- BODY -->
            <div class="px-10 py-10">

                <!-- ERROR -->
                @if($errors->any())
                    <div class="mb-8 border border-red-200 bg-red-50 rounded-xl p-4 text-sm text-red-700">
                        <p class="font-medium mb-2">Validation Errors</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- FORM -->
                <form action="{{ route('reports.store') }}" method="POST" class="space-y-10">
                    @csrf
                    <input type="hidden" name="type" value="lab">

                    <!-- SECTION: BASIC INFO -->
                    <div>
                        <h2 class="text-sm font-semibold text-slate-700 mb-4 uppercase tracking-wide">
                            Report Details
                        </h2>

                        <div class="grid gap-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Report Name
                                </label>
                                <input 
                                    type="text" 
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="e.g. Monthly Lab Performance Report"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                                    required
                                >
                            </div>
                        </div>
                    </div>

                    <!-- SECTION: DATE FILTER -->
                    <div>
                        <h2 class="text-sm font-semibold text-slate-700 mb-4 uppercase tracking-wide">
                            Date Range (Optional)
                        </h2>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm text-slate-600 mb-2">Start Date</label>
                                <input 
                                    type="date" 
                                    name="start_date"
                                    value="{{ old('start_date') }}"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                                >
                            </div>

                            <div>
                                <label class="block text-sm text-slate-600 mb-2">End Date</label>
                                <input 
                                    type="date" 
                                    name="end_date"
                                    value="{{ old('end_date') }}"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- SECTION: INFO PANELS -->
                    <div class="grid md:grid-cols-2 gap-6">

                        <!-- LEFT -->
                        <div class="border border-slate-200 rounded-xl p-6 bg-slate-50">
                            <h3 class="text-sm font-semibold text-slate-700 mb-3">
                                Included Metrics
                            </h3>
                            <ul class="text-sm text-slate-600 space-y-2">
                                <li>• Diagnostic test results overview</li>
                                <li>• Sample collection & processing logs</li>
                                <li>• Turnaround time analytics</li>
                                <li>• Department performance indicators</li>
                            </ul>
                        </div>

                        <!-- RIGHT -->
                        <div class="border border-slate-200 rounded-xl p-6 bg-slate-50">
                            <h3 class="text-sm font-semibold text-slate-700 mb-3">
                                Usage Notes
                            </h3>
                            <p class="text-sm text-slate-600 leading-relaxed">
                                Use date filters to narrow report scope. Leaving fields empty
                                will generate a complete dataset across all available laboratory records.
                            </p>
                        </div>

                    </div>

                    <!-- FOOTER ACTIONS -->
                    <div class="flex items-center justify-between pt-6 border-t border-slate-200">

                        <a href="{{ route('reports.index') }}"
                           class="text-sm text-slate-600 hover:text-slate-800 font-medium">
                            ← Back to Reports
                        </a>

                        <div class="flex gap-3">
                            <a href="{{ route('reports.index') }}"
                               class="px-5 py-2.5 text-sm font-medium border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-100 transition">
                                Cancel
                            </a>

                            <button type="submit"
                                class="px-6 py-2.5 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow-sm transition">
                                Generate Report
                            </button>
                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection
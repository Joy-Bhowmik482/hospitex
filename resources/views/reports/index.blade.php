@extends('includePage')

@section('content')

<div class="min-h-screen bg-slate-100 py-10 px-4">
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="bg-white shadow-xl rounded-3xl overflow-hidden">
            <div class="flex flex-col gap-6 md:flex-row md:items-center justify-between bg-slate-900 text-white px-10 py-8">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Reports</p>
                    <h1 class="mt-2 text-3xl font-bold tracking-tight">Reports Overview</h1>
                    <p class="mt-3 max-w-2xl text-slate-300">Review generated reports, export PDF summaries, and create fresh reports for patients, finance, and daily operations.</p>
                </div>
                <a href="{{ route('reports.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">Generate New Report</a>
            </div>

            <div class="px-10 py-8 bg-slate-50 border-b border-slate-200">
                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Patient Reports</p>
                        <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $reportStats['patient'] ?? 0 }}</p>
                        <p class="mt-2 text-sm text-slate-500">Reports generated for patient overview and admissions.</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Financial Reports</p>
                        <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $reportStats['financial'] ?? 0 }}</p>
                        <p class="mt-2 text-sm text-slate-500">Invoice and payment summaries across your hospital.</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Daily Reports</p>
                        <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $reportStats['daily'] ?? 0 }}</p>
                        <p class="mt-2 text-sm text-slate-500">Operational metrics for appointments, admissions, and discharges.</p>
                    </div>
                </div>
            </div>

            <div class="px-10 py-8">
                @if(session('success'))
                    <div class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-green-700 shadow-sm mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto rounded-3xl border border-slate-200 bg-white shadow-sm">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Name</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Type</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Date Range</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Created By</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Created At</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @forelse($reports as $report)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-5 text-sm font-medium text-slate-900">{{ $report->name }}</td>
                                    <td class="px-6 py-5 text-sm text-slate-500">
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold 
                                            @if($report->type == 'patient') bg-blue-100 text-blue-800
                                            @elseif($report->type == 'financial') bg-emerald-100 text-emerald-800
                                            @elseif($report->type == 'daily') bg-amber-100 text-amber-800
                                            @else bg-slate-100 text-slate-700
                                            @endif">
                                            {{ ucfirst($report->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-sm text-slate-500">{{ $report->parameters['start_date'] ?? 'Any' }} — {{ $report->parameters['end_date'] ?? 'Any' }}</td>
                                    <td class="px-6 py-5 text-sm text-slate-500">{{ $report->creator->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-5 text-sm text-slate-500">{{ $report->created_at->format('M d, Y H:i') }}</td>
                                    <td class="px-6 py-5 text-sm font-medium text-slate-700 flex gap-3 items-center">
                                        <a href="{{ route('reports.show', $report) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                        <form action="{{ route('reports.destroy', $report) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this report?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                        <div class="space-y-3">
                                            <svg class="mx-auto h-14 w-14 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <div>
                                                <p class="text-lg font-semibold text-slate-900">No reports created yet</p>
                                                <p class="mt-1 text-sm text-slate-500">Create a new report to see it listed here.</p>
                                            </div>
                                            <a href="{{ route('reports.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">Generate Report</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between text-sm text-slate-500">
                    <p>Showing {{ $reports->count() }} of {{ $reports->total() }} reports</p>
                    <div>{{ $reports->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
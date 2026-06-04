@extends('includePage')

@section('content')

<div class="min-h-screen bg-slate-50 py-10 px-4">
    <div class="max-w-7xl mx-auto space-y-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-slate-900">Reports Center</h1>
            <p class="mt-2 text-slate-600">Access and manage all hospital reports, analytics, and data exports</p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Patient Reports</p>
                <p class="mt-3 text-3xl font-bold text-slate-900">{{ $reportStats['patient'] ?? 0 }}</p>
                <p class="mt-2 text-sm text-slate-600">Generated reports</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Financial Reports</p>
                <p class="mt-3 text-3xl font-bold text-slate-900">{{ $reportStats['financial'] ?? 0 }}</p>
                <p class="mt-2 text-sm text-slate-600">Generated reports</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Daily Reports</p>
                <p class="mt-3 text-3xl font-bold text-slate-900">{{ $reportStats['daily'] ?? 0 }}</p>
                <p class="mt-2 text-sm text-slate-600">Generated reports</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Total Reports</p>
                <p class="mt-3 text-3xl font-bold text-slate-900">{{ array_sum((array)$reportStats) }}</p>
                <p class="mt-2 text-sm text-slate-600">All time</p>
            </div>
        </div>

        <!-- Available Reports Grid -->
        <div>
            <h2 class="text-2xl font-bold text-slate-900 mb-6">Available Reports</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Patient Reports Card -->
                <a href="{{ route('reports.patient') }}" class="bg-white rounded-xl shadow-sm border border-slate-200 hover:shadow-lg hover:border-blue-300 transition p-8">
                    <div class="text-4xl mb-4">👥</div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Patient Reports</h3>
                    <p class="text-slate-600 text-sm mb-4">Comprehensive patient statistics, admissions, demographics, and admission trends</p>
                    <ul class="space-y-2 text-sm text-slate-600 mb-6">
                        <li class="flex items-center">✓ Total & New Patients</li>
                        <li class="flex items-center">✓ Admission Analytics</li>
                        <li class="flex items-center">✓ Gender & Age Statistics</li>
                        <li class="flex items-center">✓ Department Distribution</li>
                    </ul>
                    <span class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white">
                        View Report →
                    </span>
                </a>

                <!-- Financial Reports Card -->
                <a href="{{ route('reports.financial') }}" class="bg-white rounded-xl shadow-sm border border-slate-200 hover:shadow-lg hover:border-green-300 transition p-8">
                    <div class="text-4xl mb-4">💰</div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Financial Reports</h3>
                    <p class="text-slate-600 text-sm mb-4">Revenue tracking, billing analysis, payment collection, and financial metrics</p>
                    <ul class="space-y-2 text-sm text-slate-600 mb-6">
                        <li class="flex items-center">✓ Revenue & Expenses</li>
                        <li class="flex items-center">✓ Billing Analysis</li>
                        <li class="flex items-center">✓ Payment Status</li>
                        <li class="flex items-center">✓ Department Revenue</li>
                    </ul>
                    <span class="inline-flex items-center justify-center rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white">
                        View Report →
                    </span>
                </a>

                <!-- Daily Reports Card -->
                <a href="{{ route('reports.daily') }}" class="bg-white rounded-xl shadow-sm border border-slate-200 hover:shadow-lg hover:border-purple-300 transition p-8">
                    <div class="text-4xl mb-4">📅</div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Daily Reports</h3>
                    <p class="text-slate-600 text-sm mb-4">Real-time daily operations dashboard with today's key metrics and summaries</p>
                    <ul class="space-y-2 text-sm text-slate-600 mb-6">
                        <li class="flex items-center">✓ Today's Summary</li>
                        <li class="flex items-center">✓ Admissions & Discharges</li>
                        <li class="flex items-center">✓ Hourly Activity</li>
                        <li class="flex items-center">✓ Staff Attendance</li>
                    </ul>
                    <span class="inline-flex items-center justify-center rounded-lg bg-purple-600 px-4 py-2 text-sm font-semibold text-white">
                        View Report →
                    </span>
                </a>

                <!-- Lab Reports Card -->
                <a href="{{ route('reports.lab') }}" class="bg-white rounded-xl shadow-sm border border-slate-200 hover:shadow-lg hover:border-red-300 transition p-8">
                    <div class="text-4xl mb-4">🔬</div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Lab Reports</h3>
                    <p class="text-slate-600 text-sm mb-4">Laboratory test analytics, result trends, and test utilization statistics</p>
                    <ul class="space-y-2 text-sm text-slate-600 mb-6">
                        <li class="flex items-center">✓ Test Volume Trends</li>
                        <li class="flex items-center">✓ Result Analysis</li>
                        <li class="flex items-center">✓ Lab Revenue</li>
                        <li class="flex items-center">✓ Performance Metrics</li>
                    </ul>
                    <span class="inline-flex items-center justify-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white">
                        View Report →
                    </span>
                </a>

                <!-- Pharmacy Reports Card -->
                <a href="{{ route('reports.pharmacy') }}" class="bg-white rounded-xl shadow-sm border border-slate-200 hover:shadow-lg hover:border-yellow-300 transition p-8">
                    <div class="text-4xl mb-4">💊</div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Pharmacy Reports</h3>
                    <p class="text-slate-600 text-sm mb-4">Medicine inventory, sales analysis, stock management, and pharmacy metrics</p>
                    <ul class="space-y-2 text-sm text-slate-600 mb-6">
                        <li class="flex items-center">✓ Sales & Inventory</li>
                        <li class="flex items-center">✓ Stock Levels</li>
                        <li class="flex items-center">✓ Expiry Management</li>
                        <li class="flex items-center">✓ Supplier Analysis</li>
                    </ul>
                    <span class="inline-flex items-center justify-center rounded-lg bg-yellow-600 px-4 py-2 text-sm font-semibold text-white">
                        View Report →
                    </span>
                </a>

                <!-- Custom Reports Card -->
                <a href="{{ route('reports.create') }}" class="bg-white rounded-xl shadow-sm border border-slate-200 hover:shadow-lg hover:border-slate-300 transition p-8">
                    <div class="text-4xl mb-4">⚙️</div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Generate Custom Report</h3>
                    <p class="text-slate-600 text-sm mb-4">Create custom reports with specific parameters and date ranges</p>
                    <ul class="space-y-2 text-sm text-slate-600 mb-6">
                        <li class="flex items-center">✓ Custom Filters</li>
                        <li class="flex items-center">✓ Date Ranges</li>
                        <li class="flex items-center">✓ Export Options</li>
                        <li class="flex items-center">✓ Saved Reports</li>
                    </ul>
                    <span class="inline-flex items-center justify-center rounded-lg bg-slate-600 px-4 py-2 text-sm font-semibold text-white">
                        Create Report →
                    </span>
                </a>
            </div>
        </div>

        <!-- Recent Reports -->
        @if($recentReports->count() > 0)
            <div>
                <h2 class="text-2xl font-bold text-slate-900 mb-6">Recent Reports</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($recentReports as $report)
                        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-4 hover:shadow-md transition">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $report->name }}</p>
                                    <p class="text-xs text-slate-500 mt-1">{{ ucfirst($report->type) }} Report</p>
                                </div>
                                <button onclick="toggleFavorite({{ $report->id }})" class="text-xl {{ $report->is_favorite ? 'text-yellow-400' : 'text-slate-300' }}">
                                    ★
                                </button>
                            </div>
                            <p class="text-sm text-slate-600 mb-4">Generated {{ $report->created_at->diffForHumans() }}</p>
                            <div class="flex gap-2">
                                <a href="{{ route('reports.show', $report) }}" class="flex-1 text-center text-sm font-semibold text-blue-600 hover:text-blue-700">View</a>
                                <a href="{{ route('reports.export', $report) }}" class="flex-1 text-center text-sm font-semibold text-green-600 hover:text-green-700">Export</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- All Reports List -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-slate-900">All Generated Reports</h2>
                <form method="GET" class="flex gap-2">
                    <input type="text" name="search" placeholder="Search reports..." value="{{ $search }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">Search</button>
                </form>
            </div>

            @if(session('success'))
                <div class="rounded-lg border border-green-200 bg-green-50 px-5 py-4 text-green-700 shadow-sm mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto rounded-lg border border-slate-200 bg-white shadow-sm">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Name</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Type</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Period</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Created By</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($reports as $report)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-5 text-sm font-medium text-slate-900">{{ $report->name }}</td>
                                <td class="px-6 py-5 text-sm text-slate-500">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold 
                                        @if($report->type == 'patient') bg-blue-100 text-blue-800
                                        @elseif($report->type == 'financial') bg-emerald-100 text-emerald-800
                                        @elseif($report->type == 'daily') bg-amber-100 text-amber-800
                                        @elseif($report->type == 'lab') bg-red-100 text-red-800
                                        @elseif($report->type == 'pharmacy') bg-yellow-100 text-yellow-800
                                        @else bg-slate-100 text-slate-700
                                        @endif">
                                        {{ ucfirst($report->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-sm text-slate-500">
                                    {{ $report->parameters['start_date'] ?? 'Any' }} — {{ $report->parameters['end_date'] ?? 'Any' }}
                                </td>
                                <td class="px-6 py-5 text-sm text-slate-500">{{ $report->creator->name ?? 'N/A' }}</td>
                                <td class="px-6 py-5 text-sm text-slate-500">{{ $report->created_at->format('M d, Y H:i') }}</td>
                                <td class="px-6 py-5 text-sm font-medium text-slate-700 flex gap-3 items-center">
                                    <a href="{{ route('reports.show', $report) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                    <a href="{{ route('reports.export', $report) }}" class="text-green-600 hover:text-green-900">Export</a>
                                    <form action="{{ route('reports.destroy', $report) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
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
                                            <p class="text-lg font-semibold text-slate-900">No reports found</p>
                                            <p class="mt-1 text-sm text-slate-500">Create a new report to get started.</p>
                                        </div>
                                        <a href="{{ route('reports.create') }}" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700">Generate Report</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($reports->lastPage() > 1)
                <div class="mt-6">
                    {{ $reports->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function toggleFavorite(reportId) {
    fetch(`/reports/${reportId}/toggle-favorite`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            location.reload();
        }
    });
}
</script>

@endsection
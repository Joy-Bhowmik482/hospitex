@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-slate-800 mb-2">Maintenance Schedule</h2>
                <p class="text-slate-600">Manage equipment maintenance and servicing schedules</p>
            </div>
            <div class="flex gap-3">
                <button class="bg-slate-100 text-slate-700 font-semibold py-3 px-4 rounded-lg hover:bg-slate-200 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export
                </button>
                <button class="bg-slate-100 text-slate-700 font-semibold py-3 px-4 rounded-lg hover:bg-slate-200 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print
                </button>
                <a href="{{ route('maintenance-schedules.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Schedule Maintenance
                </a>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Upcoming This Week</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $upcomingThisWeek }}</p>
                </div>
                <div class="bg-orange-100 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Overdue</p>
                    <p class="text-2xl font-bold text-red-600">{{ $overdue }}</p>
                </div>
                <div class="bg-red-100 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Completed This Month</p>
                    <p class="text-2xl font-bold text-green-600">{{ $completedThisMonth }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Total Cost This Month</p>
                    <p class="text-2xl font-bold text-indigo-600">${{ number_format($totalCostThisMonth, 2) }}</p>
                </div>
                <div class="bg-indigo-100 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Maintenance Calendar -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-slate-800">Maintenance Calendar</h3>
            <div class="flex gap-2">
                <button class="px-3 py-1 text-sm bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200">Today</button>
                <button class="px-3 py-1 text-sm bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200">Week</button>
                <button class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded-lg">Month</button>
            </div>
        </div>
        <div class="grid grid-cols-7 gap-2 mb-4">
            <div class="text-center text-sm font-medium text-slate-500 py-2">Sun</div>
            <div class="text-center text-sm font-medium text-slate-500 py-2">Mon</div>
            <div class="text-center text-sm font-medium text-slate-500 py-2">Tue</div>
            <div class="text-center text-sm font-medium text-slate-500 py-2">Wed</div>
            <div class="text-center text-sm font-medium text-slate-500 py-2">Thu</div>
            <div class="text-center text-sm font-medium text-slate-500 py-2">Fri</div>
            <div class="text-center text-sm font-medium text-slate-500 py-2">Sat</div>
        </div>
        <div class="grid grid-cols-7 gap-2">
            @for($i = 1; $i <= 35; $i++)
                <div class="min-h-[80px] border border-slate-200 rounded-lg p-2 {{ $i >= 25 && $i <= 31 ? 'bg-slate-50' : '' }}">
                    <div class="text-xs text-slate-500 mb-1">{{ $i <= 31 ? $i : '' }}</div>
                    @if($i == 15)
                        <div class="text-xs bg-orange-100 text-orange-800 px-1 py-0.5 rounded mb-1">X-Ray Service</div>
                    @endif
                    @if($i == 22)
                        <div class="text-xs bg-red-100 text-red-800 px-1 py-0.5 rounded mb-1">Ventilator Check</div>
                    @endif
                    @if($i == 28)
                        <div class="text-xs bg-green-100 text-green-800 px-1 py-0.5 rounded mb-1">MRI Calibration</div>
                    @endif
                </div>
            @endfor
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Search Equipment</label>
                <input type="text" placeholder="Asset name, code, or technician..." class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                <select class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option>All Status</option>
                    <option>Scheduled</option>
                    <option>In Progress</option>
                    <option>Completed</option>
                    <option>Overdue</option>
                    <option>Cancelled</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Priority</label>
                <select class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option>All Priorities</option>
                    <option>Critical</option>
                    <option>High</option>
                    <option>Medium</option>
                    <option>Low</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Department</label>
                <select class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option>All Departments</option>
                    <option>Radiology</option>
                    <option>Surgery</option>
                    <option>Laboratory</option>
                    <option>Emergency</option>
                </select>
            </div>
        </div>
        <div class="flex gap-3 mt-4">
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Apply Filters</button>
            <button class="bg-slate-100 text-slate-700 px-4 py-2 rounded-lg hover:bg-slate-200 transition">Clear Filters</button>
        </div>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
            <span class="text-xl">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- No Maintenance Schedules Message -->
    @if ($maintenanceSchedules->isEmpty())
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-12 text-center">
            <div class="text-6xl mb-4">🔧</div>
            <h3 class="text-xl font-semibold text-slate-800 mb-2">No Maintenance Schedules Found</h3>
            <p class="text-slate-600 mb-6">There are no maintenance schedules in the system yet. Click the button below to schedule your first maintenance.</p>
            <a href="{{ route('maintenance-schedules.create') }}" class="inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:shadow-lg transition">
                Schedule First Maintenance
            </a>
        </div>
    @else
        <!-- Maintenance Schedules List Table -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-800">Maintenance Schedule</h3>
                <p class="text-sm text-slate-600">Complete equipment maintenance and servicing overview</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <!-- Table Header -->
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-slate-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Equipment</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Type</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Priority</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Scheduled Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Technician</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-700">Department</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Cost</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-700">Actions</th>
                        </tr>
                    </thead>
                    <!-- Table Body -->
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($maintenanceSchedules as $schedule)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-sm text-slate-700">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center
                                            @if($schedule->priority === 'critical') bg-red-100
                                            @elseif($schedule->priority === 'high') bg-orange-100
                                            @elseif($schedule->priority === 'medium') bg-yellow-100
                                            @else bg-green-100 @endif">
                                            <svg class="w-4 h-4
                                                @if($schedule->priority === 'critical') text-red-600
                                                @elseif($schedule->priority === 'high') text-orange-600
                                                @elseif($schedule->priority === 'medium') text-yellow-600
                                                @else text-green-600 @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-medium">{{ $schedule->asset->name ?? 'Unknown Equipment' }}</div>
                                            <div class="text-xs text-slate-500">{{ $schedule->asset->asset_code ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-700">{{ ucfirst($schedule->maintenance_type) }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($schedule->priority === 'critical') bg-red-100 text-red-800
                                        @elseif($schedule->priority === 'high') bg-orange-100 text-orange-800
                                        @elseif($schedule->priority === 'medium') bg-yellow-100 text-yellow-800
                                        @else bg-green-100 text-green-800 @endif">
                                        {{ ucfirst($schedule->priority) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-700">
                                    <div class="font-medium">{{ $schedule->scheduled_date->format('M d, Y') }}</div>
                                    <div class="text-xs text-slate-500">{{ $schedule->scheduled_date->format('H:i') }}
                                        @if($schedule->scheduled_end_date) - {{ $schedule->scheduled_end_date->format('H:i') }} @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-700">{{ $schedule->technician_name ?? 'Not Assigned' }}</td>
                                <td class="px-6 py-4 text-sm text-slate-700">{{ $schedule->department ?? 'General' }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($schedule->status === 'completed') bg-green-100 text-green-800
                                        @elseif($schedule->status === 'in_progress') bg-blue-100 text-blue-800
                                        @elseif($schedule->status === 'overdue') bg-red-100 text-red-800
                                        @elseif($schedule->status === 'cancelled') bg-gray-100 text-gray-800
                                        @else bg-orange-100 text-orange-800 @endif">
                                        {{ ucfirst(str_replace('_', ' ', $schedule->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-slate-700">
                                    @if($schedule->actual_cost)
                                        ${{ number_format($schedule->actual_cost, 2) }}
                                    @elseif($schedule->estimated_cost)
                                        ${{ number_format($schedule->estimated_cost, 2) }} (est.)
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('maintenance-schedules.show', $schedule) }}" class="text-blue-600 hover:text-blue-800 p-1 rounded transition" title="View Details">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        @if($schedule->status !== 'completed' && $schedule->status !== 'cancelled')
                                            <form action="{{ route('maintenance-schedules.complete', $schedule) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-800 p-1 rounded transition" title="Mark Complete">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('maintenance-schedules.edit', $schedule) }}" class="text-slate-600 hover:text-slate-800 p-1 rounded transition" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

@endsection
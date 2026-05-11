@extends('includePage')

@section('content')
<div class="max-w-7xl mx-auto py-8">
    <!-- Header -->
    <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-4xl font-bold text-slate-900">Audit Trail</h1>
            <p class="text-slate-600 mt-2">Review all data modifications, record changes, and important system actions.</p>
        </div>
        <a href="{{ route('activity-logs.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-6 py-3 text-slate-700 font-semibold hover:bg-slate-50 transition">
            ← Back to Logs
        </a>
    </div>

    <!-- Statistics -->
    <div class="mb-8 grid gap-4 md:grid-cols-4">
        <div class="rounded-2xl bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 p-6">
            <p class="text-sm font-semibold text-blue-700 uppercase">Total Actions</p>
            <p class="text-3xl font-bold text-blue-900 mt-2">{{ $logs->total() }}</p>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-green-50 to-green-100 border border-green-200 p-6">
            <p class="text-sm font-semibold text-green-700 uppercase">Created</p>
            <p class="text-3xl font-bold text-green-900 mt-2">
                @php
                    $createdCount = collect($logs->items())->where('action', 'create')->count();
                @endphp
                {{ $createdCount }}
            </p>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-yellow-50 to-yellow-100 border border-yellow-200 p-6">
            <p class="text-sm font-semibold text-yellow-700 uppercase">Updated</p>
            <p class="text-3xl font-bold text-yellow-900 mt-2">
                @php
                    $updatedCount = collect($logs->items())->where('action', 'update')->count();
                @endphp
                {{ $updatedCount }}
            </p>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-red-50 to-red-100 border border-red-200 p-6">
            <p class="text-sm font-semibold text-red-700 uppercase">Deleted</p>
            <p class="text-3xl font-bold text-red-900 mt-2">
                @php
                    $deletedCount = collect($logs->items())->where('action', 'delete')->count();
                @endphp
                {{ $deletedCount }}
            </p>
        </div>
    </div>

    <!-- Filters -->
    <div class="mb-8 rounded-3xl border border-slate-200 bg-white shadow-sm p-6">
        <h2 class="text-lg font-semibold text-slate-900 mb-4">Filter Results</h2>
        <form method="GET" class="grid gap-4 lg:grid-cols-6">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">User</label>
                <select name="user_id" class="w-full rounded-2xl border border-slate-200 px-4 py-3 bg-white text-slate-800 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition">
                    <option value="">All Users</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Action</label>
                <select name="action" class="w-full rounded-2xl border border-slate-200 px-4 py-3 bg-white text-slate-800 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition">
                    <option value="">All Actions</option>
                    @foreach($actions as $action)
                        <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                            @if($action === 'create')
                                ➕ Create
                            @elseif($action === 'update')
                                ✏️ Update
                            @elseif($action === 'delete')
                                🗑️ Delete
                            @elseif($action === 'view_sensitive')
                                👁️ View Sensitive
                            @else
                                {{ ucfirst(str_replace('_', ' ', $action)) }}
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">From Date</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 bg-white text-slate-800 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">To Date</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 bg-white text-slate-800 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Route/Module</label>
                <input type="text" name="route" value="{{ request('route') }}" placeholder="e.g., /patients" class="w-full rounded-2xl border border-slate-200 px-4 py-3 bg-white text-slate-800 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition">
            </div>

            <div class="flex items-end gap-3">
                <button type="submit" class="rounded-2xl bg-blue-600 px-6 py-3 text-white font-semibold hover:bg-blue-700 transition w-full">🔍 Filter</button>
                <a href="{{ route('activity-logs.audit-trail') }}" class="rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-700 font-semibold hover:bg-slate-50 transition">↻</a>
            </div>
        </form>
    </div>

    <!-- Results -->
    @if ($logs->isEmpty())
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm p-12 text-center">
            <div class="text-6xl mb-4">📋</div>
            <h3 class="text-xl font-semibold text-slate-900 mb-2">No Audit Records Found</h3>
            <p class="text-slate-600 mb-6">No audit entries match your criteria. Data modifications will appear here automatically.</p>
            <a href="{{ route('activity-logs.audit-trail') }}" class="inline-block rounded-2xl bg-blue-600 px-6 py-3 text-white font-semibold hover:bg-blue-700 transition">Clear Filters</a>
        </div>
    @else
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-700">
                    <thead class="bg-gradient-to-r from-slate-100 to-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 font-semibold text-slate-900 uppercase text-xs">Date & Time</th>
                            <th class="px-6 py-4 font-semibold text-slate-900 uppercase text-xs">User</th>
                            <th class="px-6 py-4 font-semibold text-slate-900 uppercase text-xs">Action</th>
                            <th class="px-6 py-4 font-semibold text-slate-900 uppercase text-xs">Description</th>
                            <th class="px-6 py-4 font-semibold text-slate-900 uppercase text-xs">Module/Route</th>
                            <th class="px-6 py-4 font-semibold text-slate-900 uppercase text-xs">IP Address</th>
                            <th class="px-6 py-4 font-semibold text-slate-900 uppercase text-xs text-right">Details</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($logs as $log)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-semibold text-slate-900 whitespace-nowrap">
                                    {{ $log->created_at->format('M d, Y') }}<br>
                                    <span class="text-xs text-slate-500">{{ $log->created_at->format('H:i:s') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center font-semibold text-blue-700 text-xs">
                                            {{ substr($log->user->name ?? 'S', 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ $log->user->name ?? 'System' }}</p>
                                            <p class="text-xs text-slate-500">{{ $log->user->email ?? '' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold
                                        @if($log->action === 'create') bg-blue-100 text-blue-800
                                        @elseif($log->action === 'update') bg-yellow-100 text-yellow-800
                                        @elseif($log->action === 'delete') bg-red-100 text-red-800
                                        @elseif($log->action === 'view_sensitive') bg-purple-100 text-purple-800
                                        @else bg-slate-100 text-slate-800
                                        @endif">
                                        @if($log->action === 'create')
                                            ➕ Create
                                        @elseif($log->action === 'update')
                                            ✏️ Update
                                        @elseif($log->action === 'delete')
                                            🗑️ Delete
                                        @elseif($log->action === 'view_sensitive')
                                            👁️ View Sensitive
                                        @else
                                            {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-700 max-w-xs truncate" title="{{ $log->description ?? 'N/A' }}">
                                    {{ $log->description ?? 'No description' }}
                                </td>
                                <td class="px-6 py-4 font-mono text-xs text-slate-600">
                                    {{ $log->route ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 font-mono text-xs text-slate-600">
                                    {{ $log->ip_address ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('activity-logs.show', $log) }}" class="px-3 py-2 rounded-xl bg-blue-50 text-blue-700 font-semibold hover:bg-blue-100 transition text-xs">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $logs->links() }}
        </div>
    @endif
</div>
@endsection

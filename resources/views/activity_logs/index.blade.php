@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto py-8">

    <!-- Header -->
    <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

        <div>
            <h1 class="text-3xl font-bold text-slate-900">Activity Logs</h1>
            <p class="text-slate-600 mt-2">
                Track user activity and system actions across the application.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('activity-logs.login-history') }}"
               class="rounded-2xl border border-slate-200 bg-white px-6 py-3 text-slate-700 font-semibold hover:bg-slate-50 transition">
                Login History
            </a>

            <a href="{{ route('activity-logs.audit-trail') }}"
               class="rounded-2xl border border-slate-200 bg-white px-6 py-3 text-slate-700 font-semibold hover:bg-slate-50 transition">
                Audit Trail
            </a>
        </div>

    </div>

    <!-- Filters -->
    <div class="mb-8 rounded-3xl border border-slate-200 bg-white shadow-sm p-6">

        <form method="GET" class="grid gap-4 lg:grid-cols-5">

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">User</label>
                <select name="user_id" class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    <option value="">All Users</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Action</label>
                <select name="action" class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    <option value="">All Actions</option>
                    @foreach($actions as $action)
                        <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                            {{ ucfirst($action) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Date From</label>
                <input type="date" name="date_from"
                       value="{{ request('date_from') }}"
                       class="w-full rounded-2xl border border-slate-200 px-4 py-3">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Date To</label>
                <input type="date" name="date_to"
                       value="{{ request('date_to') }}"
                       class="w-full rounded-2xl border border-slate-200 px-4 py-3">
            </div>

            <div class="flex items-end gap-3">
                <button type="submit"
                        class="w-full rounded-2xl bg-blue-600 px-6 py-3 text-white font-semibold hover:bg-blue-700 transition">
                    Filter
                </button>

                <a href="{{ route('activity-logs.index') }}"
                   class="rounded-2xl border border-slate-200 px-6 py-3 text-slate-700 font-semibold hover:bg-slate-50 transition">
                    Reset
                </a>
            </div>

        </form>

    </div>

    <!-- Empty State -->
    @if ($logs->isEmpty())

        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm p-12 text-center">
            <div class="text-6xl mb-4">📝</div>
            <h3 class="text-xl font-semibold text-slate-900 mb-2">No Activity Recorded</h3>
            <p class="text-slate-600">
                There are no activity logs yet. Actions will appear here as users interact with the system.
            </p>
        </div>

    @else

        <!-- Table -->
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">

            <div class="overflow-x-auto">

                <table class="min-w-full text-left text-sm text-slate-700">

                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-5 py-4 text-xs font-semibold uppercase">Time</th>
                            <th class="px-5 py-4 text-xs font-semibold uppercase">User</th>
                            <th class="px-5 py-4 text-xs font-semibold uppercase">Action</th>
                            <th class="px-5 py-4 text-xs font-semibold uppercase">Description</th>
                            <th class="px-5 py-4 text-xs font-semibold uppercase">Route</th>
                            <th class="px-5 py-4 text-xs font-semibold uppercase">IP Address</th>
                            <th class="px-5 py-4 text-xs font-semibold uppercase text-right">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200">

                        @foreach ($logs as $log)
                            <tr class="hover:bg-slate-50 transition">

                                <td class="px-5 py-4 font-semibold text-slate-800">
                                    {{ $log->created_at->format('M d, Y H:i') }}
                                </td>

                                <td class="px-5 py-4">
                                    <p class="font-semibold text-slate-900">
                                        {{ $log->user->name ?? 'System' }}
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        {{ $log->user->email ?? '' }}
                                    </p>
                                </td>

                                <td class="px-5 py-4">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold
                                        @if($log->action === 'login') bg-green-100 text-green-800
                                        @elseif($log->action === 'logout') bg-gray-100 text-gray-800
                                        @elseif($log->action === 'create') bg-blue-100 text-blue-800
                                        @elseif($log->action === 'update') bg-yellow-100 text-yellow-800
                                        @elseif($log->action === 'delete') bg-red-100 text-red-800
                                        @else bg-slate-100 text-slate-800
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                    </span>
                                </td>

                                <td class="px-5 py-4">
                                    {{ $log->description ?? 'N/A' }}
                                </td>

                                <td class="px-5 py-4 font-mono text-xs">
                                    {{ $log->route ?? 'N/A' }}
                                </td>

                                <td class="px-5 py-4 font-mono text-xs">
                                    {{ $log->ip_address ?? 'N/A' }}
                                </td>

                                <td class="px-5 py-4 text-right">
                                    <a href="{{ route('activity-logs.show', $log) }}"
                                       class="px-3 py-2 rounded-2xl bg-slate-100 text-xs font-semibold hover:bg-slate-200">
                                        View
                                    </a>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $logs->links() }}
        </div>

    @endif

</div>

@endsection
@extends('includePage')

@section('content')
<div class="max-w-7xl mx-auto py-8">
    <!-- Header -->
    <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-4xl font-bold text-slate-900">Login History</h1>
            <p class="text-slate-600 mt-2">Review authentication events and session activity for all users.</p>
        </div>
        <a href="{{ route('activity-logs.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-6 py-3 text-slate-700 font-semibold hover:bg-slate-50 transition">
            ← Back to Logs
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="mb-8 grid gap-4 md:grid-cols-3">
        <div class="rounded-2xl bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 p-6">
            <p class="text-sm font-semibold text-blue-700 uppercase">Total Logins</p>
            <p class="text-3xl font-bold text-blue-900 mt-2">{{ $logs->total() }}</p>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-green-50 to-green-100 border border-green-200 p-6">
            <p class="text-sm font-semibold text-green-700 uppercase">Active Sessions</p>
            <p class="text-3xl font-bold text-green-900 mt-2">{{ $logs->where('status', 'active')->count() ?? 0 }}</p>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 p-6">
            <p class="text-sm font-semibold text-purple-700 uppercase">Unique Users</p>
            <p class="text-3xl font-bold text-purple-900 mt-2">{{ $users->count() }}</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="mb-8 rounded-3xl border border-slate-200 bg-white shadow-sm p-6">
        <h2 class="text-lg font-semibold text-slate-900 mb-4">Filter Results</h2>
        <form method="GET" class="grid gap-4 lg:grid-cols-5">
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
                <label class="block text-sm font-semibold text-slate-700 mb-2">From Date</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 bg-white text-slate-800 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">To Date</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 bg-white text-slate-800 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                <select name="status" class="w-full rounded-2xl border border-slate-200 px-4 py-3 bg-white text-slate-800 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>🟢 Active</option>
                    <option value="logged_out" {{ request('status') == 'logged_out' ? 'selected' : '' }}>🔴 Logged Out</option>
                </select>
            </div>

            <div class="flex items-end gap-3">
                <button type="submit" class="rounded-2xl bg-blue-600 px-6 py-3 text-white font-semibold hover:bg-blue-700 transition w-full">🔍 Filter</button>
                <a href="{{ route('activity-logs.login-history') }}" class="rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-700 font-semibold hover:bg-slate-50 transition">↻</a>
            </div>
        </form>
    </div>

    <!-- Results -->
    @if ($logs->isEmpty())
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm p-12 text-center">
            <div class="text-6xl mb-4">🔐</div>
            <h3 class="text-xl font-semibold text-slate-900 mb-2">No Login Events Found</h3>
            <p class="text-slate-600 mb-6">There are no login history records matching your criteria.</p>
            <a href="{{ route('activity-logs.login-history') }}" class="inline-block rounded-2xl bg-blue-600 px-6 py-3 text-white font-semibold hover:bg-blue-700 transition">Clear Filters</a>
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
                            <th class="px-6 py-4 font-semibold text-slate-900 uppercase text-xs">Session Status</th>
                            <th class="px-6 py-4 font-semibold text-slate-900 uppercase text-xs">Duration</th>
                            <th class="px-6 py-4 font-semibold text-slate-900 uppercase text-xs">IP Address</th>
                            <th class="px-6 py-4 font-semibold text-slate-900 uppercase text-xs">Device</th>
                            <th class="px-6 py-4 font-semibold text-slate-900 uppercase text-xs text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($logs as $log)
                            @php
                                $loginTime = $log->login_time ?? $log->created_at;
                                $logoutTime = $log->logout_time;
                                $duration = $logoutTime ? $logoutTime->diffInMinutes($loginTime) : null;
                            @endphp
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-semibold text-slate-900">
                                    {{ $loginTime->format('M d, Y') }}<br>
                                    <span class="text-xs text-slate-500">{{ $loginTime->format('H:i:s') }}</span>
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
                                        @if($log->action === 'login') bg-green-100 text-green-800
                                        @elseif($log->action === 'logout') bg-slate-100 text-slate-800
                                        @else bg-blue-100 text-blue-800
                                        @endif">
                                        @if($log->action === 'login')
                                            ✓ Login
                                        @elseif($log->action === 'logout')
                                            ✕ Logout
                                        @else
                                            {{ ucfirst($log->action) }}
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold
                                        @if($log->status === 'active') bg-green-100 text-green-800
                                        @elseif($log->status === 'logged_out') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800
                                        @endif">
                                        @if($log->status === 'active')
                                            🟢 Active
                                        @elseif($log->status === 'logged_out')
                                            🔴 Logged Out
                                        @else
                                            {{ ucfirst(str_replace('_', ' ', $log->status ?? 'unknown')) }}
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-mono text-xs text-slate-700">
                                    @if($duration)
                                        {{ $duration }} mins
                                    @else
                                        Ongoing
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-mono text-xs text-slate-600">{{ $log->ip_address ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-xs text-slate-600">{{ \Illuminate\Support\Str::limit($log->user_agent ?? 'N/A', 30) }}</td>
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

@extends('includePage')

@section('content')
<div class="max-w-5xl mx-auto py-8">
    <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Activity Log Details</h1>
            <p class="text-slate-600 mt-2">View the full details for this activity log entry.</p>
        </div>
        <a href="{{ route('activity-logs.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-6 py-3 text-slate-700 font-semibold hover:bg-slate-50 transition">Back</a>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm p-8">
        <div class="grid gap-6 md:grid-cols-2 mb-8">
            <div class="rounded-3xl border border-slate-100 bg-slate-50 p-6">
                <p class="text-sm uppercase tracking-widest text-slate-400 mb-2">Timestamp</p>
                <p class="text-lg font-semibold text-slate-900">{{ $log->created_at->format('M d, Y H:i:s') }}</p>
            </div>
            <div class="rounded-3xl border border-slate-100 bg-slate-50 p-6">
                <p class="text-sm uppercase tracking-widest text-slate-400 mb-2">User</p>
                <p class="text-lg font-semibold text-slate-900">{{ $log->user->name ?? 'System' }}</p>
                @if($log->user)
                    <p class="text-sm text-slate-600 mt-1">{{ $log->user->email }}</p>
                @endif
            </div>
            <div class="rounded-3xl border border-slate-100 bg-slate-50 p-6">
                <p class="text-sm uppercase tracking-widest text-slate-400 mb-2">Action</p>
                <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold
                    @if($log->action === 'login') bg-green-100 text-green-800
                    @elseif($log->action === 'logout') bg-gray-100 text-gray-800
                    @elseif($log->action === 'create') bg-blue-100 text-blue-800
                    @elseif($log->action === 'update') bg-yellow-100 text-yellow-800
                    @elseif($log->action === 'delete') bg-red-100 text-red-800
                    @elseif($log->action === 'view_sensitive') bg-purple-100 text-purple-800
                    @else bg-slate-100 text-slate-800
                    @endif">
                    {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                </span>
            </div>
            <div class="rounded-3xl border border-slate-100 bg-slate-50 p-6">
                <p class="text-sm uppercase tracking-widest text-slate-400 mb-2">Route</p>
                <p class="text-lg font-semibold text-slate-900 font-mono">{{ $log->route ?? 'N/A' }}</p>
            </div>
        </div>

        @if($log->description)
        <div class="mb-8 rounded-3xl border border-slate-100 bg-slate-50 p-6">
            <p class="text-sm uppercase tracking-widest text-slate-400 mb-2">Description</p>
            <p class="text-slate-900">{{ $log->description }}</p>
        </div>
        @endif

        <div class="grid gap-6 md:grid-cols-2 mb-8">
            @if($log->login_time || $log->logout_time)
            <div class="rounded-3xl border border-slate-100 bg-slate-50 p-6">
                <p class="text-sm uppercase tracking-widest text-slate-400 mb-2">Login Time</p>
                <p class="text-lg font-semibold text-slate-900">
                    @if($log->login_time)
                        {{ $log->login_time->format('M d, Y H:i:s') }}
                    @else
                        N/A
                    @endif
                </p>
            </div>
            <div class="rounded-3xl border border-slate-100 bg-slate-50 p-6">
                <p class="text-sm uppercase tracking-widest text-slate-400 mb-2">Logout Time</p>
                <p class="text-lg font-semibold text-slate-900">
                    @if($log->logout_time)
                        {{ $log->logout_time->format('M d, Y H:i:s') }}
                    @else
                        N/A
                    @endif
                </p>
            </div>
            @endif

            <div class="rounded-3xl border border-slate-100 bg-slate-50 p-6">
                <p class="text-sm uppercase tracking-widest text-slate-400 mb-2">IP Address</p>
                <p class="text-lg font-semibold text-slate-900 font-mono">{{ $log->ip_address ?? 'N/A' }}</p>
            </div>
            <div class="rounded-3xl border border-slate-100 bg-slate-50 p-6">
                <p class="text-sm uppercase tracking-widest text-slate-400 mb-2">Status</p>
                <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold
                    @if($log->status === 'active') bg-green-100 text-green-800
                    @elseif($log->status === 'logged_out') bg-red-100 text-red-800
                    @else bg-slate-100 text-slate-800
                    @endif">
                    {{ ucfirst(str_replace('_', ' ', $log->status ?? 'unknown')) }}
                </span>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-100 bg-slate-50 p-6">
            <p class="text-sm uppercase tracking-widest text-slate-400 mb-2">User Agent</p>
            <p class="text-slate-900 font-mono text-sm break-all">{{ $log->user_agent ?? 'N/A' }}</p>
        </div>

        @if($log->meta)
        <div class="mt-8 rounded-3xl border border-slate-100 bg-slate-50 p-6">
            <p class="text-sm uppercase tracking-widest text-slate-400 mb-2">Additional Data</p>
            <pre class="text-sm text-slate-900 bg-white p-4 rounded-2xl overflow-x-auto">{{ json_encode($log->meta, JSON_PRETTY_PRINT) }}</pre>
        </div>
        @endif
    </div>
</div>


        </div>

        <div class="space-y-4">
            <div>
                <h3 class="text-xl font-semibold text-slate-800 mb-2">Metadata</h3>
                <pre class="rounded-2xl bg-slate-50 border border-slate-200 p-4 text-sm text-slate-700 overflow-x-auto">{{ json_encode($log->meta, JSON_PRETTY_PRINT) }}</pre>
            </div>
        </div>
    </div>
</div>

@endsection

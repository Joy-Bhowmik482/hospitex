@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Activity Log Details</h2>
            <p class="text-slate-600">View the full details for this activity log entry.</p>
        </div>
        <a href="{{ route('activity-logs.index') }}" class="bg-slate-200 text-slate-800 px-4 py-2 rounded-xl hover:bg-slate-300 transition">Back</a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-lg p-8">
        <div class="grid gap-6 md:grid-cols-2 mb-8">
            <div>
                <p class="text-sm uppercase tracking-widest text-slate-400">Timestamp</p>
                <p class="mt-2 text-lg font-semibold text-slate-800">{{ $log->created_at->format('M d, Y H:i') }}</p>
            </div>
            <div>
                <p class="text-sm uppercase tracking-widest text-slate-400">User</p>
                <p class="mt-2 text-lg font-semibold text-slate-800">{{ $log->user->name ?? 'System' }}</p>
            </div>
            <div>
                <p class="text-sm uppercase tracking-widest text-slate-400">Action</p>
                <p class="mt-2 text-lg font-semibold text-slate-800">{{ $log->action }}</p>
            </div>
            <div>
                <p class="text-sm uppercase tracking-widest text-slate-400">Module</p>
                <p class="mt-2 text-lg font-semibold text-slate-800">{{ $log->module }}</p>
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2 mb-8">
            <div>
                <p class="text-sm uppercase tracking-widest text-slate-400">Record Type</p>
                <p class="mt-2 text-lg font-semibold text-slate-800">{{ $log->record_type }}</p>
            </div>
            <div>
                <p class="text-sm uppercase tracking-widest text-slate-400">Record ID</p>
                <p class="mt-2 text-lg font-semibold text-slate-800">{{ $log->record_id }}</p>
            </div>
            <div>
                <p class="text-sm uppercase tracking-widest text-slate-400">IP Address</p>
                <p class="mt-2 text-lg font-semibold text-slate-800">{{ $log->ip ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm uppercase tracking-widest text-slate-400">User Agent</p>
                <p class="mt-2 text-lg font-semibold text-slate-800">{{ \Illuminate\Support\Str::limit($log->user_agent ?? 'N/A', 90) }}</p>
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

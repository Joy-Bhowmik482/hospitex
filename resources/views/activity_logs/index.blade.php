@extends('includePage')

@section('content')

<div class="max-w-7xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Activity Logs</h2>
            <p class="text-slate-600">Track user activity and system actions across the application.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('activity-logs.login-history') }}" class="bg-slate-200 text-slate-800 px-4 py-2 rounded-xl hover:bg-slate-300 transition">Login History</a>
            <a href="{{ route('activity-logs.audit-trail') }}" class="bg-slate-200 text-slate-800 px-4 py-2 rounded-xl hover:bg-slate-300 transition">Audit Trail</a>
        </div>
    </div>

    @if ($logs->isEmpty())
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-12 text-center">
            <div class="text-6xl mb-4">📝</div>
            <h3 class="text-xl font-semibold text-slate-800 mb-2">No Activity Recorded</h3>
            <p class="text-slate-600">There are no activity logs yet. Actions will appear here as users interact with the system.</p>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold uppercase text-slate-700">Time</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase text-slate-700">User</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase text-slate-700">Action</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase text-slate-700">Module</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase text-slate-700">Record</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase text-slate-700">Details</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($logs as $log)
                            <tr class="hover:bg-slate-50 transition duration-150">
                                <td class="px-6 py-4 text-slate-700">{{ $log->created_at->format('M d, Y H:i') }}</td>
                                <td class="px-6 py-4 text-slate-800">{{ $log->user->name ?? 'System' }}</td>
                                <td class="px-6 py-4 text-slate-700">{{ $log->action }}</td>
                                <td class="px-6 py-4 text-slate-700">{{ $log->module }}</td>
                                <td class="px-6 py-4 text-slate-700">{{ $log->record_type }} #{{ $log->record_id }}</td>
                                <td class="px-6 py-4 text-slate-800">
                                    <a href="{{ route('activity-logs.show', $log) }}" class="text-blue-600 hover:text-blue-800 font-semibold">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4">
                {{ $logs->links() }}
            </div>
        </div>
    @endif
</div>

@endsection

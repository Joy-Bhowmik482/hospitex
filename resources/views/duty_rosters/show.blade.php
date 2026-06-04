@extends('includePage')

@section('content')
<div class="max-w-5xl mx-auto py-8">
    <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Roster Detail</h1>
            <p class="text-slate-600 mt-2">Review the assigned doctor, staff, shift, and location for this roster entry.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('duty-rosters.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-6 py-3 text-slate-700 font-semibold hover:bg-slate-50 transition">Back to list</a>
            <a href="{{ route('duty-rosters.edit', $dutyRoster) }}" class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-6 py-3 text-white font-semibold hover:bg-blue-700 transition">Edit entry</a>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm p-8">
        <div class="grid gap-6 md:grid-cols-2">
            <div class="space-y-4 rounded-3xl border border-slate-100 bg-slate-50 p-6">
                <h2 class="text-lg font-semibold text-slate-900">Assignment</h2>
                <p><span class="font-semibold text-slate-700">Day:</span> {{ ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'][$dutyRoster->day_of_week] ?? 'Unknown' }}</p>
                <p><span class="font-semibold text-slate-700">Shift:</span> {{ $dutyRoster->shift->name ?? 'N/A' }}</p>
                <p><span class="font-semibold text-slate-700">Time:</span> {{ \Carbon\Carbon::parse($dutyRoster->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($dutyRoster->end_time)->format('g:i A') }}</p>
                <p><span class="font-semibold text-slate-700">Active:</span> <span class="font-medium text-{{ $dutyRoster->is_active ? 'emerald' : 'rose' }}-600">{{ $dutyRoster->is_active ? 'Yes' : 'No' }}</span></p>
            </div>
            <div class="space-y-4 rounded-3xl border border-slate-100 bg-slate-50 p-6">
                <h2 class="text-lg font-semibold text-slate-900">People</h2>
                <p><span class="font-semibold text-slate-700">Doctor:</span> {{ $dutyRoster->doctor->name ?? 'N/A' }} @if(optional($dutyRoster->doctor)->specialization) - {{ $dutyRoster->doctor->specialization }}@endif</p>
                <p><span class="font-semibold text-slate-700">Staff:</span> {{ $dutyRoster->staff->name ?? 'N/A' }} @if(optional($dutyRoster->staff)->designation) - {{ $dutyRoster->staff->designation }}@endif</p>
                <p><span class="font-semibold text-slate-700">Department:</span> {{ $dutyRoster->department->name ?? 'N/A' }}</p>
                <p><span class="font-semibold text-slate-700">Ward:</span> {{ $dutyRoster->ward->name ?? 'N/A' }}</p>
                <p><span class="font-semibold text-slate-700">Room:</span> {{ $dutyRoster->room->room_no ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="mt-8 rounded-3xl border border-slate-100 bg-slate-50 p-6">
            <h2 class="text-lg font-semibold text-slate-900">Task / Responsibility</h2>
            <p class="text-slate-700">{{ $dutyRoster->task_description ?? 'No task description provided.' }}</p>
        </div>

        <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-between">
            <form action="{{ route('duty-rosters.destroy', $dutyRoster) }}" method="POST" onsubmit="return confirm('Delete this roster entry?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-rose-600 px-6 py-3 text-white font-semibold hover:bg-rose-700 transition">Delete Entry</button>
            </form>
            <a href="{{ route('duty-rosters.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-6 py-3 text-slate-700 font-semibold hover:bg-slate-50 transition">Return to roster list</a>
        </div>
    </div>
</div>
@endsection

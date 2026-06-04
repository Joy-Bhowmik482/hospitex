@extends('includePage')

@section('content')
<div class="max-w-7xl mx-auto py-8">
    <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Weekly Duty Roster</h1>
            <p class="text-slate-600 mt-2">View active medical team assignments by weekday and schedule.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('duty-rosters.print') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-6 py-3 text-slate-700 font-semibold hover:bg-slate-50 transition">Print roster</a>
            <a href="{{ route('duty-rosters.index') }}" class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-6 py-3 text-white font-semibold hover:bg-blue-700 transition">Manage roster</a>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        @foreach($daysOfWeek as $dayKey => $dayLabel)
            <section class="rounded-3xl border border-slate-200 bg-white shadow-sm p-6">
                <div class="mb-4 flex items-center justify-between gap-4">
                    <h2 class="text-xl font-semibold text-slate-900">{{ $dayLabel }}</h2>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-600">{{ optional($rosters->get($dayKey))->count() ?? 0 }} assignments</span>
                </div>

                @if($rosters->has($dayKey) && $rosters->get($dayKey)->isNotEmpty())
                    <div class="space-y-4">
                        @foreach($rosters->get($dayKey) as $roster)
                            <article class="rounded-3xl border border-slate-200 bg-slate-50 p-5 shadow-sm">
                                <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                                    <div class="space-y-2">
                                        <p class="text-sm font-semibold text-slate-700">{{ $roster->shift->name ?? 'Shift' }} • {{ \Carbon\Carbon::parse($roster->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($roster->end_time)->format('g:i A') }}</p>
                                        <h3 class="text-lg font-semibold text-slate-900">{{ $roster->doctor->name ?? 'Doctor not assigned' }}</h3>
                                        <p class="text-sm text-slate-600">{{ optional($roster->doctor)->specialization ? $roster->doctor->specialization : 'General care' }}</p>
                                    </div>
                                    <div class="space-y-2 text-right">
                                        <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-700">{{ $roster->is_active ? 'Active' : 'Inactive' }}</span>
                                        <a href="{{ route('duty-rosters.show', $roster) }}" class="text-sm font-semibold text-slate-700 hover:text-blue-600">View details</a>
                                    </div>
                                </div>

                                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                    <div class="rounded-3xl bg-white p-4 shadow-sm">
                                        <p class="text-sm font-semibold text-slate-700">Staff</p>
                                        <p class="text-slate-800">{{ $roster->staff->name ?? 'Unassigned' }}</p>
                                    </div>
                                    <div class="rounded-3xl bg-white p-4 shadow-sm">
                                        <p class="text-sm font-semibold text-slate-700">Location</p>
                                        <p class="text-slate-800">{{ optional($roster->ward)->name ?? 'No ward' }} &middot; {{ optional($roster->room)->room_no ?? 'No room' }}</p>
                                    </div>
                                </div>

                                <div class="mt-4 rounded-3xl bg-slate-100 p-4 text-sm text-slate-700">
                                    <p class="font-semibold text-slate-800">Task:</p>
                                    <p>{{ $roster->task_description ?? 'No task assigned.' }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-slate-500">No active assignments for this day.</p>
                @endif
            </section>
        @endforeach
    </div>
</div>
@endsection

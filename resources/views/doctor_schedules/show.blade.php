@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Schedule Details</h2>
            <p class="text-slate-600">Detailed information for this doctor's schedule.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('doctor-schedules.edit', $doctorSchedule) }}" class="bg-amber-50 hover:bg-amber-100 text-amber-700 font-semibold py-2 px-6 rounded-lg transition">
                ✏️ Edit Schedule
            </a>
            <a href="{{ route('doctor-schedules.index') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-800 font-semibold py-2 px-6 rounded-lg transition">
                ← Back to List
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Doctor</p>
                <p class="text-base text-slate-800 font-semibold">{{ $doctorSchedule->doctor->name ?? 'Doctor' }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Specialization</p>
                <p class="text-base text-slate-800">{{ $doctorSchedule->doctor->specialization }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Day</p>
                <p class="text-base text-slate-800">{{ ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'][$doctorSchedule->day_of_week] }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Start Time</p>
                <p class="text-base text-slate-800">{{ \\Carbon\\Carbon::createFromFormat('H:i:s',$doctorSchedule->start_time)->format('g:i A') }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-600 font-semibold uppercase mb-1">End Time</p>
                <p class="text-base text-slate-800">{{ \\Carbon\\Carbon::createFromFormat('H:i:s',$doctorSchedule->end_time)->format('g:i A') }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Room</p>
                <p class="text-base text-slate-800">{{ $doctorSchedule->room_no ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-600 font-semibold uppercase mb-1">Status</p>
                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $doctorSchedule->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $doctorSchedule->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
        </div>
    </div>
</div>

@endsection
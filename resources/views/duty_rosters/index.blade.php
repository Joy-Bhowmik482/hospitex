@extends('includePage')

@section('content')
<div class="max-w-7xl mx-auto py-8">
    <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Duty Roster</h1>
            <p class="text-slate-600 mt-2">Manage assigned doctors, staff, shifts, rooms, and responsibilities with filters and reports.</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('duty-rosters.create') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-blue-600 text-white font-semibold shadow hover:bg-blue-700 transition">+ Add Roster</a>
            <a href="{{ route('duty-rosters.print', request()->query()) }}" target="_blank" class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-slate-100 text-slate-800 font-semibold shadow hover:bg-slate-200 transition">Print</a>
            <a href="{{ route('duty-rosters.export-pdf', request()->query()) }}" class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-slate-100 text-slate-800 font-semibold shadow hover:bg-slate-200 transition">Export PDF</a>
        </div>
    </div>

    <div class="grid gap-5 xl:grid-cols-[1fr_320px] mb-8">
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm p-6">
            <div class="flex items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Roster List</h2>
                    <p class="text-slate-500">Filtered results show the latest duty assignments.</p>
                </div>
                <span class="rounded-full bg-blue-50 text-blue-700 px-3 py-1 text-sm font-semibold">{{ $rosters->total() }} entries</span>
            </div>

            <form method="GET" class="grid gap-4 lg:grid-cols-3">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Day</label>
                    <select name="day_of_week" class="w-full rounded-2xl border border-slate-200 px-4 py-3 bg-white text-slate-800 focus:border-blue-500 focus:ring-blue-500 outline-none">
                        <option value="">All days</option>
                        @foreach($daysOfWeek as $key => $label)
                            <option value="{{ $key }}" {{ request('day_of_week') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Doctor</label>
                    <select name="doctor_id" class="w-full rounded-2xl border border-slate-200 px-4 py-3 bg-white text-slate-800 focus:border-blue-500 focus:ring-blue-500 outline-none">
                        <option value="">All doctors</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>{{ $doctor->name }}@if($doctor->specialization) - {{ $doctor->specialization }}@endif</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Staff</label>
                    <select name="staff_id" class="w-full rounded-2xl border border-slate-200 px-4 py-3 bg-white text-slate-800 focus:border-blue-500 focus:ring-blue-500 outline-none">
                        <option value="">All staff</option>
                        @foreach($staff as $member)
                            <option value="{{ $member->id }}" {{ request('staff_id') == $member->id ? 'selected' : '' }}>{{ $member->name }}@if($member->designation) - {{ $member->designation }}@endif</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Department</label>
                    <select name="department_id" class="w-full rounded-2xl border border-slate-200 px-4 py-3 bg-white text-slate-800 focus:border-blue-500 focus:ring-blue-500 outline-none">
                        <option value="">All departments</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Shift</label>
                    <select name="shift_id" class="w-full rounded-2xl border border-slate-200 px-4 py-3 bg-white text-slate-800 focus:border-blue-500 focus:ring-blue-500 outline-none">
                        <option value="">All shifts</option>
                        @foreach($shifts as $shift)
                            <option value="{{ $shift->id }}" {{ request('shift_id') == $shift->id ? 'selected' : '' }}>{{ $shift->name }} ({{ \Carbon\Carbon::createFromFormat('H:i:s', $shift->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $shift->end_time)->format('g:i A') }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                    <select name="is_active" class="w-full rounded-2xl border border-slate-200 px-4 py-3 bg-white text-slate-800 focus:border-blue-500 focus:ring-blue-500 outline-none">
                        <option value="">Any status</option>
                        <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="lg:col-span-3 flex flex-col sm:flex-row gap-3 items-stretch">
                    <button type="submit" class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">Apply Filters</button>
                    <a href="{{ route('duty-rosters.index') }}" class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-slate-100 text-slate-800 font-semibold hover:bg-slate-200 transition">Reset</a>
                </div>
            </form>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-gradient-to-br from-slate-50 to-white shadow-sm p-6">
            <div class="space-y-5">
                <div class="rounded-3xl bg-slate-900 p-6 text-white shadow-lg">
                    <h3 class="text-xl font-semibold">Roster Summary</h3>
                    <p class="text-slate-300 mt-2">Quick snapshot of roster capacity and scheduling status.</p>
                </div>
                <div class="grid gap-4">
                    <div class="rounded-3xl border border-slate-200 p-4 bg-white">
                        <p class="text-sm text-slate-500">Total assignments</p>
                        <p class="text-3xl font-bold text-slate-900">{{ $rosters->total() }}</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 p-4 bg-white">
                        <p class="text-sm text-slate-500">Active entries</p>
                        <p class="text-3xl font-bold text-emerald-700">{{ $rosters->where('is_active', true)->count() }}</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 p-4 bg-white">
                        <p class="text-sm text-slate-500">Inactive entries</p>
                        <p class="text-3xl font-bold text-rose-700">{{ $rosters->where('is_active', false)->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-slate-700">
                    <tr>
                        <th class="px-5 py-4">Day</th>
                        <th class="px-5 py-4">Doctor</th>
                        <th class="px-5 py-4">Staff</th>
                        <th class="px-5 py-4">Department</th>
                        <th class="px-5 py-4">Ward / Room</th>
                        <th class="px-5 py-4">Shift</th>
                        <th class="px-5 py-4">Task</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($rosters as $roster)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-4 font-semibold text-slate-800">{{ $daysOfWeek[$roster->day_of_week] ?? 'Unknown' }}</td>
                            <td class="px-5 py-4">
                                <p class="font-semibold text-slate-900">{{ $roster->doctor->name ?? 'N/A' }}</p>
                                <p class="text-xs text-slate-500">{{ $roster->doctor->specialization ?? 'General' }}</p>
                            </td>
                            <td class="px-5 py-4">
                                <p class="font-semibold text-slate-800">{{ optional($roster->staff)->name ?? 'None' }}</p>
                                <p class="text-xs text-slate-500">{{ optional($roster->staff)->designation ?? '—' }}</p>
                            </td>
                            <td class="px-5 py-4">{{ optional($roster->department)->name ?? optional($roster->doctor->department)->name ?? 'General' }}</td>
                            <td class="px-5 py-4">{{ optional($roster->ward)->name ?? 'No ward' }}<br>{{ optional($roster->room)->room_no ?? 'No room' }}</td>
                            <td class="px-5 py-4">{{ optional($roster->shift)->name ?? 'Custom' }}<br><span class="text-xs text-slate-500">{{ \Carbon\Carbon::createFromFormat('H:i:s', $roster->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $roster->end_time)->format('g:i A') }}</span></td>
                            <td class="px-5 py-4 text-slate-700">{{ $roster->task_description ?? 'General duties' }}</td>
                            <td class="px-5 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $roster->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">{{ $roster->is_active ? 'Active' : 'Inactive' }}</span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('duty-rosters.show', $roster) }}" class="px-3 py-2 rounded-2xl bg-slate-100 text-slate-800 text-xs font-semibold hover:bg-slate-200 transition">View</a>
                                    <a href="{{ route('duty-rosters.edit', $roster) }}" class="px-3 py-2 rounded-2xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition">Edit</a>
                                    <form action="{{ route('duty-rosters.destroy', $roster) }}" method="POST" onsubmit="return confirm('Delete this roster entry?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-2 rounded-2xl bg-rose-500 text-white text-xs font-semibold hover:bg-rose-600 transition">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-5 py-10 text-center text-slate-500">No duty roster entries match your filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $rosters->links() }}
    </div>
</div>
@endsection

@extends('includePage')

@section('content')
<div class="max-w-6xl mx-auto py-8">
    <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Edit Duty Roster</h1>
            <p class="text-slate-600 mt-2">Update shift assignments, staff, rooms, and responsibilities.</p>
        </div>
        <a href="{{ route('duty-rosters.index') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-slate-100 text-slate-800 font-semibold hover:bg-slate-200 transition">Back to list</a>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-3xl border border-rose-200 bg-rose-50 p-6 text-rose-800">
            <h2 class="font-semibold mb-2">Please fix the following errors:</h2>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm p-8">
        <form action="{{ route('duty-rosters.update', $dutyRoster) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-slate-700">Day</label>
                    <select id="day_of_week" name="day_of_week" class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select day</option>
                        @foreach([1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday', 0 => 'Sunday'] as $key => $label)
                            <option value="{{ $key }}" {{ old('day_of_week', $dutyRoster->day_of_week) == (string)$key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-slate-700">Shift</label>
                    <select id="shift_id" name="shift_id" class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Choose a shift</option>
                        @foreach($shifts as $shift)
                            <option value="{{ $shift->id }}" data-start="{{ $shift->start_time }}" data-end="{{ $shift->end_time }}" {{ old('shift_id', $dutyRoster->shift_id) == $shift->id ? 'selected' : '' }}>{{ $shift->name }} ({{ \Carbon\Carbon::createFromFormat('H:i:s', $shift->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $shift->end_time)->format('g:i A') }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-slate-700">Doctor</label>
                    <select id="doctor_id" name="doctor_id" class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select doctor</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" data-schedules='@json($doctor->schedules->groupBy('day_of_week'))' {{ old('doctor_id', $dutyRoster->doctor_id) == $doctor->id ? 'selected' : '' }}>{{ $doctor->name }}@if($doctor->specialization) - {{ $doctor->specialization }}@endif</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-slate-700">Staff</label>
                    <select id="staff_id" name="staff_id" class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select support staff</option>
                        @foreach($staff as $member)
                            <option value="{{ $member->id }}" {{ old('staff_id', $dutyRoster->staff_id) == $member->id ? 'selected' : '' }}>{{ $member->name }}@if($member->designation) - {{ $member->designation }}@endif</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-slate-700">Department</label>
                    <select id="department_id" name="department_id" class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id', $dutyRoster->department_id) == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-slate-700">Ward</label>
                    <select id="ward_id" name="ward_id" class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Choose ward</option>
                        @foreach($wards as $ward)
                            <option value="{{ $ward->id }}" {{ old('ward_id', $dutyRoster->ward_id) == $ward->id ? 'selected' : '' }}>{{ $ward->name }} @if($ward->code) ({{ $ward->code }})@endif</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-slate-700">Room</label>
                    <select id="room_id" name="room_id" class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Choose room</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" data-ward="{{ $room->ward_id }}" {{ old('room_id', $dutyRoster->room_id) == $room->id ? 'selected' : '' }}>{{ $room->room_no }}@if(optional($room->ward)->name) - {{ optional($room->ward)->name }}@endif</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-slate-700">Start Time</label>
                    <input id="start_time" type="time" name="start_time" value="{{ old('start_time', $dutyRoster->start_time) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-slate-700">End Time</label>
                    <input id="end_time" type="time" name="end_time" value="{{ old('end_time', $dutyRoster->end_time) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div class="lg:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700">Task / Responsibility</label>
                    <textarea name="task_description" rows="3" class="w-full rounded-3xl border border-slate-200 px-4 py-3 outline-none focus:border-blue-500 focus:ring-blue-500">{{ old('task_description', $dutyRoster->task_description) }}</textarea>
                </div>

                <div class="lg:col-span-2">
                    <label class="inline-flex items-center gap-3 rounded-3xl border border-slate-200 bg-slate-50 px-4 py-4 w-full">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $dutyRoster->is_active) ? 'checked' : '' }} class="h-5 w-5 text-blue-600 rounded focus:ring-blue-500 border-slate-300">
                        <span class="text-sm font-semibold text-slate-700">Active roster assignment</span>
                    </label>
                </div>
            </div>

            <div class="flex flex-col gap-4 sm:flex-row sm:justify-between">
                <a href="{{ route('duty-rosters.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 px-6 py-3 text-slate-700 font-semibold hover:bg-slate-100 transition">Cancel</a>
                <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-6 py-3 text-white font-semibold hover:bg-blue-700 transition">Update Roster Entry</button>
            </div>
        </form>
    </div>
</div>

<script>
    const doctorScheduleAvailability = @json($doctorScheduleAvailability ?? []);
    const existingRosters = @json($existingRosters ?? []);
    const rooms = @json($rooms->toArray());

    const daySelect = document.getElementById('day_of_week');
    const shiftSelect = document.getElementById('shift_id');
    const doctorSelect = document.getElementById('doctor_id');
    const staffSelect = document.getElementById('staff_id');
    const wardSelect = document.getElementById('ward_id');
    const roomSelect = document.getElementById('room_id');
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');

    function setShiftTimes() {
        const selectedShift = shiftSelect.options[shiftSelect.selectedIndex];
        if (!selectedShift || !selectedShift.dataset.start) return;
        startTimeInput.value = selectedShift.dataset.start.substring(0, 5); // Format as H:i
        endTimeInput.value = selectedShift.dataset.end.substring(0, 5); // Format as H:i
        updateDoctorOptions();
        updateStaffOptions();
    }

    function updateDoctorOptions() {
        const selectedDay = daySelect.value;
        const start = startTimeInput.value;
        const end = endTimeInput.value;

        const availableDoctorIds = new Set();
        if (selectedDay !== '' && start && end) {
            const schedules = doctorScheduleAvailability[selectedDay] || [];
            schedules.forEach(schedule => {
                if (schedule.start_time <= start && schedule.end_time >= end) {
                    availableDoctorIds.add(schedule.doctor_id);
                }
            });
        }

        doctorSelect.querySelectorAll('option').forEach(option => {
            if (option.value === '') return;
            if (selectedDay === '' || !start || !end) {
                option.hidden = false;
                option.disabled = false;
                return;
            }
            if (availableDoctorIds.size === 0) {
                option.hidden = false;
                option.disabled = false;
                return;
            }
            const available = availableDoctorIds.has(parseInt(option.value, 10));
            option.hidden = !available;
            option.disabled = !available;
        });
    }

    function timeOverlap(startA, endA, startB, endB) {
        return startA < endB && endA > startB;
    }

    function updateStaffOptions() {
        const selectedDay = daySelect.value;
        const start = startTimeInput.value;
        const end = endTimeInput.value;

        staffSelect.querySelectorAll('option').forEach(option => {
            if (option.value === '') return;
            if (!selectedDay || !start || !end) {
                option.disabled = false;
                return;
            }
            const staffId = parseInt(option.value, 10);
            const conflict = existingRosters.some(roster => parseInt(roster.staff_id, 10) === staffId && parseInt(roster.day_of_week, 10) === parseInt(selectedDay, 10) && timeOverlap(roster.start_time, roster.end_time, start, end));
            option.disabled = conflict;
        });
    }

    function updateRoomOptions() {
        const selectedWard = wardSelect.value;
        roomSelect.querySelectorAll('option').forEach(option => {
            if (option.value === '') return;
            const belongsToWard = option.dataset.ward === selectedWard;
            option.hidden = selectedWard ? !belongsToWard : false;
            option.disabled = selectedWard ? !belongsToWard : false;
        });
    }

    shiftSelect.addEventListener('change', setShiftTimes);
    daySelect.addEventListener('change', () => { updateDoctorOptions(); updateStaffOptions(); });
    startTimeInput.addEventListener('change', updateStaffOptions);
    endTimeInput.addEventListener('change', updateStaffOptions);
    wardSelect.addEventListener('change', updateRoomOptions);

    document.addEventListener('DOMContentLoaded', () => {
        setShiftTimes();
        updateDoctorOptions();
        updateStaffOptions();
        updateRoomOptions();
    });
</script>
@endsection

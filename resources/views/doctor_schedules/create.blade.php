@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-3xl font-bold text-slate-800 mb-2">Create Doctor Schedule</h2>
                <p class="text-slate-600">Set up comprehensive weekly availability for doctors with multiple time slots</p>
            </div>
        </div>
        <div class="h-1 w-24 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full"></div>
    </div>

    <!-- Card Container -->
    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">

        @if ($errors->any())
            <div class="mb-0 bg-red-50 border-b border-red-200 px-8 py-4">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <strong class="text-red-700 font-semibold">Please fix the following errors:</strong>
                </div>
                <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('doctor-schedules.store') }}" method="POST" class="p-8">
            @csrf

            <!-- Schedule Information Section -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">Schedule Details</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <!-- Doctor -->
                        <div class="space-y-2">
                            <label for="doctor_id" class="block text-sm font-semibold text-slate-700 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Doctor
                            </label>
                            <select id="doctor_id" name="doctor_id"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 bg-white hover:border-slate-400 @error('doctor_id') border-red-500 @enderror"
                                required>
                                <option value="">Select a doctor...</option>
                                @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                        {{ $doctor->name }} @if($doctor->specialization) - {{ $doctor->specialization }}@endif
                                    </option>
                                @endforeach
                            </select>
                            @error('doctor_id')
                                <span class="text-red-500 text-sm flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    {{ $message }}
                                </span>
                            @enderror
                            <p class="text-xs text-slate-500">Choose the doctor for this schedule</p>
                        </div>

                        <!-- Staff -->
                        <div class="space-y-2">
                            <label for="staff_id" class="block text-sm font-semibold text-slate-700 flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V9a2 2 0 00-2-2h-3M9 20H4V9a2 2 0 012-2h3m3 4a4 4 0 11-8 0 4 4 0 018 0zm0 4h8m-4-4v4"></path>
                                </svg>
                                Support Staff
                            </label>
                            <select id="staff_id" name="staff_id"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all duration-200 bg-white hover:border-slate-400 @error('staff_id') border-red-500 @enderror">
                                <option value="">Select supporting staff (optional)</option>
                                @foreach ($staff as $member)
                                    <option value="{{ $member->id }}" {{ old('staff_id') == $member->id ? 'selected' : '' }}>
                                        {{ $member->name }} @if($member->designation) - {{ $member->designation }}@endif
                                    </option>
                                @endforeach
                            </select>
                            @error('staff_id')
                                <span class="text-red-500 text-sm flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    {{ $message }}
                                </span>
                            @enderror
                            <p class="text-xs text-slate-500">Optional staff member assigned to help with the shift.</p>
                        </div>
                    </div>

                    <!-- Days of Week -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-slate-700 flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Available Days
                        </label>
                        <div class="grid grid-cols-2 gap-3 p-4 bg-slate-50 rounded-lg border border-slate-200">
                            <label class="flex items-center p-2 rounded-md hover:bg-white hover:shadow-sm transition-all duration-200 cursor-pointer">
                                <input type="checkbox" name="days[]" value="1" {{ in_array('1', old('days', [])) ? 'checked' : '' }}
                                    class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 mr-3">
                                <span class="text-sm font-medium text-slate-700">Monday</span>
                            </label>
                            <label class="flex items-center p-2 rounded-md hover:bg-white hover:shadow-sm transition-all duration-200 cursor-pointer">
                                <input type="checkbox" name="days[]" value="2" {{ in_array('2', old('days', [])) ? 'checked' : '' }}
                                    class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 mr-3">
                                <span class="text-sm font-medium text-slate-700">Tuesday</span>
                            </label>
                            <label class="flex items-center p-2 rounded-md hover:bg-white hover:shadow-sm transition-all duration-200 cursor-pointer">
                                <input type="checkbox" name="days[]" value="3" {{ in_array('3', old('days', [])) ? 'checked' : '' }}
                                    class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 mr-3">
                                <span class="text-sm font-medium text-slate-700">Wednesday</span>
                            </label>
                            <label class="flex items-center p-2 rounded-md hover:bg-white hover:shadow-sm transition-all duration-200 cursor-pointer">
                                <input type="checkbox" name="days[]" value="4" {{ in_array('4', old('days', [])) ? 'checked' : '' }}
                                    class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 mr-3">
                                <span class="text-sm font-medium text-slate-700">Thursday</span>
                            </label>
                            <label class="flex items-center p-2 rounded-md hover:bg-white hover:shadow-sm transition-all duration-200 cursor-pointer">
                                <input type="checkbox" name="days[]" value="5" {{ in_array('5', old('days', [])) ? 'checked' : '' }}
                                    class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 mr-3">
                                <span class="text-sm font-medium text-slate-700">Friday</span>
                            </label>
                            <label class="flex items-center p-2 rounded-md hover:bg-white hover:shadow-sm transition-all duration-200 cursor-pointer">
                                <input type="checkbox" name="days[]" value="6" {{ in_array('6', old('days', [])) ? 'checked' : '' }}
                                    class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 mr-3">
                                <span class="text-sm font-medium text-slate-700">Saturday</span>
                            </label>
                            <label class="flex items-center p-2 rounded-md hover:bg-white hover:shadow-sm transition-all duration-200 cursor-pointer col-span-2">
                                <input type="checkbox" name="days[]" value="0" {{ in_array('0', old('days', [])) ? 'checked' : '' }}
                                    class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 mr-3">
                                <span class="text-sm font-medium text-slate-700">Sunday</span>
                            </label>
                        </div>
                        @error('days')
                            <span class="text-red-500 text-sm flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                {{ $message }}
                            </span>
                        @enderror
                        <p class="text-xs text-slate-500">Select all days when the doctor is available</p>
                    </div>

                    <!-- Time Slots -->
                    <div class="md:col-span-2">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Availability</p>
                                <h4 class="text-lg font-semibold text-slate-800">Times per selected day</h4>
                            </div>
                            <div class="text-sm text-slate-500">Select a day above to add its available times.</div>
                        </div>

                        <div id="day-times-wrapper" class="space-y-4"></div>
                        @error('time_slots')
                            <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span>
                        @enderror
                        <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-sm text-blue-800 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                After selecting a day, add time slots for that day to define the doctor's weekly availability.
                            </p>
                        </div>
                    </div>

                    <script>
                        const dayLabels = {
                            0: 'Sunday',
                            1: 'Monday',
                            2: 'Tuesday',
                            3: 'Wednesday',
                            4: 'Thursday',
                            5: 'Friday',
                            6: 'Saturday',
                        };

                        const dayTimesWrapper = document.getElementById('day-times-wrapper');
                        const daySlotCounts = {};

                        function createDayPanel(day, addInitialSlot = true) {
                            if (document.getElementById(`day-panel-${day}`)) {
                                return;
                            }

                            daySlotCounts[day] = 0;
                            const panel = document.createElement('div');
                            panel.id = `day-panel-${day}`;
                            panel.className = 'bg-slate-50 p-5 rounded-2xl border border-slate-200 shadow-sm';
                            panel.innerHTML = `
                                <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-4 gap-4">
                                    <div>
                                        <p class="text-xs text-slate-500 uppercase tracking-wide">Selected day</p>
                                        <h4 class="text-lg font-semibold text-slate-800">${dayLabels[day]}</h4>
                                    </div>
                                    <button type="button" class="add-day-slot bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-5 py-2.5 rounded-xl shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2 font-semibold" data-day="${day}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Add Time
                                    </button>
                                </div>
                                <div id="slot-container-${day}" class="space-y-4"></div>
                            `;
                            dayTimesWrapper.appendChild(panel);
                            if (addInitialSlot) {
                                addSlot(day);
                            }
                        }

                        function addSlot(day, startTime = '09:00', endTime = '17:00', taskDescription = '') {
                            const slotContainer = document.getElementById(`slot-container-${day}`);
                            if (!slotContainer) {
                                return;
                            }

                            const index = daySlotCounts[day] ?? 0;
                            const slotDiv = document.createElement('div');
                            slotDiv.className = 'grid grid-cols-1 md:grid-cols-[1fr_1fr_1fr_auto] gap-4 items-end p-4 bg-white rounded-2xl border border-slate-200 shadow-sm';
                            slotDiv.innerHTML = `
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-slate-700">Start Time</label>
                                    <input type="time" name="time_slots[${day}][${index}][start_time]" value="${startTime}"
                                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200"
                                        required>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-slate-700">End Time</label>
                                    <input type="time" name="time_slots[${day}][${index}][end_time]" value="${endTime}"
                                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200"
                                        required>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-slate-700">Task</label>
                                    <input type="text" name="time_slots[${day}][${index}][task_description]" value="${taskDescription || ''}"
                                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200"
                                        placeholder="e.g., Triage, patient follow-up">
                                </div>
                                <button type="button" class="remove-slot bg-red-50 hover:bg-red-100 text-red-700 border border-red-300 px-5 py-3 rounded-xl font-semibold transition-all duration-200 flex items-center gap-2 whitespace-nowrap" data-day="${day}" data-index="${index}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Remove
                                </button>
                            `;
                            slotContainer.appendChild(slotDiv);
                            daySlotCounts[day] = index + 1;
                        }

                        function removeDayPanel(day) {
                            const panel = document.getElementById(`day-panel-${day}`);
                            if (panel) {
                                panel.remove();
                                delete daySlotCounts[day];
                            }
                        }

                        document.querySelectorAll('input[name="days[]"]').forEach((checkbox) => {
                            checkbox.addEventListener('change', (event) => {
                                const day = event.target.value;
                                if (event.target.checked) {
                                    createDayPanel(day);
                                } else {
                                    removeDayPanel(day);
                                }
                            });
                        });

                        document.addEventListener('click', (event) => {
                            const addButton = event.target.closest('.add-day-slot');
                            if (addButton) {
                                addSlot(addButton.dataset.day);
                                return;
                            }

                            const removeButton = event.target.closest('.remove-slot');
                            if (removeButton) {
                                const buttonDay = removeButton.dataset.day;
                                const slotWrapper = removeButton.closest('.grid');
                                if (slotWrapper) {
                                    slotWrapper.remove();
                                }
                            }
                        });

                        const oldDays = @json(old('days', []));
                        const oldTimeSlots = @json(old('time_slots', []));

                        if (oldDays.length > 0) {
                            oldDays.forEach((day) => {
                                createDayPanel(day, false);
                                if (oldTimeSlots[day] && oldTimeSlots[day].length > 0) {
                                    oldTimeSlots[day].forEach((slot) => {
                                        addSlot(day, slot.start_time || '09:00', slot.end_time || '17:00', slot.task_description || '');
                                    });
                                } else {
                                    addSlot(day);
                                }
                            });
                        }
                    </script>

                    <!-- Room Number -->
                    <div class="space-y-2">
                        <label for="room_no" class="block text-sm font-semibold text-slate-700 flex items-center gap-2">
                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Room Number
                        </label>
                        <input type="text" id="room_no" name="room_no" value="{{ old('room_no') }}"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 bg-white hover:border-slate-400 @error('room_no') border-red-500 @enderror"
                            placeholder="e.g., Room 101, Clinic A">
                        @error('room_no')
                            <span class="text-red-500 text-sm flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                {{ $message }}
                            </span>
                        @enderror
                        <p class="text-xs text-slate-500">Optional room or clinic designation</p>
                    </div>

                    <!-- Is Active -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-slate-700 flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Schedule Status
                        </label>
                        <div class="flex items-center p-4 bg-slate-50 rounded-lg border border-slate-200">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 mr-3 w-4 h-4">
                            <div>
                                <span class="text-sm font-medium text-slate-700">Active Schedule</span>
                                <p class="text-xs text-slate-500 mt-1">Uncheck if this schedule should be inactive</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 pt-8 mt-8 border-t border-slate-200">
                <a href="{{ route('doctor-schedules.index') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-800 font-semibold py-3 px-8 rounded-xl transition-all duration-200 flex items-center gap-2 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 order-2 md:order-1 w-full md:w-auto justify-center md:justify-start">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Schedules
                </a>
                <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-8 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2 order-1 md:order-2 w-full md:w-auto justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Create Schedule
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
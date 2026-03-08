@extends('includePage')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800 mb-2">Add New Doctor Schedule</h2>
        <p class="text-slate-600">Create a new schedule for doctor availability.</p>
    </div>

    <!-- Card Container -->
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-8">

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                <strong class="block mb-2">Errors:</strong>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('doctor-schedules.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Schedule Information Section -->
            <div class="border-b border-slate-200 pb-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Schedule Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Doctor -->
                    <div>
                        <label for="doctor_id" class="block text-sm font-semibold text-slate-700 mb-2">Doctor *</label>
                        <select id="doctor_id" name="doctor_id"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('doctor_id') border-red-500 @enderror"
                            required>
                            <option value="">Select Doctor</option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->name }} @if($doctor->specialization) - {{ $doctor->specialization }}@endif
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Day of Week -->
                    <div>
                        <label for="day_of_week" class="block text-sm font-semibold text-slate-700 mb-2">Day of Week *</label>
                        <select id="day_of_week" name="day_of_week"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('day_of_week') border-red-500 @enderror"
                            required>
                            <option value="">Select Day</option>
                            <option value="0" {{ old('day_of_week') == '0' ? 'selected' : '' }}>Sunday</option>
                            <option value="1" {{ old('day_of_week') == '1' ? 'selected' : '' }}>Monday</option>
                            <option value="2" {{ old('day_of_week') == '2' ? 'selected' : '' }}>Tuesday</option>
                            <option value="3" {{ old('day_of_week') == '3' ? 'selected' : '' }}>Wednesday</option>
                            <option value="4" {{ old('day_of_week') == '4' ? 'selected' : '' }}>Thursday</option>
                            <option value="5" {{ old('day_of_week') == '5' ? 'selected' : '' }}>Friday</option>
                            <option value="6" {{ old('day_of_week') == '6' ? 'selected' : '' }}>Saturday</option>
                        </select>
                        @error('day_of_week')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Start Time -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Start Time *</label>
                        @php
                            $times12 = [];
                            for($h = 0; $h < 12; $h++) {
                                foreach([0,30] as $m) {
                                    $hour = $h === 0 ? 12 : $h;
                                    $times12[] = sprintf('%d:%02d', $hour, $m);
                                }
                            }
                        @endphp
                        <div class="flex gap-2">
                            <input type="text" name="start_time_input" id="start_time_input"
                                value="{{ old('start_time_input') }}"
                                class="flex-1 px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('start_time') border-red-500 @enderror"
                                placeholder="00:00" maxlength="5" required>
                            <select name="start_ampm" id="start_ampm"
                                class="w-24 px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                                <option value="AM" {{ old('start_ampm')=='AM' ? 'selected':'' }}>AM</option>
                                <option value="PM" {{ old('start_ampm')=='PM' ? 'selected':'' }}>PM</option>
                            </select>
                        </div>
                        <input type="hidden" name="start_time" id="start_time" value="{{ old('start_time') }}">
                        @error('start_time')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- End Time -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">End Time *</label>
                        <div class="flex gap-2">
                            <input type="text" name="end_time_input" id="end_time_input"
                                value="{{ old('end_time_input') }}"
                                class="flex-1 px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('end_time') border-red-500 @enderror"
                                placeholder="00:00" maxlength="5" required>
                            <select name="end_ampm" id="end_ampm"
                                class="w-24 px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                                <option value="AM" {{ old('end_ampm')=='AM' ? 'selected':'' }}>AM</option>
                                <option value="PM" {{ old('end_ampm')=='PM' ? 'selected':'' }}>PM</option>
                            </select>
                        </div>
                        <input type="hidden" name="end_time" id="end_time" value="{{ old('end_time') }}">
                        @error('end_time')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <script>
                        function to24(input, ampm) {
                            let parts = input.split(':');
                            if(parts.length !== 2) return '';
                            let h = parseInt(parts[0]);
                            let m = parts[1];
                            if(ampm === 'PM' && h < 12) h += 12;
                            if(ampm === 'AM' && h === 12) h = 0;
                            return ('0'+h).slice(-2) + ':' + m;
                        }

                        function syncTimes() {
                            document.getElementById('start_time').value = to24(
                                document.getElementById('start_time_input').value,
                                document.getElementById('start_ampm').value
                            );
                            document.getElementById('end_time').value = to24(
                                document.getElementById('end_time_input').value,
                                document.getElementById('end_ampm').value
                            );
                        }
                        ['start_time_input','start_ampm','end_time_input','end_ampm'].forEach(id => {
                            const el = document.getElementById(id);
                            el.addEventListener('change', syncTimes);
                            el.addEventListener('blur', syncTimes);
                        });

                        // masked time input: only digits, auto-formats to hh:mm
                        function maskTimeInput(e) {
                            let v = e.target.value.replace(/[^0-9]/g, '');
                            let formatted = '';
                            
                            if (v.length === 0) {
                                formatted = '00:00';
                            } else if (v.length === 1) {
                                formatted = '0' + v + ':00';
                            } else if (v.length === 2) {
                                formatted = v + ':00';
                            } else if (v.length === 3) {
                                formatted = v.slice(0, 2) + ':0' + v[2];
                            } else if (v.length >= 4) {
                                formatted = v.slice(0, 2) + ':' + v.slice(2, 4);
                            }
                            
                            e.target.value = formatted;
                        }
                        
                        ['start_time_input', 'end_time_input'].forEach(id => {
                            const inp = document.getElementById(id);
                            inp.addEventListener('input', maskTimeInput);
                            inp.addEventListener('blur', maskTimeInput);
                        });
                    </script>

                    <!-- Room Number -->
                    <div>
                        <label for="room_no" class="block text-sm font-semibold text-slate-700 mb-2">Room Number</label>
                        <input type="text" id="room_no" name="room_no" value="{{ old('room_no') }}"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('room_no') border-red-500 @enderror"
                            placeholder="e.g., Room 101, Clinic A">
                        @error('room_no')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                        <p class="text-xs text-slate-500 mt-1">Optional room or clinic designation</p>
                    </div>

                    <!-- Is Active -->
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm font-semibold text-slate-700">Active Schedule</span>
                        </label>
                        <p class="text-xs text-slate-500 mt-1">Uncheck if this schedule is currently inactive</p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6">
                <a href="{{ route('doctor-schedules.index') }}" class="bg-slate-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-slate-600 transition">
                    Cancel
                </a>
                <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                    Create Schedule
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\DutyRoster;
use App\Models\Room;
use App\Models\Shift;
use App\Models\Staff;
use App\Models\Ward;
use Illuminate\Http\Request;

class DutyRosterController extends Controller
{
    public function weekly(Request $request)
    {
        $daysOfWeek = [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            0 => 'Sunday',
        ];

        $rosters = DutyRoster::with(['doctor.department', 'staff', 'shift', 'ward', 'room', 'department'])
            ->where('is_active', true)
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get()
            ->groupBy('day_of_week');

        return view('duty_rosters.weekly', compact('rosters', 'daysOfWeek'));
    }

    public function index(Request $request)
    {
        $daysOfWeek = [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            0 => 'Sunday',
        ];

        $doctors = Doctor::where('is_active', true)->get();
        $staff = Staff::where('is_active', true)->get();
        $departments = Department::all();
        $shifts = Shift::where('is_active', true)->get();

        $query = DutyRoster::with(['doctor.department', 'staff', 'shift', 'ward', 'room', 'department']);

        if ($request->filled('day_of_week')) {
            $query->where('day_of_week', $request->day_of_week);
        }

        if ($request->filled('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }

        if ($request->filled('staff_id')) {
            $query->where('staff_id', $request->staff_id);
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('shift_id')) {
            $query->where('shift_id', $request->shift_id);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active === '1');
        }

        $rosters = $query->orderBy('day_of_week')->orderBy('start_time')->paginate(15)->withQueryString();

        return view('duty_rosters.index', compact('rosters', 'daysOfWeek', 'doctors', 'staff', 'departments', 'shifts'));
    }

    public function create()
    {
        $doctors = Doctor::with('schedules')->where('is_active', true)->get();
        $staff = Staff::where('is_active', true)->get();
        $departments = Department::all();
        $wards = Ward::all();
        $rooms = Room::with('ward')->get();
        $shifts = Shift::where('is_active', true)->get();

        $doctorScheduleAvailability = DoctorSchedule::where('is_active', true)
            ->get()
            ->groupBy('day_of_week');

        $existingRosters = DutyRoster::select(['id', 'doctor_id', 'staff_id', 'day_of_week', 'start_time', 'end_time'])->get();

        return view('duty_rosters.create', compact(
            'doctors',
            'staff',
            'departments',
            'wards',
            'rooms',
            'shifts',
            'doctorScheduleAvailability',
            'existingRosters'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'staff_id' => 'nullable|exists:staff,id',
            'department_id' => 'nullable|exists:departments,id',
            'ward_id' => 'nullable|exists:wards,id',
            'room_id' => 'nullable|exists:rooms,id',
            'shift_id' => 'required|exists:shifts,id',
            'day_of_week' => 'required|integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'task_description' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        if (! $this->doctorHasAvailability($data['doctor_id'], $data['day_of_week'], $data['start_time'], $data['end_time'])) {
            return back()->withErrors(['doctor_id' => 'Selected doctor is not available for the chosen day and time.'])->withInput();
        }

        if ($this->hasOverlap('doctor_id', $data['doctor_id'], $data['day_of_week'], $data['start_time'], $data['end_time'])) {
            return back()->withErrors(['doctor_id' => 'This doctor already has a conflicting roster assignment.'])->withInput();
        }

        if (! empty($data['staff_id']) && $this->hasOverlap('staff_id', $data['staff_id'], $data['day_of_week'], $data['start_time'], $data['end_time'])) {
            return back()->withErrors(['staff_id' => 'Selected staff member already has a conflicting roster assignment.'])->withInput();
        }

        $data['is_active'] = $request->has('is_active');

        DutyRoster::create($data);

        return redirect()->route('duty-rosters.index')->with('success', 'Duty roster entry created successfully.');
    }

    public function show(DutyRoster $dutyRoster)
    {
        $dutyRoster->load(['doctor.department', 'staff', 'shift', 'ward', 'room', 'department']);

        return view('duty_rosters.show', compact('dutyRoster'));
    }

    public function edit(DutyRoster $dutyRoster)
    {
        $doctors = Doctor::with('schedules')->where('is_active', true)->get();
        $staff = Staff::where('is_active', true)->get();
        $departments = Department::all();
        $wards = Ward::all();
        $rooms = Room::with('ward')->get();
        $shifts = Shift::where('is_active', true)->get();

        $doctorScheduleAvailability = DoctorSchedule::where('is_active', true)
            ->get()
            ->groupBy('day_of_week');

        $existingRosters = DutyRoster::where('id', '<>', $dutyRoster->id)
            ->select(['id', 'doctor_id', 'staff_id', 'day_of_week', 'start_time', 'end_time'])
            ->get();

        return view('duty_rosters.edit', compact(
            'dutyRoster',
            'doctors',
            'staff',
            'departments',
            'wards',
            'rooms',
            'shifts',
            'doctorScheduleAvailability',
            'existingRosters'
        ));
    }

    public function update(Request $request, DutyRoster $dutyRoster)
    {
        $data = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'staff_id' => 'nullable|exists:staff,id',
            'department_id' => 'nullable|exists:departments,id',
            'ward_id' => 'nullable|exists:wards,id',
            'room_id' => 'nullable|exists:rooms,id',
            'shift_id' => 'required|exists:shifts,id',
            'day_of_week' => 'required|integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'task_description' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        if (! $this->doctorHasAvailability($data['doctor_id'], $data['day_of_week'], $data['start_time'], $data['end_time'])) {
            return back()->withErrors(['doctor_id' => 'Selected doctor is not available for the chosen day and time.'])->withInput();
        }

        if ($this->hasOverlap('doctor_id', $data['doctor_id'], $data['day_of_week'], $data['start_time'], $data['end_time'], $dutyRoster->id)) {
            return back()->withErrors(['doctor_id' => 'This doctor already has a conflicting roster assignment.'])->withInput();
        }

        if (! empty($data['staff_id']) && $this->hasOverlap('staff_id', $data['staff_id'], $data['day_of_week'], $data['start_time'], $data['end_time'], $dutyRoster->id)) {
            return back()->withErrors(['staff_id' => 'Selected staff member already has a conflicting roster assignment.'])->withInput();
        }

        $data['is_active'] = $request->has('is_active');

        $dutyRoster->update($data);

        return redirect()->route('duty-rosters.index')->with('success', 'Duty roster entry updated successfully.');
    }

    public function destroy(DutyRoster $dutyRoster)
    {
        $dutyRoster->delete();

        return redirect()->route('duty-rosters.index')->with('success', 'Duty roster entry deleted successfully.');
    }

    public function available(Request $request)
    {
        $day = $request->input('day_of_week');
        $shift = Shift::find($request->input('shift_id'));
        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');

        $availableDoctors = [];
        $availableStaff = Staff::where('is_active', true)->get();

        if ($day !== null && $shift !== null) {
            $startTime = $startTime ?: $shift->start_time;
            $endTime = $endTime ?: $shift->end_time;

            $availableDoctors = DoctorSchedule::where('day_of_week', $day)
                ->where('is_active', true)
                ->get()
                ->filter(function ($schedule) use ($startTime, $endTime) {
                    return $schedule->start_time <= $startTime && $schedule->end_time >= $endTime;
                })
                ->pluck('doctor_id')
                ->unique()
                ->values();
        }

        $busyStaff = DutyRoster::when($day !== null, function ($query) use ($day) {
                return $query->where('day_of_week', $day);
            })
            ->when($startTime && $endTime, function ($query) use ($startTime, $endTime) {
                return $query->where(function ($sub) use ($startTime, $endTime) {
                    $sub->where('start_time', '<', $endTime)
                        ->where('end_time', '>', $startTime);
                });
            })
            ->pluck('staff_id')
            ->filter()
            ->unique();

        return response()->json([
            'available_doctors' => $availableDoctors,
            'available_staff' => $availableStaff->filter(function ($item) use ($busyStaff) {
                return ! $busyStaff->contains($item->id);
            })->values(),
        ]);
    }

    public function print(Request $request)
    {
        $rosters = $this->filterRosters($request)->orderBy('day_of_week')->orderBy('start_time')->get();

        return view('duty_rosters.print', compact('rosters'));
    }

    public function exportPdf(Request $request)
    {
        $rosters = $this->filterRosters($request)->orderBy('day_of_week')->orderBy('start_time')->get();
        $html = view('duty_rosters.print', compact('rosters'))->render();

        $pdf = new \Dompdf\Dompdf();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="duty-roster.pdf"');
    }

    protected function doctorHasAvailability($doctorId, $day, $startTime, $endTime)
    {
        return DoctorSchedule::where('doctor_id', $doctorId)
            ->where('day_of_week', $day)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where('start_time', '<=', $startTime)
                    ->where('end_time', '>=', $endTime);
            })
            ->exists();
    }

    protected function hasOverlap($field, $personId, $day, $startTime, $endTime, $excludeId = null)
    {
        if (empty($personId)) {
            return false;
        }

        $query = DutyRoster::where($field, $personId)
            ->where('day_of_week', $day)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where('start_time', '<', $endTime)
                    ->where('end_time', '>', $startTime);
            });

        if ($excludeId) {
            $query->where('id', '<>', $excludeId);
        }

        return $query->exists();
    }

    protected function timesOverlap($startA, $endA, $startB, $endB)
    {
        return $startA < $endB && $endA > $startB;
    }

    protected function filterRosters(Request $request)
    {
        $query = DutyRoster::with(['doctor.department', 'staff', 'shift', 'ward', 'room', 'department']);

        if ($request->filled('day_of_week')) {
            $query->where('day_of_week', $request->day_of_week);
        }

        if ($request->filled('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }

        if ($request->filled('staff_id')) {
            $query->where('staff_id', $request->staff_id);
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('shift_id')) {
            $query->where('shift_id', $request->shift_id);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active === '1');
        }

        return $query;
    }
}

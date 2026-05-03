<?php

namespace App\Http\Controllers;

use App\Models\DoctorSchedule;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorScheduleController extends Controller
{
    public function index()
    {
        $schedules = DoctorSchedule::with('doctor')->get();
        return view('doctor_schedules.index', compact('schedules'));
    }

    public function create()
    {
        $doctors = Doctor::where('is_active', true)->get();
        return view('doctor_schedules.create', compact('doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'days' => 'required|array|min:1',
            'days.*' => 'integer|between:0,6',
            'time_slots' => 'required|array|min:1',
            'time_slots.*' => 'required|array|min:1',
            'time_slots.*.*.start_time' => 'required|date_format:H:i',
            'time_slots.*.*.end_time' => 'required|date_format:H:i',
            'room_no' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        foreach ($request->time_slots as $day => $slots) {
            foreach ($slots as $index => $timeSlot) {
                if (strtotime($timeSlot['end_time']) <= strtotime($timeSlot['start_time'])) {
                    return back()->withErrors(["time_slots.{$day}.{$index}.end_time" => 'End time must be after start time.'])->withInput();
                }
            }
        }

        $createdCount = 0;
        foreach ($request->days as $day) {
            if (! isset($request->time_slots[$day])) {
                continue;
            }
            foreach ($request->time_slots[$day] as $timeSlot) {
                DoctorSchedule::create([
                    'doctor_id' => $request->doctor_id,
                    'day_of_week' => $day,
                    'start_time' => $timeSlot['start_time'],
                    'end_time' => $timeSlot['end_time'],
                    'room_no' => $request->room_no,
                    'is_active' => $request->is_active ?? true,
                ]);
                $createdCount++;
            }
        }

        return redirect()->route('doctor-schedules.index')->with('success', "Doctor schedule created successfully. {$createdCount} schedule entries added.");
    }

    public function show(DoctorSchedule $doctorSchedule)
    {
        $doctorSchedule->load('doctor');
        return view('doctor_schedules.show', compact('doctorSchedule'));
    }

    public function edit(DoctorSchedule $doctorSchedule)
    {
        $doctors = Doctor::where('is_active', true)->get();
        return view('doctor_schedules.edit', compact('doctorSchedule', 'doctors'));
    }

    public function update(Request $request, DoctorSchedule $doctorSchedule)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'day_of_week' => 'required|integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room_no' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $doctorSchedule->update($request->all());

        return redirect()->route('doctor-schedules.index')->with('success', 'Doctor schedule updated successfully.');
    }

    public function destroy(DoctorSchedule $doctorSchedule)
    {
        $doctorSchedule->delete();

        return redirect()->route('doctor-schedules.index')->with('success', 'Doctor schedule deleted successfully.');
    }
}

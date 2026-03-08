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
            'day_of_week' => 'required|integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room_no' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        DoctorSchedule::create($request->all());

        return redirect()->route('doctor-schedules.index')->with('success', 'Doctor schedule created successfully.');
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

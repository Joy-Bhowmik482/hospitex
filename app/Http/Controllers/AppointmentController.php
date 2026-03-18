<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of all appointments.
     */
    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor', 'department'])
            ->orderBy('appointment_date', 'appointment_time', 'desc')
            ->paginate(15);
        
        return view('appointments.list', compact('appointments'));
    }

    /**
     * Show the form for creating a new appointment.
     */
    public function create()
    {
        $patients = Patient::orderBy('first_name')->get();
        $doctors = Doctor::where('is_active', true)->orderBy('name')->get();
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        
        return view('appointments.create', compact('patients', 'doctors', 'departments'));
    }

    /**
     * Store a newly created appointment in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'department_id' => 'required|exists:departments,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'status' => 'required|in:Pending,Confirmed,Completed,Cancelled,NoShow',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Generate unique appointment number
        $appointmentNo = 'APT' . date('YmdHis') . rand(100, 999);
        
        $appointment = Appointment::create([
            'appointment_no' => $appointmentNo,
            'patient_id' => $validated['patient_id'],
            'doctor_id' => $validated['doctor_id'],
            'department_id' => $validated['department_id'],
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('appointments.show', $appointment)
            ->with('success', 'Appointment created successfully!');
    }

    /**
     * Display the specified appointment.
     */
    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor', 'department', 'createdBy']);
        
        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified appointment.
     */
    public function edit(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor', 'department']);
        $patients = Patient::orderBy('first_name')->get();
        $doctors = Doctor::where('is_active', true)->orderBy('name')->get();
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        
        return view('appointments.edit', compact('appointment', 'patients', 'doctors', 'departments'));
    }

    /**
     * Update the specified appointment in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'department_id' => 'required|exists:departments,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'status' => 'required|in:Pending,Confirmed,Completed,Cancelled,NoShow',
            'notes' => 'nullable|string|max:1000',
        ]);

        $appointment->update($validated);

        return redirect()->route('appointments.show', $appointment)
            ->with('success', 'Appointment updated successfully!');
    }

    /**
     * Remove the specified appointment from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment deleted successfully!');
    }

    /**
     * Get queue/appointments for a specific day
     */
    public function queue(Request $request)
    {
        $date = $request->query('date', now()->toDateString());
        
        $appointments = Appointment::with(['patient', 'doctor', 'department'])
            ->whereDate('appointment_date', $date)
            ->orderBy('appointment_time')
            ->get();

        return view('appointments.queue', compact('appointments', 'date'));
    }

    /**
     * Change appointment status
     */
    public function changeStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:Pending,Confirmed,Completed,Cancelled,NoShow',
        ]);

        $appointment->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Appointment status updated successfully!');
    }
}

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
            ->orderBy( 'appointment_time', 'desc')
            ->orderBy('appointment_date',  'desc')
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
            'created_by' => Auth::id()  ?? 1, // Default to 1 if no authenticated user
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
            'status' => 'required|in:Pending,Confirmed,Completed,Cancelled,NoShow,Checked In,Waiting,In Consultation,Rescheduled',
        ]);

        $appointment->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Appointment status updated successfully!');
    }

    /**
     * Display OPD appointments
     */
    public function opd(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor', 'department']);

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('appointment_no', 'like', "%$search%")
                  ->orWhereHas('patient', function ($q) use ($search) {
                      $q->where('first_name', 'like', "%$search%")
                        ->orWhere('last_name', 'like', "%$search%");
                  })
                  ->orWhereHas('doctor', function ($q) use ($search) {
                      $q->where('name', 'like', "%$search%");
                  });
            });
        }

        // Status Filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Date Range Filter
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('appointment_date', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('appointment_date', '<=', $request->date_to);
        }

        // Department Filter
        if ($request->has('department_id') && $request->department_id) {
            $query->where('department_id', $request->department_id);
        }

        // Doctor Filter
        if ($request->has('doctor_id') && $request->doctor_id) {
            $query->where('doctor_id', $request->doctor_id);
        }

        $appointments = $query->orderBy('appointment_date', 'desc')
                               ->orderBy('appointment_time', 'desc')
                               ->paginate(15);

        // Get statistics
        $todayCount = Appointment::whereDate('appointment_date', now())->count();
        $pendingCount = Appointment::where('status', 'Pending')->count();
        $confirmedCount = Appointment::where('status', 'Confirmed')->count();
        $completedCount = Appointment::whereMonth('appointment_date', now()->month)
                                     ->where('status', 'Completed')
                                     ->count();

        return view('appointments.opd', compact('appointments', 'todayCount', 'pendingCount', 'confirmedCount', 'completedCount'));
    }

    /**
     * Display follow-up appointments
     */
    public function followup(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor', 'department']);

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('appointment_no', 'like', "%$search%")
                  ->orWhereHas('patient', function ($q) use ($search) {
                      $q->where('first_name', 'like', "%$search%")
                        ->orWhere('last_name', 'like', "%$search%");
                  })
                  ->orWhereHas('doctor', function ($q) use ($search) {
                      $q->where('name', 'like', "%$search%");
                  });
            });
        }

        // Status Filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Date Range Filter
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('appointment_date', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('appointment_date', '<=', $request->date_to);
        }

        // Department Filter
        if ($request->has('department_id') && $request->department_id) {
            $query->where('department_id', $request->department_id);
        }

        // Doctor Filter
        if ($request->has('doctor_id') && $request->doctor_id) {
            $query->where('doctor_id', $request->doctor_id);
        }

        $appointments = $query->orderBy('appointment_date', 'desc')
                               ->orderBy('appointment_time', 'desc')
                               ->paginate(15);

        // Get statistics
        $pendingFollowups = Appointment::where('status', 'Pending')->count();
        $dueThisWeek = Appointment::whereBetween('appointment_date', [now(), now()->addDays(7)])->count();
        $completedFollowups = Appointment::where('status', 'Completed')->count();
        $withReminders = Appointment::count(); // Placeholder - can be extended with reminder field

        return view('appointments.followup', compact('appointments', 'pendingFollowups', 'dueThisWeek', 'completedFollowups', 'withReminders'));
    }

    /**
     * Display appointments by status
     */
    public function status(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor', 'department']);

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('appointment_no', 'like', "%$search%")
                  ->orWhereHas('patient', function ($q) use ($search) {
                      $q->where('first_name', 'like', "%$search%")
                        ->orWhere('last_name', 'like', "%$search%");
                  })
                  ->orWhereHas('doctor', function ($q) use ($search) {
                      $q->where('name', 'like', "%$search%");
                  });
            });
        }

        // Status Filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $appointments = $query->orderBy('appointment_date', 'desc')
                               ->orderBy('appointment_time', 'desc')
                               ->paginate(15);

        // Get status counts for all statuses
        $allStatuses = ['Pending', 'Confirmed', 'Checked In', 'Waiting', 'In Consultation', 'Completed', 'Cancelled', 'No Show', 'Rescheduled'];
        $statusCounts = [];
        foreach ($allStatuses as $status) {
            $statusCounts[$status] = Appointment::where('status', $status)->count();
        }
        $totalCount = Appointment::count();

        return view('appointments.status', compact('appointments', 'statusCounts', 'totalCount'));
    }
}

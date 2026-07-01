<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceSchedule;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maintenanceSchedules = MaintenanceSchedule::with(['asset', 'creator'])
            ->orderBy('scheduled_date', 'asc')
            ->paginate(15);

        // Summary statistics
        $upcomingThisWeek = MaintenanceSchedule::upcoming()->thisWeek()->count();
        $overdue = MaintenanceSchedule::overdue()->count();
        $completedThisMonth = MaintenanceSchedule::where('status', 'completed')
            ->whereMonth('completed_date', now()->month)
            ->whereYear('completed_date', now()->year)
            ->count();
        $totalCostThisMonth = MaintenanceSchedule::where('status', 'completed')
            ->whereMonth('completed_date', now()->month)
            ->whereYear('completed_date', now()->year)
            ->sum('actual_cost');

        return view('maintenance_schedules.list', compact(
            'maintenanceSchedules',
            'upcomingThisWeek',
            'overdue',
            'completedThisMonth',
            'totalCostThisMonth'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $assets = Asset::where('status', 'Active')->get();
        return view('maintenance_schedules.create', compact('assets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Convert datetime-local format (Y-m-d\TH:i) to expected format (Y-m-d H:i)
        // datetime-local sends: 2026-07-01T15:30 → convert to: 2026-07-01 15:30
        if ($request->has('scheduled_date') && $request->scheduled_date) {
            $request->merge(['scheduled_date' => str_replace('T', ' ', $request->scheduled_date)]);
        }
        if ($request->has('scheduled_end_date') && $request->scheduled_end_date) {
            $request->merge(['scheduled_end_date' => str_replace('T', ' ', $request->scheduled_end_date)]);
        }
        if ($request->has('completed_date') && $request->completed_date) {
            $request->merge(['completed_date' => str_replace('T', ' ', $request->completed_date)]);
        }

        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'maintenance_type' => 'required|string|max:255',
            'priority' => 'required|in:critical,high,medium,low',
            'scheduled_date' => 'required|date_format:Y-m-d H:i',
            'scheduled_end_date' => 'nullable|date_format:Y-m-d H:i',
            'technician_name' => 'nullable|string|max:255',
            'technician_contact' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'estimated_cost' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        MaintenanceSchedule::create([
            'asset_id' => $request->asset_id,
            'maintenance_type' => $request->maintenance_type,
            'priority' => $request->priority,
            'scheduled_date' => $request->scheduled_date,
            'scheduled_end_date' => $request->scheduled_end_date,
            'technician_name' => $request->technician_name,
            'technician_contact' => $request->technician_contact,
            'department' => $request->department,
            'estimated_cost' => $request->estimated_cost,
            'description' => $request->description,
            'notes' => $request->notes,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('maintenance-schedules.index')
            ->with('success', 'Maintenance schedule created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MaintenanceSchedule $maintenanceSchedule)
    {
        $maintenanceSchedule->load(['asset', 'creator']);
        return view('maintenance_schedules.show', compact('maintenanceSchedule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaintenanceSchedule $maintenanceSchedule)
    {
        $assets = Asset::where('status', 'Active')->get();
        return view('maintenance_schedules.edit', compact('maintenanceSchedule', 'assets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MaintenanceSchedule $maintenanceSchedule)
    {
        // Convert datetime-local format (Y-m-d\TH:i) to expected format (Y-m-d H:i)
        // datetime-local sends: 2026-07-01T15:30 → convert to: 2026-07-01 15:30
        if ($request->has('scheduled_date') && $request->scheduled_date) {
            $request->merge(['scheduled_date' => str_replace('T', ' ', $request->scheduled_date)]);
        }
        if ($request->has('scheduled_end_date') && $request->scheduled_end_date) {
            $request->merge(['scheduled_end_date' => str_replace('T', ' ', $request->scheduled_end_date)]);
        }
        if ($request->has('completed_date') && $request->completed_date) {
            $request->merge(['completed_date' => str_replace('T', ' ', $request->completed_date)]);
        }

        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'maintenance_type' => 'required|string|max:255',
            'priority' => 'required|in:critical,high,medium,low',
            'scheduled_date' => 'required|date_format:Y-m-d H:i',
            'scheduled_end_date' => 'nullable|date_format:Y-m-d H:i',
            'technician_name' => 'nullable|string|max:255',
            'technician_contact' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'status' => 'required|in:scheduled,in_progress,completed,overdue,cancelled',
            'estimated_cost' => 'nullable|numeric|min:0',
            'actual_cost' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'work_performed' => 'nullable|string',
            'parts_used' => 'nullable|string',
            'notes' => 'nullable|string',
            'completed_date' => 'nullable|date_format:Y-m-d H:i|required_if:status,completed',
        ]);

        $maintenanceSchedule->update($request->all());

        return redirect()->route('maintenance-schedules.index')
            ->with('success', 'Maintenance schedule updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaintenanceSchedule $maintenanceSchedule)
    {
        $maintenanceSchedule->delete();

        return redirect()->route('maintenance-schedules.index')
            ->with('success', 'Maintenance schedule deleted successfully.');
    }

    /**
     * Mark maintenance as completed
     */
    public function complete(Request $request, MaintenanceSchedule $maintenanceSchedule)
    {
        $request->validate([
            'actual_cost' => 'nullable|numeric|min:0',
            'work_performed' => 'nullable|string',
            'parts_used' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $maintenanceSchedule->update([
            'status' => 'completed',
            'completed_date' => now(),
            'actual_cost' => $request->actual_cost,
            'work_performed' => $request->work_performed,
            'parts_used' => $request->parts_used,
            'notes' => $request->notes,
        ]);

        return redirect()->route('maintenance-schedules.index')
            ->with('success', 'Maintenance marked as completed.');
    }
}

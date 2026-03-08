<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Department;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::with('department')->get();
        return view('staff.index', compact('staff'));
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        return view('staff.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $designations = ['Nurse', 'Senior Nurse', 'Lab Technician', 'X-Ray Technician', 'Pharmacist', 'Assistant Pharmacist', 'Receptionist', 'Accountant', 'Administrator', 'Cleaner', 'Security Guard', 'Driver', 'Ward Boy', 'Attendant', 'Medical Records Officer', 'Paramedic'];
        
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'designation' => 'required|in:' . implode(',', $designations),
            'joining_date' => 'required|date',
            'salary' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        Staff::create($request->all());

        return redirect()->route('staff.index')->with('success', 'Staff created successfully.');
    }

    public function show(Staff $staff)
    {
        $staff->load('department');
        return view('staff.show', compact('staff'));
    }

    public function edit(Staff $staff)
    {
        $departments = Department::where('is_active', true)->get();
        return view('staff.edit', compact('staff', 'departments'));
    }

    public function update(Request $request, Staff $staff)
    {
        $designations = ['Nurse', 'Senior Nurse', 'Lab Technician', 'X-Ray Technician', 'Pharmacist', 'Assistant Pharmacist', 'Receptionist', 'Accountant', 'Administrator', 'Cleaner', 'Security Guard', 'Driver', 'Ward Boy', 'Attendant', 'Medical Records Officer', 'Paramedic'];
        
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'designation' => 'required|in:' . implode(',', $designations),
            'joining_date' => 'required|date',
            'salary' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $staff->update($request->all());

        return redirect()->route('staff.index')->with('success', 'Staff updated successfully.');
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();

        return redirect()->route('staff.index')->with('success', 'Staff deleted successfully.');
    }
}

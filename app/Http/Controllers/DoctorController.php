<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('department')->get();
        return view('doctors.index', compact('doctors'));
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        return view('doctors.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'reg_no' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'fee' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        Doctor::create($request->all());

        return redirect()->route('doctors.index')->with('success', 'Doctor created successfully.');
    }

    public function show(Doctor $doctor)
    {
        $doctor->load('department', 'schedules');
        return view('doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        $departments = Department::where('is_active', true)->get();
        return view('doctors.edit', compact('doctor', 'departments'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'reg_no' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'fee' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $doctor->update($request->all());

        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully.');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();

        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully.');
    }
}

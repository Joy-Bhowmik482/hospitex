<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admissions = Admission::with('patient', 'doctor', 'department', 'createdBy', 'bedAllocations')->get();
        return view('admissions.list', compact('admissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        $departments = Department::all();
        $users = User::all();
        
        // Generate unique admission number
        $admissionNo = 'ADM' . date('Ymd') . str_pad(Admission::count() + 1, 5, '0', STR_PAD_LEFT);
        
        return view('admissions.create', compact('patients', 'doctors', 'departments', 'users', 'admissionNo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'admission_no' => 'required|string|unique:admissions',
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'department_id' => 'required|exists:departments,id',
            'admitted_at' => 'required|date_format:Y-m-d H:i',
            'discharge_at' => 'nullable|date_format:Y-m-d H:i',
            'status' => 'required|in:Admitted,Discharged,Cancelled',
            'diagnosis' => 'nullable|string',
            'remarks' => 'nullable|string',
            'created_by' => 'required|exists:users,id',
        ]);

        Admission::create($validated);

        return redirect()->route('admissions.index')
            ->with('success', 'Admission created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Admission $admission)
    {
        $admission->load('patient', 'doctor', 'department', 'createdBy', 'bedAllocations.bed.room.ward');
        return view('admissions.show', compact('admission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admission $admission)
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        $departments = Department::all();
        $users = User::all();
        
        return view('admissions.edit', compact('admission', 'patients', 'doctors', 'departments', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admission $admission)
    {
        $validated = $request->validate([
            'admission_no' => 'required|string|unique:admissions,admission_no,' . $admission->id,
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'department_id' => 'required|exists:departments,id',
            'admitted_at' => 'required|date_format:Y-m-d H:i',
            'discharge_at' => 'nullable|date_format:Y-m-d H:i',
            'status' => 'required|in:Admitted,Discharged,Cancelled',
            'diagnosis' => 'nullable|string',
            'remarks' => 'nullable|string',
            'created_by' => 'required|exists:users,id',
        ]);

        $admission->update($validated);

        return redirect()->route('admissions.index')
            ->with('success', 'Admission updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admission $admission)
    {
        $admission->delete();

        return redirect()->route('admissions.index')
            ->with('success', 'Admission deleted successfully!');
    }
}

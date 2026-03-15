<?php

namespace App\Http\Controllers;

use App\Models\BedAllocation;
use App\Models\Admission;
use App\Models\Bed;
use Illuminate\Http\Request;

class BedAllocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allocations = BedAllocation::with('admission.patient', 'bed.room.ward')->get();
        return view('bed_allocations.list', compact('allocations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $admissions = Admission::with('patient')->where('status', 'Admitted')->get();
        $beds = Bed::where('status', 'Available')->with('room.ward')->get();
        
        return view('bed_allocations.create', compact('admissions', 'beds'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'admission_id' => 'required|exists:admissions,id',
            'bed_id' => 'required|exists:beds,id',
            'allocated_at' => 'required|date_format:Y-m-d H:i',
            'allocation_status' => 'required|in:Active,Released',
            'notes' => 'nullable|string',
        ]);

        // Check if bed is available
        $bed = Bed::find($validated['bed_id']);
        if ($bed->status !== 'Available' && $validated['allocation_status'] === 'Active') {
            return back()->withErrors(['bed_id' => 'This bed is not available.']);
        }

        BedAllocation::create($validated);

        // Update bed status to Occupied
        if ($validated['allocation_status'] === 'Active') {
            $bed->update(['status' => 'Occupied']);
        }

        return redirect()->route('bed_allocations.index')
            ->with('success', 'Bed allocated successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(BedAllocation $bedAllocation)
    {
        $bedAllocation->load('admission.patient', 'admission.doctor', 'admission.department', 'bed.room.ward');
        return view('bed_allocations.show', compact('bedAllocation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BedAllocation $bedAllocation)
    {
        $admissions = Admission::with('patient')->get();
        $beds = Bed::with('room.ward')->get();
        
        return view('bed_allocations.edit', compact('bedAllocation', 'admissions', 'beds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BedAllocation $bedAllocation)
    {
        $validated = $request->validate([
            'admission_id' => 'required|exists:admissions,id',
            'bed_id' => 'required|exists:beds,id',
            'allocated_at' => 'required|date_format:Y-m-d H:i',
            'released_at' => 'nullable|date_format:Y-m-d H:i',
            'allocation_status' => 'required|in:Active,Released',
            'notes' => 'nullable|string',
        ]);

        // If changing to Released, update bed status
        if ($validated['allocation_status'] === 'Released' && $bedAllocation->allocation_status === 'Active') {
            $bedAllocation->bed->update(['status' => 'Available']);
            $validated['released_at'] = now();
        }

        $bedAllocation->update($validated);

        return redirect()->route('bed_allocations.index')
            ->with('success', 'Bed allocation updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BedAllocation $bedAllocation)
    {
        // Release the bed
        $bedAllocation->bed->update(['status' => 'Available']);
        $bedAllocation->delete();

        return redirect()->route('bed_allocations.index')
            ->with('success', 'Bed allocation deleted successfully!');
    }
}

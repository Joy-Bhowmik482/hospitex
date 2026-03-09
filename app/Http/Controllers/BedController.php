<?php

namespace App\Http\Controllers;

use App\Models\Bed;
use App\Models\Room;
use Illuminate\Http\Request;

class BedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $beds = Bed::with('room.ward', 'allocations')->get();
        return view('beds.list', compact('beds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rooms = Room::with('ward')->get();
        return view('beds.create', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'bed_no' => 'required|string|max:100',
            'status' => 'required|in:Available,Occupied,Maintenance',
        ]);

        Bed::create($validated);

        return redirect()->route('beds.index')
            ->with('success', 'Bed added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bed $bed)
    {
        $bed->load('room.ward', 'allocations.admission.patient');
        return view('beds.show', compact('bed'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bed $bed)
    {
        $rooms = Room::with('ward')->get();
        return view('beds.edit', compact('bed', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bed $bed)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'bed_no' => 'required|string|max:100',
            'status' => 'required|in:Available,Occupied,Maintenance',
        ]);

        $bed->update($validated);

        return redirect()->route('beds.index')
            ->with('success', 'Bed updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bed $bed)
    {
        $bed->delete();

        return redirect()->route('beds.index')
            ->with('success', 'Bed deleted successfully!');
    }
}

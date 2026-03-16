<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Ward;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::with('ward', 'beds')->get();
        return view('rooms.list', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $wards = Ward::all();
        return view('rooms.create', compact('wards'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ward_id' => 'required|exists:wards,id',
            'room_no' => 'required|string|max:100',
            'room_type' => 'required|string|max:100',
            'daily_rate' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        Room::create($validated);

        return redirect()->route('rooms.index')
            ->with('success', 'Room added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        $room->load('ward', 'beds');
        return view('rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        $wards = Ward::all();
        return view('rooms.edit', compact('room', 'wards'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'ward_id' => 'required|exists:wards,id',
            'room_no' => 'required|string|max:100',
            'room_type' => 'required|string|max:100',
            'daily_rate' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $room->update($validated);

        return redirect()->route('rooms.index')
            ->with('success', 'Room updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('rooms.index')
            ->with('success', 'Room deleted successfully!');
    }
}

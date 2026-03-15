<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use Illuminate\Http\Request;

class WardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wards = Ward::with('rooms')->get();
        return view('wards.list', compact('wards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('wards.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:wards',
            'floor' => 'nullable|integer|min:0',
            'gender_policy' => 'required|in:Male,Female,Any',
        ]);

        Ward::create($validated);

        return redirect()->route('wards.index')
            ->with('success', 'Ward added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ward $ward)
    {
        $ward->load('rooms.beds');
        return view('wards.show', compact('ward'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ward $ward)
    {
        return view('wards.edit', compact('ward'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ward $ward)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:wards,code,' . $ward->id,
            'floor' => 'nullable|integer|min:0',
            'gender_policy' => 'required|in:Male,Female,Any',
        ]);

        $ward->update($validated);

        return redirect()->route('wards.index')
            ->with('success', 'Ward updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ward $ward)
    {
        $ward->delete();

        return redirect()->route('wards.index')
            ->with('success', 'Ward deleted successfully!');
    }
}

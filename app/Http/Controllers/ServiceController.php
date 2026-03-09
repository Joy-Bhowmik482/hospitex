<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Department;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('department')->paginate(10);
        return view('services.list', compact('services'));
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        return view('services.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:services,code',
            'department_id' => 'nullable|exists:departments,id',
            'price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        Service::create($validated);
        return redirect()->route('services.index')->with('success', 'Service created successfully');
    }

    public function show(Service $service)
    {
        $service->load('department');
        return view('services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        $departments = Department::where('is_active', true)->get();
        return view('services.edit', compact('service', 'departments'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:services,code,' . $service->id,
            'department_id' => 'nullable|exists:departments,id',
            'price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $service->update($validated);
        return redirect()->route('services.index')->with('success', 'Service updated successfully');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted successfully');
    }
}

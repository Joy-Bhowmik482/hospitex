<?php

namespace App\Http\Controllers;

use App\Models\InsuranceProvider;
use Illuminate\Http\Request;

class InsuranceProviderController extends Controller
{
    public function index()
    {
        $insuranceProviders = InsuranceProvider::paginate(10);
        return view('insurance-providers.list', compact('insuranceProviders'));
    }

    public function create()
    {
        return view('insurance-providers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:insurance_providers,name',
            'policy_rules' => 'nullable|string',
        ]);

        InsuranceProvider::create($validated);
        return redirect()->route('insurance-providers.index')->with('success', 'Insurance Provider created successfully');
    }

    public function show(InsuranceProvider $insuranceProvider)
    {
        return view('insurance-providers.show', compact('insuranceProvider'));
    }

    public function edit(InsuranceProvider $insuranceProvider)
    {
        return view('insurance-providers.edit', compact('insuranceProvider'));
    }

    public function update(Request $request, InsuranceProvider $insuranceProvider)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:insurance_providers,name,' . $insuranceProvider->id,
            'policy_rules' => 'nullable|string',
        ]);

        $insuranceProvider->update($validated);
        return redirect()->route('insurance-providers.index')->with('success', 'Insurance Provider updated successfully');
    }

    public function destroy(InsuranceProvider $insuranceProvider)
    {
        $insuranceProvider->delete();
        return redirect()->route('insurance-providers.index')->with('success', 'Insurance Provider deleted successfully');
    }
}

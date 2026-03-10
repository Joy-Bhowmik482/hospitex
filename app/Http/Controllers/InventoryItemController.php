<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventoryItems = InventoryItem::with('movements')->get();
        return view('inventory_items.list', compact('inventoryItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventory_items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255',
            'unit' => 'required|string|max:255',
            'qty_on_hand' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
        ]);

        InventoryItem::create($validated);

        return redirect()->route('inventory-items.index')->with('success', 'Inventory item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(InventoryItem $inventoryItem)
    {
        $inventoryItem->load('movements.createdByUser');
        return view('inventory_items.show', compact('inventoryItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InventoryItem $inventoryItem)
    {
        return view('inventory_items.edit', compact('inventoryItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InventoryItem $inventoryItem)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255',
            'unit' => 'required|string|max:255',
            'qty_on_hand' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
        ]);

        $inventoryItem->update($validated);

        return redirect()->route('inventory-items.index')->with('success', 'Inventory item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryItem $inventoryItem)
    {
        $inventoryItem->delete();

        return redirect()->route('inventory-items.index')->with('success', 'Inventory item deleted successfully.');
    }

    /**
     * Add stock movement.
     */
    public function addMovement(Request $request, InventoryItem $inventoryItem)
    {
        $validated = $request->validate([
            'type' => 'required|in:IN,OUT,ADJUST',
            'qty' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:255',
            'ref_type' => 'nullable|string|max:255',
            'ref_id' => 'nullable|string|max:255',
        ]);

        $qtyChange = $validated['qty'];
        if ($validated['type'] === 'OUT' || $validated['type'] === 'ADJUST') {
            $qtyChange = -$qtyChange;
        }

        // Update inventory quantity
        $inventoryItem->qty_on_hand += $qtyChange;
        $inventoryItem->save();

        // Create movement record
        InventoryMovement::create([
            'inventory_item_id' => $inventoryItem->id,
            'type' => $validated['type'],
            'qty' => $validated['qty'],
            'reason' => $validated['reason'],
            'ref_type' => $validated['ref_type'],
            'ref_id' => $validated['ref_id'],
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('inventory-items.show', $inventoryItem)->with('success', 'Stock movement recorded successfully.');
    }
}
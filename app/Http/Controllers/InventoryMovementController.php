<?php

namespace App\Http\Controllers;

use App\Models\InventoryMovement;
use Illuminate\Http\Request;

class InventoryMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movements = InventoryMovement::with(['inventoryItem', 'createdByUser'])->latest()->get();
        return view('inventory_movements.list', compact('movements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $inventoryItems = \App\Models\InventoryItem::all();
        return view('inventory_movements.create', compact('inventoryItems'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inventory_item_id' => 'required|exists:inventory_items,id',
            'type' => 'required|in:IN,OUT,ADJUST',
            'qty' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:255',
            'ref_type' => 'nullable|string|max:255',
            'ref_id' => 'nullable|string|max:255',
        ]);

        $inventoryItem = \App\Models\InventoryItem::find($validated['inventory_item_id']);
        $qtyChange = $validated['qty'];
        if ($validated['type'] === 'OUT' || $validated['type'] === 'ADJUST') {
            $qtyChange = -$qtyChange;
        }

        // Update inventory quantity
        $inventoryItem->qty_on_hand += $qtyChange;
        $inventoryItem->save();

        // Create movement record
        InventoryMovement::create(array_merge($validated, [
            'created_by' => auth()->id(),
        ]));

        return redirect()->route('inventory-movements.index')->with('success', 'Inventory movement recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(InventoryMovement $inventoryMovement)
    {
        $inventoryMovement->load(['inventoryItem', 'createdByUser']);
        return view('inventory_movements.show', compact('inventoryMovement'));
    }
}
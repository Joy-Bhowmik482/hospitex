<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InventoryItem;
use App\Models\InventoryMovement;
use App\Models\User;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'Paracetamol', 'sku' => 'SKU-PAR-001', 'unit' => 'box', 'qty_on_hand' => 100, 'reorder_level' => 20],
            ['name' => 'Bandage', 'sku' => 'SKU-BND-001', 'unit' => 'pack', 'qty_on_hand' => 200, 'reorder_level' => 50],
        ];

        $user = User::first();

        foreach ($items as $it) {
            $item = InventoryItem::firstOrCreate(['sku' => $it['sku']], $it);

            InventoryMovement::create([
                'inventory_item_id' => $item->id,
                'type' => 'in',
                'qty' => $it['qty_on_hand'],
                'reason' => 'Initial stock',
                'ref_type' => null,
                'ref_id' => null,
                'created_by' => $user ? $user->id : null,
            ]);
        }
    }
}

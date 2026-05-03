<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InventoryItem;

class EnhancedInventoryItemsSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'Syringes 5ml', 'code' => 'SYR-005', 'category' => 'Medical Supplies', 'unit' => 'Box', 'quantity' => 500, 'unit_cost' => 45],
            ['name' => 'Syringes 10ml', 'code' => 'SYR-010', 'category' => 'Medical Supplies', 'unit' => 'Box', 'quantity' => 400, 'unit_cost' => 60],
            ['name' => 'Needles 24G', 'code' => 'NEED-24', 'category' => 'Medical Supplies', 'unit' => 'Box', 'quantity' => 1000, 'unit_cost' => 30],
            ['name' => 'Needles 26G', 'code' => 'NEED-26', 'category' => 'Medical Supplies', 'unit' => 'Box', 'quantity' => 800, 'unit_cost' => 35],
            ['name' => 'Cotton Swabs', 'code' => 'COTS', 'category' => 'Medical Supplies', 'unit' => 'Pack', 'quantity' => 200, 'unit_cost' => 120],
            ['name' => 'Gauze Pads 4x4', 'code' => 'GAU-44', 'category' => 'Medical Supplies', 'unit' => 'Box', 'quantity' => 300, 'unit_cost' => 150],
            ['name' => 'Elastic Bandage', 'code' => 'BAND-EL', 'category' => 'Medical Supplies', 'unit' => 'Roll', 'quantity' => 100, 'unit_cost' => 80],
            ['name' => 'Thermometer Digital', 'code' => 'THERM-DIG', 'category' => 'Equipment', 'unit' => 'Piece', 'quantity' => 25, 'unit_cost' => 450],
            ['name' => 'BP Monitor', 'code' => 'BPM', 'category' => 'Equipment', 'unit' => 'Piece', 'quantity' => 15, 'unit_cost' => 2500],
            ['name' => 'Pulse Oximeter', 'code' => 'OXI', 'category' => 'Equipment', 'unit' => 'Piece', 'quantity' => 20, 'unit_cost' => 1500],
            ['name' => 'Stethoscope', 'code' => 'STETH', 'category' => 'Equipment', 'unit' => 'Piece', 'quantity' => 30, 'unit_cost' => 800],
            ['name' => 'Paracetamol 500mg', 'code' => 'PARA-500', 'category' => 'Medicines', 'unit' => 'Box', 'quantity' => 1000, 'unit_cost' => 5],
            ['name' => 'Amoxicillin 500mg', 'code' => 'AMX-500', 'category' => 'Medicines', 'unit' => 'Box', 'quantity' => 500, 'unit_cost' => 35],
            ['name' => 'Ibuprofen 400mg', 'code' => 'IBU-400', 'category' => 'Medicines', 'unit' => 'Box', 'quantity' => 800, 'unit_cost' => 8],
            ['name' => 'Metformin 500mg', 'code' => 'MET-500', 'category' => 'Medicines', 'unit' => 'Box', 'quantity' => 600, 'unit_cost' => 12],
            ['name' => 'Lisinopril 10mg', 'code' => 'LIS-10', 'category' => 'Medicines', 'unit' => 'Box', 'quantity' => 400, 'unit_cost' => 25],
            ['name' => 'Surgical Gloves M', 'code' => 'GLOVE-M', 'category' => 'Safety', 'unit' => 'Box', 'quantity' => 200, 'unit_cost' => 350],
            ['name' => 'Surgical Mask', 'code' => 'MASK', 'category' => 'Safety', 'unit' => 'Box', 'quantity' => 500, 'unit_cost' => 150],
            ['name' => 'Hand Sanitizer 500ml', 'code' => 'SANS-500', 'category' => 'Safety', 'unit' => 'Bottle', 'quantity' => 100, 'unit_cost' => 180],
            ['name' => 'Disinfectant Spray', 'code' => 'DISF', 'category' => 'Safety', 'unit' => 'Bottle', 'quantity' => 50, 'unit_cost' => 250],
        ];

        foreach ($items as $item) {
            InventoryItem::firstOrCreate(['code' => $item['code']], $item + ['is_active' => true]);
        }
    }
}

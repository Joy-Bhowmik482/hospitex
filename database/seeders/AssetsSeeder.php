<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asset;

class AssetsSeeder extends Seeder
{
    public function run(): void
    {
        $assets = [
            ['asset_code' => 'AST-001', 'name' => 'ECG Machine', 'category' => 'Equipment', 'purchase_date' => now()->subYears(2)->toDateString(), 'cost' => 5000, 'status' => 'active', 'location' => 'Cardiology'],
            ['asset_code' => 'AST-002', 'name' => 'X-Ray Machine', 'category' => 'Equipment', 'purchase_date' => now()->subYears(3)->toDateString(), 'cost' => 15000, 'status' => 'active', 'location' => 'Radiology'],
        ];

        foreach ($assets as $a) {
            Asset::firstOrCreate(['asset_code' => $a['asset_code']], $a);
        }
    }
}

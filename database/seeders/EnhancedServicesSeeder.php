<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class EnhancedServicesSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'X-Ray', 'code' => 'XRAY', 'price' => 50, 'is_active' => true],
            ['name' => 'Blood Test', 'code' => 'BLDTEST', 'price' => 30, 'is_active' => true],
            ['name' => 'MRI Scan', 'code' => 'MRI', 'price' => 250, 'is_active' => true],
        ];

        foreach ($services as $s) {
            Service::firstOrCreate(['code' => $s['code']], $s);
        }
    }
}

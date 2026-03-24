<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Department;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        $departments = Department::all();
        foreach (['Consultation','X-Ray','Laboratory','Pharmacy'] as $s) {
            Service::firstOrCreate([
                'name' => $s,
            ], [
                'code' => strtoupper(substr($s,0,3)) . rand(10,99),
                'department_id' => $departments->random()->id,
                'price' => 50.00,
                'is_active' => true,
            ]);
        }
    }
}

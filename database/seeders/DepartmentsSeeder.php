<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentsSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'General Medicine', 'code' => 'GEN', 'is_active' => true],
            ['name' => 'Pediatrics', 'code' => 'PED', 'is_active' => true],
            ['name' => 'Obstetrics & Gynecology', 'code' => 'OBG', 'is_active' => true],
            ['name' => 'Cardiology', 'code' => 'CAR', 'is_active' => true],
        ];

        foreach ($departments as $d) {
            Department::firstOrCreate(['code' => $d['code']], $d);
        }
    }
}

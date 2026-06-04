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
            ['name' => 'Orthopedics', 'code' => 'ORT', 'is_active' => true],
            ['name' => 'Neurology', 'code' => 'NEU', 'is_active' => true],
            ['name' => 'Psychiatry', 'code' => 'PSY', 'is_active' => true],
            ['name' => 'Dermatology', 'code' => 'DER', 'is_active' => true],
            ['name' => 'ENT (Ear, Nose, Throat)', 'code' => 'ENT', 'is_active' => true],
            ['name' => 'Ophthalmology', 'code' => 'OPH', 'is_active' => true],
            ['name' => 'Gastroenterology', 'code' => 'GAS', 'is_active' => true],
            ['name' => 'Pulmonology', 'code' => 'PUL', 'is_active' => true],
            ['name' => 'Urology', 'code' => 'URO', 'is_active' => true],
            ['name' => 'Surgery', 'code' => 'SUR', 'is_active' => true],
            ['name' => 'Emergency Medicine', 'code' => 'EMR', 'is_active' => true],
        ];

        foreach ($departments as $d) {
            Department::firstOrCreate(['code' => $d['code']], $d);
        }
    }
}

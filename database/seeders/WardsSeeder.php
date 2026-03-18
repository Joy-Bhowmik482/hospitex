<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ward;

class WardsSeeder extends Seeder
{
    public function run(): void
    {
        $wards = [
            ['name' => 'General Ward', 'code' => 'W-GEN', 'floor' => 1, 'gender_policy' => 'Any'],
            ['name' => 'Maternity Ward', 'code' => 'W-MAT', 'floor' => 2, 'gender_policy' => 'Female'],
        ];

        foreach ($wards as $w) {
            Ward::firstOrCreate(['code' => $w['code']], $w);
        }
    }
}

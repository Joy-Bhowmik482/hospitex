<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shift;

class ShiftsSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing shifts
        Shift::truncate();

        $shifts = [
            [
                'name' => 'Morning',
                'start_time' => '07:00:00',
                'end_time' => '15:00:00',
                'is_active' => true,
            ],
            [
                'name' => 'Evening',
                'start_time' => '15:00:00',
                'end_time' => '23:00:00',
                'is_active' => true,
            ],
            [
                'name' => 'Night',
                'start_time' => '23:00:00',
                'end_time' => '07:00:00',
                'is_active' => true,
            ],
        ];

        foreach ($shifts as $shift) {
            Shift::create($shift);
        }
    }
}
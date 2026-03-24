<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\Ward;

class RoomsSeeder extends Seeder
{
    public function run(): void
    {
        $wards = Ward::all();
        foreach ($wards as $ward) {
            for ($i = 1; $i <= 3; $i++) {
                Room::firstOrCreate([
                    'ward_id' => $ward->id,
                    'room_no' => $ward->code . '-R' . $i,
                ], [
                    'room_type' => 'General',
                    'daily_rate' => 100.00,
                    'is_active' => true,
                ]);
            }
        }
    }
}

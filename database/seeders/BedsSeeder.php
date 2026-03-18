<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bed;
use App\Models\Room;

class BedsSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = Room::all();
        foreach ($rooms as $room) {
            for ($i = 1; $i <= 4; $i++) {
                Bed::firstOrCreate([
                    'room_id' => $room->id,
                    'bed_no' => $room->room_no . '-B' . $i,
                ], [
                    'status' => 'available',
                ]);
            }
        }
    }
}

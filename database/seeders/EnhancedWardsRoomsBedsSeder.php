<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ward;
use App\Models\Room;
use App\Models\Bed;

class EnhancedWardsRoomsBedsSeder extends Seeder
{
    public function run(): void
    {
        $wardData = [
            ['name' => 'General Ward - A', 'type' => 'General', 'capacity' => 50],
            ['name' => 'General Ward - B', 'type' => 'General', 'capacity' => 50],
            ['name' => 'ICU Ward', 'type' => 'ICU', 'capacity' => 20],
            ['name' => 'Pediatric Ward', 'type' => 'Pediatric', 'capacity' => 30],
            ['name' => 'Maternity Ward', 'type' => 'Maternity', 'capacity' => 25],
            ['name' => 'Surgical Ward', 'type' => 'Surgical', 'capacity' => 40],
            ['name' => 'Cardiac Ward', 'type' => 'Specialty', 'capacity' => 20],
            ['name' => 'Orthopedic Ward', 'type' => 'Specialty', 'capacity' => 30],
        ];

        foreach ($wardData as $ward) {
            $createdWard = Ward::firstOrCreate(['name' => $ward['name']], $ward + ['is_active' => true]);
            
            // Create rooms for each ward
            $numRooms = ceil($ward['capacity'] / 4); // 4 beds per room average
            
            for ($r = 1; $r <= $numRooms; $r++) {
                $room = Room::firstOrCreate([
                    'ward_id' => $createdWard->id,
                    'room_no' => $createdWard->id . '-' . str_pad($r, 2, '0', STR_PAD_LEFT),
                ], [
                    'type' => ['Single', 'Double', 'Triple', 'Quad'][rand(0, 3)],
                    'capacity' => rand(1, 4),
                    'status' => 'Available',
                    'is_active' => true,
                ]);
                
                // Create beds for each room
                $bedsInRoom = $room->capacity ?? 2;
                for ($b = 1; $b <= $bedsInRoom; $b++) {
                    Bed::firstOrCreate([
                        'room_id' => $room->id,
                        'bed_no' => $room->room_no . '-B' . $b,
                    ], [
                        'status' => 'Available',
                        'is_active' => true,
                    ]);
                }
            }
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DoctorSchedule;
use App\Models\Doctor;

class DoctorSchedulesSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = Doctor::all();
        $days = [1, 2, 3, 4, 5]; // Monday to Friday
        
        $timeSlots = [
            ['start' => '09:00', 'end' => '12:00'],
            ['start' => '14:00', 'end' => '17:00'],
            ['start' => '09:00', 'end' => '13:00'],
            ['start' => '15:00', 'end' => '19:00'],
            ['start' => '10:00', 'end' => '12:00'],
        ];

        foreach ($doctors as $doctor) {
            $selectedDays = array_rand(array_flip($days), rand(3, 5));
            $numSlots = rand(1, 2);
            
            foreach ($selectedDays as $day) {
                for ($i = 0; $i < $numSlots; $i++) {
                    $slot = $timeSlots[array_rand($timeSlots)];
                    
                    DoctorSchedule::firstOrCreate([
                        'doctor_id' => $doctor->id,
                        'day_of_week' => $day,
                        'start_time' => $slot['start'],
                        'end_time' => $slot['end'],
                    ], [
                        'room_no' => 'Room ' . rand(101, 320),
                        'is_active' => true,
                    ]);
                }
            }
        }
    }
}

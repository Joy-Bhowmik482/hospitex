<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\DoctorSchedule;

class DoctorSchedulesSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = Doctor::all();

        foreach ($doctors as $doctor) {
            // create a couple of schedules (weekday mornings)
            for ($dow = 1; $dow <= 5; $dow++) {
                DoctorSchedule::create([
                    'doctor_id' => $doctor->id,
                    'day_of_week' => $dow,
                    'start_time' => '09:00:00',
                    'end_time' => '12:00:00',
                    'room_no' => 'R' . rand(1,20),
                    'is_active' => true,
                ]);
            }
        }
    }
}

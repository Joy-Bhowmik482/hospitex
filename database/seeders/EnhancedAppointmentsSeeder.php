<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;

class EnhancedAppointmentsSeeder extends Seeder
{
    public function run(): void
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        
        $statuses = ['Scheduled', 'Completed', 'Cancelled', 'No-Show'];
        $reasons = [
            'General Checkup',
            'Follow-up Consultation',
            'Complaint - Fever',
            'Complaint - Cough',
            'Complaint - Body Pain',
            'Complaint - Headache',
            'Preventive Care',
            'Chronic Disease Management',
            'Post-Operative Review',
            'Lab Report Review'
        ];

        $appointmentCount = min(100, $patients->count() * 3);
        
        for ($i = 0; $i < $appointmentCount; $i++) {
            $appointmentDate = now()->addDays(rand(-30, 60));
            $appointmentTime = rand(9, 16) . ':' . sprintf('%02d', [0, 30][rand(0, 1)]);
            
            Appointment::firstOrCreate([
                'patient_id' => $patients->random()->id,
                'doctor_id' => $doctors->random()->id,
                'appointment_date' => $appointmentDate->toDateString(),
                'appointment_time' => $appointmentTime,
            ], [
                'reason' => $reasons[array_rand($reasons)],
                'status' => $statuses[array_rand($statuses)],
                'notes' => 'Appointment for consultation',
                'is_active' => true,
            ]);
        }
    }
}

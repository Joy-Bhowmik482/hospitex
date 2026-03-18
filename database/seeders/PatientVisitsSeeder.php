<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\PatientVisit;
use App\Models\Doctor;
use App\Models\User;

class PatientVisitsSeeder extends Seeder
{
    public function run(): void
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        $user = User::first();

        foreach ($patients as $patient) {
            $doctor = $doctors->random();

            PatientVisit::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'visit_type' => 'consultation',
                'visit_date' => now(),
                'chief_complaint' => 'Routine checkup',
                'diagnosis' => 'Healthy',
                'notes' => null,
                'created_by' => $user ? $user->id : null,
            ]);
        }
    }
}

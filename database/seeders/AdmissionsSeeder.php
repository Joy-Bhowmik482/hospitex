<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admission;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Department;

class AdmissionsSeeder extends Seeder
{
    public function run(): void
    {
        $patient = Patient::first();
        $doctor = Doctor::first();
        $department = Department::first();

        if ($patient && $doctor) {
            Admission::firstOrCreate([
                'admission_no' => 'ADM-' . now()->format('Ymd') . '-1'
            ], [
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'department_id' => $department?->id,
                'admitted_at' => now(),
                'status' => 'admitted',
                'diagnosis' => 'Observation',
                'created_by' => $patient->id,
            ]);
        }
    }
}

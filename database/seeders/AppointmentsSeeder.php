<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;

class AppointmentsSeeder extends Seeder
{
    public function run(): void
    {
        $patients = Patient::all();
        $doctors = Doctor::all();

        $user = \App\Models\User::first();
        foreach ($patients->take(5) as $patient) {
            $doctor = $doctors->random();
            $deptId = $doctor->department_id ?? null;
            $appointmentDate = now()->addDays(rand(1,10))->setTime(rand(8,16), 0, 0);

            Appointment::firstOrCreate([
                'appointment_no' => 'APPT-' . $patient->id . '-' . $appointmentDate->format('YmdHi'),
            ], [
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'department_id' => $deptId,
                'appointment_date' => $appointmentDate->toDateTimeString(),
                'appointment_time' => $appointmentDate->format('H:i:s'),
                'status' => 'Pending',
                'token_no' => null,
                'notes' => 'Auto-generated appointment',
                'created_by' => $user ? $user->id : null,
            ]);
        }
    }
}

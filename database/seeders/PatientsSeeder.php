<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use Illuminate\Support\Str;

class PatientsSeeder extends Seeder
{
    public function run(): void
    {
        $bloodTypes = ['A+', 'A-', 'B+', 'O+'];

        for ($i = 1; $i <= 10; $i++) {
            $gender = rand(0,1) ? 'Male' : 'Female';
            $email = "patient{$i}@example.com";

            Patient::firstOrCreate([
                'email' => $email,
            ], [
                'first_name' => 'Patient' . $i,
                'last_name' => 'Test',
                'phone' => '07' . rand(10000000,99999999),
                'date_of_birth' => now()->subYears(20 + rand(0,50))->toDateString(),
                'gender' => $gender,
                'address' => '123 Test St',
                'blood_type' => $bloodTypes[array_rand($bloodTypes)],
                'allergies' => null,
                'medical_conditions' => null,
                'emergency_contact_name' => 'Emergency Contact',
                'emergency_contact_phone' => '07' . rand(10000000,99999999),
                'date_admitted' => now()->toDateString(),
                'status' => 'In',
                'notes' => null,
            ]);
        }
    }
}

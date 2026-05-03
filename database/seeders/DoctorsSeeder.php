<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Department;

class DoctorsSeeder extends Seeder
{
    public function run(): void
    {
        $departments = Department::all();
        $specializations = [
            'GEN' => ['General Practitioner', 'Family Medicine Specialist'],
            'PED' => ['Pediatrician', 'Child Specialist', 'Neonatologist'],
            'OBG' => ['Gynecologist', 'Obstetrician', 'Maternal Health Specialist'],
            'CAR' => ['Cardiologist', 'Interventional Cardiologist'],
            'ORT' => ['Orthopedic Surgeon', 'Spine Specialist', 'Joint Replacement Specialist'],
            'NEU' => ['Neurologist', 'Neurosurgeon'],
            'PSY' => ['Psychiatrist', 'Clinical Psychologist'],
            'DER' => ['Dermatologist', 'Cosmetic Surgeon'],
            'ENT' => ['ENT Specialist', 'Otolaryngologist'],
            'OPH' => ['Ophthalmologist', 'Eye Specialist'],
            'GAS' => ['Gastroenterologist', 'Hepatologist'],
            'PUL' => ['Pulmonologist', 'Respiratory Specialist'],
            'URO' => ['Urologist', 'Urological Surgeon'],
            'SUR' => ['General Surgeon', 'Trauma Surgeon'],
            'EMR' => ['Emergency Medicine Specialist', 'Trauma Specialist'],
        ];

        $doctorNames = [
            'Dr. Rajesh Kumar',
            'Dr. Priya Sharma',
            'Dr. Amit Patel',
            'Dr. Neha Singh',
            'Dr. Vikram Reddy',
            'Dr. Anjali Gupta',
            'Dr. Rohan Chopra',
            'Dr. Meera Verma',
            'Dr. Arun Nair',
            'Dr. Deepika Iyer',
            'Dr. Sanjay Malhotra',
            'Dr. Pooja Desai',
            'Dr. Arjun Bhatt',
            'Dr. Sneha Kapoor',
            'Dr. Nikhil Saxena',
            'Dr. Ritika Bhat',
            'Dr. Mohit Joshi',
            'Dr. Ishita Agrawal',
            'Dr. Harsh Pandey',
            'Dr. Varun Kumar',
        ];

        foreach ($doctorNames as $index => $name) {
            $email = 'doctor' . ($index + 1) . '@hospitex.com';
            $user = User::where('email', $email)->first();
            
            if (!$user) {
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => bcrypt('password123'),
                    'is_active' => true,
                ]);
            }

            if (!Doctor::where('user_id', $user->id)->exists()) {
                $dept = $departments->random();
                $specs = $specializations[$dept->code] ?? ['Specialist'];
                
                Doctor::create([
                    'user_id' => $user->id,
                    'department_id' => $dept->id,
                    'reg_no' => 'REG' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                    'specialization' => $specs[array_rand($specs)],
                    'fee' => rand(500, 2000),
                    'is_active' => true,
                ]);
            }
        }
    }
}

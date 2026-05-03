<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Staff;
use App\Models\User;
use App\Models\Department;

class EnhancedStaffSeeder extends Seeder
{
    public function run(): void
    {
        $departments = Department::all();
        
        $staffNames = [
            'Nurse Priya', 'Nurse Anjali', 'Nurse Neha', 'Nurse Ritu', 'Nurse Shreya',
            'Lab Technician Rakesh', 'Lab Technician Arun', 'Lab Technician Sanjay',
            'Receptionist Pooja', 'Receptionist Kavya',
            'Pharmacist Rahul', 'Pharmacist Dhruv',
            'Attendant Vinod', 'Attendant Ramesh', 'Attendant Suresh'
        ];
        
        $positions = ['Nurse', 'Lab Technician', 'Receptionist', 'Pharmacist', 'Attendant', 'Administrative Staff'];

        foreach ($staffNames as $index => $name) {
            $email = strtolower(str_replace(' ', '.', $name) . '@hospitex.com');
            
            $user = User::where('email', $email)->first();
            if (!$user) {
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => bcrypt('password123'),
                    'is_active' => true,
                ]);
            }

            if (!Staff::where('user_id', $user->id)->exists()) {
                Staff::create([
                    'user_id' => $user->id,
                    'department_id' => $departments->random()->id,
                    'position' => $positions[array_rand($positions)],
                    'phone' => '9' . rand(100000000, 999999999),
                    'address' => 'Staff Address ' . ($index + 1),
                    'hire_date' => now()->subMonths(rand(1, 60))->toDateString(),
                    'is_active' => true,
                ]);
            }
        }
    }
}

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

        for ($i = 1; $i <= 4; $i++) {
            $email = "doctor{$i}@example.com";
            $user = User::where('email', $email)->first();
            if (! $user) {
                $user = User::create([
                    'name' => "Dr. Doctor $i",
                    'email' => $email,
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'is_active' => true,
                ]);
            }

            if (! Doctor::where('user_id', $user->id)->exists()) {
                Doctor::create([
                    'user_id' => $user->id,
                    'department_id' => $departments->random()->id,
                    'reg_no' => 'REG' . rand(1000,9999),
                    'specialization' => 'General Practice',
                    'fee' => 50 + rand(0,150),
                    'is_active' => true,
                ]);
            }
        }
    }
}

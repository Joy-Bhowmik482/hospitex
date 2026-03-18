<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Staff;
use App\Models\Department;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $departments = Department::all();

        // create 3 staff users
        for ($i = 1; $i <= 3; $i++) {
            $email = "staff{$i}@example.com";
            $user = User::where('email', $email)->first();
            if (! $user) {
                $user = User::create([
                    'name' => "Staff Member $i",
                    'email' => $email,
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'is_active' => true,
                ]);
            }

            // create staff only if not exists for user
            if (! Staff::where('user_id', $user->id)->exists()) {
                Staff::create([
                    'user_id' => $user->id,
                    'department_id' => $departments->random()->id,
                    'designation' => 'Nurse',
                    'joining_date' => now()->subYears(rand(0,5))->toDateString(),
                    'salary' => 30000 + rand(0,20000),
                    'is_active' => true,
                ]);
            }
        }
    }
}

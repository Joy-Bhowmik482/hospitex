<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // keep a single test user (create without factory to match DB schema)
        \Illuminate\Support\Facades\Hash::make('password');
        if (! User::where('email', 'test@example.com')->exists()) {
            User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'is_active' => true,
            ]);
        }

        // Core data
        $this->call([
            DepartmentsSeeder::class,
            WardsSeeder::class,
            RoomsSeeder::class,
            BedsSeeder::class,
            StaffSeeder::class,
            DoctorsSeeder::class,
            DoctorSchedulesSeeder::class,
            ServicesSeeder::class,
            PatientsSeeder::class,
            PatientDocumentsSeeder::class,
            PatientVisitsSeeder::class,
            AppointmentsSeeder::class,
            AdmissionsSeeder::class,
            BedAllocationsSeeder::class,
            InvoicesSeeder::class,
            AssetsSeeder::class,
            InventorySeeder::class,
            InsuranceProvidersSeeder::class,
            RolesPermissionsSeeder::class,
            SettingsSeeder::class,
        ]);
    }
}

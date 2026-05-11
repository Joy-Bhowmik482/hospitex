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

        // Core entities with enhanced data
        $this->call([
            DepartmentsSeeder::class,              // 15 departments
            DoctorsSeeder::class,                  // 20 doctors with specializations
            ShiftsSeeder::class,                   // Default shifts (Morning, Evening, Night)
        ]);

        // Create patients with users
        $this->call([
            PatientsSeeder::class,                 // 50 patients
        ]);

        // Services and insurance
        $this->call([
            EnhancedServicesSeeder::class,         // 15 services
            EnhancedInsuranceProvidersSeeder::class, // 10 insurance providers
        ]);

        // Infrastructure
        $this->call([
            EnhancedWardsRoomsBedsSeder::class,    // 8 wards with rooms and beds
            EnhancedStaffSeeder::class,            // 15 staff members
        ]);

        // Schedule and appointments
        $this->call([
            EnhancedDoctorSchedulesSeeder::class,  // Weekly schedules for doctors
            EnhancedAppointmentsSeeder::class,     // 100 appointments
        ]);

        // Patient care
        $this->call([
            EnhancedAdmissionsSeeder::class,       // 30 admissions
        ]);

        // Financial
        $this->call([
            EnhancedInvoicesSeeder::class,         // 50 invoices with items
            EnhancedPaymentsSeeder::class,         // Payments for invoices
        ]);

        // Inventory
        $this->call([
            EnhancedInventoryItemsSeeder::class,   // 20 inventory items
        ]);

        // Legacy seeders (if still needed)
        $this->call([
            PatientDocumentsSeeder::class,
            PatientVisitsSeeder::class,
            BedAllocationsSeeder::class,
            AssetsSeeder::class,
            RolesPermissionsSeeder::class,
            SettingsSeeder::class,
        ]);
    }
}

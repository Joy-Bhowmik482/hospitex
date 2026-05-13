<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MaintenanceSchedule;
use App\Models\Asset;
use App\Models\User;
use Carbon\Carbon;

class MaintenanceSchedulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some assets and users
        $assets = Asset::take(5)->get();
        $users = User::take(3)->get();

        if ($assets->isEmpty() || $users->isEmpty()) {
            return; // Skip if no assets or users exist
        }

        $maintenanceTypes = ['preventive', 'corrective', 'calibration', 'inspection'];
        $priorities = ['low', 'medium', 'high', 'critical'];
        $departments = ['Radiology', 'Surgery', 'Laboratory', 'Emergency', 'ICU'];
        $technicians = ['John Smith', 'Sarah Johnson', 'Mike Davis', 'Lisa Chen', 'Robert Wilson'];

        // Create sample maintenance schedules
        $schedules = [
            [
                'asset_id' => $assets->first()->id,
                'maintenance_type' => 'preventive',
                'priority' => 'high',
                'scheduled_date' => Carbon::now()->addDays(3),
                'scheduled_end_date' => Carbon::now()->addDays(3)->addHours(2),
                'technician_name' => 'John Smith',
                'technician_contact' => 'john.smith@hospital.com',
                'department' => 'Radiology',
                'status' => 'scheduled',
                'estimated_cost' => 250.00,
                'description' => 'Quarterly preventive maintenance for X-Ray machine including calibration and safety checks.',
                'notes' => 'Machine has been showing minor calibration drift in recent scans.',
                'created_by' => $users->first()->id,
            ],
            [
                'asset_id' => $assets->skip(1)->first()->id ?? $assets->first()->id,
                'maintenance_type' => 'corrective',
                'priority' => 'critical',
                'scheduled_date' => Carbon::now()->addDays(1),
                'scheduled_end_date' => Carbon::now()->addDays(1)->addHours(4),
                'technician_name' => 'Sarah Johnson',
                'technician_contact' => '+1-555-0123',
                'department' => 'Surgery',
                'status' => 'in_progress',
                'estimated_cost' => 500.00,
                'description' => 'Emergency repair of surgical ventilator - oxygen sensor malfunction.',
                'notes' => 'Patient safety critical - ventilator taken offline until repair completed.',
                'created_by' => $users->first()->id,
            ],
            [
                'asset_id' => $assets->skip(2)->first()->id ?? $assets->first()->id,
                'maintenance_type' => 'calibration',
                'priority' => 'medium',
                'scheduled_date' => Carbon::now()->subDays(2),
                'scheduled_end_date' => Carbon::now()->subDays(2)->addHours(1),
                'technician_name' => 'Mike Davis',
                'technician_contact' => 'mike.davis@hospital.com',
                'department' => 'Laboratory',
                'status' => 'completed',
                'estimated_cost' => 150.00,
                'actual_cost' => 145.50,
                'description' => 'Annual calibration of blood analyzer equipment.',
                'work_performed' => 'Calibrated all sensors and verified accuracy against reference standards. All readings within acceptable parameters.',
                'parts_used' => 'Calibration solution kit, reference standards',
                'notes' => 'Equipment performing well, no issues found.',
                'completed_date' => Carbon::now()->subDays(2)->addHours(1),
                'created_by' => $users->skip(1)->first()->id ?? $users->first()->id,
            ],
            [
                'asset_id' => $assets->skip(3)->first()->id ?? $assets->first()->id,
                'maintenance_type' => 'inspection',
                'priority' => 'low',
                'scheduled_date' => Carbon::now()->addWeeks(1),
                'technician_name' => 'Lisa Chen',
                'department' => 'Emergency',
                'status' => 'scheduled',
                'estimated_cost' => 75.00,
                'description' => 'Monthly safety inspection of emergency defibrillators.',
                'notes' => 'Part of regular maintenance schedule for critical emergency equipment.',
                'created_by' => $users->first()->id,
            ],
            [
                'asset_id' => $assets->skip(4)->first()->id ?? $assets->first()->id,
                'maintenance_type' => 'preventive',
                'priority' => 'medium',
                'scheduled_date' => Carbon::now()->subDays(5),
                'scheduled_end_date' => Carbon::now()->subDays(5)->addHours(3),
                'technician_name' => 'Robert Wilson',
                'technician_contact' => '+1-555-0456',
                'department' => 'ICU',
                'status' => 'overdue',
                'estimated_cost' => 300.00,
                'description' => 'Monthly maintenance of ICU monitoring equipment including battery replacement and software updates.',
                'notes' => 'Maintenance was delayed due to equipment being in use. Reschedule as soon as possible.',
                'created_by' => $users->skip(2)->first()->id ?? $users->first()->id,
            ],
        ];

        foreach ($schedules as $schedule) {
            MaintenanceSchedule::create($schedule);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admission;
use App\Models\Patient;
use App\Models\Ward;
use App\Models\Bed;

class EnhancedAdmissionsSeeder extends Seeder
{
    public function run(): void
    {
        $patients = Patient::all();
        $wards = Ward::all();
        $beds = Bed::where('status', 'Available')->get();
        
        $reasons = [
            'Emergency Admission',
            'Surgery Required',
            'Chronic Disease Management',
            'Accident/Trauma',
            'Pre-operative Assessment',
            'Post-operative Care',
            'Infectious Disease',
            'Cardiac Condition',
        ];

        $numAdmissions = min(30, $patients->count());
        
        for ($i = 0; $i < $numAdmissions; $i++) {
            $admissionDate = now()->subDays(rand(1, 90));
            $dischargDate = null;
            $status = 'Active';
            
            if (rand(0, 1)) {
                $dischargDate = $admissionDate->copy()->addDays(rand(1, 30));
                $status = 'Discharged';
            }
            
            $bed = $beds->random();
            
            Admission::firstOrCreate([
                'patient_id' => $patients->random()->id,
                'admission_date' => $admissionDate->toDateString(),
            ], [
                'ward_id' => $bed->room->ward_id ?? $wards->random()->id,
                'bed_id' => $bed->id,
                'reason' => $reasons[array_rand($reasons)],
                'discharge_date' => $dischargDate?->toDateString(),
                'status' => $status,
                'notes' => 'Admission notes',
                'is_active' => true,
            ]);
        }
    }
}

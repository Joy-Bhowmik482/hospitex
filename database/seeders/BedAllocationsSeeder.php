<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BedAllocation;
use App\Models\Admission;
use App\Models\Bed;

class BedAllocationsSeeder extends Seeder
{
    public function run(): void
    {
        $admission = Admission::first();
        $bed = Bed::first();

        if ($admission && $bed) {
            BedAllocation::firstOrCreate([
                'admission_id' => $admission->id,
            ], [
                'bed_id' => $bed->id,
                'allocated_at' => now(),
            ]);
        }
    }
}

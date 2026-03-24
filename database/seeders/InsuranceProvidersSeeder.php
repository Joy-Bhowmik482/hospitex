<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InsuranceProvider;

class InsuranceProvidersSeeder extends Seeder
{
    public function run(): void
    {
        $providers = [
            ['name' => 'HealthCare Co', 'policy_rules' => ['cover_inpatient' => true]],
            ['name' => 'MediInsure', 'policy_rules' => ['cover_outpatient' => true]],
        ];

        foreach ($providers as $p) {
            InsuranceProvider::firstOrCreate(['name' => $p['name']], $p);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InsuranceProvider;

class EnhancedInsuranceProvidersSeeder extends Seeder
{
    public function run(): void
    {
        $providers = [
            ['name' => 'Apollo Munich Health Insurance', 'code' => 'APOLLO', 'contact' => '1800-123-2222', 'email' => 'claims@apollomunich.com'],
            ['name' => 'ICICI Lombard Health Insurance', 'code' => 'ICICI', 'contact' => '1800-123-3333', 'email' => 'claims@icilombard.com'],
            ['name' => 'HDFC ERGO Health Insurance', 'code' => 'HDFC', 'contact' => '1800-123-4444', 'email' => 'claims@hdfcergo.com'],
            ['name' => 'Bajaj Allianz Health Insurance', 'code' => 'BAJAJ', 'contact' => '1800-123-5555', 'email' => 'claims@bajajallianz.com'],
            ['name' => 'Aetna Health Insurance', 'code' => 'AETNA', 'contact' => '1800-123-6666', 'email' => 'claims@aetna.com'],
            ['name' => 'Star Health Insurance', 'code' => 'STAR', 'contact' => '1800-123-7777', 'email' => 'claims@starhealth.com'],
            ['name' => 'United India Health Insurance', 'code' => 'UNITED', 'contact' => '1800-123-8888', 'email' => 'claims@unitedindi.com'],
            ['name' => 'Care Health Insurance', 'code' => 'CARE', 'contact' => '1800-123-9999', 'email' => 'claims@carehealth.com'],
            ['name' => 'Niva Bupa Health Insurance', 'code' => 'NIVA', 'contact' => '1800-123-0000', 'email' => 'claims@nivabupa.com'],
            ['name' => 'Religare Health Insurance', 'code' => 'REL', 'contact' => '1800-123-1111', 'email' => 'claims@religare.com'],
        ];

        foreach ($providers as $provider) {
            InsuranceProvider::firstOrCreate(['code' => $provider['code']], $provider + ['is_active' => true]);
        }
    }
}

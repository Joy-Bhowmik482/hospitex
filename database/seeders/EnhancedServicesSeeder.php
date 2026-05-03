<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class EnhancedServicesSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Consultation', 'code' => 'CONS', 'price' => 500, 'description' => 'General Medical Consultation'],
            ['name' => 'Blood Test', 'code' => 'BT', 'price' => 300, 'description' => 'Complete Blood Count'],
            ['name' => 'X-Ray', 'code' => 'XR', 'price' => 800, 'description' => 'X-Ray Imaging'],
            ['name' => 'Ultrasound', 'code' => 'US', 'price' => 1200, 'description' => 'Ultrasound Scanning'],
            ['name' => 'CT Scan', 'code' => 'CT', 'price' => 3500, 'description' => 'CT Scan Imaging'],
            ['name' => 'MRI Scan', 'code' => 'MRI', 'price' => 5000, 'description' => 'MRI Scan Imaging'],
            ['name' => 'ECG', 'code' => 'ECG', 'price' => 400, 'description' => 'Electrocardiogram'],
            ['name' => 'EEG', 'code' => 'EEG', 'price' => 600, 'description' => 'Electroencephalogram'],
            ['name' => 'Vaccination', 'code' => 'VAC', 'price' => 350, 'description' => 'Vaccination Services'],
            ['name' => 'Anesthesia', 'code' => 'ANS', 'price' => 2000, 'description' => 'Anesthesia Services'],
            ['name' => 'Surgery', 'code' => 'SURG', 'price' => 15000, 'description' => 'Surgical Procedure'],
            ['name' => 'Pharmacy', 'code' => 'PHAR', 'price' => 0, 'description' => 'Pharmacy Services'],
            ['name' => 'Physiotherapy', 'code' => 'PHYS', 'price' => 400, 'description' => 'Physiotherapy Session'],
            ['name' => 'Dental Cleaning', 'code' => 'DENT', 'price' => 600, 'description' => 'Dental Cleaning Service'],
            ['name' => 'Pathology Test', 'code' => 'PATH', 'price' => 500, 'description' => 'Pathology Lab Test'],
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(['code' => $service['code']], $service);
        }
    }
}

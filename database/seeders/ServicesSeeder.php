<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        Service::create([
            'name' => 'General Consultation',
            'code' => 'CONSULT',
            'price' => 0,
            'is_active' => true,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site.name', 'value' => ['value' => 'Hospitex'], 'group' => 'app'],
            ['key' => 'site.email', 'value' => ['value' => 'info@example.com'], 'group' => 'app'],
        ];

        foreach ($settings as $s) {
            Setting::firstOrCreate(['key' => $s['key']], $s);
        }
    }
}

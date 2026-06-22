<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Department;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;

class ActivityLogsSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::take(3)->get();
        $patient = Patient::first();
        $department = Department::first();

        if ($users->isEmpty()) {
            return;
        }

        $events = [
            [
                'action' => 'create',
                'module' => 'patients',
                'record_type' => 'patient',
                'record_id' => (string) ($patient?->id ?? 1),
                'meta' => ['source' => 'seeder', 'note' => 'Initial patient record created'],
            ],
            [
                'action' => 'update',
                'module' => 'departments',
                'record_type' => 'department',
                'record_id' => (string) ($department?->id ?? 1),
                'meta' => ['source' => 'seeder', 'note' => 'Department status updated'],
            ],
            [
                'action' => 'login',
                'module' => 'auth',
                'record_type' => 'user',
                'record_id' => (string) $users->first()->id,
                'meta' => ['source' => 'seeder', 'note' => 'User login activity recorded'],
            ],
        ];

        foreach ($events as $index => $event) {
            $user = $users[$index % $users->count()];

            ActivityLog::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'action' => $event['action'],
                    'module' => $event['module'],
                    'record_type' => $event['record_type'],
                    'record_id' => $event['record_id'],
                ],
                [
                    'ip' => '127.0.0.1',
                    'user_agent' => 'Seeder/ActivityLogsSeeder',
                    'meta' => $event['meta'],
                ]
            );
        }
    }
}

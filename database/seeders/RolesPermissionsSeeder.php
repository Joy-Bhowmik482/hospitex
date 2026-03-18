<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

class RolesPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'Manage Users', 'slug' => 'manage-users', 'module' => 'users'],
            ['name' => 'Manage Patients', 'slug' => 'manage-patients', 'module' => 'patients'],
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['slug' => $p['slug']], $p);
        }

        $role = Role::firstOrCreate(['slug' => 'admin'], ['name' => 'Administrator']);
        $perms = Permission::all();
        $role->permissions()->sync($perms->pluck('id')->toArray());

        $user = User::first();
        if ($user) {
            $role->users()->syncWithoutDetaching([$user->id]);
        }
    }
}

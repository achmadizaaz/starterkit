<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['code' => 'super-administrator', 'name' => 'Super Administrator', 'guard_name' => 'web'],
            ['code' => 'administrator', 'name' => 'Administrator', 'guard_name' => 'web'],
            ['code' => 'user', 'name' => 'User', 'guard_name' => 'web'],
            ['code' => 'editor', 'name' => 'Editor', 'guard_name' => 'web'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['code' => $role['code'], 'guard_name' => $role['guard_name']],
                $role
            );
        }

        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');
    }
}

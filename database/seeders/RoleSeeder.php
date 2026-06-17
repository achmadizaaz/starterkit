<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
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

        $allPermissions = Permission::pluck('name')->all();

        Role::where('code', 'super-administrator')->first()?->syncPermissions($allPermissions);
        Role::where('code', 'administrator')->first()?->syncPermissions(
            Permission::whereNotIn('name', [
                'restore-backup-database',
                'impersonate-user',
            ])->pluck('name')->all()
        );
        Role::where('code', 'editor')->first()?->syncPermissions([
            'read-dashboard',
            'access-dashboard',
            'read-user',
            'read-role',
            'read-permission',
            'read-profile',
            'update-profile',
        ]);
        Role::where('code', 'user')->first()?->syncPermissions([
            'read-dashboard',
            'access-dashboard',
            'read-profile',
            'update-profile',
        ]);

        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');
    }
}

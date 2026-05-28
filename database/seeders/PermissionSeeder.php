<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\PermissionGroup;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        $permissions = [
            'User' => [
                'read-user',
                'create-user',
                'update-user',
                'delete-user',
                'export-user',
            ],
            'Role' => [
                'read-role',
                'create-role',
                'update-role',
                'delete-role',
            ],
            'Permission' => [
                'read-permission',
                'create-permission',
                'update-permission',
                'delete-permission',
            ],
            'Dashboard' => [
                'read-dashboard',
                'access-dashboard',
            ],
            'Profile' => [
                'read-profile',
                'update-profile',
                'delete-profile',
            ],
            'Activity Log' => [
                'read-activity-log',
                'export-activity-log',
            ],
        ];

        foreach ($permissions as $groupName => $groupPermissions) {
            $group = PermissionGroup::where('name', $groupName)->first();

            if ($group) {
                foreach ($groupPermissions as $permission) {
                    $perm = Permission::where('name', $permission)
                        ->where('guard_name', 'web')
                        ->first();

                    if ($perm) {
                        $perm->update(['permission_group_id' => $group->id]);
                    } else {
                        Permission::create([
                            'id' => (string) Str::ulid(),
                            'name' => $permission,
                            'guard_name' => 'web',
                            'permission_group_id' => $group->id
                        ]);
                    }
                }
            }
        }
    }
}


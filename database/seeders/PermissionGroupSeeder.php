<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionGroup;

class PermissionGroupSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            ['name' => 'User', 'sort_at' => 10],
            ['name' => 'Role', 'sort_at' => 20],
            ['name' => 'Permission', 'sort_at' => 30],
            ['name' => 'Permission Group', 'sort_at' => 35],
            ['name' => 'Role Permission', 'sort_at' => 38],
            ['name' => 'Dashboard', 'sort_at' => 40],
            ['name' => 'Profile', 'sort_at' => 50],
            ['name' => 'Settings', 'sort_at' => 55],
            ['name' => 'Activity Log', 'sort_at' => 60],
            ['name' => 'Backup Database', 'sort_at' => 70],
            ['name' => 'System Health', 'sort_at' => 80],
            ['name' => 'Notification', 'sort_at' => 90],
            ['name' => 'Report', 'sort_at' => 100],
        ];

        foreach ($groups as $group) {
            PermissionGroup::firstOrCreate(
                ['name' => $group['name']],
                ['sort_at' => $group['sort_at']]
            );
        }
    }
}

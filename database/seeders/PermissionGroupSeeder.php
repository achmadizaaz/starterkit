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
            ['name' => 'Dashboard', 'sort_at' => 40],
            ['name' => 'Profile', 'sort_at' => 50],
            ['name' => 'Activity Log', 'sort_at' => 60],
        ];

        foreach ($groups as $group) {
            PermissionGroup::firstOrCreate(
                ['name' => $group['name']],
                ['sort_at' => $group['sort_at']]
            );
        }
    }
}

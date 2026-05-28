<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionGroupSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
        ]);

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Administrator',
            'username' => 'administrator',
            'slug' => 'admin',
            'email' => 'administrator@gmail.com',
        ]);
    }
}

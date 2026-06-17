<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

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

        $administratorPassword = env('ADMIN_PASSWORD');

        if (blank($administratorPassword)) {
            throw new RuntimeException('ADMIN_PASSWORD wajib diatur sebelum menjalankan DatabaseSeeder.');
        }

        $user = User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'administrator@gmail.com')],
            [
                'name' => 'Administrator',
                'username' => env('ADMIN_USERNAME', 'administrator'),
                'slug' => 'admin',
                'password' => Hash::make($administratorPassword),
                'email_verified_at' => now(),
                'status' => true,
            ]
        );

        $user->assignRole('Super Administrator');

        $this->call(DummyDataSeeder::class);
    }
}

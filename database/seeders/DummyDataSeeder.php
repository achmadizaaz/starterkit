<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make(env('DEMO_PASSWORD', 'password'));

        $users = [
            ['name' => 'Budi Santoso', 'username' => 'budi.santoso', 'email' => 'budi@example.com', 'role' => 'Administrator', 'status' => true],
            ['name' => 'Siti Rahma', 'username' => 'siti.rahma', 'email' => 'siti@example.com', 'role' => 'Editor', 'status' => true],
            ['name' => 'Rizky Pratama', 'username' => 'rizky.pratama', 'email' => 'rizky@example.com', 'role' => 'User', 'status' => true],
            ['name' => 'Maya Lestari', 'username' => 'maya.lestari', 'email' => 'maya@example.com', 'role' => 'User', 'status' => true],
            ['name' => 'Andi Wijaya', 'username' => 'andi.wijaya', 'email' => 'andi@example.com', 'role' => 'Editor', 'status' => false],
            ['name' => 'Dewi Anggraini', 'username' => 'dewi.anggraini', 'email' => 'dewi@example.com', 'role' => 'User', 'status' => true],
        ];

        foreach ($users as $index => $item) {
            $user = User::updateOrCreate(
                ['email' => $item['email']],
                [
                    'name' => $item['name'],
                    'username' => $item['username'],
                    'password' => $password,
                    'email_verified_at' => $index % 2 === 0 ? now() : null,
                    'status' => $item['status'],
                ]
            );

            $role = Role::where('name', $item['role'])->first();
            if ($role) {
                $user->syncRoles([$role->id]);
            }

            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'phone' => '08'.fake()->numerify('##########'),
                    'gender' => $index % 2 === 0 ? 'male' : 'female',
                    'birth_date' => now()->subYears(24 + $index)->subDays($index * 17)->toDateString(),
                    'country' => 'Indonesia',
                    'address' => 'Jl. Demo No. '.($index + 1).', Jakarta',
                    'website' => 'https://example.com/'.$item['username'],
                    'social_media' => [
                        'instagram' => 'https://instagram.com/'.$item['username'],
                        'linkedin' => 'https://linkedin.com/in/'.$item['username'],
                    ],
                ]
            );
        }
    }
}

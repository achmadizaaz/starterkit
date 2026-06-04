<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('administrator can set and clear user email verification status', function () {
    $administratorRole = Role::create([
        'code' => 'administrator',
        'name' => 'Administrator',
        'guard_name' => 'web',
    ]);
    $userRole = Role::create([
        'code' => 'user',
        'name' => 'User',
        'guard_name' => 'web',
    ]);
    $administrator = User::factory()->create([
        'email_verified_at' => now(),
        'status' => true,
    ]);
    $administrator->assignRole($administratorRole);

    $this->actingAs($administrator)
        ->post(route('user.store'), [
            'name' => 'Verified User',
            'username' => 'verified-user',
            'email' => 'verified@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'status' => '1',
            'email_verified' => '1',
            'role' => $userRole->id,
        ])
        ->assertSessionHasNoErrors();

    $user = User::where('email', 'verified@example.com')->firstOrFail();
    expect($user->email_verified_at)->not->toBeNull();

    $this->actingAs($administrator)
        ->put(route('user.update', $user->id), [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'status' => '1',
            'email_verified' => '0',
            'role' => $userRole->id,
        ])
        ->assertSessionHasNoErrors();

    expect($user->refresh()->email_verified_at)->toBeNull();
});

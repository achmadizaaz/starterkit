<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function usernameTestAdministrator(): User
{
    $role = Role::create([
        'code' => 'administrator',
        'name' => 'Administrator',
        'guard_name' => 'web',
    ]);
    $administrator = User::factory()->create([
        'email_verified_at' => now(),
        'status' => true,
    ]);
    $administrator->assignRole($role);

    return $administrator;
}

test('user detail route uses username as parameter', function () {
    $administrator = usernameTestAdministrator();
    $user = User::factory()->create(['username' => 'detail.user-name']);

    expect(route('user.show', $user->username))
        ->toEndWith('/dashboard/user/detail.user-name');

    $this->actingAs($administrator)
        ->get(route('user.show', $user->username))
        ->assertOk()
        ->assertSee($user->name);

    $this->actingAs($administrator)
        ->get('/dashboard/user/'.$user->id)
        ->assertNotFound();
});

test('username containing spaces is rejected in user management', function () {
    $administrator = usernameTestAdministrator();
    $userRole = Role::create([
        'code' => 'user',
        'name' => 'User',
        'guard_name' => 'web',
    ]);

    $this->actingAs($administrator)
        ->post(route('user.store'), [
            'name' => 'Invalid Username',
            'username' => 'invalid username',
            'email' => 'invalid-username@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'status' => '1',
            'role' => $userRole->id,
        ])
        ->assertSessionHasErrors('username');

    expect(User::where('email', 'invalid-username@example.com')->exists())->toBeFalse();
});

test('user detail redirects to the new username after username update', function () {
    $administrator = usernameTestAdministrator();
    $userRole = Role::create([
        'code' => 'user',
        'name' => 'User',
        'guard_name' => 'web',
    ]);
    $user = User::factory()->create(['username' => 'old-username']);
    $user->assignRole($userRole);

    $this->actingAs($administrator)
        ->put(route('user.update', $user->id), [
            'name' => $user->name,
            'username' => 'new-username',
            'email' => $user->email,
            'status' => '1',
            'email_verified' => '1',
            'role' => $userRole->id,
            'redirect_to' => 'detail',
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('user.show', 'new-username'));
});

test('username containing spaces is rejected during public registration', function () {
    $this->post('/register', [
        'name' => 'Invalid Registration',
        'username' => 'invalid registration',
        'email' => 'invalid-registration@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertSessionHasErrors('username');

    expect(User::where('email', 'invalid-registration@example.com')->exists())->toBeFalse();
});

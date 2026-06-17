<?php

use App\Models\Role;
use App\Models\User;
use App\Services\MfaCodeService;
use Database\Seeders\PermissionGroupSeeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function seedSecurityPermissions(): void
{
    test()->seed(PermissionGroupSeeder::class);
    test()->seed(PermissionSeeder::class);
    test()->seed(RoleSeeder::class);
}

test('user routes require explicit permission', function () {
    seedSecurityPermissions();

    $role = Role::create([
        'code' => 'limited-admin',
        'name' => 'Limited Admin',
        'guard_name' => 'web',
    ]);
    $admin = User::factory()->create(['status' => true]);
    $admin->assignRole($role);

    $this->actingAs($admin)
        ->get(route('user.index'))
        ->assertForbidden();

    $role->givePermissionTo('read-user');

    $this->actingAs($admin)
        ->get(route('user.index'))
        ->assertOk();
});

test('mfa recovery code can be used once', function () {
    $user = User::factory()->create([
        'status' => true,
        'mfa_enabled' => true,
    ]);
    $code = app(MfaCodeService::class)->generateRecoveryCodes($user, 1)[0];

    $this->withSession(['mfa:user_id' => $user->id])
        ->post(route('mfa.verify'), ['code' => $code])
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticatedAs($user);
    expect($user->refresh()->mfa_recovery_codes)->toBe([]);
});

test('super administrator can login as another verified active user and return', function () {
    seedSecurityPermissions();

    $super = User::factory()->create(['status' => true]);
    $target = User::factory()->create(['status' => true]);
    $super->assignRole('Super Administrator');
    $target->assignRole('User');

    $this->actingAs($super)
        ->post(route('impersonate.store', $target))
        ->assertRedirect(route('dashboard'));

    $this->assertAuthenticatedAs($target);
    expect(session('impersonator_id'))->toBe($super->id);

    $this->delete(route('impersonate.destroy'))
        ->assertRedirect(route('dashboard'));

    $this->assertAuthenticatedAs($super);
});

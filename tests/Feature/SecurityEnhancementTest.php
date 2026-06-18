<?php

use App\Models\Role;
use App\Models\User;
use App\Models\LoginHistory;
use App\Services\MfaCodeService;
use Database\Seeders\PermissionGroupSeeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

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

test('logout records logout time without schema error', function () {
    $user = User::factory()->create(['status' => true]);
    $history = LoginHistory::create([
        'user_id' => $user->id,
        'ip_address' => '127.0.0.1',
        'device' => 'Test Device',
        'browser' => 'Test Browser',
        'login_at' => now()->subMinute(),
    ]);

    $this->actingAs($user)
        ->post(route('logout'))
        ->assertRedirect('/');

    expect($history->refresh()->logout_at)->not->toBeNull();
    $this->assertGuest();
});

test('global search returns users for authorized account', function () {
    seedSecurityPermissions();

    $role = Role::create([
        'code' => 'user-reader',
        'name' => 'User Reader',
        'guard_name' => 'web',
    ]);
    $role->givePermissionTo('read-user');

    $actor = User::factory()->create(['status' => true]);
    $target = User::factory()->create([
        'name' => 'Global Search Target',
        'username' => 'global.target',
        'email' => 'global.target@example.com',
        'status' => true,
    ]);
    $actor->assignRole($role);

    $this->actingAs($actor)
        ->getJson(route('global-search', ['q' => 'global']))
        ->assertOk()
        ->assertJsonFragment([
            'type' => 'user',
            'title' => $target->name,
            'url' => route('user.show', $target->username),
        ]);
});

test('global search hides menu without required permission', function () {
    seedSecurityPermissions();

    $role = Role::create([
        'code' => 'profile-only',
        'name' => 'Profile Only',
        'guard_name' => 'web',
    ]);
    $actor = User::factory()->create(['status' => true]);
    $actor->assignRole($role);

    $response = $this->actingAs($actor)
        ->getJson(route('global-search', ['q' => 'backup']))
        ->assertOk();

    expect(collect($response->json('results'))->pluck('title'))->not->toContain('Backup Database');
});

test('authorized user can view and restore soft deleted user', function () {
    seedSecurityPermissions();

    $role = Role::create([
        'code' => 'user-recovery',
        'name' => 'User Recovery',
        'guard_name' => 'web',
    ]);
    $role->givePermissionTo(['read-deleted-user', 'restore-user']);

    $actor = User::factory()->create(['status' => true]);
    $target = User::factory()->create([
        'name' => 'Deleted User Target',
        'username' => 'deleted.target',
        'status' => true,
    ]);
    $actor->assignRole($role);
    $target->delete();

    $this->actingAs($actor)
        ->get(route('user.deleted.index'))
        ->assertOk()
        ->assertSee('Deleted User Target');

    $this->actingAs($actor)
        ->patch(route('user.deleted.restore', $target->id))
        ->assertRedirect()
        ->assertSessionHasNoErrors();

    expect($target->fresh())->not->toBeNull()
        ->and($target->fresh()->deleted_at)->toBeNull();
});

test('force delete requires confirmation and removes avatar', function () {
    Storage::fake('public');
    seedSecurityPermissions();

    $role = Role::create([
        'code' => 'user-purge',
        'name' => 'User Purge',
        'guard_name' => 'web',
    ]);
    $role->givePermissionTo('force-delete-user');

    $actor = User::factory()->create(['status' => true]);
    $target = User::factory()->create([
        'username' => 'purge.target',
        'avatar' => 'avatars/purge-target.jpg',
        'status' => true,
    ]);
    $actor->assignRole($role);
    Storage::disk('public')->put($target->avatar, 'avatar');
    $target->delete();

    $this->actingAs($actor)
        ->delete(route('user.deleted.force-delete', $target->id), [
            'confirmation' => 'incorrect',
        ])
        ->assertSessionHasErrors('confirmation');

    expect(User::withTrashed()->find($target->id))->not->toBeNull();
    Storage::disk('public')->assertExists($target->avatar);

    $this->actingAs($actor)
        ->delete(route('user.deleted.force-delete', $target->id), [
            'confirmation' => $target->username,
        ])
        ->assertRedirect()
        ->assertSessionHasNoErrors();

    expect(User::withTrashed()->find($target->id))->toBeNull();
    Storage::disk('public')->assertMissing($target->avatar);
});

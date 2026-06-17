<?php

use App\Models\AdminNotification;
use App\Models\DatabaseBackup;
use App\Models\Role;
use App\Models\User;
use App\Notifications\MfaCodeNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);

function operationsAdmin(): User
{
    $role = Role::create([
        'code' => 'administrator',
        'name' => 'Administrator',
        'guard_name' => 'web',
    ]);
    $admin = User::factory()->create([
        'email_verified_at' => now(),
        'status' => true,
    ]);
    $admin->assignRole($role);

    return $admin;
}

test('administrator can view system health page', function () {
    $admin = operationsAdmin();

    $this->actingAs($admin)
        ->get(route('system-health.index'))
        ->assertOk()
        ->assertSee('System Health')
        ->assertSee('Database');
});

test('administrator can create and download encrypted database backup', function () {
    $admin = operationsAdmin();

    $this->actingAs($admin)
        ->post(route('backup.store'))
        ->assertRedirect()
        ->assertSessionHasNoErrors();

    $backup = DatabaseBackup::firstOrFail();

    expect($backup->encrypted_at)->not->toBeNull();

    $this->actingAs($admin)
        ->get(route('backup.download', $backup))
        ->assertOk();
});

test('mfa enabled user is challenged after password authentication', function () {
    Notification::fake();

    $user = User::factory()->create([
        'username' => 'mfa-user',
        'email' => 'mfa-user@example.com',
        'email_verified_at' => now(),
        'status' => true,
        'mfa_enabled' => true,
    ]);

    $this->post(route('login'), [
        'login' => $user->email,
        'password' => 'password',
    ])->assertRedirect(route('mfa.challenge'));

    $this->assertGuest();
    expect(session('mfa:user_id'))->toBe($user->id);
    Notification::assertSentTo($user, MfaCodeNotification::class);
});

test('administrator can mark notification as read', function () {
    $admin = operationsAdmin();
    $notification = AdminNotification::create([
        'user_id' => $admin->id,
        'type' => 'info',
        'title' => 'Test Notification',
        'message' => 'Notifikasi untuk pengujian.',
    ]);

    $this->actingAs($admin)
        ->patch(route('notifications.read', $notification))
        ->assertRedirect();

    expect($notification->refresh()->read_at)->not->toBeNull();
});

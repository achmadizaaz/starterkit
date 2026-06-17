<?php

use App\Models\ActivityLog;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function auditLogAdministrator(): array
{
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

    return [$administrator, $userRole];
}

test('administrator can view audit log page', function () {
    [$administrator] = auditLogAdministrator();

    $this->actingAs($administrator)
        ->get(route('audit-log.index'))
        ->assertOk()
        ->assertSee('Audit Log');
});

test('user management action is written to audit log', function () {
    [$administrator, $userRole] = auditLogAdministrator();

    $this->actingAs($administrator)
        ->post(route('user.store'), [
            'name' => 'Logged User',
            'username' => 'logged-user',
            'email' => 'logged-user@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'status' => '1',
            'role' => $userRole->id,
        ])
        ->assertSessionHasNoErrors();

    expect(ActivityLog::where('activity', 'Menambahkan user logged-user')->exists())->toBeTrue();
});

test('administrator can export audit log csv', function () {
    [$administrator] = auditLogAdministrator();

    ActivityLog::create([
        'user_id' => $administrator->id,
        'activity' => 'Menguji export audit log',
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Feature Test',
    ]);

    $this->actingAs($administrator)
        ->get(route('audit-log.export'))
        ->assertOk()
        ->assertHeader('content-type', 'text/csv; charset=UTF-8');
});

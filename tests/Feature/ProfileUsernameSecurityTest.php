<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user cannot change username from profile update', function () {
    $user = User::factory()->create([
        'username' => 'original-username',
        'email_verified_at' => now(),
        'status' => true,
    ]);

    $this->actingAs($user)
        ->patch(route('profile.update'), [
            'name' => $user->name,
            'username' => 'changed-username',
            'email' => $user->email,
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('profile.show'));

    expect($user->refresh()->username)->toBe('original-username');
});

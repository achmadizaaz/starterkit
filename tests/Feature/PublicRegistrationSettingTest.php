<?php

use App\Models\AppSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('public registration can be disabled', function () {
    AppSetting::setValue('registration_enabled', '0');

    $this->get('/register')
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors('register');

    $this->post('/register', [])
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors('register');
});

test('public registration is closed outside its configured period', function () {
    AppSetting::setValue('registration_enabled', '1');
    AppSetting::setValue('registration_starts_at', now()->addDay()->toDateTimeString());

    $this->get('/register')->assertRedirect(route('login'));

    AppSetting::setValue('registration_starts_at', now()->subDays(2)->toDateTimeString());
    AppSetting::setValue('registration_ends_at', now()->subDay()->toDateTimeString());

    $this->get('/register')->assertRedirect(route('login'));
});

test('public registration is open during its configured period', function () {
    AppSetting::setValue('registration_enabled', '1');
    AppSetting::setValue('registration_starts_at', now()->subDay()->toDateTimeString());
    AppSetting::setValue('registration_ends_at', now()->addDay()->toDateTimeString());

    $this->get('/register')->assertOk();
});

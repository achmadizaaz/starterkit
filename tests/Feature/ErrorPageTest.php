<?php

use Illuminate\Support\Facades\Route;
beforeEach(function () {
    config(['app.debug' => false]);
});

test('custom 404 error page is rendered', function () {
    $this->get('/halaman-yang-tidak-tersedia')
        ->assertNotFound()
        ->assertSee('Sepertinya halaman ini sudah berpindah')
        ->assertSee('assets/css/error.css', false);
});

test('custom client error pages are rendered', function (int $status, string $title) {
    Route::get('/test-error-'.$status, fn () => abort($status));

    $this->get('/test-error-'.$status)
        ->assertStatus($status)
        ->assertSee($title);
})->with([
    [403, 'Anda tidak memiliki akses'],
    [419, 'Sesi Anda sudah kedaluwarsa'],
    [429, 'Mohon tunggu sebentar'],
]);

test('custom server error pages are rendered', function (int $status, string $title) {
    Route::get('/test-error-'.$status, function () use ($status) {
        if ($status === 500) {
            throw new \RuntimeException('Internal detail must not be displayed.');
        }

        abort($status);
    });

    $this->get('/test-error-'.$status)
        ->assertStatus($status)
        ->assertSee($title)
        ->assertDontSee('Internal detail must not be displayed.');
})->with([
    [500, 'Ada kendala di sisi kami'],
    [503, 'Layanan sedang tidak tersedia'],
]);

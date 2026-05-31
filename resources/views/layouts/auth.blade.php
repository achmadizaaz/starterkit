<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="auto">
    <head>
        <meta charset="utf-8">
        <title>@yield('title', env('APP_NAME'))</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @vite(['resources/sass/app.scss', 'resources/js/app.js'])

        <script src="{{ asset('assets/js/darkmode.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">

        @yield('head')
    </head>

    <body class="auth-body">
        <main class="auth-shell">
            @yield('content')

            <div class="auth-footer">
                {{ date('Y') }} &copy; {{ env('APP_NAME') }} - All rights reserved.
            </div>
        </main>

        <div class="auth-theme-toggle">
            <x-darkmode-button/>
        </div>

        @stack('scripts')
    </body>
</html>

<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="auto">
    @php
        $authAppName = \App\Models\AppSetting::getValue('app_name', env('APP_NAME', config('app.name', 'Starterkit')));
        $authFavicon = \App\Models\AppSetting::getValue('favicon');
        $authFooter = \App\Models\AppSetting::getValue('footer_copyright', date('Y') . ' © ' . $authAppName . ' - All rights reserved.');
    @endphp
    <head>
        <meta charset="utf-8">
        <title>@yield('title', $authAppName)</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @if($authFavicon)
            <link rel="shortcut icon" href="{{ asset('storage/' . $authFavicon) }}">
        @endif

        @vite(['resources/sass/app.scss', 'resources/js/app.js'])

        <script src="{{ asset('assets/js/darkmode.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">

        @yield('head')
    </head>

    <body class="auth-body">
        <main class="auth-shell">
            @yield('content')

            <div class="auth-footer">
                {{ $authFooter }}
            </div>
        </main>

        <div class="auth-theme-toggle">
            <x-darkmode-button/>
        </div>

        @stack('scripts')
    </body>
</html>

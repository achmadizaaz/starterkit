<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="auto">
    @php
        $errorAppName = \App\Models\AppSetting::getValue('app_name', config('app.name', 'Starterkit'));
        $errorLogo = \App\Models\AppSetting::getValue('app_logo');
        $errorFavicon = \App\Models\AppSetting::getValue('favicon');
        $errorFooter = \App\Models\AppSetting::getValue(
            'footer_copyright',
            date('Y') . ' © ' . $errorAppName . ' - All rights reserved.'
        );
    @endphp
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow">
        <title>@yield('code') | @yield('title') - {{ $errorAppName }}</title>

        @if($errorFavicon)
            <link rel="shortcut icon" href="{{ asset('storage/' . $errorFavicon) }}">
        @endif

        <script src="{{ asset('assets/js/darkmode.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('assets/css/error.css') }}">
    </head>
    <body>
        <main class="error-shell">
            <nav class="error-nav" aria-label="Navigasi halaman error">
                <a href="{{ url('/') }}" class="error-brand" aria-label="{{ $errorAppName }}">
                    @if($errorLogo)
                        <img src="{{ asset('storage/' . $errorLogo) }}" alt="">
                    @else
                        <span class="error-brand-mark" aria-hidden="true">S</span>
                    @endif
                    <span>{{ $errorAppName }}</span>
                </a>

                <button type="button" class="theme-toggle" id="errorThemeToggle" aria-label="Ubah tema">
                    <span class="theme-toggle-light" aria-hidden="true">☀</span>
                    <span class="theme-toggle-dark" aria-hidden="true">☾</span>
                </button>
            </nav>

            <section class="error-content">
                <div class="error-visual" aria-hidden="true">
                    <div class="error-code-shadow">@yield('code')</div>
                    <div class="error-symbol">@yield('symbol', '!')</div>
                    <span class="error-status-label">HTTP @yield('code')</span>
                </div>

                <div class="error-copy">
                    <span class="error-kicker">@yield('kicker', 'Terjadi Kendala')</span>
                    <h1>@yield('title')</h1>
                    <p class="error-message">@yield('message')</p>
                    <p class="error-hint">@yield('hint')</p>

                    <div class="error-actions">
                        @yield('actions')
                    </div>

                    <div class="error-reference">
                        <span>Status</span>
                        <strong>@yield('code')</strong>
                        <span class="error-reference-divider"></span>
                        <span>{{ now()->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </section>

            <footer class="error-footer">{{ $errorFooter }}</footer>
        </main>

        <script>
            document.getElementById('errorThemeToggle')?.addEventListener('click', function () {
                const root = document.documentElement;
                const nextTheme = root.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';

                root.setAttribute('data-bs-theme', nextTheme);
                localStorage.setItem('theme', nextTheme);
            });
        </script>
    </body>
</html>

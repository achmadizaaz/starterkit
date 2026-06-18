<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="auto">
@php
    $landingAppName = \App\Models\AppSetting::getValue('app_name', config('app.name', 'Starterkit'));
    $landingLogo = \App\Models\AppSetting::getValue('app_logo');
    $landingFavicon = \App\Models\AppSetting::getValue('favicon');
    $landingDescription = \App\Models\AppSetting::getValue(
        'app_description',
        'Sistem administrasi modern untuk mengelola pengguna, akses, keamanan, dan operasional aplikasi dalam satu tempat.'
    );
    $landingAddress = \App\Models\AppSetting::getValue('institution_address');
    $landingPhone = \App\Models\AppSetting::getValue('phone_number');
    $landingEmail = \App\Models\AppSetting::getValue('official_email');
    $landingWebsite = \App\Models\AppSetting::getValue('official_website');
    $landingFooter = \App\Models\AppSetting::getValue('footer_copyright', date('Y').' © '.$landingAppName.'. All rights reserved.');
    $registrationOpen = \App\Models\AppSetting::isPublicRegistrationOpen();
@endphp
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $landingDescription }}">

    <title>{{ $landingAppName }}</title>

    @if($landingFavicon)
        <link rel="shortcut icon" href="{{ asset('storage/'.$landingFavicon) }}">
    @endif

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="{{ asset('assets/js/darkmode.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">
</head>
<body class="landing-body">
    <header class="landing-header">
        <nav class="navbar navbar-expand-lg" aria-label="Navigasi utama">
            <div class="container">
                <a class="landing-brand" href="{{ url('/') }}">
                    <span class="landing-brand-mark">
                        @if($landingLogo)
                            <img src="{{ asset('storage/'.$landingLogo) }}" alt="">
                        @else
                            <i class="bi bi-command"></i>
                        @endif
                    </span>
                    <span>{{ $landingAppName }}</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#landingNavigation" aria-controls="landingNavigation" aria-expanded="false" aria-label="Buka navigasi">
                    <i class="bi bi-list"></i>
                </button>

                <div class="collapse navbar-collapse" id="landingNavigation">
                    <ul class="navbar-nav ms-auto align-items-lg-center">
                        <li class="nav-item"><a class="nav-link" href="#features">Fitur</a></li>
                        <li class="nav-item"><a class="nav-link" href="#security">Keamanan</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Kontak</a></li>
                    </ul>
                    <div class="landing-nav-actions">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn landing-btn-primary">
                                <i class="bi bi-grid-1x2"></i>
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn landing-btn-light">Masuk</a>
                            @if($registrationOpen)
                                <a href="{{ route('register') }}" class="btn landing-btn-primary">Daftar</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section class="landing-hero" aria-labelledby="landingHeroTitle">
            <img src="{{ asset('assets/images/landing-dashboard-hero.png') }}" alt="Pratinjau dashboard administrasi {{ $landingAppName }}" class="landing-hero-image">
            <div class="landing-hero-shade"></div>
            <div class="container landing-hero-content">
                <div class="landing-hero-copy">
                    <span class="landing-eyebrow">
                        <i class="bi bi-shield-check"></i>
                        Administrasi terpusat dan aman
                    </span>
                    <h1 id="landingHeroTitle">{{ $landingAppName }}</h1>
                    <p>{{ $landingDescription }}</p>
                    <div class="landing-hero-actions">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn landing-btn-primary landing-btn-lg">
                                Buka Dashboard
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn landing-btn-primary landing-btn-lg">
                                Masuk ke Sistem
                                <i class="bi bi-arrow-right"></i>
                            </a>
                            @if($registrationOpen)
                                <a href="{{ route('register') }}" class="btn landing-btn-hero-light landing-btn-lg">Buat Akun</a>
                            @endif
                        @endauth
                    </div>
                    <div class="landing-registration-status">
                        <span class="{{ $registrationOpen ? 'is-open' : 'is-closed' }}"></span>
                        Registrasi publik {{ $registrationOpen ? 'sedang dibuka' : 'sedang ditutup' }}
                    </div>
                </div>
            </div>
        </section>

        <section class="landing-trust-band" aria-label="Kapabilitas utama">
            <div class="container">
                <div class="landing-trust-grid">
                    <div><i class="bi bi-people"></i><span>Manajemen User</span></div>
                    <div><i class="bi bi-shield-lock"></i><span>Role & Permission</span></div>
                    <div><i class="bi bi-journal-check"></i><span>Audit Log</span></div>
                    <div><i class="bi bi-database-check"></i><span>Backup & Restore</span></div>
                    <div><i class="bi bi-heart-pulse"></i><span>System Health</span></div>
                </div>
            </div>
        </section>

        <section class="landing-section" id="features">
            <div class="container">
                <div class="landing-section-heading">
                    <span>Kontrol operasional</span>
                    <h2>Satu pusat kerja untuk administrasi aplikasi</h2>
                    <p>Dirancang untuk aktivitas rutin administrator: cepat dipindai, mudah diaudit, dan tetap nyaman digunakan.</p>
                </div>

                <div class="landing-feature-grid">
                    <article class="landing-feature">
                        <span class="landing-feature-icon blue"><i class="bi bi-person-gear"></i></span>
                        <h3>User Management</h3>
                        <p>Kelola profil, status, verifikasi email, role, kata sandi, soft delete, dan login as dari satu alur.</p>
                    </article>
                    <article class="landing-feature">
                        <span class="landing-feature-icon emerald"><i class="bi bi-key"></i></span>
                        <h3>Access Control</h3>
                        <p>Permission granular per tindakan dengan role yang dapat disesuaikan untuk kebutuhan setiap tim.</p>
                    </article>
                    <article class="landing-feature">
                        <span class="landing-feature-icon cyan"><i class="bi bi-activity"></i></span>
                        <h3>Operasional Sistem</h3>
                        <p>Pantau kesehatan layanan, audit aktivitas, notifikasi admin, serta backup database terenkripsi.</p>
                    </article>
                    <article class="landing-feature">
                        <span class="landing-feature-icon amber"><i class="bi bi-file-earmark-bar-graph"></i></span>
                        <h3>Laporan</h3>
                        <p>Filter laporan user dan aktivitas login/logout, lalu tampilkan dalam HTML, PDF, atau Excel.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="landing-security-section" id="security">
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-5">
                        <span class="landing-section-kicker">Security by default</span>
                        <h2>Lapisan keamanan untuk akses yang lebih terkendali</h2>
                        <p class="landing-security-copy">Setiap area penting dilindungi autentikasi, status akun aktif, dan permission yang sesuai. Aktivitas sensitif juga tercatat agar mudah ditelusuri.</p>
                    </div>
                    <div class="col-lg-7">
                        <div class="landing-security-list">
                            <div>
                                <i class="bi bi-patch-check"></i>
                                <span><strong>MFA & recovery codes</strong><small>Perlindungan login dengan OTP dan kode akses darurat sekali pakai.</small></span>
                            </div>
                            <div>
                                <i class="bi bi-fingerprint"></i>
                                <span><strong>Permission granular</strong><small>Akses dibatasi berdasarkan kemampuan aktual, bukan hanya nama role.</small></span>
                            </div>
                            <div>
                                <i class="bi bi-clock-history"></i>
                                <span><strong>Jejak aktivitas</strong><small>Audit log serta riwayat login dan logout membantu investigasi operasional.</small></span>
                            </div>
                            <div>
                                <i class="bi bi-database-lock"></i>
                                <span><strong>Backup terenkripsi</strong><small>Backup private storage dengan dry-run dan konfirmasi restore berlapis.</small></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="landing-contact-section" id="contact">
            <div class="container">
                <div class="landing-contact-inner">
                    <div>
                        <span class="landing-section-kicker">Mulai bekerja</span>
                        <h2>Akses sistem administrasi {{ $landingAppName }}</h2>
                        <p>Masuk menggunakan akun yang telah diberikan atau hubungi pengelola sistem untuk informasi akses.</p>
                        <div class="landing-contact-actions">
                            @auth
                                <a href="{{ route('dashboard') }}" class="btn landing-btn-primary landing-btn-lg">Buka Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="btn landing-btn-primary landing-btn-lg">Masuk ke Sistem</a>
                                @if($registrationOpen)
                                    <a href="{{ route('register') }}" class="btn landing-btn-light landing-btn-lg">Daftar Akun</a>
                                @endif
                            @endauth
                        </div>
                    </div>
                    @if($landingEmail || $landingPhone || $landingAddress || $landingWebsite)
                        <address class="landing-contact-details">
                            @if($landingEmail)<a href="mailto:{{ $landingEmail }}"><i class="bi bi-envelope"></i>{{ $landingEmail }}</a>@endif
                            @if($landingPhone)<a href="tel:{{ preg_replace('/\s+/', '', $landingPhone) }}"><i class="bi bi-telephone"></i>{{ $landingPhone }}</a>@endif
                            @if($landingWebsite)<a href="{{ $landingWebsite }}" target="_blank" rel="noopener"><i class="bi bi-globe"></i>{{ $landingWebsite }}</a>@endif
                            @if($landingAddress)<span><i class="bi bi-geo-alt"></i>{{ $landingAddress }}</span>@endif
                        </address>
                    @endif
                </div>
            </div>
        </section>
    </main>

    <footer class="landing-footer">
        <div class="container">
            <div class="landing-footer-inner">
                <a class="landing-brand" href="{{ url('/') }}">
                    <span class="landing-brand-mark"><i class="bi bi-command"></i></span>
                    <span>{{ $landingAppName }}</span>
                </a>
                <p>{{ $landingFooter }}</p>
                <a href="{{ route('login') }}">Portal Login <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </footer>

    <x-darkmode-button/>
</body>
</html>

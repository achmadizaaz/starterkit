@extends('layouts.auth')

@section('title','Login')

@section('content')
    @php
        $authBrandName = \App\Models\AppSetting::getValue('app_name', env('APP_NAME', config('app.name', 'Starterkit')));
        $authBrandDescription = \App\Models\AppSetting::getValue('app_description', env('APP_DESCRIPTION', 'Kelola akses dan data sistem dengan pengalaman yang bersih dan profesional.'));
    @endphp

    <div class="auth-card">
        <div class="row g-0">
            <div class="col-lg-5 d-none d-lg-block">
                <div class="auth-brand-panel">
                    <div class="auth-brand-mark"><i class="bi bi-shield-lock"></i></div>
                    <h1>{{ $authBrandName }}</h1>
                    <p>{{ $authBrandDescription }}</p>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="auth-content">
                    <span class="auth-kicker">Welcome Back</span>
                    <h2 class="auth-title">Login</h2>
                    <p class="auth-subtitle">Masuk menggunakan email atau username Anda.</p>

                    <form method="POST" action="{{ route('login') }}" class="auth-form">
                        @csrf

                        <x-auth-session-status class="alert auth-alert mb-3" :status="session('status')" />

                        @if($errors->any())
                            <div class="auth-error p-3 mb-3">
                                {{ implode(' ', $errors->all()) }}
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label" for="login">Email / Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="login" class="form-control" required autofocus autocomplete="username" placeholder="Masukkan email atau username" id="login">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan kata sandi" required autocomplete="current-password">
                                <button type="button" class="input-group-text auth-password-toggle" data-password-toggle="password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4 gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label small" for="remember">Ingat saya</label>
                            </div>
                            <a href="{{ route('password.request') }}" class="auth-link small">Lupa kata sandi?</a>
                        </div>

                        <button class="btn auth-primary-btn w-100 mb-3">
                            <i class="bi bi-box-arrow-in-right"></i>
                            Sign in
                        </button>
                    </form>

                    @if(\App\Models\AppSetting::isPublicRegistrationOpen())
                        <div class="text-center text-muted small">
                            Tidak memiliki akun? <a href="{{ route('register') }}" class="auth-link">Register</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('[data-password-toggle]').forEach(function (button) {
            button.addEventListener('click', function () {
                const input = document.getElementById(button.dataset.passwordToggle);
                const icon = button.querySelector('i');
                input.type = input.type === 'password' ? 'text' : 'password';
                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            });
        });
    </script>
@endpush

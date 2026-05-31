@extends('layouts.auth')

@section('title','Register')

@section('content')
    @php
        $authBrandName = \App\Models\AppSetting::getValue('app_name', env('APP_NAME', config('app.name', 'Starterkit')));
    @endphp

    <div class="auth-card">
        <div class="row g-0">
            <div class="col-lg-5 d-none d-lg-block">
                <div class="auth-brand-panel">
                    <div class="auth-brand-mark"><i class="bi bi-person-plus"></i></div>
                    <h1>{{ $authBrandName }}</h1>
                    <p>Buat akun baru untuk mulai mengakses dashboard dan fitur pengelolaan sistem.</p>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="auth-content">
                    <span class="auth-kicker">Create Account</span>
                    <h2 class="auth-title">Register</h2>
                    <p class="auth-subtitle">Lengkapi data berikut untuk membuat akun baru.</p>

                    <form method="POST" action="{{ route('register') }}" class="auth-form">
                        @csrf

                        @if($errors->any())
                            <div class="auth-error p-3 mb-3">{{ implode(' ', $errors->all()) }}</div>
                        @endif

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="name">Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="name" class="form-control" required autocomplete="name" placeholder="Nama lengkap" id="name" value="{{ old('name') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="username">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-at"></i></span>
                                    <input type="text" name="username" class="form-control" required autocomplete="username" placeholder="Username" id="username" value="{{ old('username') }}">
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="email">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control" required autocomplete="email" placeholder="email@domain.com" id="email" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Kata sandi" required autocomplete="new-password">
                                    <button type="button" class="input-group-text auth-password-toggle" data-password-toggle="password"><i class="bi bi-eye"></i></button>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="password_confirmation">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi kata sandi" required autocomplete="new-password">
                                    <button type="button" class="input-group-text auth-password-toggle" data-password-toggle="password_confirmation"><i class="bi bi-eye"></i></button>
                                </div>
                            </div>
                        </div>

                        <button class="btn auth-primary-btn w-100 mt-4 mb-3">
                            <i class="bi bi-person-plus"></i>
                            Register
                        </button>
                    </form>

                    <div class="text-center text-muted small">
                        Sudah punya akun? <a href="{{ route('login') }}" class="auth-link">Login</a>
                    </div>
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

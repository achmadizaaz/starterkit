@extends('layouts.auth')

@section('title','Reset Password')

@section('content')
    <div class="auth-card auth-card-narrow">
        <div class="auth-content-narrow">
            <span class="auth-kicker">New Password</span>
            <h2 class="auth-title">Reset Password</h2>
            <p class="auth-subtitle">Masukkan kata sandi baru untuk akun Anda.</p>

            <form method="POST" action="{{ route('password.store') }}" class="auth-form">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <x-auth-session-status class="alert auth-alert mb-3" :status="session('status')" />

                @if($errors->any())
                    <div class="auth-error p-3 mb-3">{{ implode(' ', $errors->all()) }}</div>
                @endif

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input id="email" class="form-control" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Kata sandi baru" required autocomplete="new-password">
                        <button type="button" class="input-group-text auth-password-toggle" data-password-toggle="password"><i class="bi bi-eye"></i></button>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi kata sandi baru" required autocomplete="new-password">
                        <button type="button" class="input-group-text auth-password-toggle" data-password-toggle="password_confirmation"><i class="bi bi-eye"></i></button>
                    </div>
                </div>

                <button type="submit" class="btn auth-primary-btn w-100">
                    <i class="bi bi-check2"></i>
                    Reset Password
                </button>
            </form>
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

@extends('layouts.auth')

@section('title','Confirm Password')

@section('content')
    <div class="auth-card auth-card-narrow">
        <div class="auth-content-narrow">
            <span class="auth-kicker">Secure Area</span>
            <h2 class="auth-title">Confirm Password</h2>
            <p class="auth-subtitle">Ini adalah area aman. Konfirmasi kata sandi Anda sebelum melanjutkan.</p>

            <form method="POST" action="{{ route('password.confirm') }}" class="auth-form">
                @csrf

                @if($errors->any())
                    <div class="auth-error p-3 mb-3">{{ implode(' ', $errors->all()) }}</div>
                @endif

                <div class="mb-4">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" autofocus>
                        <button type="button" class="input-group-text auth-password-toggle" data-password-toggle="password"><i class="bi bi-eye"></i></button>
                    </div>
                </div>

                <button class="btn auth-primary-btn w-100">
                    <i class="bi bi-shield-check"></i>
                    Confirm
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

@extends('layouts.auth')

@section('title','Forgot Password')

@section('content')
    <div class="auth-card auth-card-narrow">
        <div class="auth-content-narrow">
            <span class="auth-kicker">Password Recovery</span>
            <h2 class="auth-title">Forgot Password</h2>
            <p class="auth-subtitle">Masukkan email Anda dan kami akan mengirimkan link untuk membuat kata sandi baru.</p>

            <form method="POST" action="{{ route('password.email') }}" class="auth-form">
                @csrf

                <x-auth-session-status class="alert auth-alert mb-3" :status="session('status')" />

                @if($errors->any())
                    <div class="auth-error p-3 mb-3">{{ implode(' ', $errors->all()) }}</div>
                @endif

                <div class="mb-4">
                    <label for="email" class="form-label">Email address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" value="{{ old('email') }}" name="email" id="email" required autofocus placeholder="email@domain.com">
                    </div>
                </div>

                <button class="btn auth-primary-btn w-100 mb-3">
                    <i class="bi bi-send"></i>
                    Send Reset Link
                </button>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="auth-link small">
                        <i class="bi bi-arrow-left"></i>
                        Kembali ke Login
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('layouts.auth')

@section('title','Verifikasi MFA')

@section('content')
    @php
        $authBrandName = \App\Models\AppSetting::getValue('app_name', env('APP_NAME', config('app.name', 'Starterkit')));
    @endphp

    <div class="auth-card">
        <div class="row g-0">
            <div class="col-lg-5 d-none d-lg-block">
                <div class="auth-brand-panel">
                    <div class="auth-brand-mark"><i class="bi bi-shield-check"></i></div>
                    <h1>{{ $authBrandName }}</h1>
                    <p>Masukkan kode keamanan untuk menyelesaikan proses login.</p>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="auth-content">
                    <span class="auth-kicker">Multi-Factor Authentication</span>
                    <h2 class="auth-title">Verifikasi Login</h2>
                    <p class="auth-subtitle">Masukkan kode 6 digit dari email atau recovery code MFA Anda.</p>

                    <form method="POST" action="{{ route('mfa.verify') }}" class="auth-form">
                        @csrf
                        <x-auth-session-status class="alert auth-alert mb-3" :status="session('status')" />
                        @if($errors->any())
                            <div class="auth-error p-3 mb-3">{{ implode(' ', $errors->all()) }}</div>
                        @endif
                        <div class="mb-3">
                            <label class="form-label" for="code">Kode MFA / Recovery Code</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-key"></i></span>
                                <input type="text" maxlength="32" name="code" id="code" class="form-control" placeholder="123456 atau ABCDE-FGHIJ" required autofocus>
                            </div>
                            <div class="form-text">Recovery code hanya dapat digunakan satu kali.</div>
                        </div>
                        <button class="btn auth-primary-btn w-100 mb-3">
                            <i class="bi bi-check2-circle"></i>
                            Verifikasi
                        </button>
                    </form>

                    <form method="POST" action="{{ route('mfa.resend') }}" class="text-center">
                        @csrf
                        <button type="submit" class="btn btn-link auth-link">Kirim ulang kode</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

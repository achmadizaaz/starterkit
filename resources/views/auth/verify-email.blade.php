@extends('layouts.auth')

@section('title','Verify Email')

@section('content')
    <div class="auth-card auth-card-narrow">
        <div class="auth-content-narrow">
            <span class="auth-kicker">Email Verification</span>
            <h2 class="auth-title">Verify Email</h2>
            <p class="auth-subtitle">Terima kasih sudah mendaftar. Klik link verifikasi yang sudah kami kirim ke email Anda. Jika belum menerima email, kirim ulang link verifikasi dari halaman ini.</p>

            @if (session('status') == 'verification-link-sent')
                <div class="auth-alert p-3 mb-3">
                    Link verifikasi baru telah dikirim ke email yang Anda gunakan saat registrasi.
                </div>
            @endif

            <div class="d-grid gap-2">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button class="btn auth-primary-btn w-100">
                        <i class="bi bi-send"></i>
                        Resend Verification Email
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-box-arrow-right"></i>
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.auth')

@section('title','Forgot Password')

@section('content')

    <div class="container">
        <div class="row justify-content-center align-items-center m-auto">
            <div class="col-lg-8 col-md-10">

            <div class="card login-card shadow-lg">
                <div class="row g-0">

                    {{-- LEFT --}}
                    <div class="col-md-6 d-none d-md-flex login-left align-items-center p-4">
                        <div>
                             <h3 class="fw-bold mb-3">{{ env('APP_NAME') }}</h3>
                            <p class="opacity-75">
                                {{ env('APP_DESCRIPTION') }}
                            </p>
                        </div>
                    </div>

                    {{-- RIGHT --}}
                    <div class="col-md-6 p-4 position-relative">
                        
                        <h4 class="fw-bold mb-3 text-center">Forgot Password</h4>
                        <p class="text-muted text-center mb-4 small">
                            Masukkan email Anda dan kami akan mengirimkan link untuk membuat password baru.
                        </p>
                        <hr>
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                             <!-- Errors -->
                            @if($errors->any())
                                <div class="text-center text-danger mb-2">
                                    <small>{{ implode('', $errors->all(':message')) }}</small>
                                </div>
                            @endif

                            <!-- Email Address -->
                            <div class="mb-4">
                                <label for="email" class="form-label">Email address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" value="{{ old('email') }}" name="email" required autofocus placeholder="Masukan email anda" />
                            </div>

                             <!-- Button send reset link-->
                            <div class="flex items-center justify-end">
                                 <button class="btn btn-primary w-100 py-2 mb-3">
                                   Send Reset Link
                                </button>
                            </div>

                            <div class="text-center">
                                <a href="{{ route('login') }}" class="text-decoration-none small">
                                    ← Kembali ke Login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

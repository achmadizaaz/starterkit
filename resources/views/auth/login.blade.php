@extends('layouts.auth')

@section('title','Login')

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
                        <h4 class="fw-bold mb-2 text-center">Login</h4>
                        <p class="text-muted text-center mb-4 small">
                            Silakan masuk ke akun Anda
                        </p>
                        <hr>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                             <!-- Session Status -->
                            <x-auth-session-status class="mb-4" :status="session('status')" />
                            <!-- Errors -->
                            @if($errors->any())
                                <div class="text-center text-danger mb-3">
                                    <small>{{ implode('', $errors->all(':message')) }}</small>
                                </div>
                            @endif

                           <!-- Email / Username -->
                            <div class="mb-3">
                                <label class="form-label small" for="login">Email / Username</label>
                                <div class="input-group">
                                    <input type="text"
                                    name="login"
                                    class="form-control"
                                    required autofocus autocomplete="off" placeholder="Masukan nama pengguna" id="login">
                                    <span class="input-group-text">
                                          <i class="bi bi-person-fill"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label small" for="password">Password</label>
                                <div class="input-group">
                                    <input type="password"
                                           name="password"
                                           id="password"
                                           class="form-control"
                                           placeholder="Masukan katasandi"
                                           required>

                                    <div onclick="showPassword()" style="cursor:pointer;" class="input-group-text show_password">
                                        <i class="bi bi-lock-fill" id="icon-password" title="Tampilkan katasandi"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Captcha --}}
                            {{-- <div class="mb-3 d-flex justify-content-center">
                                <div class="g-recaptcha"
                                     data-sitekey="{{ config('services.recaptcha.site_key') }}">
                                </div>
                            </div> --}}

                            <!-- Remember -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label small" for="remember">Ingat saya</label>
                                </div>
                                <a href="{{ route('password.request') }}" class="text-decoration-none text-primary small fst-italic">
                                    Lupa katasandi?
                                </a>
                            </div>

                            <button class="btn btn-primary w-100 py-2 mb-3">
                                Sign in
                            </button>
                            {{-- <div class="d-grid">
                                <a class="btn bg-danger text-white" href="{{ route('oauth.google.redirect') }}">
                                    <i class="bi bi-google me-2 "></i> Sign in with Google
                                </a>
                            </div> --}}
                        </form>

                        <div class="text-center text-muted">Tidak memiliki akun? <a href="{{ route('register') }}" class="text-decoration-none fst-italic fw-semibold text-primary">Register</a></div>

                       
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Show / Hide Password
    function togglePassword() {
        const input = document.getElementById('password');
        input.type = input.type === 'password' ? 'text' : 'password';
    }


    function showPassword() {
        let icon_eye = document.getElementById("icon-password");
        let password = document.getElementById("password");

        if (password.type  === "password") {
            document.getElementById("icon-password").classList.remove('bi-lock-fill');
            document.getElementById("icon-password").classList.add('bi-unlock2-fill');
            document.getElementById("icon-password").setAttribute('title', 'Sembunyikan katasandi');

            // Change Type Input Password to Text
            password.type = "text";
        } else {
            document.getElementById("icon-password").classList.remove('bi-unlock2-fill');
            document.getElementById("icon-password").classList.add('bi-lock-fill');
            document.getElementById("icon-password").setAttribute('title', 'Tampilkan katasandi');
            // Change Type Input Password to Password
            password.type = "password";
        }
    }
</script>
@endpush
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
                        <h4 class="fw-bold mb-2 text-center">Register</h4>
                        <p class="text-muted text-center mb-4 small">
                            Silakan isi data pendaftaran akun
                        </p>
                        <hr>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <!-- Session Status -->
                            <x-auth-session-status class="mb-4" :status="session('status')" />
                            <!-- Errors -->
                            @if($errors->any())
                                <div class="text-center text-danger mb-3">
                                    <small>{{ implode('', $errors->all(':message')) }}</small>
                                </div>
                            @endif

                           <!-- Name -->
                            <div class="mb-3">
                                <label class="form-label small" for="name">Name</label>
                                <div class="input-group">
                                    <input type="text"
                                    name="name"
                                    class="form-control"
                                    required autocomplete="off" placeholder="Masukan nama anda" id="name">
                                </div>
                            </div>
                           <!--Username -->
                            <div class="mb-3">
                                <label class="form-label small" for="username">Username</label>
                                <div class="input-group">
                                    <input type="text"
                                    name="username"
                                    class="form-control"
                                    required autocomplete="off" placeholder="Masukan nama pengguna" id="username">
                                </div>
                            </div>
                           <!--Email -->
                            <div class="mb-3">
                                <label class="form-label small" for="email">Email</label>
                                <div class="input-group">
                                    <input type="email"
                                    name="email"
                                    class="form-control"
                                    required autocomplete="off" placeholder="Masukan email anda" id="email">
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
                                           placeholder="Masukan katasandi baru"
                                           required>

                                    <div onclick="togglePassword('password','icon-password')" style="cursor:pointer;" class="input-group-text show_password">
                                        <i class="bi bi-lock-fill" id="icon-password" title="Tampilkan katasandi"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small" for="password_confirmation">Confirm Password</label>
                                <div class="input-group">
                                    <input type="password"
                                           name="password_confirmation"
                                           id="password_confirmation"
                                           class="form-control"
                                           placeholder="Ulangi katasandi baru"
                                           required>

                                    <div style="cursor:pointer;" class="input-group-text show_password">
                                        <i class="bi bi-lock-fill" id="icon-password-confirmation"
   onclick="togglePassword('password_confirmation','icon-password-confirmation')" title="Tampilkan katasandi"></i>
                                    </div>
                                </div>
                                <small id="password_message" class="d-block mt-1"></small>
                            </div>

                            <button class="btn btn-primary w-100 py-2 mb-3">
                                Register
                            </button>
                            
                        </form>

                        <div class="text-center mb-4">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="text-decoration-none text-primary fst-italic">
                                Login
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
    <script>

        function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace('bi-lock-fill', 'bi-unlock2-fill');
                icon.title = "Sembunyikan katasandi";
            } else {
                input.type = "password";
                icon.classList.replace('bi-unlock2-fill', 'bi-lock-fill');
                icon.title = "Tampilkan katasandi";
            }
        }

        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');
        const message = document.getElementById('password_message');

        function checkPasswordMatch() {

            if (confirmPassword.value.length === 0) {
                message.innerHTML = "";
                return;
            }

            if (password.value === confirmPassword.value) {
                message.innerHTML = "✔ Password cocok";
                message.classList.remove('text-danger');
                message.classList.add('text-success');
                confirmPassword.classList.remove('is-invalid');
                confirmPassword.classList.add('is-valid');
            } else {
                message.innerHTML = "✖ Password tidak sesuai";
                message.classList.remove('text-success');
                message.classList.add('text-danger');
                confirmPassword.classList.remove('is-valid');
                confirmPassword.classList.add('is-invalid');
            }
        }

        password.addEventListener('keyup', checkPasswordMatch);
        confirmPassword.addEventListener('keyup', checkPasswordMatch);
    </script>
@endpush
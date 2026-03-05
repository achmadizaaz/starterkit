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
                        
                        <h4 class="fw-bold mb-3 text-center">Reset Password</h4>
                        <p class="text-muted text-center mb-4 small">
                            Masukkan katasandi baru untuk akun Anda.
                        </p>
                        <hr>
                        <form method="POST" action="{{ route('password.store') }}">
                            @csrf

                            
                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <!-- Session Status -->
                            <x-auth-session-status class="mb-4" :status="session('status')" />
                            <!-- Errors -->
                            @if($errors->any())
                                <div class="text-center text-danger mb-3">
                                    <small>{{ implode('', $errors->all(':message')) }}</small>
                                </div>
                            @endif

                            <!-- Email Address -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" class="form-control" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
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

                            <!-- Confirm Password -->
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
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                                    Reset Password
                                </button>
                            </div>
                        </form>
                        

                        <div class="text-center mt-4 text-muted small">
                           {{ date('Y') }}  © {{ env('APP_NAME') }} - All rights reserved.
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
</script>
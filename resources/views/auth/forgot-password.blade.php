@extends('layouts.guest')

@section('title', 'Forgot Password')

@push('head')
<style>
    html,
body {
  height: 100%;
}

.form-signin {
  max-width: 720px;
  padding: 1.2rem;
}

.form-signin .form-floating:focus-within {
  z-index: 2;
}

.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}

.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}

    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .b-example-divider {
      width: 100%;
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }

    .btn-bd-primary {
      --bd-violet-bg: #712cf9;
      --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

      --bs-btn-font-weight: 600;
      --bs-btn-color: var(--bs-white);
      --bs-btn-bg: var(--bd-violet-bg);
      --bs-btn-border-color: var(--bd-violet-bg);
      --bs-btn-hover-color: var(--bs-white);
      --bs-btn-hover-bg: #6528e0;
      --bs-btn-hover-border-color: #6528e0;
      --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
      --bs-btn-active-color: var(--bs-btn-hover-color);
      --bs-btn-active-bg: #5a23c8;
      --bs-btn-active-border-color: #5a23c8;
    }

    .bd-mode-toggle {
      z-index: 1500;
    }

    .bd-mode-toggle .dropdown-menu .active .bi {
      display: block !important;
    }
  </style>
@endpush

@section('content')
<main class="form-signin w-100 m-auto card rounded-4">
    <form action="{{ route('password.email') }}" method="post">
        @csrf
        <div class="row">
            <div class="d-flex justify-content-between align-items-center p-2 mb-4 border-bottom">
                <div class="text-start col-8">
                    <h5 class="fw-bold">Forgot Password</h5>
                    <span class="small text-secondary fst-italic">
                        Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
                    </span>
                </div>
                <div class="text-center d-block auth-logo col-4">
                    <img src="{{ asset('assets/images/laravel.png') }}" alt="{{ config('app.name', 'Laravel') }}" height="28"> <span class="logo-txt">{{ config('app.name', 'Laravel') }}</span>
                </div>
            </div>
            <x-alert/>
            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">Email<span class="text-danger fst-italic">*</span></label>
                <input type="email" class="form-control" name="email" required placeholder="Enter your email account" autofocus>
            </div>

            <!-- Button Reset Password -->
            <div class="mb-3">
                <button class="btn btn-primary waves-effect waves-light" type="submit">
                    <i class="bi bi-link-45deg"></i> Send Reset Link
                </button>
            </div>

        </div>
    </form>
</main>

@endsection

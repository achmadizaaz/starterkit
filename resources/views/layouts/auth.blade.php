<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="auto">
    <head>
        <meta charset="utf-8" />
        <title>@yield('title', env('APP_NAME'))</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])

        <!-- Scripts Dark Mode Bootstrap -->
        <script src="{{ asset('assets/js/darkmode.js') }}"></script>

        @yield('head')

        <style>
            :root {
                --primary: #6610f2;
                --bg-light: #f4f6f9;
                --bg-dark: #121212;
                --card-dark: #1e1e1e;
            }

            body {
                font-family: 'Poppins', sans-serif;
                min-height: 100vh;
                font-size: 14px;
                /* background: linear-gradient(135deg, #6610f2, #4c0ecf); */
            }

            body.dark-mode {
                background: #0d0d0d;
            }

            .login-card {
                border-radius: 14px;
                overflow: hidden;
            }

            .login-left {
                background: linear-gradient(180deg, #6610f2, #4c0ecf);
                color: #fff;
            }

            body.dark-mode .login-left {
                background: #1b1b1b;
            }

            body.dark-mode .card {
                background: var(--card-dark);
                color: #eaeaea;
            }

            body.dark-mode .form-control {
                background: #2a2a2a;
                color: #fff;
                border-color: #444;
            }

            .password-toggle {
                cursor: pointer;
            }
        </style>
    </head>


    <!-- Top Bar Start -->
    <body class="min-vh-100 d-flex align-items-center justify-content-center">
        @yield('content')

        <!-- Button Mode Color / Dark Mode -->
        <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
            <button class="btn btn-sm btn-primary  dropdown-toggle d-flex align-items-center gap-1" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (dark)">
                <span class="bi my-1 theme-icon-active">
                    <i class="theme-change-icon"></i>
                </span>
            <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
                    <i class="bi bi-sun-fill me-2"></i>
                    Light
                    <span class="bi ms-auto d-none" width="1em" height="1em"><a href="#check2"><i class="bi bi-check"></i></a></span>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="dark" aria-pressed="true">
                    <i class="bi bi-moon-stars-fill me-2"></i>
                    Dark
                    <span class="bi ms-auto d-none" width="1em" height="1em"><a href="#check2"><i class="bi bi-check"></i></a></span>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="auto" aria-pressed="false">
                    <i class="bi bi-circle-half me-2"></i>
                    Auto
                    <span class="bi ms-auto d-none" width="1em" height="1em"><a href="#check2"><i class="bi bi-check"></i></a></span>
                </button>
            </li>
            </ul>
        </div>
        <!-- END Button Mode Color / Dark Mode -->

        @stack('scripts')
    </body>
    <!--end body-->
</html>
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


         <div class="text-center mt-4 text-muted small">
            {{ date('Y') }}  © {{ env('APP_NAME') }} - All rights reserved.
        </div>

        <x-darkmode-button/>

        @stack('scripts')
    </body>
    <!--end body-->
</html>
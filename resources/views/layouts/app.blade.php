<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="auto">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
        <!-- Scripts Dark Mode Bootstrap -->
        <script src="{{ asset('assets/js/darkmode.js') }}"></script>


        @yield('head')


    </head>
    <body>
        @include('layouts.sidebar')
        @include('layouts.topbar')

        @yield('content')

        <x-darkmode-button/>

        <script>

            function toggleSidebar(){

            if(window.innerWidth < 992){
                document.getElementById('sidebar').classList.add('mobile-show')
                }else{
                    document.body.classList.toggle('sidebar-collapsed')
                    }
                }
                function closeSidebar(){
                document.getElementById('sidebar').classList.remove('mobile-show')
            }

        </script>

        @stack('scripts')
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="auto">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel') )</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
        
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/darkmode.css') }}">
        <!-- Scripts Dark Mode Bootstrap -->
        <script src="{{ asset('assets/js/darkmode.js') }}"></script>

        @yield('head')
        <!-- Select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    </head>
    <body>
        @include('layouts.sidebar')
        @include('layouts.topbar')

        <div class="main">
            
            <!-- Title -->
            @yield('title-page')
            <!-- Status & Errors -->
            <x-status/>
            <x-alert/>
            <!-- Content -->
            @yield('content')
        </div>



        <x-darkmode-button/>

        <div class="sidebar-backdrop" id="sidebarBackdrop" onclick="closeSidebar()"></div>

        <script>

            function toggleSidebar(){

            if(window.innerWidth < 992){
                document.getElementById('sidebar').classList.add('mobile-show')
                document.getElementById('sidebarBackdrop').classList.add('show')
                }else{
                    document.body.classList.toggle('sidebar-collapsed')
                    }
                }
                function closeSidebar(){
                document.getElementById('sidebar').classList.remove('mobile-show')
                document.getElementById('sidebarBackdrop').classList.remove('show')
            }

        </script>

        @stack('scripts')
    </body>
</html>

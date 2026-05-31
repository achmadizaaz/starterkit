<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="auto">
    @php
        $layoutAppName = \App\Models\AppSetting::getValue('app_name', config('app.name', 'Laravel'));
        $layoutFavicon = \App\Models\AppSetting::getValue('favicon');
    @endphp
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', $layoutAppName)</title>

        @if($layoutFavicon)
            <link rel="shortcut icon" href="{{ asset('storage/' . $layoutFavicon) }}">
        @endif

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
        <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
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

            function initSelect2(scope = document) {
                if (!window.jQuery || !jQuery.fn.select2) {
                    return;
                }

                jQuery(scope).find('select.js-select2').each(function () {
                    const select = jQuery(this);

                    if (select.hasClass('select2-hidden-accessible')) {
                        return;
                    }

                    const dropdownParentSelector = select.data('dropdown-parent');
                    const options = {
                        theme: 'bootstrap-5',
                        width: '100%',
                        placeholder: select.data('placeholder') || select.attr('placeholder') || 'Pilih data',
                        allowClear: select.data('allow-clear') !== false
                    };

                    if (dropdownParentSelector && jQuery(dropdownParentSelector).length) {
                        options.dropdownParent = jQuery(dropdownParentSelector);
                    }

                    select.select2(options);
                });
            }

            document.addEventListener('DOMContentLoaded', function () {
                initSelect2(document);
            });

            document.addEventListener('shown.bs.modal', function (event) {
                initSelect2(event.target);
            });

        </script>

        @stack('scripts')
    </body>
</html>

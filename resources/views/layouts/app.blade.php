<!DOCTYPE html>

<html :class="{ 'theme-dark': !dark }" x-data="data()" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
     
    
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="Kunaisoft">
    <title>{{ $title }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  
    <link rel="stylesheet" href="{{ asset('css/tailwind.output.css') }}" />
    {{-- <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script> --}}
    <script src="{{asset('js/alpine.min.js')}}" defer></script>
    <script src="{{asset('js/init-alpine.js')}}" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" />
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script> --}}
    {{-- <script src="{{asset('js/charts-lines.js')}}" defer></script>
    <script src="{{asset('js/charts-pie.js')}}" defer></script>
    <script src="{{asset('js/charts-bars.js')}}" defer></script> --}}

    @livewireStyles
    {{-- <script>
        import Turbolinks from 'turbolinks';
        Turbolinks.start()
    </script> --}}

    <!-- Scripts -->
    {{-- <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.6.0/dist/alpine.js" defer></script> --}}
</head>

<body {{ Session::has('notification') ? 'data-notification' : '' }} 
data-notification-type="{{  Session::has('notification') ? Session::get('notification')['alert_type'] : '' }}" 
data-notification-message="{{ Session::has('notification') ? json_encode(Session::get('notification')['message']) : '' }}" >

    <noscript>You need to enable JavaScript to run this app.</noscript>
    <div  class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
        
        @include('layouts.menu')
        @include('layouts.mobile-menu')

        <div class="flex flex-col flex-1 w-full">
            @include('layouts.navigation-dropdown')
            <main id="app" class="h-full overflow-y-auto">
                {{ $slot }}
            </main>
        </div>


        @stack('modals')
        <script src="{{ mix('js/app.js') }}" ></script>
        <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places"></script>
        <script src="{{ asset('js/main.js') }}"></script> 
        @livewireScripts
        @yield('scripts')
        @stack('scripts')

    </div>
</body>

</html>

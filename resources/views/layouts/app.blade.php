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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  
    <link rel="stylesheet" href="{{ asset('css/tailwind.output.css') }}" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- <script src="{{asset('js/focus-trap.js')}}" defer></script>   -->
    <script src="{{asset('js/init-alpine.js')}}" defer></script>
    
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons.png') }}">
   
 

    <style>
		[x-cloak] {
			display: none;
		}
	</style>
    
    @livewireStyles
   
</head>

<body {{ Session::has('notification') ? 'data-notification' : '' }} 
data-notification-type="{{  Session::has('notification') ? Session::get('notification')['alert_type'] : '' }}" 
data-notification-message="{{ Session::has('notification') ? json_encode(Session::get('notification')['message']) : '' }}" >

    <noscript>You need to enable JavaScript to run this app.</noscript>
    <div
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="flex h-screen bg-gray-50 dark:bg-gray-900"
        :class="{ 'overflow-hidden': isSideMenuOpen }">
        
        @include('layouts.menu')
        @include('layouts.mobile-menu')

        <div class="flex flex-col flex-1 w-full">
            @include('layouts.navigation-dropdown')
            <main id="app" class="h-full overflow-y-auto" >
                {{ $slot }}
            </main>
        </div>

        @stack('modals')
        <script src="{{ mix('js/app.js') }}" ></script>
        <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&language=es&libraries=places"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{ asset('js/main.js') }}"></script> 
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
       
        @livewireScripts
        @yield('scripts')
        @stack('scripts')

    </div>
</body>

</html>

<x-app-layout title="Dashboard">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            
        </h2>

        @if(auth()->user()->hasRole('Client'))  
            @include('dashboard.client')
        @else
            @include('dashboard.admin')
        @endif
    </div>

</x-app-layout>
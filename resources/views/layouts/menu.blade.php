<!-- Desktop sidebar -->
<aside class="z-20 flex-shrink-0 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block">
    @if(auth()->user()->hasRole('Cliente') or auth()->user()->hasRole('ClienteLimitado'))  
        @include('layouts._menus')
    @else
        @include('layouts.admin_menu')
    @endif
</aside>

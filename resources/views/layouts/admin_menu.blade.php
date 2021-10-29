<div class="py-4 text-gray-500 dark:text-gray-400">
    <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
        {{ config('app.name') }}
    </a>
    <ul class="mt-6">

      <li class="relative px-6 py-3">
            {!! request()->routeIs('dashboard') ? '<span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a data-turbolinks-action="replace" class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100" href="{{route('dashboard')}}">
                <svg class="w-5 h-5" ari a-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
             
                <span class="ml-4">  Dashboard </span>
            </a>
        </li>
        
        <li class="relative px-6 py-3">
            {!! request()->routeIs('admin.applications.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a data-turbolinks-action="replace" class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="{{route('admin.applications.index')}}">
                <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20" />
                </svg>
                <span class="ml-4">Solicitudes</span>
            </a>
        </li>


         {{-- Factoring --}}

         <li class="relative px-6 py-3">
            
          <button
            class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
            @click="toggleFinancingMenu"  aria-haspopup="true" 
          >
            <span class="inline-flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {!! request()->is('factoring/*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}

              <span class="ml-4"> Financiamiento </span>
            </span>
          </button>
          <template x-if="isFinancingMenuOpen">
            <ul
              x-transition:enter="transition-all ease-in-out duration-300"
              x-transition:enter-start="opacity-25 max-h-0"
              x-transition:enter-end="opacity-100 max-h-xl"
              x-transition:leave="transition-all ease-in-out duration-300"
              x-transition:leave-start="opacity-100 max-h-xl"
              x-transition:leave-end="opacity-0 max-h-0"
              class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
              aria-label="submenu"
            >
              @can('factoring.quote.index')
                <li
                class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200
                {!! request()->is('factoring/quote') ? 'italic font-black' : '' !!} "
                >
                  <a class="w-full " href="{{ route('factoring.quote')}}">
                    Cotizar  
                  </a>
                </li>
              @endcan
              @can('factoring.applications.index')
                <li
                  class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                  {!! (request()->is('factoring/applications') || request()->is('factoring/applications/*')) ? 'italic font-black' : '' !!} "
                >
                  <a class="w-full"  href="{{route('factoring.applications.index')}}" >
                    Solicitudes
                  </a>
                </li>
              @endcan
              @can('factoring.disbursements.index')
              <li
                class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200
                {!! request()->is('factoring/disbursements') ? 'italic font-black' : '' !!} "
                >
                  <a class="w-full" href="{{ route('factoring.disbursements.index')}}">
                    Desembolsos
                  </a>
                </li>
              @endcan
            </ul>
          </template>
        </li>

        {{-- End Factoring --}}
        
        <li class="relative px-6 py-3">
            <button
              class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              @click="togglePagesMenu"
              aria-haspopup="true"
            >
              <span class="inline-flex items-center">
                <svg
                  class="w-5 h-5"
                  aria-hidden="true"
                  fill="none"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"
                  ></path>
                </svg>
                <span class="ml-4">Mantenimiento</span>
              </span>
              <svg
                class="w-4 h-4"
                aria-hidden="true"
                fill="currentColor"
                viewBox="0 0 20 20"
              >
                <path
                  fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clip-rule="evenodd"
                ></path>
              </svg>
            </button>
            <template x-if="isPagesMenuOpen">
              <ul
                x-transition:enter="transition-all ease-in-out duration-300"
                x-transition:enter-start="opacity-25 max-h-0"
                x-transition:enter-end="opacity-100 max-h-xl"
                x-transition:leave="transition-all ease-in-out duration-300"
                x-transition:leave-start="opacity-100 max-h-xl"
                x-transition:leave-end="opacity-0 max-h-0"
                class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                aria-label="submenu"
              >
                @can('warehouses.index')
                  <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                  {!! request()->routeIs('admin.currencies.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
                  <a class="w-full" href="{{route('admin.warehouses.index')}}">Almacenes</a>
                </li>
                @endcan

                {{-- @can('warehouses.index')
                <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                {!! request()->routeIs('admin.category_service.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
                <a class="w-full" href="{{route('admin.category_service.index')}}">Categorias Servicios</a>
                </li>
                @endcan --}}

                @can('trans_companies.index')
                  <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                  {!! request()->routeIs('admin.currencies.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
                  <a class="w-full" href="{{route('admin.trans_companies.index')}}">Compañias de transporte</a>
                </li>
                @endcan

                @can('suppl_cond_sales.index')
                <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                {!! request()->routeIs('admin.currencies.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
                <a class="w-full" href="{{route('admin.suppl_cond_sales.index')}}">Condicion de Venta del Proveedor</a>
              </li>
              @endcan
              
                @can('currencies.index')
                  <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                  {!! request()->routeIs('admin.currencies.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
                  <a class="w-full" href="{{route('admin.currencies.index')}}">Monedas</a>
                </li>
                @endcan

               
              @can('services.index')
                <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                  {!! request()->routeIs('admin.services.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
                  <a class="w-full" href="{{route('admin.services.index')}}">Servicios</a>
                </li>
              @endcan
                
              </ul>
            </template>
          </li>
          @can('custom_agents.index')
          <li class="relative px-6 py-3">
          {!! request()->routeIs('custom-agents.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="{{route('custom-agents.index')}}">
             
              <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
              </svg>
         
              <span class="ml-4">Agente de Aduanas</span>
            </a>
          </li>
         @endcan

          @can('clients.index')
            <li class="relative px-6 py-3">
            {!! request()->routeIs('admin.clients.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
              <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="{{route('admin.clients.index')}}">
               
                <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="ml-4">Clientes</span>
              </a>
            </li>
          @endcan

          @can('users.index')
            <li class="relative px-6 py-3">
              {!! request()->routeIs('admin.users.*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
              <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="{{route('admin.users.index')}}">
                
                  <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                  </svg>
                  <span class="ml-4">Usuarios</span>
              </a>
            </li>
          @endcan
    </ul>
</div>

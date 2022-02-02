<div class="py-4 text-gray-500 dark:text-gray-400">
    <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
        {{ config('app.name') }}
    </a>
    <ul class="mt-6">
        <li class="relative px-6 py-3">
            {!! request()->routeIs('dashboard') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-1000 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <a data-turbolinks-action="replace" class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100" href="{{route('dashboard')}}">
                <svg class="w-5 h-5" ari a-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
             
                <span class="ml-4"> Panel </span>
            </a>
        </li>
        

        <li class="relative px-6 py-3">
            {!! request()->is('applications') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-1000 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}
            <button
              class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-blue-1300 focus:outline-none dark:hover:text-gray-200"
              @click="togglePagesMenu"
              aria-haspopup="true"
            >
              <span class="inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20" />
                  </svg>
                <span class="ml-4"> Importaciones</span>
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
                <li
                class="px-2 py-1 transition-colors duration-150 hover:text-blue-1300 dark:hover:text-gray-200 
                {!! request()->is('applications') || request()->is('applications/*')  ? 'italic font-black' : '' !!} "
                >
                <a class="w-full" href="{{ route('applications.index')}}">
                    Solicitudes
                </a>
                </li>
                {{-- <li
                  class="px-2 py-1 transition-colors duration-150 hover:text-blue-1300 dark:hover:text-gray-200"
                >
                  <a class="w-full"  href="{{route('services.show')}}" > Gestion de Servicios</a>
                </li> --}}
                <li
                  class="px-2 py-1 transition-colors duration-150 hover:text-blue-1300 dark:hover:text-gray-200
                  {!! request()->is('supplier') || request()->is('supplier/*')  ? 'italic font-black' : '' !!}"
                >
                  <a class="w-full" href="{{ route('supplier.index')}}">
                    Proveedores
                  </a>
                </li>
                <li
                class="px-2 py-1 transition-colors duration-150 hover:text-blue-1300 dark:hover:text-gray-200"
              >
                <a class="w-full" href="{{ route('custom-agents.index')}}">
                  Agente de Aduanas
                </a>
              </li>
              </ul>
            </template>
          </li>

          {{-- Factoring --}}

          <li class="relative px-6 py-3">
            
            <button
              class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-blue-1300 focus:outline-none dark:hover:text-gray-200"
              @click="toggleFinancingMenu"  aria-haspopup="true" 
            >
              <span class="inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  {!! request()->is('factoring/*') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-1000 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : '' !!}

                <span class="ml-4"> Pago Importaciones </span>
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
                  class="px-2 py-1 transition-colors duration-150 hover:text-blue-1300 dark:hover:text-gray-200
                  {!! request()->is('factoring/quote')  ? 'italic font-black' : '' !!} "
                  >
                    <a class="w-full " href="{{ route('factoring.quote')}}">
                      Panel  
                    </a>
                  </li>
                @endcan
                @can('factoring.applications.index')
                  <li
                    class="px-2 py-1 transition-colors duration-150 hover:text-blue-1300 dark:hover:text-gray-200
                    {!! request()->is('factoring/applications') || request()->is('factoring/applications/*') ? 'italic font-black' : '' !!} "
                  >
                    <a class="w-full"  href="{{route('factoring.applications.index')}}" >
                      Solicitudes
                    </a>
                  </li>
                @endcan
                @can('factoring.disbursements.index')
                <li
                  class="px-2 py-1 transition-colors duration-150 hover:text-blue-1300 dark:hover:text-gray-200
                  {!! request()->is('factoring/disbursements') || request()->is('factoring/disbursements/*') ? 'italic font-black' : '' !!} "
                  >
                    <a class="w-full" href="{{ route('factoring.disbursements.index')}}">
                      Abonos
                    </a>
                  </li>
                @endcan
              </ul>
            </template>
          </li>




    </ul>
</div>

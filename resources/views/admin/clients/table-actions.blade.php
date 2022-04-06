<div class="flex space-x-1 justify-around">
    <div class="flex items-center space-x-4 text-sm">
        <a  href="{{ route($route.'show', [$id]) }}" 
            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-1400 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
            aria-label="Show">
           
            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                viewBox="0 0 20 20">

                  <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                 
                  <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                
            </svg>
        </a>

        <a  href="{{ route($route.'edit', [$id]) }}"
                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-gray-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                aria-label="Edit">
            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                    </path>
            </svg>
        </a>

    </div>

    @if ($company->user->credentialStores()->where('provider_name', 'SII')->first())
                                              
        @can('client.show')
            <a  href="#" 
                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray btn-sync"
                data-type="Ventas"
                data-remote="{{ route('admin.factoring.ventas.detalle').'?client_id='.$company->user->id.'&month=12'}}" 
                title="Sincorinzar ultimos 12 meses del Sii"
                aria-label="Edit">
                                  
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </a>

            <a  href="#" 
                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-300 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray btn-sync"
                data-type="Compras"
                data-remote="{{ route('admin.factoring.compras.detalle').'?client_id='.$company->user->id.'&month=12'}}" 
                title="Sincorinzar ultimos 12 meses del Sii compras"
                aria-label="Edit">
                                  
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2h2m3-4H9a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-1m-1 4l-3 3m0 0l-3-3m3 3V3" />
                </svg>
            </a>
        @endcan

    @endif

</div>

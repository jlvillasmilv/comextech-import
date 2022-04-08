<div class="container grid px-6 mx-auto">
    <h2 class="mt-5 text-2xl font-semibold text-gray-700 dark:text-gray-200">
       Solicitudes
     </h2>

     <div class="flex justify-between items-end mb-1">
        <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
            Lista de Solicitudes
        </h4>
        <a href="{{ route('applications.create') }}"
            class="flex px-2 py-2 m-2  text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-1300 border border-transparent rounded-lg active:bg-blue-1300 hover:bg-blue-1200 focus:outline-none focus:shadow-outline-blue"
            title="Nueva Solicitud">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
            <span> Solicitud </span>
        </a>
    </div>

  <div class="flex flex-wrap ">
      
       <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
            <div class="relative w-full max-w-xl mr-6 focus-within:text-blue-500 ">
                 <div class="absolute inset-y-0 flex items-center pl-2">
                     <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                         <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                     </svg>
                 </div>
                 
                <x-input class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-blue-300 focus:outline-none focus:shadow-outline-blue form-input"
                   placeholder="Busqueda"
                    aria-label="Search"
                    wire:model.debounce.300ms="search" 
                />
                
             </div>
       </div>
      
   </div>

   <div class="w-full overflow-hidden rounded-lg shadow-xs  mb-8">
       <div class="w-full overflow-x-auto">
           <table class="w-full whitespace-no-wrap" id="table">
                <thead
                    class="text-xs text-center font-semibold tracking-wide text-white uppercase border-b dark:border-gray-700 bg-blue-1300 dark:text-gray-400 dark:bg-gray-800">
                    <tr>
                        <th class="px-4 py-3"
                         title="Numero de solicitud / Fecha registro">
                            @include('components.table.sort', ['field' => 'code', 'label' => 'Nro/Fecha'])
                        </th>
                        <th class="px-4 py-3"
                         title="Servicios Seleccionados">
                         SERVICIOS 
                        </th>
                        <th class="px-4 py-3"
                         title="Monto Total Operacion / Pago Proveedor">
                         M. TOTAL / PROVEEDOR
                        </th>
                        <th class="px-4 py-3">ETD/ETA</th>
                        <th class="px-4 py-3">Estatus </th>
                        <th class="px-4 py-3">Proveedor </th> 
                        <th class="px-4 py-3">&nbsp; </th> 
                    </tr>
                </thead>
               <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                   @forelse($datas as $application)
                   <tr class="text-gray-700 dark:text-gray-400 text-center"
                    wire:loading.class.delay="opacity-50"
                    id="{{ $application->id }}">
                       <td class="px-2 pb-2 text-center tex-sm border-b-2 border-gray-400">
                           <div class="flex justify-center items-center">
                               <span class="iconify h-9 w-9" data-icon="{{ $application->typeTransport->icon }}"></span>
                           </div>
           
                           <p class="font-semibold text-md"> {{ $application->code }} </p>

                           <p class="text-gray-600 dark:text-gray-400 text-sm">
                               {{ date('d-m-y', strtotime($application->created_at)) }}
                           </p>
                       </td>
                       <td class="px-2 py-2  text-sm border-b-2 border-gray-400">
                            
                        <div class="flex justify-center items-start mt-1">
                            <span 
                              class="iconify h-5 w-5 {{ in_array('ICS01', (array)explode(",", $application->services_code)) ? 'text-blue-1400' : '' }} "
                              data-icon="vs:p-square"></span>
                        </div>
                        <div class="flex justify-center items-start mt-1">
                            <span class="iconify h-5 w-5 text-red {{ in_array('ICS03', (array)explode(",", $application->services_code)) ? 'text-blue-1400' : '' }} "
                             data-icon="vs:t-square"></span>
                        </div>
                        <div class="flex justify-center items-start mt-1">
                            <span class="iconify h-5 w-5 text-bg-red-300 {{ in_array('ICS04', (array)explode(",", $application->services_code)) ? 'text-blue-1400' : '' }}"
                             data-icon="vs:a-square"></span>
                        </div>
                           
                       </td>
                       <td class="px-2 py-2  text-sm border-b-2 border-gray-400">
                           <strong> 
                                {{ number_format($application->tco, ($application->currencyTco->code == 'CLP' ? 0 : 2) , ',', '.') }}
                                {{ $application->currencyTco->code }}
                           </strong>
                           <br>
                           <strong> 
                                {{ number_format($application->amount, ($application->currency->code == 'CLP' ? 0 : 2) , ',', '.') }}
                                {{ $application->currency->code }}
                            </strong>
                       </td>
                       <td class="px-2 py-2  text-sm border-b-2 border-gray-400">
                           @if (isset($application->transport->id))
                                {{ date('d-m-y', strtotime($application->transport->estimated_date)) }}
                                <br>
                                {{ is_null($application->transport->eta) ? '' : date('d-m-y', strtotime($application->transport->eta)) }}
                           @endif
                            
                       </td>
                       <td class="px-2 text-sm w-32 border-b-2 border-gray-400">
                           {{-- Status application --}}
                           @include('client.applications.status')
                       </td>
                       <td class="px-4 py-3 border-b-2 border-gray-400">
                           <p class="font-semibold  text-md">
                               {{ $application->supplier->name }}
                           </p>
                       </td>
                       <td class="py-3 border-b-2 border-gray-400">
                            @include('livewire.client.application.actions')
                       </td>
                   </tr>
               @empty
                   <tr>
                       <td class="px-4 py-3 border-b-2 border-gray-400" colspan="6">
                           <div class="flex justify-center items-center">
                                <span class="font-medium py-4 text-cool-gray-400 text-xl">Sin solicitudes</span> 
                           </div>
                        </td>
                   </tr>
               @endforelse

            </tbody>
           </table>
       </div>
       <div class="sm:flex my-3 justify-between">
            <div class="w-full md:w-1/2 px-3">
                <select wire:model="perPage" class="flex w-1/2 pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-blue-300 focus:outline-none focus:shadow-outline-blue form-select ">
                @foreach($paginationOptions as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
            </div>
            {{ $datas->withQueryString()->links() }}
       </div>
       
        @include('client.applications.modal')
   </div>
</div>

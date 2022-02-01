<x-app-layout title="Solicitudes">

    <div class="container grid px-6 mx-auto">
        <h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Servicios Solicitado
        </h2>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Lista de Solicitudes
            </h4>
            <a   href="{{ route('applications.create')}}" class="flex  px-2 py-2 m-2  text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-1300 border border-transparent rounded-lg active:bg-blue-1300 hover:bg-blue-1200 focus:outline-none focus:shadow-outline-blue" title="Nueva Solicitud">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>   
                <span> Solicitud </span>
            </a>
        </div>
      
        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table id="table" class="table-auto md:w-full whitespace-no-wrap">
                    <thead class="">
                        <tr
                            class="text-xs text-center font-semibold tracking-wide text-white  uppercase border-b dark:border-gray-700 bg-blue-1300 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3"> Nro/Fecha </th>
                            <th class="px-4 py-3"> Total Operacion </th>
                            <th class="px-4 py-3"> Pago Proveedor </th>
                            <th class="px-4 py-3"> Estatus </th>
                            <th class="px-4 py-3"> Proveedor </th> 
                            <th class="px-4 py-3"> &nbsp; </th> 
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @forelse($data as $application)
                        <tr id="{{$application->id}}" class="text-gray-700 dark:text-gray-400 text-center">
                            <td class="px-2 py-2 text-center ">
                                <div>
                                    <p class="font-semibold"> {{$application->code}} </p>
                                     
                                    <p class="tex-sm  text-gray-600 dark:text-gray-400 ">
                                         {{ date('d-m-y', strtotime($application->created_at)) }}
                                    </p>
                                </div>
                            </td>
                            <td class="px-2 py-2  text-sm">
                                <ol>
                                    <li class=" dark:text-gray-400 py-1">  <strong> {{ $application->currencyTco->code }} {{ $application->currencyTco->symbol }} {{number_format($application->tco,0,",",".") }}</strong>   </li>
                                    {{-- <li class=" dark:text-gray-400 py-1">  <strong> Intereses : </strong>  MM $ 25.345 </li>
                                    <li class=" dark:text-gray-400 py-1">  <strong> Comision : </strong> MM $ 25.345 </li> --}}
                                </ol>
                            </td>
                            <td class="px-2 py-2  text-sm">
                                <ol>
                                    <li class=" dark:text-gray-400 py-1">  <strong> {{ $application->currency->code }} {{ $application->currency->symbol }} {{number_format($application->amount,0,",",".") }}</strong>
                                   </li>
                                </ol>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <span class="px-2 py-1 font-semibold leading-tight {{$application->status->status_color}}  rounded-full dark:text-white dark:bg-green-600">
                                    {{$application->status->name}}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-semibold  text-md">
                                    {{$application->supplier->name}}
                                </p>
                            </td>  
                            <td class=" py-3" >
                                <div class="flex flex-nowrap">
                                 <a  
                                href="{{ route('applications.show', \Crypt::encryptString($application->id)) }}" 
                                    class="px-1 py-2  text-sm font-medium leading-5 text-blue-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                    aria-label="Edit">
                                   
                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                        viewBox="0 0 20 20">

                                          <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                         
                                          <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        
                                    </svg>
                                </a>
                                @if($application->status->client_modify)
                                <a  
                                href="{{ route('applications.edit', \Crypt::encryptString($application->id)) }}" 
                                    class=" px-1 py-2 text-sm font-medium leading-5 text-green-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                    aria-label="Edit">
                                   
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                      </svg>
                                </a>
                                @endif
                                @if($application->status->modify )
                               
                                    <button
                                        data-id="{{base64_encode($application->id)}}"
                                        data-msg="Desea actualizar el costo de la solicitud {{$application->code}} al tipo de cambio vigente"
                                        data-remote="{{route('application.importUpdateCost')}}"
                                        class="px-1 py-2 text-sm font-medium leading-5 text-gray-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray btn-sync-app">

                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>

                                    </button>  

                                @endif

                                @if($application->status->name == 'Borrador')
                               
                                    <button
                                        data-id="{{\Crypt::encryptString($application->id)}}"
                                        data-remote="{{route('applications.destroy', \Crypt::encryptString($application->id))}}"
                                        class="px-1 py-2 text-sm font-medium leading-5 text-red-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray btn-delete" aria-label="Delete">
                                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>  

                                @endif

                                @if($application->status->client_modify)
                                
                                    <button
                                        title="Pagar Solicitud {{$application->code}}"
                                        data-id="{{base64_encode($application->id)}}"
                                        data-msg="¿Desea Pagar solicitud {{$application->code}}?"
                                        data-remote="{{route('application.generate.order')}}"
                                        class="px-1 py-2 text-sm font-medium leading-5 text-green-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray btn-sync-app" aria-label="Delete">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>  

                                @endif

                               
                               
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="10">No entries found.</td>
                            </tr>
                        @endforelse
                        
                    </tbody>
                </table>
                {{ $data->links() }}
            </div>
            
        </div>
    </div>
    
</x-app-layout>
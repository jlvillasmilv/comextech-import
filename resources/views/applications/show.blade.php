<x-app-layout title="Detalle Registro">
	<div class="container grid px-6 mx-auto">
        <h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{route('applications.index')}}">Solicitudes</a>  
        </h2>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Detalle Solicitud  #   {{str_pad($application->id, 6, '0', STR_PAD_LEFT) }}
            </h4>
           
        </div>
       
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">

                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400 font-bold mb-2">Status:</span>
                    <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">{{$application->status->name}} </p>
                </label>

               
                <div class="px-2">
                    <div class="flex mb-4">
                        <div class="w-1/2 mr-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Monto de la operación:</label>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                {{ $application->currency->code }} {{ $application->currency->symbol }} {{number_format($application->amount,0,",",".") }} 
                            </p>
                        </div>
                        <div class="w-1/2 ml-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" >Condicion de Venta del Proveedor</label>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                {{ $application->condition }} 
                            </p>
                        </div>
                    </div>
                </div>

                <div class="px-2">
                    <div class="flex mb-4">
                        <div class="w-1/2 mr-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Fecha Solicitud:</label>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                {{ date('d-m-Y', strtotime($application->created_at)) }}
                            </p>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Detalle Solicitud 
            </h4>
        </div>

        @include('admin.applications.services')

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                             class="text-xs font-semibold tracking-wide text-left text-white  uppercase border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Servicio </th>
                            <th class="px-4 py-3">MO </th>
                            <th class="px-4 py-3">Monto </th>
                            
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @forelse($application->details as $detail)
                        <tr class="text-gray-700 dark:text-gray-400">
                            
                            <td class="px-4 py-3 text-sm">
                                <p class="font-semibold">{{ $detail->service->name }}</p>
                            </td>
                            <td class="px-4 py-3 text-xs">
                                <div class="flex items-center text-sm">                                 
                                    {{ $detail->currency->code }}  {{ $detail->currency->symbol }}   {{number_format($detail->amount,0,",",".") }}
                                </div>
                                
                            </td>
                          
                            <td class="px-4 py-3 text-sm">
                                {{ $detail->currency2->code }}  {{ $detail->currency2->symbol }}  {{number_format($detail->amount2,0,",",".") }}
                            </td>
                            
                        </tr>
     
                        @empty
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm" colspan="5">No entries found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
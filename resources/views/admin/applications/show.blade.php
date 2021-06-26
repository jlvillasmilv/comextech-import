<x-app-layout title="Detalle Registro">
	<div class="container grid px-6 mx-auto">
        <h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{route('admin.applications.index')}}">Solicitudes</a>  
        </h2>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Detalle Solicitud  #   {{str_pad($data->id, 6, '0', STR_PAD_LEFT) }}
            </h4>
           
        </div>
       
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">

                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400 font-bold mb-2">Status:</span>
                    <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">{{$data->status->name}} </p>
                </label>

                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400 font-bold mb-2">Cliente:</span>
                    <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                        {{$data->user->company->tax_id}} {{$data->user->company->name}} 
                    </p>
                </label>

                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400 font-bold mb-2 dark:text-gray-300">Descripccion:</span>
                    <p class="text-grey-dark mb-2 text-sm dark:text-gray-300 dark:text-gray-300">
                        {{$data->description}} 
                    </p>
                </label>
                <div class="px-2">
                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400 font-bold mb-2 dark:text-gray-300">Monto de la operación:</span>
                        <p class="text-grey-dark mb-2 text-sm dark:text-gray-300 dark:text-gray-300">
                            {{ $data->currency->code }} {{ $data->currency->symbol }} {{number_format($data->amount,0,",",".") }} 
                        </p>
                    </label>
                </div>

                <div class="px-2">
                    <div class="flex mb-4">
                        <div class="w-1/2 mr-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Adelanto</label>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                {{ $data->fee1 }} %
                            </p>
                        </div>
                        <div class="w-1/2 ml-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" >Saldo</label>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                {{ $data->fee2 }} %
                            </p>
                        </div>
                    </div>
                </div>

                <div class="px-2">
                    <div class="flex mb-4">
                        <div class="w-1/2 mr-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Fecha Solicitud:</label>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                {{ date('d-m-Y', strtotime($data->created_at)) }}
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

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Servicio </th>
                            <th class="px-4 py-3">MO </th>
                            <th class="px-4 py-3">Monto </th>
                            
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @forelse($data->details as $detail)
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
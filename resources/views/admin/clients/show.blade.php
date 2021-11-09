<x-app-layout title="Detalle Registro">
	<div class="container grid px-6 mx-auto">
        <h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{route('admin.clients.index')}}">Clientes</a>  
        </h2>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Detalle Registro 
            </h4>
           
        </div>
       
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">

        	<table class="w-full whitespace-no-wrap">
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <tr class="text-gray-700 dark:text-gray-400" >
                            <th class="px-4 py-3">
                               Usuario
                            </th>
                            <td class="px-4 py-3">
                                 <div class="flex items-center text-sm">
                                    
                                    <div>
                                        <p class="font-semibold">{{ $data->user->name }}</p>
                                    </div>
                                </div>
                            </td>
                        </tr> 

                        <tr class="text-gray-700 dark:text-gray-400">
                            <th class="px-4 py-3">
                               Nro. identificación tributaria
                            </th>
                            <td class="px-4 py-3">
                                {{ $data->tax_id }}
                            </td>
                        </tr>

                    	<tr class="text-gray-700 dark:text-gray-400" >
                            <th class="px-4 py-3">
                               Nombre
                            </th>
                            <td class="px-4 py-3">
                                 <div class="flex items-center text-sm">
                                    
                                    <div>
                                        <p class="font-semibold">{{ $data->name }}</p>
                                    </div>
                                </div>
                            </td>
                        </tr> 
                         <tr class="text-gray-700 dark:text-gray-400">
                            <th class="px-4 py-3">
                               Email
                            </th>
                            <td class="px-4 py-3">
                                {{ $data->email }}
                            </td>
                        </tr>
                        <tr class="text-gray-700 dark:text-gray-400">
                            <th class="px-4 py-3">
                               Telefono
                            </th>
                            <td class="px-4 py-3">
                                {{ $data->phone }}
                            </td>
                        </tr>

                        <tr class="text-gray-700 dark:text-gray-400">
                            <th class="px-4 py-3">
                               Nombre reresentante
                            </th>
                            <td class="px-4 py-3">
                                {{ $data->contact_name }}
                            </td>
                        </tr>

                        <tr class="text-gray-700 dark:text-gray-400">
                            <th class="px-4 py-3">
                               Telefono reresentante
                            </th>
                            <td class="px-4 py-3">
                                {{ $data->contact_telf }}
                            </td>
                        </tr>
                       

                        <tr class="text-gray-700 dark:text-gray-400">
                            <th class="px-4 py-3">
                               Pais
                            </th>
                            <td class="px-4 py-3">
                                ({{ $data->country->code }}) {{ $data->country->name }}
                            </td>
                        </tr> 
                      
                        <tr class="text-gray-700 dark:text-gray-400">
                            <th class="px-4 py-3">
                               Fecha de registro
                            </th>
                            <td class="px-4 py-3">
                                {{ date('d-m-Y', strtotime($data->created_at)) }}
                            </td>
                        </tr> 

                            

                    </tbody>
                </table>
            </div>
        </div>

        <hr>

        <div class="flex justify-between items-end mt-2">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Direcciones
            </h4>
        </div>

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
    
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs text-center font-semibold tracking-wide text-left text-white border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Pais</th>
                            <th class="px-4 py-3">Cod. Postal</th>
                            <th class="px-4 py-3">Localidad </th>
                            <th class="px-4 py-3">Lugar </th>
                            <th class="px-4 py-3">Direccion</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @forelse($data->address as $address)
                        <tr class="text-gray-700 dark:text-gray-400 text-xs text-center">
                            <td class="px-2 py-3 text-center">
                                {{ $address->country->name}}
                            </td>
                            <td class="px-2 py-3 text-center">
                                {{ $address->postal_code}}
                            </td>
                            <td class="px-2 py-3 text-center">
                                {{ $address->locality}}
                            </td>
                            <td class="px-2 py-3 text-center">
                                {{ $address->place}}
                            </td>
                            <td class="px-2 py-3 text-center">
                                {{ $address->address}}
                            </td>
                        </tr>
                            
                        @empty
                        <tr class="text-gray-700 dark:text-gray-400 text-xs text-center">
                            <td colspan="5" class="px-2 py-3 text-center">
                                Sin datos
                            </td>
                        </tr>
                            
                        @endforelse     
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
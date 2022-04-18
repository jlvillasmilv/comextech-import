<x-app-layout title="Detalle Categoria">
	<div class="container grid px-6 mx-auto">
        <h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{route('admin.warehouses.index')}}">Almacenes</a>  
        </h2>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Detalle Registro 
            </h4>
           
        </div>
	

    <div class="w-full overflow-hidden rounded-lg ring-1 ring-black ring-opacity-5">
        <div class="w-full overflow-x-auto">

        	<table class="w-full whitespace-nowrap">
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    	<tr class="text-gray-700 dark:text-gray-400" >
                            <th class="px-4 py-3">
                               Nombre
                            </th>
                            <td class="px-4 py-3">
                                {{ $warehouse->name }}
                            </td>
                        </tr>
                        <tr class="text-gray-700 dark:text-gray-400">
                            <th class="px-4 py-3">
                                Codigo postal
                            </th>
                            <td class="px-4 py-3">
                                {{ $warehouse->postal_code }}
                            </td>
                        </tr>
                        <tr class="text-gray-700 dark:text-gray-400">
                            <th class="px-4 py-3">
                                Telefono
                            </th>
                            <td class="px-4 py-3">
                                {{ $warehouse->phone_number }}
                            </td>
                        </tr>
                        <tr class="text-gray-700 dark:text-gray-400">
                            <th class="px-4 py-3">
                                Dirección
                            </th>
                            <td class="px-4 py-3">
                                {{ $warehouse->address }}
                            </td>
                        </tr>
                      
                         

                    </tbody>
                </table>
        </div>
    </div>
    </div>
</x-app-layout>
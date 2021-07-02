<x-app-layout title="Detalle Categoria">
	<div class="container grid px-6 mx-auto">
        <h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{route('admin.trans_companies.index')}}">Transporte</a>  
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
                               Nombre
                            </th>
                            <td class="px-4 py-3">
                                {{ $data->name }}
                            </td>
                        </tr>
                        <tr class="text-gray-700 dark:text-gray-400">
                            <th class="px-4 py-3">
                                Descripción
                            </th>
                            <td class="px-4 py-3">
                                {{ $data->description }}
                            </td>
                        </tr>
                        <tr class="text-gray-700 dark:text-gray-400">
                            <th class="px-4 py-3">
                                Pagina web
                            </th>
                            <td class="px-4 py-3">
                                {{ $data->url }}
                            </td>
                        </tr>

                    </tbody>
                </table>
        </div>
    </div>
    </div>
</x-app-layout>
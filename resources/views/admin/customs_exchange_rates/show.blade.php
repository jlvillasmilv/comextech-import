<x-app-layout title="Detalle Registro">
	<div class="container grid px-6 mx-auto">
		<h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Detalle Registro
        </h2>
	

    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">

        	<table class="w-full whitespace-no-wrap">
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <tr class="text-gray-700 dark:text-gray-400">
                            <th class="px-4 py-3">
                               Categoria
                            </th>
                            <td class="px-4 py-3">
                                {{ $data->category->name }}
                            </td>
                        </tr>
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

                    </tbody>
                </table>
        </div>
    </div>
    </div>
</x-app-layout>
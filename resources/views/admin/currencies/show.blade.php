<x-app-layout title="Detalle Registro">
	<div class="container grid px-6 mx-auto">
		<h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Detalle Registro
        </h2>
	

    <div class="w-full overflow-hidden rounded-lg ring-1 ring-black ring-opacity-5">
        <div class="w-full overflow-x-auto">

        	<table class="w-full whitespace-nowrap">
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
                               Codigo
                            </th>
                            <td class="px-4 py-3">
                                {{ $data->code }}
                            </td>
                        </tr>
                      
                        <tr class="text-gray-700 dark:text-gray-400">
                            <th class="px-4 py-3">
                               Símbolo
                            </th>
                            <td class="px-4 py-3">
                                {{ $data->symbol }}
                            </td>
                        </tr>               

                    </tbody>
                </table>
        </div>
    </div>
    </div>
</x-app-layout>
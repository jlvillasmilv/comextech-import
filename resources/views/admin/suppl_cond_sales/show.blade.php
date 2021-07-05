<x-app-layout title="Detalle Categoria">
	<div class="container grid px-6 mx-auto">
        <h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{route('admin.suppl_cond_sales.index')}}">Condicion de Venta del Proveedor</a>  
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
                                Fecha de registro
                            </th>
                            <td class="px-4 py-3">
                                {{ date('d-m-Y', strtotime($data->created_at)) }}
                            </td>
                        </tr>
                        <tr class="text-gray-700 dark:text-gray-400">
                            <th class="px-4 py-3">
                                Categorias
                            </th>
                           <td class="px-4 py-3">
                                @forelse($data->services as $category)
                                <p class=" py-2">
                                <span
                                    class="px-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    {{ $category->name }}
                                </span>
                                 </p>
                                @empty
                                @endforelse
                            </td>
                        </tr> 

                    </tbody>
                </table>
        </div>
    </div>
    </div>
</x-app-layout>
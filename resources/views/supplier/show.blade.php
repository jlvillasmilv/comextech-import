<x-app-layout title="Detalle Registro">
	<div class="container grid px-6 mx-auto">
            <h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
                <a href="{{route('supplier.index')}}">Proveedores</a>  
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
                                    <div>
                                        <p class="font-semibold">{{ $supplier->name }}</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                         <tr class="text-gray-700 dark:text-gray-400">
                            <th class="px-4 py-3">
                                Dirección                         
                            </th>
                            <td class="px-4 py-3">
                                {{ $supplier->address }}
                            </td>
                        </tr>

                        <tr class="text-gray-700 dark:text-gray-400">
                            <th class="px-4 py-3">
                               Banco
                            </th>
                            <td class="px-4 py-3">
                                {{ $supplier->bank }}
                            </td>
                        </tr>

                        <tr class="text-gray-700 dark:text-gray-400">
                            <th class="px-4 py-3">
                               ISIN
                            </th>
                            <td class="px-4 py-3">
                                {{ $supplier->isin }}
                            </td>
                        </tr>

                        <tr class="text-gray-700 dark:text-gray-400">
                            <th class="px-4 py-3">
                               IBAN
                            </th>
                            <td class="px-4 py-3">
                                {{ $supplier->iban }}
                            </td>
                        </tr>

                        <tr class="text-gray-700 dark:text-gray-400">
                            <th class="px-4 py-3">
                               Telefono
                            </th>
                            <td class="px-4 py-3">
                                {{ $supplier->iban }}
                            </td>
                        </tr>

                        <tr class="text-gray-700 dark:text-gray-400">
                            <th class="px-4 py-3">
                               Email
                            </th>
                            <td class="px-4 py-3">
                                {{ $supplier->email }}
                            </td>
                        </tr>
                      
                        <tr class="text-gray-700 dark:text-gray-400">
                            <th class="px-4 py-3">
                               Fecha de registro
                            </th>
                            <td class="px-4 py-3">
                                {{ date('d-m-Y', strtotime($supplier->created_at)) }}
                            </td>
                        </tr> 

                           

                    </tbody>
                </table>
        </div>
    </div>
    </div>
</x-app-layout>
<x-app-layout title="Detalle Registro">
	<div class="container grid px-6 mx-auto">
		<h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Detalle Registro 
        </h2>
	

    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">

        	<table class="w-full whitespace-no-wrap">
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    	<tr class="text-gray-700 dark:text-gray-400" >
                            <th class="px-4 py-3">
                               Nombre
                            </th>
                            <td class="px-4 py-3">
                                 <div class="flex items-center text-sm">
                                    <!-- Avatar with inset shadow -->
                                    <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                        <img class="object-cover w-full h-full rounded-full"
                                            src="{{$data->profile_photo_url }}" alt="{{ $data->name }}" aria-hidden="true"
                                            alt="" loading="lazy" />

                                        <div class="absolute inset-0 rounded-full shadow-inner"
                                            aria-hidden="true"></div>
                                    </div>
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
                               Fecha de registro
                            </th>
                            <td class="px-4 py-3">
                                {{ date('d-m-Y', strtotime($data->created_at)) }}
                            </td>
                        </tr> 

                         <tr class="text-gray-700 dark:text-gray-400">
                            <th class="px-4 py-3">
                                Roles
                            </th>
                            <td class="px-4 py-3">
                                @foreach($data->getRoleNames() as $id => $roles)
                                    <span class="label label-info label-many">{{ $roles }}</span>
                                @endforeach
                            </td>
                        </tr>            

                    </tbody>
                </table>
        </div>
    </div>
    </div>
</x-app-layout>
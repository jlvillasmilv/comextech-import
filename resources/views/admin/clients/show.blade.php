<x-app-layout title="Detalle Registro">
	<div class="container grid px-6 mx-auto">

        <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-4">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                <a href="{{route('admin.clients.index')}}">Clientes</a>  
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Detalle Registro.
                </p>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                    Usuarios
                    </dt>
                    <div class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        @forelse ($data->users as $user)
                            <p class="font-semibold">{{ $user->name }}</p>
                        @empty
                            
                        @endforelse
                    
                    </div>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                    Nro. identificación tributaria
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $data->tax_id }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                    Nombre
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $data->name }}
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                    Correo electrónico
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $data->email }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                    Teléfono
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $data->phone }}
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                    Representado por
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $data->contact_name }}
                    </dd>
                </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                    Telefono representante
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $data->contact_telf }}
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                    Pais
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    ({{ $data->country->code }}) {{ $data->country->name }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                    Fecha de registro
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ date('d-m-Y', strtotime($data->created_at)) }}
                    </dd>
                </div>
                </dl>
            </div>
        </div>
       
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        

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
                            class="text-xs text-center font-semibold tracking-wide text-left text-white border-b dark:border-gray-700 bg-blue-1300 dark:text-gray-400 dark:bg-gray-800">
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
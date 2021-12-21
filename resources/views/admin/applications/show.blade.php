<x-app-layout title="Detalle Registro">
	<div class="container grid px-6 mx-auto">
        <h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{route('admin.applications.index')}}">Solicitudes</a>  
        </h2>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Detalle Solicitud  #   {{ $application->code }}
            </h4>
           
        </div>
       
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">

                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400 font-bold mb-2">Status:</span>
                    <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">{{$application->status->name}} </p>
                </label>

                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400 font-bold mb-2">Cliente:</span>
                    <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                        {{$application->user->company->tax_id}} {{$application->user->company->name}} 
                    </p>
                </label>
               
                <div class="px-2">
                    <div class="flex mb-4">
                        <div class="w-1/2 mr-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Monto de la operación:</label>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                {{ $application->currency->code }} {{ $application->currency->symbol }} {{number_format($application->amount,0,",",".") }} 
                            </p>
                        </div>
                        <div class="w-1/2 ml-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" >Condicion de Venta del Proveedor</label>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                {{ $application->condition }} 
                            </p>
                        </div>
                    </div>
                </div>

                <div class="px-2">
                    <div class="flex mb-4">
                        <div class="w-1/2 mr-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Fecha Solicitud:</label>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                {{ date('d-m-Y', strtotime($application->created_at)) }}
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

        @include('admin.applications.services')
        @include('admin.applications.show_summary')

    </div>
</x-app-layout>
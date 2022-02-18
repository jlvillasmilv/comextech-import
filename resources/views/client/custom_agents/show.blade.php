<x-app-layout title="Formulario de registro">
	<div class="container grid px-6 mx-auto">
		<h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{route('custom-agents.index')}}">Agentes de Aduanas</a>  
        </h2>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Detalle Agente de Aduana
            </h4>
           
        </div>

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        
			<div class="px-2">
				<div class="flex mb-4">
					<div class="w-1/2 mr-1">
						<label class="block text-sm my-3">
							<span class="text-gray-700 dark:text-gray-400">RUT</span>
                            <p class="font-semibold">{{$data->rut}}</p>
							
						</label>
					</div>
					<div class="w-1/2 ml-1">

                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400">Nombre</span>
                            <p class="font-semibold">{{$data->name}}</p>
                        </label>
						
					</div>
				</div>
			</div>


            <div class="px-2">
				<div class="flex mb-4">
					<div class="w-1/2 mr-1">
                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400">Persona de contacto</span>

                            <p class=" text-gray-600 dark:text-gray-400">
                                {{$data->contact_person}}
                            </p>

                        </label>
					</div>
					<div class="w-1/2 ml-1">

                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400">Tarifa Base</span>
                            <p class=" text-gray-600 dark:text-gray-400">
                                {{$data->rate}}
                            </p>
                           
                        </label>
						
					</div>
				</div>
			</div>

            <div class="px-2">
				<div class="flex mb-4">
					<div class="w-1/2 mr-1">
                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400">Banco para depósitos</span>
                            <p class=" text-gray-600 dark:text-gray-400">
                                {{$data->bank}}
                            </p>
                           
                        </label>
					</div>
					<div class="w-1/2 ml-1">

                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400">Número de cuenta corriente</span>
                            <p class=" text-gray-600 dark:text-gray-400">
                                {{$data->account_number}}
                            </p>
                        </label>
						
					</div>
				</div>
			</div>

			<div class="px-2 mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    Status
                </span>
                <div class="mt-2">
                    <label class="inline-flex items-center text-gray-600 dark:text-gray-400">
                        <p class="font-semibold">{{($data->status==true)? "Activo" : "Inactivo" }}</p>
                    </label>
                   
                </div>
            </div>
	</div>
</x-app-layout>
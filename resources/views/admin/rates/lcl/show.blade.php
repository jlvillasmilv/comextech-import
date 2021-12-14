<x-app-layout title="Detalle Categoria">
	<div class="container grid px-6 mx-auto">
        <h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{route('admin.rates.lcl.index')}}">Tarifa FCL</a>  
        </h2>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Detalle Registro 
            </h4>
           
        </div>
	
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">

            <label class="block text-sm my-3">
				<div class="px-2" id="add_to">
					<div class="flex mb-4">
						<div class="w-2/4 mr-1 sm:w-full ">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Origen:</label>
							{{$data->from}}
						</div>
					   
						<div class="w-2/4 ml-1 sm:w-full ">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Destino:</label>
							{{$data->to}}
							
						</div>

					</div>
				</div>
			  
			</label>

			<label class="block text-sm my-3">
				<div class="px-2" id="add_to">
					<div class="flex mb-4">
						<div class="w-1/4 mr-1 sm:w-full ">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">VIA:</label>
							{{$data->via}}
						</div>
					   
						<div class="w-1/4 ml-1 sm:w-full ">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Transist time:</label>
							{{$data->t_time}}
						</div>

						<div class="w-1/4 ml-1 sm:w-full">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Moneda:</label>

							{{$data->currency}}
							
						</div>

					</div>
				</div>
			  
			</label>

			<label class="block text-sm my-3">
				<div class="px-2" id="add_to">
					<div class="flex mb-4">
						<div class="w-2/4 mr-1 sm:w-full ">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Fecha Origen:</label>

                            {{ date("d-m-Y", strtotime($data->valid_from)) }}

						</div>
					   
						<div class="w-2/4 ml-1 sm:w-full ">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Fecha:</label>

                            {{ date("d-m-Y", strtotime($data->valid_to)) }}
							
						</div>

					</div>
				</div>
			  
			</label>


			<label class="block text-sm my-3">
				<div class="px-2" id="add_to">
					<div class="flex mb-4">
						<div class="w-auto mr-1 sm:w-full">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">20:</label>
                          
                            {{number_format($data->c20,0,",",".") }}
						</div>
					   
						<div class="w-auto ml-1 sm:w-full">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">40:</label>
                            {{number_format($data->c40,0,",",".") }}
						
							
						</div>

						<div class="w-auto ml-1 sm:w-full">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">40HC:</label>

                            {{number_format($data->c40HC,0,",",".") }}
							
							
						</div>

						<div class="w-auto ml-1 sm:w-full">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">40NOR:</label>
                            {{number_format($data->c40NOR,0,",",".") }}
							
						</div>

						<div class="w-auto ml-1 sm:w-full">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Ot Gastos</label>
                            {{number_format($data->oth_exp,0,",",".") }}
							
						</div>


					</div>
				</div>
			  
			</label>

			<div class="mt-4 ml-2 text-sm">
                <span class="text-gray-700 dark:text-gray-400 ">
                    Status
                </span>
                <div class="mt-2">
                    <label class="inline-flex items-center text-gray-600 dark:text-gray-400">
                        <span class="ml-2">{{ $data->status ? "Activo" : "Inactivo"}}</span>
                    </label>
                </div>
            </div>


        </div>
    </div>
    </div>
</x-app-layout>
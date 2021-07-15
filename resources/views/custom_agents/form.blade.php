<x-app-layout title="Formulario de registro">
	<div class="container grid px-6 mx-auto">
		<h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{route('custom-agents.index')}}">Agentes de Aduanas</a>  
        </h2>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Registro Agente de Aduana
            </h4>
           
        </div>

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        
            <form class="form-horizontal" role="form" method="POST" action="{{ isset($data) ? route('custom-agents.update', base64_encode($data->id)) : route('custom-agents.store') }}" >
                @csrf
                 @if(isset($data))
		           @method('PUT')
		        @endif

			<div class="px-2">
				<div class="flex mb-4">
					<div class="w-1/2 mr-1">
						<label class="block text-sm my-3">
							<span class="text-gray-700 dark:text-gray-400">RUT</span>
							<input class="{{ $errors->has('rut') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Número de identificación fiscal" / name="rut" value="{{ old('rut', isset($data) ? $data->rut : '') }}" max="25" required="">
							@if($errors->has('rut'))
									 <span class="text-xs text-red-600 dark:text-red-400">
										{{ $errors->first('rut') }}
									</span>
								@endif
						</label>
					</div>
					<div class="w-1/2 ml-1">

                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400">Nombre</span>
                            <input class="{{ $errors->has('name') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Nombre del Agente de aduana" / name="name" value="{{ old('name', isset($data) ? $data->name : '') }}" max="100" required="">
                            @if($errors->has('name'))
                                     <span class="text-xs text-red-600 dark:text-red-400">
                                        {{ $errors->first('name') }}
                                    </span>
                                @endif
                        </label>
						
					</div>
				</div>
			</div>


            <div class="px-2">
				<div class="flex mb-4">
					<div class="w-1/2 mr-1">
                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400">Persona de contacto</span>
                            <input class="{{ $errors->has('contact_person') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Nombre Persona de contacto" / name="contact_person" value="{{ old('contact_person', isset($data) ? $data->contact_person : '') }}" max="50">
                            @if($errors->has('contact_person'))
                                     <span class="text-xs text-red-600 dark:text-red-400">
                                        {{ $errors->first('contact_person') }}
                                    </span>
                                @endif
                        </label>
					</div>
					<div class="w-1/2 ml-1">

                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400">Tarifa Base</span>
                            <input type="number" class="{{ $errors->has('rate') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Tarifa Base" name="rate" value="{{ old('name', isset($data) ? $data->rate : 0) }}"  required="">
                            @if($errors->has('rate'))
                                     <span class="text-xs text-red-600 dark:text-red-400">
                                        {{ $errors->first('rate') }}
                                    </span>
                                @endif
                        </label>
						
					</div>
				</div>
			</div>

            <div class="px-2">
				<div class="flex mb-4">
					<div class="w-1/2 mr-1">
                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400">Banco para depósitos</span>
                            <input class="{{ $errors->has('bank') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Nombre Banco para depósitos" name="bank" value="{{ old('bank', isset($data) ? $data->bank : '') }}" max="100">
                            @if($errors->has('bank'))
                                     <span class="text-xs text-red-600 dark:text-red-400">
                                        {{ $errors->first('bank') }}
                                    </span>
                                @endif
                        </label>
					</div>
					<div class="w-1/2 ml-1">

                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400">Número de cuenta corriente</span>
                            <input class="{{ $errors->has('account_number') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Número de cuenta corriente" name="account_number" value="{{ old('name', isset($data) ? $data->account_number : '') }}"  required="">
                            @if($errors->has('account_number'))
                                     <span class="text-xs text-red-600 dark:text-red-400">
                                        {{ $errors->first('account_number') }}
                                    </span>
                                @endif
                        </label>
						
					</div>
				</div>
			</div>

			<div class="mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    Status
                </span>
                <div class="mt-2">
                    <label class="inline-flex items-center text-gray-600 dark:text-gray-400">
                        <input type="radio" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="status" value=true
						{{isset($data) ? ($data->status==true)? "checked" : ""  : ""}}
						 />
                        <span class="ml-2">Activo</span>
                    </label>
                    <label class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400">
                        <input type="radio" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="status" value=false
						{{isset($data) ? ($data->status==false)? "checked" : ""  : ""}}
						 />
                        <span class="ml-2">Inactivo</span>
                    </label>
                </div>
            </div>

	       
	       <div class="flex justify-end">
		        <button class="flex  px-4 py-2 my-8 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
		            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
		                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2h2m3-4H9a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-1m-1 4l-3 3m0 0l-3-3m3 3V3" />
		             </svg>
		            <span> Guardar </span>
		        </button>
      		</div>
      	</form>

	</div>
</x-app-layout>
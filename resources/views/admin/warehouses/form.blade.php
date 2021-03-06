<x-app-layout title="Formulario de registro">
	<div class="container grid px-6 mx-auto">
		<h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{route('admin.warehouses.index')}}">Almacenes</a>  
        </h2>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Registro Almacen
            </h4>
           
        </div>

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        
            <form class="form-horizontal" role="form" method="POST" action="{{ isset($data) ? route('admin.warehouses.update', $data->id) : route('admin.warehouses.store') }}" >
                @csrf
                 @if(isset($data))
		           @method('PUT')
		        @endif

	        <label class="block text-sm my-3">
	            <span class="text-gray-700 dark:text-gray-400">Nombre</span>
	            <input class="{{ $errors->has('name') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Nombre de la caregoria" / name="name" value="{{ old('name', isset($data) ? $data->name : '') }}" max="100" required="">
	            @if($errors->has('name'))
		             	<span class="text-xs text-red-600 dark:text-red-400">
		                    {{ $errors->first('name') }}
		                </span>
	                @endif
	        </label>


			<div class="px-2">
				<div class="flex mb-4">
					<div class="w-1/2 mr-1">
						<label class="block text-sm my-3">
							<span class="text-gray-700 dark:text-gray-400">Codigo postal</span>
							<input class="{{ $errors->has('postal_code') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Breve descripci??n" / name="postal_code" value="{{ old('postal_code', isset($data) ? $data->postal_code : '') }}" max="10" >
							@if($errors->has('postal_code'))
									 <span class="text-xs text-red-600 dark:text-red-400">
										{{ $errors->first('postal_code') }}
									</span>
								@endif
						</label>
					</div>
					<div class="w-1/2 ml-1">
						<label class="block text-sm my-3">
							<span class="text-gray-700 dark:text-gray-400">Telefono</span>
							<input class="{{ $errors->has('phone_number') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Breve descripci??n" / name="phone_number" value="{{ old('phone_number', isset($data) ? $data->phone_number : '') }}" max="50">
							@if($errors->has('phone_number'))
									 <span class="text-xs text-red-600 dark:text-red-400">
										{{ $errors->first('phone_number') }}
									</span>
								@endif
						</label>
					</div>
				</div>
			</div>


			<label class="block text-sm my-3">
	            <span class="text-gray-700 dark:text-gray-400">Direcci??n</span>
	            <input class="{{ $errors->has('address') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Nombre de la caregoria" / name="address" value="{{ old('address', isset($data) ? $data->address : '') }}" max="254">
	            @if($errors->has('address'))
		             	<span class="text-xs text-red-600 dark:text-red-400">
		                    {{ $errors->first('address') }}
		                </span>
	                @endif
	        </label>

			<div class="mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    Status
                </span>
                <div class="mt-2">
                    <label class="inline-flex items-center text-gray-600 dark:text-gray-400">
                        <input type="radio" class="text-blue-600 form-radio focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray" name="status" value=1
						{{isset($data) ? ($data->status==1)? "checked" : ""  : ""}}
						 />
                        <span class="ml-2">Activo</span>
                    </label>
                    <label class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400">
                        <input type="radio" class="text-blue-600 form-radio focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray" name="status" value=0
						{{isset($data) ? ($data->status==0)? "checked" : ""  : ""}}
						 />
                        <span class="ml-2">Inactivo</span>
                    </label>
                </div>
            </div>

	       
	       <div class="flex justify-end">
		        <button class="flex  px-4 py-2 my-8 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
		            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
		                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2h2m3-4H9a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-1m-1 4l-3 3m0 0l-3-3m3 3V3" />
		             </svg>
		            <span> Guardar </span>
		        </button>
      		</div>
      	</form>

	</div>
</x-app-layout>
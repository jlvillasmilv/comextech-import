<x-app-layout title="Formulario de registro">
	<div class="container grid px-6 mx-auto">
		<h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{route('admin.trans_companies.index')}}">Transporte</a>  
        </h2>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Registro Empresa de transporte
            </h4>
           
        </div>

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        
            <form class="form-horizontal" role="form" method="POST" action="{{ isset($transportMode) ? route('admin.transport-modes.update', $transportMode->id) : route('admin.transport-modes.store') }}" >
                @csrf
                 @if(isset($transportMode))
		           @method('PUT')
		        @endif
			
			<div class="mt-4 text-sm">
				<label class="block text-sm my-3">
					<span class="text-gray-700 dark:text-gray-400">Nombre</span>
					<input class="{{ $errors->has('name') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Nombre" name="name" value="{{ old('name', isset($transportMode) ? $transportMode->name : '') }}" max="100" required="">
					@if($errors->has('name'))
							<span class="text-xs text-red-600 dark:text-red-400">
								{{ $errors->first('name') }}
							</span>
						@endif
				</label>
			</div>

			<div class="mt-4 text-sm">
				<label class="block text-sm my-3">
					<span class="text-gray-700 dark:text-gray-400">Descripción</span>
					<input class="{{ $errors->has('description') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="description" value="{{ old('description', isset($transportMode) ? $transportMode->description : '') }}" >
					@if($errors->has('description'))
							<span class="text-xs text-red-600 dark:text-red-400">
								{{ $errors->first('description') }}
							</span>
						@endif
				</label>
			</div>

			<div class="flex mb-4">
				<div class="mt-4 text-sm w-auto mr-1 sm:w-full">
					<span class="text-gray-700 dark:text-gray-400">
						Status
					</span>
					<div class="mt-2">
						<label class="inline-flex items-center text-gray-600 dark:text-gray-400">
							<input type="radio" class="text-blue-600 form-radio focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray" name="status" value=true
							{{isset($transportMode) ? ($transportMode->status==true)? "checked" : ""  : ""}}
							/>
							<span class="ml-2">Activo</span>
						</label>
						<label class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400">
							<input type="radio" class="text-blue-600 form-radio focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray" name="status" value=false
							{{isset($transportMode) ? ($transportMode->status==false)? "checked" : ""  : ""}}
							/>
							<span class="ml-2">Inactivo</span>
						</label>
						@if($errors->has('status'))
								<span class="text-xs text-red-600 dark:text-red-400">
									{{ $errors->first('status') }}
								</span>
							@endif
					</div>
				</div>
				<div class="mt-4 text-sm w-auto mr-1 sm:w-full">
					<span class="text-gray-700 dark:text-gray-400">
						Deshabilitado
					</span>
					<div class="mt-2">
						<label class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400">
							<input type="radio" class="text-blue-600 form-radio focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray" name="disabled" value=false
							{{isset($transportMode) ? ($transportMode->disabled==false)? "checked" : ""  : ""}}
							/>
							<span class="ml-2">Habilitar</span>
						</label>
						<label class="inline-flex items-center text-gray-600 dark:text-gray-400">
							<input type="radio" class="text-blue-600 form-radio focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray" name="disabled" value=true
							{{isset($transportMode) ? ($transportMode->disabled==true)? "checked" : ""  : ""}}
							/>
							<span class="ml-2">Deshabilitar</span>
						</label>
						
						@if($errors->has('disabled'))
								<span class="text-xs text-red-600 dark:text-red-400">
									{{ $errors->first('disabled') }}
								</span>
							@endif
					</div>
				</div>

			</div>
	       
	       <div class="flex justify-end">
		        <button class="flex  px-4 py-2 my-8 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-1300 border border-transparent rounded-lg active:bg-blue-1300 focus:outline-none focus:shadow-outline-blue">
		            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
		                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2h2m3-4H9a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-1m-1 4l-3 3m0 0l-3-3m3 3V3" />
		             </svg>
		            <span> Guardar </span>
		        </button>
      		</div>
      	</form>

	</div>
</x-app-layout>
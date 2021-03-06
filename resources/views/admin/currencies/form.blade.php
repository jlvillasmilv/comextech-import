<x-app-layout title="Formulario de registro">
	<div class="container grid px-6 mx-auto">
		<h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Registro de moneda
        </h2>

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        

            <form class="form-horizontal" role="form" method="POST" action="{{ isset($data) ? route('admin.currencies.update', $data->id) : route('admin.currencies.store') }}"  enctype="multipart/form-data">
                @csrf
                 @if(isset($data))
		           @method('PUT')
		        @endif

	        <label class="block text-sm my-3">
	            <span class="text-gray-700 dark:text-gray-400">Nombre</span>
	            <input class="{{ $errors->has('name') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Nombre de la moneda" / name="name" value="{{ old('name', isset($data) ? $data->name : '') }}" max="100" required="">
	            @if($errors->has('name'))
		             	<span class="text-xs text-red-600 dark:text-red-400">
		                    {{ $errors->first('name') }}
		                </span>
	                @endif
	        </label>

	        <div class="flex flex-wrap">
			    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
			      <label class="block text-sm my-3">
		            <span class="text-gray-700 dark:text-gray-400">Codigo</span>
		            <input class="{{ $errors->has('code') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Nombre de la moneda" / name="code" value="{{ old('code', isset($data) ? $data->code : '') }}" max="10" required="">

		          
		            @if($errors->has('code'))
		             	<span class="text-xs text-red-600 dark:text-red-400">
		                    {{ $errors->first('code') }}
		                </span>
	                @endif
		        </label>
			    </div>
			    <div class="w-full md:w-1/2 px-3">
			     <label class="block text-sm my-3">
		            <span class="text-gray-700 dark:text-gray-400">Simbolo</span>
		            <input class="{{ $errors->has('symbol') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Nombre de la moneda" / name="symbol" value="{{ old('symbol', isset($data) ? $data->symbol : '') }}" max="10">
		            @if($errors->has('symbol'))
		             	<span class="text-xs text-red-600 dark:text-red-400">
		                    {{ $errors->first('symbol') }}
		                </span>
	                @endif
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
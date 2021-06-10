<x-app-layout title="Formulario de registro">
	<div class="container grid px-6 mx-auto">
		<h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{route('admin.services.index')}}">Servicios</a>  
        </h2>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Registro de Servicios
            </h4>
           
        </div>
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
    
            <form class="form-horizontal" role="form" method="POST" action="{{ isset($data) ? route('admin.services.update', $data->id) : route('admin.services.store') }}">
                @csrf
                 @if(isset($data))
		           @method('PUT')
		        @endif

				<label class="block text-sm my-3">
                    <span class="text-gray-700 dark:text-gray-400">Categoria</span>

                    <select name="category_service_id" class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-select select2  @error('category_service_id') is-invalid @enderror">

                    @foreach($category as $id => $name)

                        @if(old('category_service_id', isset($data->category_service_id) && $data->category_service_id == $id) )
                            <option value="{{ $id }}" selected>{{ $name }}</option>
                        @else
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endif

                        @endforeach
                    </select>
                    
                    @if($errors->has('category_service_id'))
                        <span class="text-xs text-red-600 dark:text-red-400">
                            {{ $errors->first('category_service_id') }}
                        </span>
                    @endif
                </label>

	        <label class="block text-sm my-3">
	            <span class="text-gray-700 dark:text-gray-400">Nombre</span>
	            <input class="{{ $errors->has('name') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Nombre del servicio" / name="name" value="{{ old('name', isset($data) ? $data->name : '') }}" max="100" required="">
	            @if($errors->has('name'))
		             	<span class="text-xs text-red-600 dark:text-red-400">
		                    {{ $errors->first('name') }}
		                </span>
	                @endif
	        </label>

	        <label class="block text-sm my-3">
	            <span class="text-gray-700 dark:text-gray-400">Descripción</span>
	            <input class="{{ $errors->has('description') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Breve descripción" / name="description" value="{{ old('description', isset($data) ? $data->description : '') }}" max="100" required="">
	            @if($errors->has('description'))
		             	<span class="text-xs text-red-600 dark:text-red-400">
		                    {{ $errors->first('description') }}
		                </span>
	                @endif
	        </label>
	        
	       
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
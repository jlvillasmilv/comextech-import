<x-app-layout title="Formulario de registro">
	<div class="container grid px-6 mx-auto">
		<h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{route('bank-accounts.index')}}">Cuentas bancarias</a>  
        </h2>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Registro de Cuenta bancarias
            </h4>
           
        </div>
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
    
            <form class="form-horizontal" role="form" method="POST" action="{{ isset($bankAccount) ? route('bank-accounts.update', $id) : route('bank-accounts.store') }}">
                @csrf
                 @if(isset($bankAccount))
		           @method('PUT')
		        @endif

				<label class="block text-sm my-3">
                    <span class="text-gray-700 dark:text-gray-400">Banco</span>

                    <select name="bank_id" class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-blue-300 focus:outline-none focus:shadow-outline-blue form-select select2  @error('bank_id') is-invalid @enderror">

                    	@foreach($banks as $id => $name)

							@if(old('bank_id', isset($bankAccount->bank_id) && $bankAccount->bank_id == $id) )
								<option value="{{ $id }}" selected>{{ $name }}</option>
							@else
								<option value="{{ $id }}">{{ $name }}</option>
							@endif

                        @endforeach
                    </select>
                    
                    @if($errors->has('bank_id'))
                        <span class="text-xs text-red-600 dark:text-red-400">
                            {{ $errors->first('bank_id') }}
                        </span>
                    @endif
                </label>

	        <label class="block text-sm my-3">
	            <span class="text-gray-700 dark:text-gray-400">Numero</span>
	            <input class="{{ $errors->has('number') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Nombre del servicio" / name="number" value="{{ old('number', isset($bankAccount) ? $bankAccount->number : '') }}" max="35" required="">
	            @if($errors->has('number'))
		             	<span class="text-xs text-red-600 dark:text-red-400">
		                    {{ $errors->first('number') }}
		                </span>
	                @endif
	        </label>

			<div class="mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    Status
                </span>
                <div class="mt-2">
                    <label class="inline-flex items-center text-gray-600 dark:text-gray-400">
                        <input type="radio" class="text-blue-600 form-radio focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray" name="status" value=true
						{{isset($bankAccount) ? ($bankAccount->status==true)? "checked" : ""  : ""}}
						 />
                        <span class="ml-2">Activo</span>
                    </label>
                    <label class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400">
                        <input type="radio" class="text-blue-600 form-radio focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray" name="status" value=false
						{{isset($bankAccount) ? ($bankAccount->status==false)? "checked" : ""  : ""}}
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
<x-app-layout title="Formulario de registro">
	<div class="container grid px-6 mx-auto">
		<h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{route('admin.customs-exchange-rates.index')}}">Tipo de cambio Aduanero</a>  
        </h2>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Registro de tipo de cambio
            </h4>
           
        </div>
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
    
            <form class="form-horizontal" role="form" method="POST" action="{{ isset($data) ? route('admin.customs-exchange-rates.update', base64_encode($data->id)) : route('admin.customs-exchange-rates.store') }}">
                @csrf
                 @if(isset($data))
		           @method('PUT')
		        @endif


				<label class="block text-sm my-3">
					<div class="px-2" id="add_to">
						<div class="flex mb-4">
							<div class="w-auto mr-1 sm:w-full">
								<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Moneda:</label>
	
								<select name="currency_code" class="select2  @error('currency_code') is-invalid @enderror">

									@foreach($currencies as $id => $name)
				
										@if(old('currency_code', isset($data->currency_code) && $data->currency_code == $id) )
											<option value="{{ $id }}" selected>{{ $name }}</option>
										@else
											<option value="{{ $id }}">{{ $name }}</option>
										@endif
				
										@endforeach
									</select>
									
								  @if($errors->has('currency_code'))
									  <span class="text-xs text-red-600 dark:text-red-400">
										  {{ $errors->first('currency_code') }}
									  </span>
								  @endif
							</div>
						   
							<div class="w-auto ml-1 sm:w-full">
								<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Monto:</label>
	
								<input class="{{ $errors->has('amount') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
								type="number"
								name="amount"
								value="{{ old('amount', isset($data) ? $data->amount : '') }}" 
								required="">
								
								@if($errors->has('amount'))
									<span class="text-xs text-red-600 dark:text-red-400">
										{{ $errors->first('amount') }}
									</span>
								@endif
								
							</div>
	
							<div class="w-auto ml-1 sm:w-full">
								<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Fecha:</label>
	
								<input class="{{ $errors->has('exchange') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
								type="date"
								name="exchange"
								value='{{ old('exchange',(isset($data)) && strtotime($data->exchange) != false  ? date("Y-m-d", strtotime($data->exchange)) : date("Y-m-d") )}}' 
								required="">
								
								@if($errors->has('c40HC'))
									<span class="text-xs text-red-600 dark:text-red-400">
										{{ $errors->first('c40HC') }}
									</span>
								@endif
								
							</div>
	
						</div>
					</div>
				  
				</label>

			
	       
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
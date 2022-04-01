<x-app-layout title="Categorias servicios ">
    <div class="container grid px-6 mx-auto">
	    <div class="flex justify-between items-end">
            <h4 class="my-4 text-lg  text-gray-600 dark:text-gray-300">
               Ajustes de sistema
            </h4>
           
        </div>

		
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
    
            <form class="form-horizontal" role="form" method="POST" action="{{ isset($data) ? route('admin.settings.update', $data->id) : route('admin.settings.store') }}">
                @csrf
                 @if(isset($data))
		           @method('PUT')
		        @endif

	        <label class="block text-sm my-3">
	            <span class="text-gray-700 dark:text-gray-400">Nombre</span>
	            <input class="{{ $errors->has('name') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Nombre Aplicacion" name="name" value="{{ old('name', isset($data) ? $data->name : '') }}" max="100" required="">
	            @if($errors->has('name'))
		             	<span class="text-xs text-red-600 dark:text-red-400">
		                    {{ $errors->first('name') }}
		                </span>
	                @endif
	        </label>


	        <label class="block text-sm my-3 font-bold ">Factoring</label>
            <hr>

            <label class="block text-sm my-3">
				<div class="px-2" id="add_to">
					<div class="sm:flex mb-4">
						<div class="w-auto sm:w-full ">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">TASA:</label>
							<input class="{{ $errors->has('rate') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							name="rate"
							value="{{ old('rate', isset($data) ? $data->rate : '') }}"
							type="number"
							required="">
							@if($errors->has('rate'))
								<span class="text-xs text-red-600 dark:text-red-400">
									{{ $errors->first('rate') }}
								</span>
							@endif
						</div>
					   
						<div class="w-auto ml-1 sm:w-full ">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">TASA_MORA</label>
							<input class="{{ $errors->has('mora_rate') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							type="number"
							name="mora_rate"
							value="{{ old('mora_rate', isset($data) ? $data->mora_rate : '') }}"
							required="">
							@if($errors->has('mora_rate'))
								<span class="text-xs text-red-600 dark:text-red-400">
									{{ $errors->first('mora_rate') }}
								</span>
							@endif
						</div>

						<div class="w-auto ml-1 sm:w-full">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">DESCUENTO:</label>

                            <input class="{{ $errors->has('discount') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							type="number"
							name="discount"
							value="{{ old('discount', isset($data) ? $data->discount : '') }}"
							max="100"
							required="">

								
								@if($errors->has('discount'))
									<span class="text-xs text-red-600 dark:text-red-400">
										{{ $errors->first('discount') }}
									</span>
								@endif
						</div>

                        <div class="w-auto ml-1 sm:w-full">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">COMISION:</label>

                            <input class="{{ $errors->has('commission') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							type="number"
							name="commission"
							value="{{ old('commission', isset($data) ? $data->commission : '') }}"
							required="">

								
								@if($errors->has('commission'))
									<span class="text-xs text-red-600 dark:text-red-400">
										{{ $errors->first('commission') }}
									</span>
								@endif
						</div>

					</div>
				</div>
			  
			</label>

            <label class="block text-sm my-3">
	            <span class="text-gray-700 dark:text-gray-400 font-bold">Url Sii</span>
	            <input class="{{ $errors->has('api_sii') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                type="url" 
                placeholder="Url"
                name="api_sii"
                value="{{ old('api_sii', isset($data) ? $data->api_sii : '') }}"
                required="">
	            @if($errors->has('api_sii'))
		             	<span class="text-xs text-red-600 dark:text-red-400">
		                    {{ $errors->first('api_sii') }}
		                </span>
	                @endif
	        </label>

            <label class="block text-sm my-3">
	            <span class="text-gray-700 dark:text-gray-400 font-bold ">Token Sii</span>
                <textarea class="{{ $errors->has('token_sii') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="token_sii" rows="3">{{ old('token_sii', isset($data) ? $data->token_sii : '') }}</textarea>
	            @if($errors->has('token_sii'))
		             	<span class="text-xs text-red-600 dark:text-red-400">
		                    {{ $errors->first('token_sii') }}
		                </span>
	                @endif
	        </label>

            <label class="block text-sm my-3">
	            <span class="text-gray-700 dark:text-gray-400 font-bold ">Terminos y condiciones </span>
                <textarea class="{{ $errors->has('terms') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="terms" rows="3">{{ old('terms', isset($data) ? $data->terms : '') }}</textarea>
	            @if($errors->has('terms'))
		             	<span class="text-xs text-red-600 dark:text-red-400">
		                    {{ $errors->first('terms') }}
		                </span>
	                @endif
	        </label>

			<hr>
			
            <label class="block text-sm my-3 font-bold ">Importaciones</label>

            <label class="block text-sm my-3">
				<div class="px-2" id="add_to">
					<div class="flex mb-4">
						<div class="w-1/4 mr-1 sm:w-full ">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">TASA MIN FCL</label>
							<input class="{{ $errors->has('min_rate_fcl') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							name="min_rate_fcl"
							value="{{ old('min_rate_fcl', isset($data) ? $data->min_rate_fcl : '') }}"
							type="number"
							required="">
							@if($errors->has('min_rate_fcl'))
								<span class="text-xs text-red-600 dark:text-red-400">
									{{ $errors->first('min_rate_fcl') }}
								</span>
							@endif
						</div>
					   
						<div class="w-1/4 ml-1 sm:w-full ">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">TASA MIN LCL</label>
							<input class="{{ $errors->has('min_rate_lcl') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							type="number"
							name="min_rate_lcl"
							value="{{ old('min_rate_lcl', isset($data) ? $data->min_rate_lcl : '') }}"
							required="">
							@if($errors->has('min_rate_lcl'))
								<span class="text-xs text-red-600 dark:text-red-400">
									{{ $errors->first('min_rate_lcl') }}
								</span>
							@endif
						</div>

						<div class="w-1/4 ml-1 sm:w-full">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">TASA MIN AEREO</label>

                            <input class="{{ $errors->has('min_rate_aereo') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							type="number"
							name="min_rate_aereo"
							value="{{ old('min_rate_aereo', isset($data) ? $data->min_rate_aereo : '') }}"
							max="100"
							required="">

								
								@if($errors->has('min_rate_aereo'))
									<span class="text-xs text-red-600 dark:text-red-400">
										{{ $errors->first('min_rate_aereo') }}
									</span>
								@endif
						</div>

                        <div class="w-1/4 ml-1 sm:w-full">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">TASA MIN TRANSP</label>

                            <input class="{{ $errors->has('min_rate_transp') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							type="number"
							name="min_rate_transp"
							value="{{ old('min_rate_transp', isset($data) ? $data->min_rate_transp : '') }}"
							required="">

								
								@if($errors->has('min_rate_transp'))
									<span class="text-xs text-red-600 dark:text-red-400">
										{{ $errors->first('min_rate_transp') }}
									</span>
								@endif
						</div>

					</div>
				</div>
			  
			</label>
			<hr>

			<label class="block text-sm my-3 font-bold ">Tasa de cambio</label>

            <label class="block text-sm my-3">
				<div class="px-2" id="add_to">
					<div class="flex mb-4">
						<div class="w-1/2">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Variacion</label>
							<input class="{{ $errors->has('exch_rate_variation') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							name="exch_rate_variation"
							value="{{ old('exch_rate_variation', isset($data) ? $data->exch_rate_variation : '') }}"
							type="number"
							required="">
							@if($errors->has('exch_rate_variation'))
								<span class="text-xs text-red-600 dark:text-red-400">
									{{ $errors->first('exch_rate_variation') }}
								</span>
							@endif
						</div>
					</div>
				</div>
			  
			</label>

			<hr>
			<label class="block text-sm my-3 font-bold ">Gatos de puerto (Aduana)</label>

            <label class="block text-sm my-3">
				<div class="px-2" id="add_to">
					<div class="sm:flex mb-4">
						<div class="w-auto mr-1 sm:w-full ">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300"> Gestión Documental LCL</label>
							<input class="{{ $errors->has('doc_mgmt_lcl') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							name="doc_mgmt_lcl"
							value="{{ old('doc_mgmt_lcl', isset($data) ? $data->doc_mgmt_lcl : '') }}"
							type="number"
							required="">
							@if($errors->has('doc_mgmt_lcl'))
								<span class="text-xs text-red-600 dark:text-red-400">
									{{ $errors->first('doc_mgmt_lcl') }}
								</span>
							@endif
						</div>
					   
						<div class="w-auto ml-1 sm:w-full ">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Visación documental LCL</label>
							<input class="{{ $errors->has('doc_visa_lcl') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							type="number"
							name="doc_visa_lcl"
							value="{{ old('doc_visa_lcl', isset($data) ? $data->doc_visa_lcl : '') }}"
							required="">
							@if($errors->has('doc_visa_lcl'))
								<span class="text-xs text-red-600 dark:text-red-400">
									{{ $errors->first('doc_visa_lcl') }}
								</span>
							@endif
						</div>

						<div class="w-auto ml-1 sm:w-full">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Despacho LCL</label>

                            <input class="{{ $errors->has('dispatch_lcl') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							type="number"
							name="dispatch_lcl"
							value="{{ old('dispatch_lcl', isset($data) ? $data->dispatch_lcl : '') }}"
							max="100"
							required="">

								
								@if($errors->has('dispatch_lcl'))
									<span class="text-xs text-red-600 dark:text-red-400">
										{{ $errors->first('dispatch_lcl') }}
									</span>
								@endif
						</div>

					</div>
				</div>
			  
			</label>

			<label class="block text-sm my-3">
				<div class="px-2" id="add_to">
					<div class="sm:flex mb-4">
						<div class="w-auto mr-1 sm:w-full ">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300"> Gestión Documental FCL</label>
							<input class="{{ $errors->has('doc_mgmt_fcl') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							name="doc_mgmt_fcl"
							value="{{ old('doc_mgmt_fcl', isset($data) ? $data->doc_mgmt_fcl : '') }}"
							type="number"
							required="">
							@if($errors->has('doc_mgmt_fcl'))
								<span class="text-xs text-red-600 dark:text-red-400">
									{{ $errors->first('doc_mgmt_fcl') }}
								</span>
							@endif
						</div>
					   
						<div class="w-auto ml-1 sm:w-full ">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Comodato</label>
							<input class="{{ $errors->has('loan_fcl') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							type="number"
							name="loan_fcl"
							value="{{ old('loan_fcl', isset($data) ? $data->loan_fcl : '') }}"
							required="">
							@if($errors->has('loan_fcl'))
								<span class="text-xs text-red-600 dark:text-red-400">
									{{ $errors->first('loan_fcl') }}
								</span>
							@endif
						</div>

						<div class="w-auto ml-1 sm:w-full">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Gate In</label>

                            <input class="{{ $errors->has('gate_in_fcl') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							type="number"
							name="gate_in_fcl"
							value="{{ old('gate_in_fcl', isset($data) ? $data->gate_in_fcl : '') }}"
							max="900"
							required="">

								
								@if($errors->has('gate_in_fcl'))
									<span class="text-xs text-red-600 dark:text-red-400">
										{{ $errors->first('gate_in_fcl') }}
									</span>
								@endif
						</div>

					</div>
				</div>
			  
			</label>
	       
	       <div class="flex justify-end">
		        <button class="flex  px-4 py-2 my-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
		            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
		                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2h2m3-4H9a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-1m-1 4l-3 3m0 0l-3-3m3 3V3" />
		             </svg>
		            <span> Guardar </span>
		        </button>
      		</div>
      	</form>

	</div>
</x-app-layout>

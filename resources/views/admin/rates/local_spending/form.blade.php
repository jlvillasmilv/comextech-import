<x-app-layout title="Formulario de registro">
	<div class="container grid px-6 mx-auto">
		<h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{route('admin.rates.local-spending.index')}}">Tarifas gasto local</a>  
        </h2>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Registro Tarifa
            </h4>
           
        </div>

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        

            <form class="form-horizontal" role="form" method="POST" action="{{ isset($data) ? route('admin.rates.local-spending.update', base64_encode($data->id)) : route('admin.rates.local-spending.store') }}"  enctype="multipart/form-data">
                @csrf
                 @if(isset($data))
		           @method('PUT')
		        @endif

			<label class="block text-sm my-3">
				<div class="px-2" id="add_to">
					<div class="flex mb-4">
						<div class="w-2/4 mr-1 sm:w-full ">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Empresa:</label>
							<select name="trans_company_id" class="select2  @error('trans_company_id') is-invalid @enderror">

							  @foreach($trans_companies as $id => $name)
		  
								  @if(old('trans_company_id', isset($data->trans_company_id) && $data->trans_company_id == $id) )
									  <option value="{{ $id }}" selected>{{ $name }}</option>
								  @else
									  <option value="{{ $id }}">{{ $name }}</option>
								  @endif
		  
								  @endforeach
							  </select>
							  
							  @if($errors->has('trans_company_id'))
								  <span class="text-xs text-red-600 dark:text-red-400">
									  {{ $errors->first('trans_company_id') }}
								  </span>
							  @endif
						</div>
					</div>
				</div>
			  
			</label>

			<label class="block text-sm my-3">
					<div class="px-2" id="add_to">
						<div class="flex mb-4">
							<div class="w-auto mr-1 sm:w-full">
								<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Valor PRODUCTO (USD):</label>
	
								<input class="{{ $errors->has('val_init') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
								type="number"
								name="val_init"
								value="{{ old('val_init', isset($data) ? $data->val_init : '') }}" 
								required="">
								  
								  @if($errors->has('val_init'))
									  <span class="text-xs text-red-600 dark:text-red-400">
										  {{ $errors->first('val_init') }}
									  </span>
								  @endif
							</div>
						   
							<div class="w-auto ml-1 sm:w-full">
								<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Valor PRODUCTO (USD) limite:</label>
	
								<input class="{{ $errors->has('val_limit') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
								type="number"
								name="val_limit"
								value="{{ old('val_limit', isset($data) ? $data->val_limit : '') }}" 
								required="">
								
								@if($errors->has('val_limit'))
									<span class="text-xs text-red-600 dark:text-red-400">
										{{ $errors->first('val_limit') }}
									</span>
								@endif
								
							</div>
	
							<div class="w-auto ml-1 sm:w-full">
								<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Tarifa en USD :</label>
	
								<input class="{{ $errors->has('rate') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
								type="number"
								name="rate"
								value="{{ old('rate', isset($data) ? $data->rate : '') }}" 
								required="">
								
								@if($errors->has('rate'))
									<span class="text-xs text-red-600 dark:text-red-400">
										{{ $errors->first('rate') }}
									</span>
								@endif
								
							</div>
	
						</div>
					</div>
				  
				</label>

			<label class="block text-sm my-3">
				<div class="px-2" id="add_to">
					<div class="flex mb-4">
					
						<div class="w-2/4 ml-1 sm:w-full ">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Valido hasta:</label>

							<input class="{{ $errors->has('valid_to') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							type="date"
							name="valid_to"
							value='{{ old('valid_to',(isset($data)) && strtotime($data->valid_to) != false  ? date("Y-m-d", strtotime($data->valid_to)) : date("Y-m-d") )}}'
							required="">
							
							@if($errors->has('valid_to'))
								<span class="text-xs text-red-600 dark:text-red-400">
									{{ $errors->first('valid_to') }}
								</span>
							@endif
							
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
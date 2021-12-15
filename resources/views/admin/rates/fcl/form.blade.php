<x-app-layout title="Formulario de registro">
	<div class="container grid px-6 mx-auto">
		<h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{route('admin.rates.fcl.index')}}">Tarifas FCL</a>  
        </h2>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Registro Tarifa
            </h4>
           
        </div>

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        

            <form class="form-horizontal" role="form" method="POST" action="{{ isset($data) ? route('admin.rates.fcl.update', base64_encode($data->id)) : route('admin.rates.fcl.store') }}"  enctype="multipart/form-data">
                @csrf
                 @if(isset($data))
		           @method('PUT')
		        @endif

			<label class="block text-sm my-3">
				<div class="px-2" id="add_to">
					<div class="flex mb-4">
						<div class="w-2/4 mr-1 sm:w-full ">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Origen:</label>
							<select name="from" class="select2  @error('from') is-invalid @enderror">

							  @foreach($ports as $id => $name)
		  
								  @if(old('from', isset($data->from) && $data->from == $id) )
									  <option value="{{ $id }}" selected>{{ $name }}</option>
								  @else
									  <option value="{{ $id }}">{{ $name }}</option>
								  @endif
		  
								  @endforeach
							  </select>
							  
							  @if($errors->has('from'))
								  <span class="text-xs text-red-600 dark:text-red-400">
									  {{ $errors->first('from') }}
								  </span>
							  @endif
						</div>
					   
						<div class="w-2/4 ml-1 sm:w-full ">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Destino:</label>
							<select name="to" class="select2  @error('to') is-invalid @enderror">

							  @foreach($ports as $id => $name)
		  
								  @if(old('to', isset($data->to) && $data->to == $id) )
									  <option value="{{ $id }}" selected>{{ $name }}</option>
								  @else
									  <option value="{{ $id }}">{{ $name }}</option>
								  @endif
		  
								  @endforeach
							  </select>
							  
							  @if($errors->has('to'))
								  <span class="text-xs text-red-600 dark:text-red-400">
									  {{ $errors->first('to') }}
								  </span>
							  @endif
							
						</div>

					</div>
				</div>
			  
			</label>

			<label class="block text-sm my-3">
				<div class="px-2" id="add_to">
					<div class="flex mb-4">
						<div class="w-1/4 mr-1 sm:w-full ">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">VIA:</label>
							<input class="{{ $errors->has('via') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							name="via"
							value="{{ old('via', isset($data) ? $data->via : '') }}"
							max="50"
							required="">
							@if($errors->has('via'))
								<span class="text-xs text-red-600 dark:text-red-400">
									{{ $errors->first('via') }}
								</span>
							@endif
						</div>
					   
						<div class="w-1/4 ml-1 sm:w-full ">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Transist time:</label>
							<input class="{{ $errors->has('t_time') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							type="number"
							name="t_time"
							value="{{ old('t_time', isset($data) ? $data->t_time : '') }}"
							max="100"
							required="">
							@if($errors->has('t_time'))
								<span class="text-xs text-red-600 dark:text-red-400">
									{{ $errors->first('t_time') }}
								</span>
							@endif
						</div>

						<div class="w-1/4 ml-1 sm:w-full">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Moneda:</label>

							<select name="to" class="select2  @error('to') is-invalid @enderror">

								@foreach($currencies as $id => $name)
			
									@if(old('to', isset($data->to) && $data->to == $id) )
										<option value="{{ $id }}" selected>{{ $name }}</option>
									@else
										<option value="{{ $id }}">{{ $name }}</option>
									@endif
			
									@endforeach
								</select>
								
								@if($errors->has('to'))
									<span class="text-xs text-red-600 dark:text-red-400">
										{{ $errors->first('to') }}
									</span>
								@endif
							
							
						</div>

					</div>
				</div>
			  
			</label>

			<label class="block text-sm my-3">
				<div class="px-2" id="add_to">
					<div class="flex mb-4">
						<div class="w-2/4 mr-1 sm:w-full ">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Fecha Origen:</label>

							<input class="{{ $errors->has('valid_from') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							type="date"
							name="valid_from"
							value='{{ old('valid_from',(isset($data)) && strtotime($data->valid_from) != false  ? date("Y-m-d", strtotime($data->valid_from)) : date("Y-m-d") )}}' 
							required="">
							  
							  @if($errors->has('valid_from'))
								  <span class="text-xs text-red-600 dark:text-red-400">
									  {{ $errors->first('valid_from') }}
								  </span>
							  @endif
						</div>
					   
						<div class="w-2/4 ml-1 sm:w-full ">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Fecha:</label>

							<input class="{{ $errors->has('valid_to') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							type="date"
							name="valid_to"
							value='{{ old('valid_to',(isset($data)) && strtotime($data->valid_to) != false  ? date("Y-m-d", strtotime($data->valid_to)) : date("Y-m-d") )}}'
							min="{{date("Y-m-d")}}" 
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


			<label class="block text-sm my-3">
				<div class="px-2" id="add_to">
					<div class="flex mb-4">
						<div class="w-auto mr-1 sm:w-full">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">20:</label>

							<input class="{{ $errors->has('c20') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							type="number"
							name="c20"
							value="{{ old('c20', isset($data) ? $data->c20 : '') }}" 
							required="">
							  
							  @if($errors->has('valid_from'))
								  <span class="text-xs text-red-600 dark:text-red-400">
									  {{ $errors->first('valid_from') }}
								  </span>
							  @endif
						</div>
					   
						<div class="w-auto ml-1 sm:w-full">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">40:</label>

							<input class="{{ $errors->has('c40') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							type="number"
							name="c40"
							value="{{ old('c40', isset($data) ? $data->c40 : '') }}" 
							required="">
							
							@if($errors->has('c40'))
								<span class="text-xs text-red-600 dark:text-red-400">
									{{ $errors->first('c40') }}
								</span>
							@endif
							
						</div>

						<div class="w-auto ml-1 sm:w-full">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">40HC:</label>

							<input class="{{ $errors->has('c40HC') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							type="number"
							name="c40HC"
							value="{{ old('c40HC', isset($data) ? $data->c40HC : '') }}" 
							required="">
							
							@if($errors->has('c40HC'))
								<span class="text-xs text-red-600 dark:text-red-400">
									{{ $errors->first('c40HC') }}
								</span>
							@endif
							
						</div>

						<div class="w-auto ml-1 sm:w-full">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">40NOR:</label>

							<input class="{{ $errors->has('c40NOR') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							type="number"
							name="c40NOR"
							value="{{ old('c40NOR', isset($data) ? $data->c40NOR : '') }}" 
							required="">
							
							@if($errors->has('c40NOR'))
								<span class="text-xs text-red-600 dark:text-red-400">
									{{ $errors->first('c40NOR') }}
								</span>
							@endif
							
						</div>

						<div class="w-auto ml-1 sm:w-full">
							<label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Ot Gastos</label>

							<input class="{{ $errors->has('oth_exp') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							type="number"
							name="oth_exp"
							value="{{ old('oth_exp', isset($data) ? $data->oth_exp : '') }}" 
							required="">
							
							@if($errors->has('oth_exp'))
								<span class="text-xs text-red-600 dark:text-red-400">
									{{ $errors->first('oth_exp') }}
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
                        <input type="radio" class="text-blue-600 form-radio focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray" name="status" value=true
						{{isset($data) ? ($data->status==true)? "checked" : ""  : ""}}
						 />
                        <span class="ml-2">Activo</span>
                    </label>
                    <label class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400">
                        <input type="radio" class="text-blue-600 form-radio focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray" name="status" value=false
						{{isset($data) ? ($data->status==false)? "checked" : ""  : ""}}
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
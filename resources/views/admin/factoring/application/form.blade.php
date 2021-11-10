
@php
    $sii 			  = $data->user->credentialStores;
    $impuesto_sii     = $data->user->FileStoreClient->where('type','impuesto_sii')->last();
    $carp_tributaria  = $data->user->FileStoreClient->where('type','carp_tributaria')->last();
@endphp


<x-app-layout title="Solicitudes">
	<div class="container grid px-6 mx-auto">
		<h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{route('admin.factoring.applications.index')}}">Listado de Solicitudes</a>  
        </h2>

		@if(!$sii->provider_password)
			<div class="bg-gray-200 text-gray-700 text-sm font-bold px-4 py-3 my-3" role="alert">
				
				<p class="font-bold">
					Última declaracion de Impuesto Renta (SII)
					<a {{ $impuesto_sii !== null ? 'download' :'required' }} href="{{  $impuesto_sii !== null ? route('admin.download.client', [$impuesto_sii->id, 'impuesto_sii']):'#' }}"
					class="text-white font-bold py-1 px-2 rounded {{ $impuesto_sii !== null ? 'bg-blue-300 hover:bg-blue-700' :'bg-gray-300 hover:bg-gray-500' }}" >
					<i class="fas fa-{{$impuesto_sii !== null ? 'file-download' :'times' }} "></i>
					</a>
				</p>

				<p class="font-bold">
					Carpetas Tributarias Actualizadas 
					<a {{ $carp_tributaria !== null ? 'download' :'required' }} href="{{  $carp_tributaria !== null ? route('admin.download.client', [$carp_tributaria->id, 'impuesto_sii']):'#' }}"  class="text-white font-bold py-1 px-2 rounded {{ $carp_tributaria !== null ? 'bg-blue-300 hover:bg-blue-700' :'bg-gray-300 hover:bg-gray-500' }}" >
						<i class="fas fa-{{ $carp_tributaria !== null ? 'file-download' :'times' }} "></i>
					</a>
				</p>
			</div>
		@else

			<div class="bg-blue-300 text-blue-700 text-sm font-bold px-4 py-3 my-3" role="alert">
				<p class="font-bold">
					Clave SII del Cliente : {{ base64_decode($sii->provider_password) }}
				</p>
			</div>

		@endif
	
        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Actualizacion de Solicitud
				 # {{  isset($data) ? str_pad($data->id, 6, '0', STR_PAD_LEFT) : '' }}
            </h4>
           
        </div>
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
    
            <form class="form-horizontal" role="form" method="POST" action="{{ isset($data) ? route('admin.factoring.applications.update', $id) : route('admin.factoring.applications.store') }}"  enctype="multipart/form-data">

                @csrf
                @if(isset($data))
                    @method('PUT')
                @endif

				<p class="font-bold mb-2">Cliente: {{ $data->user->company->name}}</p>
                <p class="font-bold">RUT:  {{ $data->user->company->tax_id}}  </p>
				
				
				<div class="flex flex-wrap">
                    <div class="sm:w-full md:w-2/4 px-2 ">

                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400">Status</span>
        
							<select name="status" class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-blue-300 focus:outline-none focus:shadow-outline-blue form-select select2  @error('bank_id') is-invalid @enderror">

								@foreach($status as $id )
		
								@if(old('status', isset($data->status) && $data->status == $id) == $id )
									<option value="{{ $id }}" selected>{{ $id }}</option>
								@else
									<option value="{{ $id }}">{{ $id }}</option>
								@endif
		
							@endforeach
		
							</select>
							
							@if($errors->has('status'))
								<span class="text-xs text-red-600 dark:text-red-400">
									{{ $errors->first('status') }}
								</span>
							@endif
                           
                        </label>

                    </div>
                    <div class="md:w-2/4 px-3 sm:w-full">
                        <div class="flex justify-start">
                            <button class="flex px-4 py-2 mt-8 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
								<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2h2m3-4H9a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-1m-1 4l-3 3m0 0l-3-3m3 3V3" />
								 </svg>
								<span> Guardar </span>
							</button>
                          </div>

                    </div>
                </div>

	        <label class="block text-sm my-3">
	            <span class="text-gray-700 dark:text-gray-400">Cometarios</span>
	            <input class="{{ $errors->has('description') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Cometarios" / name="description" value="{{ old('description', isset($data) ? $data->description : '') }}" max="255" >
	            @if($errors->has('description'))
		             	<span class="text-xs text-red-600 dark:text-red-400">
		                    {{ $errors->first('description') }}
		                </span>
	                @endif
	        </label>

			@if($sii->provider_password)

	        <div class="flex flex-wrap">
			    <div class="sm:w-full md:w-1/3 px-3 ">
			      <label class="block text-sm my-3">
		            <span class="text-gray-800 dark:text-gray-400">
						Certificado de Deuda Tributaria (TGR)
					</span>

					<div role="group" class="text-gray-600 flex m-2"> 
						<div class="file-select mx-2" id="src-file1"  >
						  <input type="file" id="filecert_dueda_tribu" ref="file" >
						</div>
						<a data-remote="cert_dueda_tribu" class="upload bg-gray-400 hover:bg-gray-500 text-white font-bold py-1 px-2 rounded inline-flex items-center rounded"><i class="fas fa-cloud-upload-alt fa-lg text-white-50"></i> Subir</a>
					</div>
		           
		        	</label>
			    </div>

			    <div class="sm:w-full md:w-1/3 px-3">
			    	<label class="block text-sm my-3">
		            	<span class="text-gray-800 dark:text-gray-400">
							 Última declaracion de Impuesto Renta (SII)
						</span>

						<div role="group" class="text-gray-600 flex m-2"> 
							<div class="file-select mx-2" id="src-file1"  >
							  <input type="file" id="fileimpuesto_sii" ref="file" >
							</div>
							<a data-remote="impuesto_sii" class="upload bg-gray-400 hover:bg-gray-500 text-white font-bold py-1 px-2 rounded inline-flex items-center rounded"><i class="fas fa-cloud-upload-alt fa-lg text-white-50"></i> Subir</a>
						</div>
		            
		        	</label>
			    </div>

				<div class="sm:w-full md:w-1/3 px-3">
			    	<label class="block text-sm my-3">
		            	<span class="text-gray-800 dark:text-gray-400">
							Carpetas Tributarias Actualizadas 
						</span>

						<div role="group" class="text-gray-600 flex m-2"> 
							<div class="file-select mx-2" id="src-file1"  >
							  <input type="file" id="filecarp_tributaria" ref="file" >
							</div>
							<a data-remote="carp_tributaria" class="upload bg-gray-400 hover:bg-gray-500 text-white font-bold py-1 px-2 rounded inline-flex items-center rounded"><i class="fas fa-cloud-upload-alt fa-lg text-white-50"></i> Subir</a>
						</div>
		            
		        	</label>
			    </div>
			</div>
			@endif

			
      	</form>
		<div class="grid gap-6 mb-8 ">
		  
			@include('admin.factoring.application.table')

		</div>
	</div>

	@section('scripts')
	@parent
	
	<script>
	
	const Toast = Swal.mixin({
		  toast: true,
		  position: 'top-end',
		  showConfirmButton: false,
		  timer: 3000,
		  timerProgressBar: true,
		  didOpen: (toast) => {
			toast.addEventListener('mouseenter', Swal.stopTimer)
			toast.addEventListener('mouseleave', Swal.resumeTimer)
		  }
		});
	
		$(".upload").on('click', function() {
		  var type = $(this).data('remote');
		  var formData = new FormData();
		  var files =   $('#file'+type)[0].files[0];
		  var route =  "{{route('factoring.single-file')}}" ;
		  let client_id = {{ $data->user->id}};
		 if(files !== undefined){
			Toast.fire({
			icon: 'warning',
			title: 'Estamos almacenando tu archivo, un momento!'
			})
		  formData.append('file',files);
		  formData.append('type', type);
		  formData.append('client_id', client_id);
		  formData.append( "_token", "{{ csrf_token() }}");
		  $.ajax({
			  url: route,
			  type: 'POST',
			  data: formData,
			  contentType: false,
			  processData: false,
			  success: function(response) {
					Toast.fire({
					icon: 'success',
					title: 'Archivo subido! Entrara en revision'
					})
			  }
		  });
		}else{
			Toast.fire({
				icon: 'info',
				title: 'Seleccione el archivo desde tu ordenandor!'
			})
		}
		  
	  });
			
	</script>
	@endsection

</x-app-layout>

	 
<style >
	.file-select {          
	  position: relative;
	  display: inline-block;
	}
	
	.file-select::before {
	  background-color:#C8C8C8;
	  color:white;
	  display: flex;            
	  justify-content: center;
	  align-items: center;
		radius: 4px;
		content: 'Cargar Archivo '; /* testo por defecto */
	  position: absolute;
	  left: 0;
	  right: 0;
	  top: 0;
	  bottom: 0;                
	}
	.team {
		position: relative;
	  display: inline-block;; /* the default for span */
	}
	
	.file-select input[type="file"] {
	  opacity: 0;
	  width: 79px;
	  height: 30px;
	  display: inline-block;            
	}
	
	#src-file1::before {
	  content: 'Seleccionar';
	}
	
   
  </style>
<x-app-layout title="Formulario de registro">
	<div class="container grid px-6 mx-auto">
        <h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{route('admin.applications.index')}}">Solicitudes</a>  
        </h2>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Detalle Solicitud  #   {{str_pad($application->id, 6, '0', STR_PAD_LEFT) }}
            </h4>
           
        </div>

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        

            <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.applications.update', $application->id) }}"  enctype="multipart/form-data">
                @csrf
                 @if(isset($application))
		           @method('PUT')
		        @endif

                <div class="flex flex-wrap">
                    <div class="sm:w-full md:w-2/6 px-2 ">

                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400">Status</span>
        
                            <select name="application_statuses_id" id="application_statuses_id" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray  @error('application_statuses_id') is-invalid @enderror">

                                @foreach($status as $id => $name)

                                    @if(old('application_statuses_id', isset($application->application_statuses_id) && $application->application_statuses_id == $id) )
                                        <option value="{{ $id }}" selected>{{ $name }}</option>
                                    @else
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endif

                                @endforeach
                            </select>
                            @if($errors->has('application_statuses_id'))
                                 <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('application_statuses_id') }}
                                </span>
                            @endif
                           
                        </label>

                    </div>

                    @if (isset($application->transport->id))

                    <div class="sm:w-full md:w-2/6 px-2 ">

                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400">Numero de Ratreo</span>
        
                            <input type="text" class=" block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Numero de rastreo envio"
                             id="tracking_number"
                             name="tracking_number" 
                             value="{{ old('amount', isset($application->transport->tracking_number) ? $application->transport->tracking_number : '') }}" 
                             >

                             @if($errors->has('tracking_number'))
									<span class="text-xs text-red-600 dark:text-red-400">
										{{ $errors->first('tracking_number') }}
									</span>
							@endif

                           
                        </label>

                    </div>

                    @endif
                </div>

                <div class="w-full overflow-hidden rounded-lg ring-1 ring-black ring-opacity-5">
                    <div class="w-full overflow-x-auto">
                
                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-bold mb-2">Cliente:</span>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                {{$application->user->company->tax_id}} {{$application->user->company->name}} 
                            </p>
                        </label>   
                       
                        <div class="flex mb-4">
                            <div class="w-1/3 mr-1">
                                    <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Monto de la operación:</label>
                                    <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                       {{number_format($application->amount,0,",",".") }}   {{ $application->currency->code }}
                                    </p>
                            </div>
                            <div class="w-1/3 ml-1">
                                    <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" >Condicion de Venta</label>
                                    <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                        {{ $application->condition }} 
                                    </p>
                            </div>
                                
                            <div class="w-1/3">
                                <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Fecha Solicitud:</label>
                                <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                    {{ date('d-m-Y', strtotime($application->created_at)) }}
                                </p>
                            </div>
                        </div>
                        
                    </div>
                    @include('admin.applications.files')

                    <div class="px-3 w-full">
                        <div class="flex justify-end mt-1">
                            <button type="submit" class="flex px-4 py-2 mt-8 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-1300 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-1400 focus:outline-none focus:shadow-outline-blue">
								<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2h2m3-4H9a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-1m-1 4l-3 3m0 0l-3-3m3 3V3" />
								 </svg>
								<span> Guardar </span>
							</button>
                          </div>
                    </div>
                </div>

                <div class="flex justify-between items-end">
                    <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                        Detalle Solicitud 
                    </h4>
                </div>
                
                @include('admin.applications.services')

                <div class="w-full overflow-hidden rounded-lg ring-1 ring-black ring-opacity-5">
                    @if ($application->status->modify)
                        @include('admin.applications.summary')
                    @endif
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {!! session()->get('error') !!} 
                    </span>
                </div> 

      		</form>
	</div>
    
@section('scripts')
@parent
<script type="text/javascript">

     // Agrega nuevo registro Direccion orgen tansporte 
     function addRow(tableID) {
       
        var table = document.getElementById("table");
        const tbodyEl = document.getElementById('table').getElementsByTagName('tbody')[0];

        let applicationDocument = document.getElementById("application_document_file_id");
        var value = applicationDocument.options[applicationDocument.selectedIndex].text;
        // let documentFile = document.getElementById("document_file");
       
        if (applicationDocument.value.length <= 0 ) { return;  }

        tbodyEl.innerHTML += `
            <tr id="${Date.now()}" class="text-gray-700 dark:text-gray-400" >
                <td class="px-4 py-3">
                 ${value}
                    <input type="hidden" name="application_document_file_id[]" value="${applicationDocument.value}">
                    <input type="file"
                     accept="application/pdf"
                     class="form-control
                              block
                              w-full
                              px-3
                              py-1.5
                              text-base
                              font-normal
                              text-gray-700
                              bg-white bg-clip-padding
                              border border-solid border-gray-300
                              rounded
                              transition
                              ease-in-out
                              m-0
                              focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                               name="application_files[]"
                               />                
                </td>
                <td class="px-4 py-3">${new Date().toISOString().slice(0, 10)} </td>
                <td class="px-4 py-3">

                    <button
                        type="button"
                        onclick="onDeleteRow(${Date.now()})"
                        class="px-1 py-2 text-sm font-medium leading-5 text-red-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                        aria-label="Delete">
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill="#e5494d" fill-rule="evenodd"
                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                    </button>
                </td>
            </tr>
        `;

       
      };


    function onDeleteRow(id) {
        var row = document.getElementById(id);
        row.parentNode.removeChild(row);
    }

</script>

@endsection
</x-app-layout>
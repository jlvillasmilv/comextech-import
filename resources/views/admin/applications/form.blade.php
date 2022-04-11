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
        

            <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.applications.update', $application->id) }}"  >
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

                <div class="w-full overflow-hidden rounded-lg shadow-xs">
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
                            <button class="flex px-4 py-2 mt-8 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-1300 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-1400 focus:outline-none focus:shadow-outline-blue">
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

                <div class="w-full overflow-hidden rounded-lg shadow-xs">
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

    function remove(id){

        const data = { id: id };
        
        Swal.fire({
            title: '¿Desea eliminar este registro?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Si',
            confirmButtonColor: '#142c44',
            cancelButtonText: 'No',
            showLoaderOnConfirm: true,
            preConfirm: () => {


                //POST request with body equal on data in JSON format
                fetch('{{ route("supplier.remove") }}', {
                method: 'POST',
                headers: {
                    "X-CSRF-Token": $('input[name="_token"]').val(),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
                })
                .then((response) => response.json())
                //Then with the data from the response in JSON...
                .then((data) => {
                    onDeleteRow(id);
                })
                //Then with the error genereted...
                .catch((error) => {
                console.error('Error:', error);
                });
            }
        });

    }
    
    const tbodyEl = document.querySelector("tbody");
    const tableEl = document.getElementById("table");

     // Agrega nuevo registro Direccion orgen tansporte 
     function addRow(tableID) {
       
        var table = document.getElementById("table");

        let applicationDocument = document.getElementById("application_document_file_id");
        let documentFile = document.getElementById("document_file");
       
        if (applicationDocument.value.length <= 0 || documentFile.length <= 0 ) { return;  }

        table.innerHTML += `
            <tr id="${Date.now()}">
                <td>
                 ${applicationDocument.value} 

                 ${applicationDocument.value}
                    <input type="hidden" name="application_document_file_id[]" value="${applicationDocument.value}">
                    <input type="hidden" name="application_file[]" value="${documentFile.value}" />                
                </td>
                <td>${Date.now()} </td>
                <td>
                    <button 
                    type="button" 
                    class="deleteBtn btn-add flex ml-2 px-3 py-1 my-8 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-1300 border border-transparent rounded-lg hover:bg-blue-1400 focus:outline-none focus:shadow-outline-blue"
                     onclick="onDeleteRow(${Date.now()})">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </td>
            </tr>
        `;

         documentFile.value = '';
       
      };


    function onDeleteRow(id) {
        var row = document.getElementById(id);
        row.parentNode.removeChild(row);
    }

</script>

@endsection
</x-app-layout>
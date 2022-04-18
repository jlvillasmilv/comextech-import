<div class="container grid px-6 mx-auto">
    <h2 class="mt-5 text-2xl font-semibold text-gray-700 dark:text-gray-200">
       Solicitudes
     </h2>

     <div class="flex justify-between items-end mb-1">
        <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
            Lista de Solicitudes
        </h4>
        <a href="{{ route('applications.create') }}"
            class="flex px-2 py-2 m-2  text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-1300 border border-transparent rounded-lg active:bg-blue-1300 hover:bg-blue-1200 focus:outline-none focus:shadow-outline-blue"
            title="Nueva Solicitud">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
            <span> Solicitud </span>
        </a>
    </div>

   <x-table.search />

   <div class="w-full overflow-hidden rounded-lg ring-1 ring-black ring-opacity-5  mb-8">
       <div class="w-full overflow-x-auto">
           <table class="w-full " id="table">
                <thead
                    class="text-xs text-center font-semibold tracking-wide text-white uppercase border-b dark:border-gray-700 bg-blue-1300 dark:text-gray-400 dark:bg-gray-800">
                    <tr>
                        <th class="px-4 py-3 cursor-pointer"
                         title="Numero de solicitud / Fecha registro">
                            @include('components.table.sort', ['field' => 'code', 'label' => 'Nro/Fecha'])
                        </th>
                        <th class="px-4 py-3 w-24"
                         title="Servicios Seleccionados">
                         SERVICIOS 
                        </th>
                        <th class="px-4 py-3"
                         title="Monto Total Operacion / Pago Proveedor">
                         M. TOTAL / PROVEEDOR
                        </th>
                        <th class="px-4 py-3 w-24">ETD/ETA</th>
                        <th class="px-4 py-3">Estatus </th>
                        <th class="px-4 py-3">Proveedor </th> 
                        <th class="px-4 py-3">Acciones</th> 
                        <th class="px-4 py-3">DOCUMENTOS </th> 
                    </tr>
                </thead>
               <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                   @forelse($datas as $application)
                   <tr class="text-gray-700 dark:text-gray-400 text-center border-b-2 border-gray-400"
                    wire:loading.class.delay="opacity-50"
                    id="{{ $application->id }}">
                       <td class="px-2 pb-2 text-center tex-sm ">
                           <div class="flex justify-center items-center">
                               <span class="iconify h-9 w-9" data-icon="{{ $application->typeTransport->icon }}"></span>
                           </div>
           
                           <p class="font-semibold text-md"> {{ $application->code }} </p>

                           <p class="text-gray-600 dark:text-gray-400 text-sm">
                               {{ date('d-m-y', strtotime($application->created_at)) }}
                           </p>
                       </td>
                       <td class="px-2 py-2  text-sm ">
                            
                        <div class="flex justify-center items-start mt-1">
                            <span 
                              class="iconify h-5 w-5 {{ in_array('ICS01', (array)explode(",", $application->services_code)) ? 'text-blue-1000' : 'text-gray-500' }} "
                              data-icon="vs:p-square"></span>
                        </div>
                        <div class="flex justify-center items-start mt-1">
                            <span class="iconify h-5 w-5 {{ in_array('ICS03', (array)explode(",", $application->services_code)) ? 'text-blue-1000' : 'text-gray-500' }} "
                             data-icon="vs:t-square"></span>
                        </div>
                        <div class="flex justify-center items-start mt-1">
                            <span class="iconify h-5 w-5 text-bg-red-300 {{ in_array('ICS04', (array)explode(",", $application->services_code)) ? 'text-blue-1000' : 'text-gray-500' }}"
                             data-icon="vs:a-square"></span>
                        </div>
                           
                       </td>
                       <td class="px-2 py-2 whitespace-nowrap">
                           <strong class="font-semibold"> 
                                {{ number_format($application->tco, ($application->currencyTco->code == 'CLP' ? 0 : 2) , ',', '.') }}
                                {{ $application->currencyTco->code }}
                           </strong>
                           <br>
                           <strong class="text-xs"> 
                                {{ number_format($application->amount, ($application->currency->code == 'CLP' ? 0 : 2) , ',', '.') }}
                                {{ $application->currency->code }}
                            </strong>
                       </td>
                       <td class="px-2 py-2  text-sm ">
                           @if (isset($application->transport->id))
                                {{ date('d-m-y', strtotime($application->transport->estimated_date)) }}
                                <br>
                                {{ is_null($application->transport->eta) ? '' : date('d-m-y', strtotime($application->transport->eta)) }}
                           @endif
                            
                       </td>
                       <td class="px-2 text-sm w-32 ">
                           {{-- Status application --}}
                           @include('livewire.client.application.status')
                       </td>
                       <td class="px-4 py-3 whitespace-nowrap">
                           <p class="font-semibold  text-md">
                               {{ $application->supplier->name }}
                           </p>
                       </td>
                       <td class="">
                            @include('livewire.client.application.actions')
                       </td>
                       <td class="py-3">
                            <a href="{{ route('applications.documents', \Crypt::encryptString($application->id)) }}"
                                class="px-2 py-2 text-sm font-medium transition-colors duration-150 bg-gray-200 border rounded-lg hover:bg-gray-300"
                                title="Documentos cargados a la solicitud">
                                <span> Finales </span>
                            </a>
                       </td>
                   </tr>
               @empty
                   <tr>
                       <td class="px-4 py-3 border-b-2 border-gray-400" colspan="6">
                           <div class="flex justify-center items-center">
                                <span class="font-medium py-4 text-cool-gray-400 text-xl">Sin solicitudes</span> 
                           </div>
                        </td>
                   </tr>
               @endforelse

            </tbody>
           </table>
       </div>
       <div class="sm:flex my-3 justify-between">
            <div class="w-full md:w-1/2 px-3">
                <select wire:model="perPage" class="flex w-1/2 pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-blue-300 focus:outline-none focus:shadow-outline-blue form-select ">
                @foreach($paginationOptions as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
            </div>
            {{ $datas->withQueryString()->links() }}
       </div>
       
        @include('livewire.client.application.modal')
   </div>
</div>

@section('scripts')
@parent
<script>

    livewire.on('setApplication', (applicationId, type) => {
       
        Swal.fire({
            title: type == 'setApplicationSummary' ? '¿Actualizar costos a tasa de cambio actual?' : '¿Desea eliminar este registro?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Si',
            confirmButtonColor: '#142c44',
            cancelButtonText: 'No',
            cancelButtonColor: '#d33',
            showLoaderOnConfirm: true,
            backdrop: true,
            preConfirm: function(result) {
                if (result) {

                    return @this.call(type,applicationId).then(() => {
                        Toast.fire({
                            icon: 'success',
                            title: type == 'setApplicationSummary' ? 'Generado con exito' : 'Registro eliminado con exito' ,
                        })
                    });

                 // livewire.emitTo('client.application-component', 'setApplicationSummary', applicationId)
                }

            },
            allowOutsideClick: () => !Swal.isLoading()
        })

    });
    
</script>

@endsection

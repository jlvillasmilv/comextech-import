@php
$impuesto_sii     = auth()->user()->FileStoreClient->where('type','impuesto_sii');
$carp_tributaria  = auth()->user()->FileStoreClient->where('type','carp_tributaria');
$credential       = auth()->user()->credentialStores;
@endphp
                
 
<x-app-layout title="Solicitudes">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Listado de Solicitudes
        </h2>

        @if(!$credential->provider_password)
            @if($impuesto_sii->isEmpty() ||  $carp_tributaria->isEmpty())


            <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
                Atencion!
            </h4>

            <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Estamos a la espera de tu <a  class="alert-link">  Carpetas Tributarias Actualizadas y la Última declaracion de Impuesto Renta (SII) </a> para aprobar tu Solicitud <a href="client#/finacial-information" class="text-sm text-gray-700 underline"> Inserta tus documentos aqui! </a>
                    <hr>
                </a>  Ingresa <a href="/client#/providers" class="text-sm text-gray-700 underline">  tu contraseña del SII  a nuestro sistema </a>y  agiliza tu proceso! 
                </p>
            </div>

            @endif 
        @endif

        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
            <!-- Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Total Solicitudes
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{$applications->count()}}
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Solicitudes Aceptadas
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{$aprobadas}}
                    </p>
                </div>
            </div>

             <!-- Card -->
             <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Solicitudes en Proceso
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{$proceso}}
                    </p>
                </div>
            </div>

            <!-- Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Solicitudes Rechazadas
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{$rechazada}}
                    </p>
                </div>
            </div>
        </div>

        <!-- Application list table -->
        <div class="grid gap-6 mb-8 ">
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                    Listado de Solicitudes
                </h4>
                <div class="w-full overflow-x-auto">
                    <table  id="table" class="w-full whitespace-no-wrap">
                        <thead>
                            <tr
                                class="text-xs text-center font-semibold tracking-wide text-left text-white border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">N°</th>
                                <th class="px-4 py-3">Fecha</th>
                                <th class="px-4 py-3">Cant. <br> Facturas</th>
                                <th class="px-4 py-3">Monto</th>
                                <th class="px-4 py-3">Diferencia <br> Precio</th>
                                <th class="px-4 py-3">Comisión</th>
                                <th class="px-4 py-3">Descuento</th>
                                <th class="px-4 py-3">Desembolso</th>
                                <th class="px-4 py-3">Excedentes</th>
                                <th class="px-4 py-3">Estado</th>
                                <th class="px-4 py-3">Detalle</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            @forelse($applications->sortBy('status') as $application)
                            <tr class="text-gray-700 dark:text-gray-400 text-center">
                                <td class="px-4 py-3 text-center ">
                                    <div>
                                        <p class="font-semibold">
                                            {{str_pad($application->id, 6, '0', STR_PAD_LEFT) }}
                                        </p>
                                    </div>
                             
                                </td>
                                <td class="px-2 py-2  text-sm">
                                    <span class="px-2 py-1 dark:text-white ">
                                        {{ date_format($application->created_at, 'd-m-y') }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="px-2 py-1 dark:text-white ">
                                        {{ $application->invoices->count('number') }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="px-2 py-1 dark:text-white ">
                                        {{number_format($application->invoices->sum('total_amount'),0,",",".")}}

                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 dark:text-white ">
                                        @php
                                        $dif_total = 0;  
                                        @endphp
                                    
                                        @foreach ($application->invoices as $key=> $invoice)
        
                                        @php
                                        
                                        $dif = (($invoice->feesHistory->rate / 100) * ($invoice->feesHistory->discount / 100) * $invoice->total_amount * ($invoice->payment_real / 30)); 
                                        $dif_total += $dif;
                                        @endphp
                                
            
                                        @endforeach
                                        {{number_format($application->invoices->sum('price_difference'),0,",",".")}}
                                    </span>
                                </td>  

                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 dark:text-white ">
                                        

                                        @php
                                        $com_total = 0;  
                                        @endphp
                                    
                                        @foreach ($application->invoices as $key=> $invoice)
        
                                            @php
                                            
                                            $dif = $invoice->feesHistory->commission;
                                            $com_total += $dif;
                                            @endphp
                                
                                        @endforeach
        
                                        {{number_format($com_total,0,",",".") }}

                                    </span>
                                </td> 
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 leading-tight rounded-full dark:text-white ">
                                        {{number_format($com_total + $application->invoices->sum('price_difference'),0,",",".")}}
                                    </span>
                                </td>  
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 leading-tight rounded-full dark:text-white ">
                                        {{number_format($application->invoices->sum('disbursement'),0,",",".")}}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 leading-tight rounded-full dark:text-white ">
                                        {{number_format($application->invoices->sum('surplus'),0,",",".")}}
                                    </span>
                                </td>   
                                <td class="px-4 py-3">
                                   

                                    <span title="{{$application->status}}" style="font-size: 15px; color: {{ App\Models\Factoring\Application::STATUS_COLOR[$application->status] ?? 'none' }};">
                                        <i class="{{ App\Models\Factoring\Application::STATUS_ICON[$application->status] ?? 'none' }}" aria-hidden="true"> </i>
                                    </span><br>
                                    <span class="px-2 py-1 leading-tight rounded-full dark:text-white ">
                                        {{$application->status}}
                                    </span>
                                   

                                </td>    
                                <td class=" py-3" >
                                    <div class="flex flex-nowrap">
                                     <a  
                                    href="{{ route('factoring.applications.show', base64_encode($application->id)) }}" 
                                        class="px-2 py-2  text-sm font-medium leading-5 text-green-300 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                        aria-label="Edit">
                                       
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                            viewBox="0 0 20 20">
    
                                              <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                             
                                              <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                            
                                        </svg>
                                    </a>

                                    @if (!$application->disbursement_status and  $application->status == 'Aprobada')      
                                        <a data-remote="{{ route('factoring.applications.update', base64_encode($application->id)) }}"
                                            href="#"
                                            class="px-2 py-2 text-sm font-medium leading-5 text-dark-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray btn-status"
                                            aria-label="Desembolso">
                                        
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-6 w-6" 
                                             fill="none" 
                                             viewBox="0 0 24 24" 
                                             stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" 
                                                stroke-width="2" 
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                        </a>
                                    @endif
    
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr class="text-gray-700 dark:text-gray-400 text-center">
                                    <td class="py-3" colspan="11">No entries found.</td>
                                </tr>
                            @endforelse
                            
                        </tbody>
                    </table>
                    {{ $applications->links() }}
                </div>
            </div>
    </div>



    

</x-app-layout>



@section('scripts')
@parent

<script>

$.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 10,
  });
  let table = $('.datatable-Project:not(.ajaxTable)').DataTable({ language: {
                    url: '{{asset("js/lang.json")}}'
                } }).columns.adjust();
  
</script>
@endsection


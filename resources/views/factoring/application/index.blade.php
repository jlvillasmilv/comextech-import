@php
$impuesto_sii     = auth()->user()->FileStoreClient->where('type','impuesto_sii');
$carp_tributaria  = auth()->user()->FileStoreClient->where('type','carp_tributaria');
$credential       = auth()->user()->credentialStores;
@endphp
                
 
<x-app-layout title="Solicitudes">
    <div class="container grid px-6 mx-auto">
        <h2 class="mt-4 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Listado de Solicitudes
        </h2>

        @if(!$credential->provider_password)
            @if($impuesto_sii->isEmpty() ||  $carp_tributaria->isEmpty())


            <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
                Atencion!
            </h4>

            <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    No se ah ingresado información de su empresa. Recomendamos actualizar la información de su empresa

                    <a  href="{{route('company.index')}}" class="text-sm text-blue-700 underline">(ingresa aqui)</a>
                    para completar la información para cargar su información del SII
                </p>
            </div>

            @endif 
        @endif

        <view-quote></view-quote> 

        <!-- Application list table -->
        <div class="grid gap-6 mb-4 ">
            <div class="min-w-0 px-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                    Listado de Solicitudes
                </h4>
                <div class="w-full overflow-x-auto">
                    <table  id="table" class="w-full whitespace-no-wrap">
                        <thead>
                            <tr
                                class="text-xs text-center font-semibold tracking-wide text-left text-white border-b dark:border-gray-700 bg-blue-1300 dark:text-gray-400 dark:bg-gray-800">
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
                                            {{$application->code }}
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
                                
                                    <!-- <span title="{{$application->status}}" style="font-size: 15px; color: {{ App\Models\Factoring\Application::STATUS_COLOR[$application->status] ?? 'none' }};">
                                        <i class="{{ App\Models\Factoring\Application::STATUS_ICON[$application->status] ?? 'none' }}" aria-hidden="true"> </i>
                                    </span><br> -->
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
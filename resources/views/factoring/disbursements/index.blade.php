
<x-app-layout title="Desembolsos">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Abonos
        </h2>

     
        @include('factoring.disbursements.summary')

        <!-- Application list table -->
        <div class="grid gap-6 mb-8 ">
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                    Listado de Abonos
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
                                <th class="text-center">Giro a Recibir</th>
                                <th class="text-center">Mora</th>
                                <th class="text-center">Excedentes</th>
                                <th class="text-center">Estatus </th>
                                <th class="text-center">Requisitos</th>
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
                                        @php
                                        $date_payment = is_null($application->disbursement->date_payment) ? date("Y-m-d") : $application->disbursement->date_payment;
                                        
                                        $morat = 0;

                                        @endphp

                                        @foreach ($application->invoices as $invoice) 
                                        @php
                                            $rate  = $invoice->feesHistory->mora_rate / 100;
                                            $mount = $invoice->total_amount * ( $invoice->feesHistory->discount / 100);
                                            $expire_date = $invoice->expire_date;
                                            $date1 = date_create($expire_date);
                                            $date2 = date_create($date_payment);
                                            $payment_real = date_diff($date1, $date2);

                                            $mora = ($payment_real->format("%r%a") * $mount *  $rate) /30 ;

                                            $mora = $mora <= 0 ? 0 : $mora;

                                            $morat += $mora;
                                            @endphp
                                        @endforeach

                                        {{number_format($morat,0,",",".")}}
                                    </span>
                                </td>   
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 leading-tight rounded-full dark:text-white ">
                                        {{number_format($application->invoices->sum('surplus') - $morat,0,",",".")}}
                                    </span>
                                   

                                </td>    
                                <td class="px-4 py-3" >
                                    <i  style="color: {{ App\Models\Factoring\Disbursement::STATUS_COLOR[$application->disbursement->status] ?? 'none' }}" class="{{ App\Models\Factoring\Disbursement::STATUS_ICON[$application->disbursement->status] ?? 'none' }}"> </i>
                                    @php
                                            $status = strtolower($application->disbursement->status);
                                            $status = ucfirst($status);
                                    @endphp
                                    <p class="text-gray-500">  {{  $status  ?? ''}} </p>
                                   
                                </td>
                                <td class="px-4 py-3" >
                                   
                                    <a  href="{{ route('factoring.disbursements.show', base64_encode($application->id)) }}"
                                        class="px-2 py-2 text-sm font-medium leading-5 text-yellow-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                        aria-label="Desembolso">
                                    
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm14 1a1 1 0 11-2 0 1 1 0 012 0zM2 13a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2zm14 1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd" />
                                          </svg>
                                    </a>
                                
                                </td>
                            </tr>
                            @empty
                                <tr class="text-gray-700 dark:text-gray-400 text-center">
                                    <td class="py-3" colspan="11">No entries found.</td>
                                </tr>
                            @endforelse
                            
                        </tbody>
                    </table>
                    {{-- {{ $applications->links() }} --}}
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


<div class="w-full overflow-x-auto">
    <table  id="table" class="w-full whitespace-no-wrap">
        <thead>
            <tr
                class="text-xs text-center font-semibold tracking-wide text-left text-white border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800">

                <th class="px-4 py-3">Folio</th>
                <th class="px-4 py-3">RUT</th>
                <th class="px-4 py-3">Pagador </th>
                <th class="px-4 py-3">Emision </th>
                <th class="px-4 py-3">Expira</th>
                <th class="px-4 py-3">Monto <br> Total </th>
                <th class="px-4 py-3">Dif Precio</th>
                <th class="px-4 py-3">Comisión</th>
                <th class="px-4 py-3">Descuento</th>
                <th class="px-4 py-3">Giro a Enviar</th>
                <th class="px-4 py-3">Mora</th>
                <th class="px-4 py-3">Excedentes</th>
                <th class="px-4 py-3">Detalles <br> Pagador </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
            @forelse($data->application->invoices as $invoice)

          <tr class="text-gray-700 dark:text-gray-400 text-xs text-center">
                <td class="px-2 py-3 text-center">
                    {{ $invoice->number}}
                </td>
                <td class="px-4 py-3 text-center ">
                    {{ $invoice->payer->name}}
                </td>
                <td class="px-4 py-3 text-center ">
                    {{ $invoice->payer->format_rut}}
                </td>
                <td class="px-4 py-3 text-center ">
                    {{  date("d-m-y", strtotime($invoice->issuing_date))}}
                </td>
                <td class="px-4 py-3 text-center ">
                    {{  date("d-m-y", strtotime($invoice->expire_date))}}
                </td>
                <td class="px-4 py-3 text-center ">
                    {{ '$ '.number_format($invoice->total_amount,0,",",".")  }} 
                </td>
                <td class="px-4 py-3 text-center ">
                    {{ '$ '.number_format($invoice->price_difference,0,",",".")  }}
                </td>
            
                <td class="px-4 py-3 text-center ">
                      {{number_format($invoice->feesHistory->commission,0,",",".") }}
                </td>
            
                <td class="px-4 py-3 text-center ">
                    {{number_format(($invoice->price_difference + $invoice->feesHistory->commission),0,",",".") }}
                </td>
            
                <td class="px-4 py-3 text-center ">  
                    {{number_format($invoice->disbursement,0,",",".")}}
                 </td>
                
                 <td class="px-4 py-3 text-center ">
                    @php
                    $mora = 0;
                    $rate = $invoice->feesHistory->mora_rate / 100;
                    $mount = $invoice->total_amount * ( $invoice->feesHistory->discount / 100) ;
                    $expire_date = $invoice->expire_date;
                    $date1 = date_create($expire_date);
                    $date2 = date_create($date_payment);
                    $payment_real = date_diff($date1, $date2);
                    $mora = ($payment_real->format("%r%a") * $mount *  $rate) /30 ;
                    $morat = $mora <= 0 ? 0 : $mora;
                 @endphp
                    {{number_format($morat ,0,",",".")}}   
                 </td>
                 <td class="px-4 py-3 text-center ">
                    {{number_format((($invoice->feesHistory->discount / 100) * $invoice->total_amount) - $morat ,0,",",".")}}
                 </td>
                 <td class="px-4 py-3 text-center ">
                    <a  href="{{route('admin.factoring.fee_history.show', base64_encode($invoice->payer->id))}}"class="text-blue-400 rounded-lg dark:text-gray-400" > 
        
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        
                    </a>
                   
                </td>
            </tr>
          @empty
              
          @endforelse
            
        </tbody>
      </table>
      
  </div>
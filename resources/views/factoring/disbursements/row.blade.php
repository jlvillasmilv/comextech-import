@forelse ($applications->invoices as $invoice)

    @php
        $date_payment = is_null($applications->disbursement->date_payment) ? date("Y-m-d") : $applications->disbursement->date_payment;
        $mora = 0;
        $rate =$invoice->feesHistory->mora_rate / 100;
        $mount = $invoice->total_amount * ( $invoice->feesHistory->discount / 100);
        $expire_date = $invoice->expire_date;
        $date1 = date_create($expire_date);
        $date2 = date_create($date_payment);
        $payment_real = date_diff($date1, $date2);
        $mora = ($payment_real->format("%r%a") * $mount *  $rate) /30 ;
        $morat = $mora <= 0 ? 0 : $mora;
    @endphp

<tr class="text-gray-700 dark:text-gray-400 text-center">
     <td class="px-4 py-3 text-center">
        {{ $invoice->number}}
        <br>
        {{  date("d-m-y", strtotime($invoice->issuing_date))}}
    </td>
    <td class="px-4 py-3 text-center">
        <p style="font-size: 10.5px" class="text-center text-uppercase mb-0" >
            {{ $invoice->payer->name}}
        </p>
        <b  style="font-size: 14px" class="text-center">
            {{ $invoice->payer->format_rut}} 
        </b>
    </td>

    <td class="px-4 py-3 text-center">
        <strong class="text-primary">
            {{ number_format($invoice->feesHistory->rate,2,",",".").' %'  }}
        </strong>
        <br>
        {{ number_format($invoice->feesHistory->mora_rate,2,",",".").' %'  }}
    </td>

    <td class="px-4 py-3 text-center">
        {{ '$ '.number_format($invoice->total_amount,0,",",".")  }} 
        <br>
        {{ '$ '.number_format($invoice->disbursement,0,",",".")}}
    </td>

    <td class="px-4 py-3 text-center"> 
        {{  '$ '.number_format($invoice->feesHistory->commission,0,",",".") }} 
        <br>
        {{ '$ '.number_format($invoice->price_difference,0,",",".")  }}
    </td>

    <td class="px-4 py-3 text-center">
        {{ number_format($invoice->feesHistory->discount,0,",",".").' %'  }}
        <br>
        {{ number_format($invoice->surplus - $morat,0,",",".") }}
    </td>

    <td class="px-4 py-3 text-center">
        {{  date("d-m-y", strtotime($invoice->expire_date))}}
    </td>
    
     <td class="px-4 py-3 text-center">
        {{number_format($morat,0,",",".")}}
     </td>
</tr>
    
@empty

<tr>
    <td colspan="7" class="text-center">  No tienes solicitudes</td> 
</tr>                    
@endforelse
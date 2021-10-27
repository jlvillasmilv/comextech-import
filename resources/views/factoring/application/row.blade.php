<tr>
    <td role="row"  class="text-center ">
        {{ $invoice->number}}
    </td>
    <td role="row"  class="text-center ">
        {{ $invoice->payer->name  }}
    </td>
    <td role="row"  class="text-center ">
        {{ $invoice->payer->format_rut  }}
    </td>
    <td role="row"  class="text-center ">
        {{  date("d-m-y", strtotime($invoice->issuing_date))}}
    </td>
    <td role="row"  class="text-center ">
        {{  date("d-m-y", strtotime($invoice->expire_date))}}
    </td>
    <td role="row"  class="text-center ">
        {{ '$ '.number_format($invoice->total_amount,0,",",".")  }} 
    </td>
    <td role="row"  class="text-center ">
        {{ '$ '.number_format($invoice->price_difference,0,",",".")  }}
    </td>

    <td role="row"  class="text-center ">   {{number_format($invoice->feesHistory->commission,0,",",".") }}   </td>

    <td role="row"  class="text-center "> {{number_format(($invoice->price_difference + $invoice->feesHistory->commission),0,",",".") }} </td>

    <td role="row"  class="text-center ">  
        {{number_format($invoice->disbursement,0,",",".")}}
    </td>
    <td role="row"  class="text-center ">
        {{number_format($invoice->surplus,0,",",".")}}
    </td>
    {{-- <td role="row"  class="text-center ">
        @php
            $mora = 0;

            $rate =$invoice->feesHistory->mora_rate / 100;

            $mount = $invoice->total_amount;

            $expire_date = $invoice->expire_date;

            $date1 = date_create($expire_date);
            $date2 = date_create(date("Y-m-d"));
            $payment_real = date_diff($date1, $date2);

            $mora = $payment_real->days * $mount * ( $rate /30) ;

        @endphp
        {{number_format($mora,0,",",".")}}
    </td> --}}
</tr>
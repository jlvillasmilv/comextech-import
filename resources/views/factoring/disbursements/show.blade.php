<x-app-layout title="Detalles de la Solicitud">

 
  @php
    $invoices_sii    = $applications->disbursement->assign_invoices_sii;
    $tax_folder      = $applications->disbursement->tax_folder;
    $declaration_sii = $applications->disbursement->tax_declaration_sii;
    $tax_debt = $applications->disbursement->tax_debt;
    $annex    = $applications->disbursement->assignment_annex;
    $accountStatus = !isset($bankAccounts)? 0:1;
    $size = 12;  
    $sii = auth()->user()->credentialStores()->where('provider_name', 'SII')->first();

  @endphp


  <div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        <a href="{{route('factoring.disbursements.index')}}">Desembolso</a> 
    </h2>

    <div class="grid gap-6 mb-8 ">
      <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <p class="font-semibold  dark:text-white ">Estado: {{$applications->disbursement->status}} </p>
          <br>
          @if($applications->disbursement->status === 'PENDIENTE' || $applications->disbursement->status === 'RECHAZADO')
          {{--invoices uploaded in XML way --}}
          @empty($sii)
            @php
                $size = 9;
            @endphp
            @include('factoring.disbursements.requirements')
          @endempty
          @endif
          <div class="w-full overflow-x-auto">
              <table  id="table" class="w-full whitespace-no-wrap">
                  <thead>
                      <tr
                          class="text-xs text-center font-semibold tracking-wide text-left text-white border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800">
                      
                          <th class="px-4 py-3"> <b>Factura</b> <br> Folio / Emisión </th>
                          <th class="px-4 py-3"> <strong>Pagador</strong><br>Nombre / RUT </th>
                          <th class="px-4 py-3"> <strong>Tasa</strong> <br> Fcto / Mora </th>
                          <th class="px-4 py-3"> <strong>Montos</strong> <br> Factura/ Desembolso</th>
                          <th class="px-4 py-3"> <strong>Costos</strong> <br> Comisión/ Dif. Precio</th>
                          <th class="px-4 py-3"> <strong>Operación</strong> <br> Fcto/ Excedentes</th>
                          <th class="px-4 py-3"> Vencimiento</th>
                          <th class="px-4 py-3"> Mora</th>
                      </tr>
                  </thead>
                  <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @include('factoring.disbursements.row')
                  </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>
 
</x-app-layout>

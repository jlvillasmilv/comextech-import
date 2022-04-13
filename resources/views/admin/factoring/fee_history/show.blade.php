<x-app-layout title="Detalle Desembolso / Solicitud">


  <div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        <a href="{{route('admin.factoring.fee_history.index')}}">Base de calculo</a> 
    </h2>


    <div class="grid gap-6 mb-8 ">
      <div class="min-w-0 p-4 bg-white rounded-lg ring-1 ring-black ring-opacity-5 dark:bg-gray-800">
    
      {{-- <p class="card-text text-uppercase font-weight-bol "> <strong class="font-bold"> TASA ACTUAL </strong></p>
      <h6 class="card-title  text-uppercase font-weight-bold">Cliente: {{ $data->application->user->company->name }}</h6> --}}
      <h6 class="my-2">Pagador: <b> {{ $data->payer->format_rut}} {{ $data->name}} </b></h6>
      <p class="my-2">Tasa:     <b> {{ $data->feeshistory->isNotEmpty() ? $data->feeshistory->last()->rate  : 0  }}  % </b></p>
      <p class="my-2">Tasa Mora:<b> {{ $data->feeshistory->isNotEmpty() ? $data->feeshistory->last()->mora_rate : 0  }}  %  </b></p>
      <p class="my-2">Descuento:<b> {{ $data->feeshistory->isNotEmpty() ? $data->feeshistory->last()->discount  : 0  }}  % </b></p>
      <p class="my-2">Comisión: <b> {{ $data->feeshistory->isNotEmpty() ? $data->feeshistory->last()->commision : 0  }}  %</b></p>
      <p class="my-2">Fecha:    <b> {{ $data->feeshistory->isNotEmpty() ? $data->feeshistory->last()->fee_date  : '' }}   </b></p> 
         
      </div>
    </div>
</div>


 
</x-app-layout>

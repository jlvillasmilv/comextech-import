<x-app-layout title="Detalle Desembolso / Solicitud">


  <div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        <a href="{{route('admin.factoring.disbursements.index')}}">Desembolso</a> 
    </h2>


    <div class="grid gap-6 mb-8 ">
      <div class="min-w-0 p-4 bg-white rounded-lg ring-1 ring-black ring-opacity-5 dark:bg-gray-800">
        <h6 class="card-title  text-uppercase font-weight-bold">Cliente: {{ $data->application->user->company->name }}</h6>
        <p class="my-2"> RUT: <strong class="font-bold">{{ $data->application->user->company->tax_id }}</strong></p>
        <p class="my-2">STATUS: <b>{{ $data->status}}</b></p> 
         
        <div class="grid gap-6 my-8 ">
		  
            @include('admin.factoring.disbursements.table')

        </div>
      </div>
    </div>
</div>


 
</x-app-layout>

<x-app-layout title="Detalles de la Solicitud">
  <div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        <a href="{{route('admin.factoring.applications.index')}}">Solicitudes</a> 
    </h2>

    <div class="grid gap-6 mb-8 ">
      <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
           Solicitud # {{str_pad($data->id, 6, '0', STR_PAD_LEFT) }}
        </h4>
        <p class="font-bold mb-2">Cliente: {{ $data->user->company->name}}</p>
        <p class="font-bold">RUT:  {{ $data->user->company->tax_id}}  </p> 

        <p class="font-semibold  dark:text-white ">Estado: 
          
            <span title="{{$data->status}}" style="font-size: 20px; color: {{ App\Models\Factoring\Application::STATUS_COLOR[$data->status] ?? 'none' }};">
                <i class="{{ App\Models\Factoring\Application::STATUS_ICON[$data->status] ?? 'none' }}" aria-hidden="true"></i>
            </span>
            
          </p>
          <p class="font-semibold  dark:text-white ">Comentario 1: {{ $data->observation}}</p>
          <p class="font-semibold  dark:text-white ">{{ $data->description}}</p>
          <br>
          <div class="w-full overflow-x-auto">
             
            @include('admin.factoring.application.table')
                
          </div>
        </div>
    </div>
</div>
 
</x-app-layout>

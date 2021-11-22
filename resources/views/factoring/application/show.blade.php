<x-app-layout title="Detalles de la Solicitud">
  <div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        <a href="{{route('factoring.applications.index')}}">Solicitudes</a> 
    </h2>

    <div class="grid gap-6 mb-8 ">
      <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
           Solicitud # {{$applications->code}}
        </h4>
        <p class="font-semibold  dark:text-white ">Estado: 
          
            <span title="{{$applications->status}}" style="font-size: 20px; color: {{ App\Models\Factoring\Application::STATUS_COLOR[$applications->status] ?? 'none' }};">
                <i class="{{ App\Models\Factoring\Application::STATUS_ICON[$applications->status] ?? 'none' }}" aria-hidden="true"></i>
            </span>
            
          </p>
          <p class="font-semibold  dark:text-white ">Comentario 1: {{ $applications->observation}}</p>
          <p class="font-semibold  dark:text-white ">{{ $applications->description}}</p>
          <br>
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
                    @each('factoring.application.row', $applications->invoices, 'invoice')
                  </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>
 
</x-app-layout>

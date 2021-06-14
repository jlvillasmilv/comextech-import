<x-app-layout title="Formulario de registro">
	<div class="container grid px-6 mx-auto">
        <h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{route('admin.applications.index')}}">Solicitudes</a>  
        </h2>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Detalle Solicitud  #   {{str_pad($application->id, 6, '0', STR_PAD_LEFT) }}
            </h4>
           
        </div>

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        

            <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.applications.update', $application->id) }}"  >
                @csrf
                 @if(isset($application))
		           @method('PUT')
		        @endif

                <div class="w-full overflow-hidden rounded-lg shadow-xs">
                    <div class="w-full overflow-x-auto">
        
                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400">Status</span>
                            <select name="application_statuses_id" id="application_statuses_id" class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-select select2  @error('application_statuses_id') is-invalid @enderror">

                                @foreach($status as $id => $name)

                                    @if(old('application_statuses_id', isset($application->application_statuses_id) && $application->application_statuses_id == $id) )
                                        <option value="{{ $id }}" selected>{{ $name }}</option>
                                    @else
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endif

                                @endforeach
                            </select>
                            @if($errors->has('application_statuses_id'))
                                 <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('application_statuses_id') }}
                                </span>
                            @endif
                        </label>
        
                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-bold mb-2">Cliente:</span>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                {{$application->user->company->tax_id}} {{$application->user->company->name}} 
                            </p>
                        </label>
        
                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400 font-bold mb-2 dark:text-gray-300">Descripccion:</span>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300 dark:text-gray-300">
                                {{$application->description}} 
                            </p>
                        </label>

                        <div class="px-2">
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400 font-bold mb-2 dark:text-gray-300">Monto de la operación:</span>
                                <p class="text-grey-dark mb-2 text-sm dark:text-gray-300 dark:text-gray-300">
                                    {{ $application->currency->code }} {{ $application->currency->symbol }} {{number_format($application->amount,0,",",".") }} 
                                </p>
                            </label>
                        </div>
        
                        <div class="px-2">
                            <div class="flex mb-4">
                                <div class="w-1/2 mr-1">
                                    <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Adelanto</label>
                                    <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                        {{ $application->fee1 }} %  fecha: {{ date('d-m-Y', strtotime($application->fee1_date)) }}
                                    </p>
                                </div>
                                <div class="w-1/2 ml-1">
                                    <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" >Saldo</label>
                                    <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                        {{ $application->fee2 }} % fecha: {{ date('d-m-Y', strtotime($application->fee2_date)) }}
                                    </p>
                                </div>
                            </div>
                        </div>
        
                        <div class="px-2">
                            <div class="flex mb-4">
                                <div class="w-1/2 mr-1">
                                    <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Fecha Solicitud:</label>
                                    <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                        {{ date('d-m-Y', strtotime($application->created_at)) }}
                                    </p>
                                </div>
                                <div class="w-1/2 ml-1">
                                    <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" >Fecha estimada</label>
                                    <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                        {{ date('d-m-Y', strtotime($application->estimated_date)) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full overflow-hidden rounded-lg shadow-xs">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr
                                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-4 py-3">Servicio </th>
                                    <th class="px-4 py-3">MO </th>
                                    <th class="px-4 py-3">Monto </th>
                                    <th class="px-4 py-3">&nbsp; </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                @forelse($application->details as $detail)
                                <tr class="text-gray-700 dark:text-gray-400">
                            
                                    <td class="px-4 py-3 text-sm">
                                        <p class="font-semibold">{{ $detail->service->name }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-xs">
                                        {{ $detail->currency->code }}  {{ $detail->currency->symbol }}   {{number_format($detail->amount,0,",",".") }}
                                    </td>
                                  
                                    <td class="px-4 py-3 text-sm">
                                        {{ $detail->currency2->code }}  {{ $detail->currency2->symbol }}  {{number_format($detail->amount2,0,",",".") }}
                                    </td>

                                    <td>
                                        <a href="#" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                        aria-label="Delete">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        </a>
                                    </td>
                                    
                                </tr>
             
                                @empty
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3 text-sm" colspan="5">No entries found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

      		</form>

	</div>
</x-app-layout>
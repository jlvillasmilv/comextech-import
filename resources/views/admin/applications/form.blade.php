<x-app-layout title="Formulario de registro">
	<div class="container grid px-6 mx-auto">
        <h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{route('admin.applications.index')}}">Solicitudes</a>  
        </h2>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Detalle Solicitud  # {{$application->id}}
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
                                <span class="text-gray-700 dark:text-gray-400 font-bold mb-2 dark:text-gray-300">Dias a partir del adelanto:</span>
                                <p class="text-grey-dark mb-2 text-sm dark:text-gray-300 dark:text-gray-300">
                                    {{$application->day_pay}} 
                                </p>
                            </label>
                        </div>
        
                        <div class="px-2">
                            <div class="flex mb-4">
                                <div class="w-1/2 mr-1">
                                    <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Adelanto</label>
                                    <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                        {{ $application->fee1 }} %
                                    </p>
                                </div>
                                <div class="w-1/2 ml-1">
                                    <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" >Saldo</label>
                                    <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                        {{ $application->fee2 }} %
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
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                @forelse($application->details as $detail)
                                <tr class="text-gray-700 dark:text-gray-400">
                            
                                    <td class="px-4 py-3 text-sm">
                                        <p class="font-semibold">{{ $detail->service->name }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-xs">
                                        <div class="flex items-center text-sm">                                 
                                            {{ $detail->currency->code }}  {{ $detail->currency->symbol }}   {{number_format($detail->amount,0,",",".") }}
                                        </div>
                                        
                                    </td>
                                  
                                    <td class="px-4 py-3 text-sm">
                                        {{ $detail->currency2->code }}  {{ $detail->currency2->symbol }}  {{number_format($detail->amount2,0,",",".") }}
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
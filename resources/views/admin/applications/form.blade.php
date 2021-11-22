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


                <div class="flex flex-wrap">
                    <div class="sm:w-full md:w-2/4 px-2 ">

                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400">Status</span>
        
                            <select name="application_statuses_id" id="application_statuses_id" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray  @error('application_statuses_id') is-invalid @enderror">

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

                    </div>
                    <div class="md:w-2/4 px-3 sm:w-full">
                        <div class="flex justify-start mt-1">
                            <button class="flex px-4 py-2 mt-8 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
								<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2h2m3-4H9a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-1m-1 4l-3 3m0 0l-3-3m3 3V3" />
								 </svg>
								<span> Guardar </span>
							</button>
                          </div>

                    </div>
                </div>

                <div class="w-full overflow-hidden rounded-lg shadow-xs">
                    <div class="w-full overflow-x-auto">
        
                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400">Status</span>
                          
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
                            <div class="flex mb-4">
                                <div class="w-1/2 mr-1">
                                    <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Monto de la operación:</label>
                                    <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                        {{ $application->currency->code }} {{ $application->currency->symbol }} {{number_format($application->amount,0,",",".") }} 
                                    </p>
                                </div>
                                <div class="w-1/2 ml-1">
                                    <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" >Condicion de Venta del Proveedor</label>
                                    <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                        {{ $application->condition }} 
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
                               
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between items-end">
                    <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                        Detalle Solicitud 
                    </h4>
                </div>
                
                @include('admin.applications.services')
                

                <div class="w-full overflow-hidden rounded-lg shadow-xs">

                    <span class="text-xs text-red-600 dark:text-red-400">
                        {!! session()->get('error') !!} 
                    </span>
                    @if ($application->status->modify)
                        
                    <div class="px-2" id="add_services">
                        <div class="flex mb-4">
                            <div class="w-1/2 mr-1">
                                <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Servicio:</label>
                                <select name="services_id" id="services_id" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray ">

                                    @foreach($services as $id => $name)

                                        <option value="{{ $id }}">{{ $name }}</option>
    
                                    @endforeach
                                </select>
                                <span id="services_idError" class="text-xs text-red-600 dark:text-red-400">
                                    <strong></strong>
                                </span>
                            </div>
                            <div class="w-1/2 ml-1">
                                <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" >Moneda</label>
                                <select id="_currency_id" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray  ">

                                    @foreach($currencies as $id => $name)
                                       <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                                <span id="currency_idError" class="text-xs text-red-600 dark:text-red-400">
                                    <strong></strong>
                                </span>
                            </div>

                            <div class="w-1/2 ml-1">
                                <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" > Monto origen</label>

                                <input type="number" class=" block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Monto Origen" id="_amount" >

                                <span id="amountError" class="text-xs text-red-600 dark:text-red-400">
                                    <strong></strong>
                                </span>
                                
                            </div>

                            <div class="w-1/2 ml-1">
                                <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" >Moneda</label>
                                <select id="_currency2_id" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray  ">  
                                    @foreach($currencies as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                 @endforeach
                                </select>

                                <span id="currency2_idError" class="text-xs text-red-600 dark:text-red-400">
                                    <strong></strong>
                                </span>
                            </div>

                            <div class="w-1/2 ml-1">
                                <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" > Monto </label>

                                <input type="number" class=" block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Monto"  id="_amount2" >

                                <span id="amount2Error" class="text-xs text-red-600 dark:text-red-400">
                                    <strong></strong>
                                </span>
                                
                            </div>

                            
                            
                                <button id="add" type="button" class="btn-add flex ml-2 px-3 py-1 my-8 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue" 
                                data-remote="{{route('admin.applications.store')}}" data-id="{{$application->id}}"
                                title="Agregar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                     </svg>

                                </button>
                        </div>
                    </div>
                    @endif


                  
                    <div class="w-full overflow-x-auto">
                        <table id="table" class="w-full whitespace-no-wrap">
                            <thead>
                                <tr
                                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-4 py-3">Servicio </th>
                                    <th class="px-4 py-3">Moneda / Monto origen </th>
                                    <th class="px-4 py-3">Monto </th>
                                    @if ($application->status->modify)<th class="px-4 py-3">&nbsp; </th> @endif
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                @forelse($application->details as $detail)
                                <tr class="text-gray-700 dark:text-gray-400" id="{{$detail->id}}">
                            
                                    <td class="px-4 py-3 text-sm">
                                        <input type="hidden"  name="service_id[]" value="{{ old('service_id', isset($detail) ? $detail->service_id : '') }}" >

                                        <p class="font-semibold">{{ $detail->service->name }}</p>
                                    </td>
                                    <td class="px-4 py-3 ">

                                            <div class="flex ">
                                                <div class="w-1/2 mr-1">
                                                   
                                                    <select name="currency_id[]" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray  @error('currency_id') is-invalid @enderror">

                                                        @foreach($currencies as $id => $name)
                        
                                                            @if(old('currency_id', isset($detail->currency_id) && $detail->currency_id == $id) )
                                                                <option value="{{ $id }}" selected>{{ $name }}</option>
                                                            @else
                                                                <option value="{{ $id }}">{{ $name }}</option>
                                                            @endif
                        
                                                        @endforeach
                                                    </select>


                                                    @if($errors->has('currency_id'))
                                                        <span class="text-xs text-red-600 dark:text-red-400">
                                                            {{ $errors->first('currency_id') }}
                                                        </span>
                                                    @endif
       
                                                </div>
                                                <div class="w-1/2 ml-1">

                                                    <input type="hidden" class=" block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Nombre de la moneda" / name="detail_id[]" value="{{ old('detail_id', isset($detail) ? $detail->id : '') }}" >


                                                    <input type="number" class="{{ $errors->has('amount') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Nombre de la moneda" / name="amount[]" value="{{ old('amount', isset($detail) ? $detail->amount : '') }}" required min="1" >
                                       
                                                    @if($errors->has('amount'))
                                                         <span class="text-xs text-red-600 dark:text-red-400">
                                                            {{ $errors->first('amount') }}
                                                        </span>
                                                    @endif
                                                    
                                                </div>
                                            </div>

                                    </td>
                                  
                                    <td class="px-4 py-3 ">
                                        <div class="flex">
                                                <div class="w-1/2 mr-1">
                                                   
                                                    <select name="currency2_id[]" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray  @error('currency_id') is-invalid @enderror">

                                                        @foreach($currencies as $id => $name)
                        
                                                            @if(old('currency2_id', isset($detail->currency2_id) && $detail->currency2_id == $id) )
                                                                <option value="{{ $id }}" selected>{{ $name }}</option>
                                                            @else
                                                                <option value="{{ $id }}">{{ $name }}</option>
                                                            @endif
                        
                                                        @endforeach
                                                    </select>


                                                    @if($errors->has('currency2_id'))
                                                        <span class="text-xs text-red-600 dark:text-red-400">
                                                            {{ $errors->first('currency2_id') }}
                                                        </span>
                                                    @endif
       
                                                </div>
                                                <div class="w-1/2 ml-1">

                                                    <input type="number" class="w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Nombre de la moneda" / name="amount2[]" value="{{ old('amount2', isset($detail) ? $detail->amount2 : '') }}" required min="1" >
                                       
                                                    @if($errors->has('amount2'))
                                                         <span class="text-xs text-red-600 dark:text-red-400">
                                                            {{ $errors->first('amount2') }}
                                                        </span>
                                                    @endif
                                                    
                                                </div>
                                            </div>
                                        
                                    </td>
                                    @if ($application->status->modify)
                                        <td>
                                            <a href="#" data-id="{{$detail->id}}" data-remote="{{route("admin.applications.destroy", $detail->id)}}"  class=" btn-delete flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                                aria-label="Delete">
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                </a>
                                        
                                        </td>
                                    @endif
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
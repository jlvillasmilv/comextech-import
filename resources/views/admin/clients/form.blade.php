
<x-app-layout title="Detalle Registro">
	<div class="container grid px-6 mx-auto">
        <h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{route('admin.clients.index')}}">Clientes</a>  
        </h2>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Cliente: {{$company->name }} - {{$company->tax_id }}
            </h4>
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Usuario: {{$company->user->name}}
            </h4>
                       
        </div>
       
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            
            <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.clients.excutive') }}">
                @csrf

                <input type="hidden" name="id" value="{{ $company->id}}">

                <div class="flex flex-wrap">
                    <div class="sm:w-full md:w-2/4 px-3 ">

                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400">Ejecutivo asignado</span>
        
                            <select name="executive_id" id="executive_id" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray  @error('executive_id') is-invalid @enderror">

                                @foreach($executive as $id => $name)
        
                                    @if(old('executive_id', isset($client->executive_id) && $client->executive_id == $id) == $id )
                                    <option value="{{ $id }}" selected>{{ $name }}</option>
                                    @else
                                    <option value="{{ $id }}">{{ $name }}</option>
                                    @endif
        
                                 @endforeach
                            </select>
                            @if($errors->has('executive_id'))
                                 <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('executive_id') }}
                                </span>
                            @endif
                           
                        </label>

                    </div>
                    <div class="md:w-2/4 px-3 sm:w-full">
                        <div class="flex justify-start">
                            <button class="flex  px-4 py-2 mt-9 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                               
                                <span> Asignar </span>
                            </button>
                          </div>

                    </div>
                </div>
               
            </form>
        </div>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Contrato Legal
            </h4>
           
        </div>

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <form  role="form" method="POST" action="{{ isset($data->id) ? route('admin.clients.update', $data->id) : route('admin.clients.store') }}" >
                @csrf

                @if(isset($data))
                    @method('PUT')
                @endif

                <input type="hidden" name="client_id" value="{{ $company->user->id}}">

                <div class="flex flex-wrap">
                    <div class="sm:w-full md:w-1/4 px-3 ">

                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400">Fecha escritura</span>
                            <input class="{{ $errors->has('writing_date') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" 
                            type="date"
                            name="writing_date" 
                            value="{{(isset($data)) && strtotime($data->writing_date) != false  ? date("Y-m-d", strtotime($data->writing_date)) : date("Y-m-d") }}"
                             >
                            @if($errors->has('writing_date'))
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('writing_date') }}
                                </span>
                            @endif
                        
                           
                        </label>

                    </div>
                    <div class="md:w-2/4 px-3 sm:w-full">
                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400">Notaria</span>
                            <input class="{{ $errors->has('notary') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Direccion Notaria" / name="notary"
                            value="{{ old('notary', isset($data) ? $data->notary : '') }}">

                            @if($errors->has('notary'))
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('notary') }}
                                </span>
                            @endif
                        </label>
                    </div>
                    <div class="sm:w-full md:w-1/4 px-3 ">

                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400">Numero repertorio</span>
                            <input class="{{ $errors->has('repertoire_number') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="N° Notaria" name="repertoire_number" value="{{ old('repertoire_number', isset($data) ? $data->repertoire_number : '') }}" max="20">

                            @if($errors->has('repertoire_number'))
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('repertoire_number') }}
                                </span>
                            @endif
                        </label>

                    </div>
                </div>
                <div class="flex justify-end">
                    <button class="flex  px-4 py-2 my-1 mr-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2h2m3-4H9a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-1m-1 4l-3 3m0 0l-3-3m3 3V3" />
                         </svg>
                        <span> Agregar </span>
                    </button>
                  </div>
            
            </form>
            <div class="grid gap-6 my-8 ">
		  
                @include('admin.clients.table')
    
            </div>
        </div>  

    </div>

   
      
		  
@include('admin.clients.discount_table')
    


</x-app-layout>
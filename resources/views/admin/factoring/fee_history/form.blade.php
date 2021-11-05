<x-app-layout title="Desembolsos">
   
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Base de Pagador
        </h2>


        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Pagador
            </h4>
           
        </div>
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <form class="form-horizontal" role="form" method="POST" action="{{ isset($data) ? route('admin.factoring.fee_history.update', $id) : route('admin.factoring.fee_history.store') }}" >

                @csrf
                @if(isset($data))
                    @method('PUT')
                @endif

                <div class="flex flex-wrap">
                    <div class="sm:w-full md:w-1/3 px-3 ">

                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400">RUT</span>
        
                            <input class="{{ $errors->has('rut') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                            name="rut"
                            value="{{ old('rut', isset($data) ? $data->payer->rut : '') }}"
                            max="12"
                            required="">
                            
                            @if($errors->has('rut'))
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('rut') }}
                                </span>
                            @endif
                        </label>

                    </div>
                    <div class="sm:w-full md:w-1/3 px-3 ">

                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400">Nombre</span>
        
                            <input class="{{ $errors->has('name') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                            name="name"
                            value="{{ old('name', isset($data) ? $data->payer->name : '') }}"
                            max="100" required="">
                            
                            @if($errors->has('name'))
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('name') }}
                                </span>
                            @endif
                        </label>

                    </div>
                    <div class="md:w-1/3 px-3 sm:w-full">
                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400">Cliente</span>

                            <select name="user_id" id="user_id" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray  @error('user_id') is-invalid @enderror">

                                @foreach($clients as $id => $name)

                                    @if(old('user_id', isset($data->user_id) && $data->user_id == $id) )
                                        <option value="{{ $id }}" selected>{{ $name }}</option>
                                    @else
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endif

                                @endforeach
                            </select>
        
                            
                            
                            @if($errors->has('user_id'))
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('user_id') }}
                                </span>
                            @endif
                        </label>

                    </div>
                </div>

                <div class="flex justify-end">
                    <button class="flex  px-4 py-2 my-8 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2h2m3-4H9a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-1m-1 4l-3 3m0 0l-3-3m3 3V3" />
                         </svg>
                        <span> Guardar </span>
                    </button>
                  </div>

                
            </form>
           
        </div>



        @isset($data->id)

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Base de Calculo
            </h4>
           
        </div>

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.factoring.fee_store') }}" >

                @csrf

                <input type="hidden" name="client_payer_id" value="{{$data->id}}">
                <input type="hidden" name="id" value="{{isset($fee) ? $fee->id : ''}}">

                <div class="flex flex-wrap">
                    <div class="sm:w-full md:w-1/5 px-3 ">

                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400">TASA</span>
        
                            <input class="{{ $errors->has('rate') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                             name="rate"
                             step="0.01"
                             type="number"
                             value="{{ old('rate', isset($fee) ? $fee->rate : '') }}"
                             required="">
                            
                            @if($errors->has('rate'))
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('rate') }}
                                </span>
                            @endif
                        </label>

                    </div>
                    <div class="sm:w-full md:w-1/5 px-3 ">

                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400">TASA MORA</span>
        
                            <input class="{{ $errors->has('mora_rate') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                            name="mora_rate"
                            required=""
                            type="number"
                            step="0.01"
                            value="{{ old('mora_rate', isset($fee) ? $fee->mora_rate : '') }}" >
                            
                            @if($errors->has('mora_rate'))
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('mora_rate') }}
                                </span>
                            @endif
                        </label>

                    </div>
                    <div class="sm:w-full md:w-1/5 px-3 ">
                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400">DESCUENTO</span>

                            <input class="{{ $errors->has('discount') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                             name="discount"
                             type="number"
                             required=""
                             step="0.01"
                             maxlength="15"
                             value="{{ old('discount', isset($fee) ? $fee->discount : '') }}" >
                            
                            @if($errors->has('discount'))
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('discount') }}
                                </span>
                            @endif
                            
                        </label>

                    </div>
                    <div class="sm:w-full md:w-1/5 px-3 ">
                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400">Comisión</span>

                            <input class="{{ $errors->has('commission') ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                             name="commission"
                             type="number"
                             required=""
                             step="0.01"
                             value="{{ old('commission', isset($fee) ? $fee->commission : '') }}"
                             maxlength="15" >
                            
                            @if($errors->has('commission'))
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('commission') }}
                                </span>
                            @endif
                            
                        </label>

                    </div>
                    <div class="sm:w-full md:w-1/5 px-3">
                        <label class="block text-sm my-3">

                            <button class="flex  px-4 py-2 my-8 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                                
                                <span> Agregar </span>
                            </button>
                            
                        </label>

                    </div>
                </div>

               
            </form>
            <div class="grid gap-6 my-8 ">
		  
                @include('admin.factoring.fee_history.table')
    
            </div>
           
        </div>
        @endisset


    </div>

</x-app-layout>
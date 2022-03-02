<x-app-layout title="Datos de la empresa">
    <div class="container grid px-6 mx-auto">
        <h2 class="mt-6 mb-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Empresa
        </h2>

        <!-- <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
            Información de empresa
        </h4> -->

        <div class=" px-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('company.update', base64_encode($data->id)) }}" >
                @csrf
                 @if(isset($data))
		           @method('PUT')
		        @endif
                <div class="px-2">
                    <label class="block text-sm my-3">
                        <span class="text-gray-700 dark:text-gray-400">Pais</span>

                        <select name="country_id" class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-blue-300 focus:outline-none focus:shadow-outline-blue form-select select2  @error('country_id') is-invalid @enderror">

                        @foreach($country as $id => $name)

                            @if(old('country_id', isset($data->country_id) && $data->country_id == $id) )
                                <option value="{{ $id }}" selected>{{ $name }}</option>
                            @else
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endif

                            @endforeach
                        </select>
                        
                        @if($errors->has('country_id'))
                            <span class="text-xs text-red-600 dark:text-red-400">
                                {{ $errors->first('country_id') }}
                            </span>
                        @endif
                    </label>
                </div>

                <div class="px-2">
                    <div class="flex mb-4">
                        <div class="w-1/2 mr-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Numero identificación tributaria</label>
                           <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Empresa" name="tax_id" value="{{ old('tax_id', isset($data) ? $data->tax_id : '') }}" max="100" required="">
                             @if($errors->has('tax_id'))
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('tax_id') }}
                                </span>
                            @endif
                        </div>
                        <div class="w-1/2 ml-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Nombre de la Empresa</label>
                            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Empresa" name="name" value="{{ old('name', isset($data) ? $data->name : '') }}" max="100" required="">
                             @if($errors->has('name'))
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('name') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                  <div class="px-2">
                    <div class="flex mb-4">
                        <div class="w-1/2 mr-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Correo electrónico</label>
                           <input type="email" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="ejemplo@correo.com" name="email" value="{{ old('email', isset($data) ? $data->email : '') }}" max="100" required="">
                             @if($errors->has('email'))
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                        </div>
                        <div class="w-1/2 ml-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" >Número de teléfono</label>
                            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Empresa" name="phone" value="{{ old('phone', isset($data) ? $data->phone : '') }}" max="100" required="">
                             @if($errors->has('phone'))
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('phone') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>


                <!-- <div class="px-2">
                    <div class="flex mb-4">
                        <div class="w-1/2 mr-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Representante</label>
                            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Nombre de reresentante o contato" name="contact_name" value="{{ old('contact_name', isset($data) ? $data->contact_name : '') }}" max="100" >
                            @if($errors->has('contact_name'))
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('contact_name') }}
                                </span>
                            @endif
                        </div>
                        <div class="w-1/2 ml-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" >Telfono represntante</label>
                            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Telefono de representante" name="contact_telf" value="{{ old('contact_telf', isset($data) ? $data->contact_telf : '') }}" max="100">
                            @if($errors->has('contact_telf'))
                               <span class="text-xs text-red-600 dark:text-red-400">
                                   {{ $errors->first('contact_telf') }}
                               </span>
                           @endif
                        </div>
                    </div>
                </div> -->


                <div class="flex justify-end px-2">
                    <button class="flex px-4 py-2 mb-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-1300 border border-transparent rounded-lg hover:bg-blue-1200 focus:outline-none focus:shadow-outline-blue">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2h2m3-4H9a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-1m-1 4l-3 3m0 0l-3-3m3 3V3" />
                         </svg>
                        <span> Actualizar </span>
                    </button>
                  </div>
              </form>
    
        </div>

    </div>

    <div class="container grid px-6 mx-auto">
        <menu-profile>  </menu-profile>  
    </div>
</x-app-layout>
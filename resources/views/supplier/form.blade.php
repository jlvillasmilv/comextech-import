<x-app-layout title="Import">
    <div class="container px-6 ">
        <h2 class="mt-5 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{route('supplier.index')}}">Proveedores</a>  
        </h2>
        <div class="flex justify-center  m-auto my-2 ">
            <div class="w-full mx-3 px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <h3 class="my-4 font-semibold text-gray-700 dark:text-gray-200">
                    Nuevo Proveedor
                </h3>
                <form class="form-horizontal" role="form" method="POST" action="{{ isset($supplier) ? route('supplier.update', $supplier->id) : route('supplier.store') }}" >
                    @csrf
                     @if(isset($supplier))
                       @method('PUT')
                    @endif
                <label class="block text-sm my-3">
                    <span class="text-gray-700 dark:text-gray-400"> Nombre</span>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Empresa" name="name" value="{{ old('name', isset($supplier) ? $supplier->name : '') }}" max="100" required="">
                    @if($errors->has('name'))
                             <span class="text-xs text-red-600 dark:text-red-400">
                                {{ $errors->first('name') }}
                            </span>
                        @endif
                </label>

                <div class="flex mb-4">

                    <div class="w-1/2 mr-1">
                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400"> Banco</span>
                            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Cuenta Bancaria" name="bank" value="{{ old('bank', isset($supplier) ? $supplier->bank : '') }}" max="100" required="">
                             @if($errors->has('bank'))
                                 <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('bank') }}
                                </span>
                            @endif
                        </label>
                    </div>

                    <div class="w-1/4 mr-1">
                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400"> ISIN </span>
                            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder=" Número de identificación de valores internacionales
                            "  name="isin" value="{{ old('isin', isset($supplier) ? $supplier->isin : '') }}" max="15" required="">
                            @if($errors->has('isin'))
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('isin') }}
                                </span>
                            @endif
                        </label>
                    </div>

                    <div class="w-1/4 mr-1">
                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400"> IBAN </span>
                            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Código Internacional de Cuenta Bancaria" name="iban" value="{{ old('iban', isset($supplier) ? $supplier->iban : '') }}" max="100" required="">
                            @if($errors->has('iban'))
                                 <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('iban') }}
                                </span>
                            @endif
                        </label>
                    </div>

                </div>

                <label class="block text-sm my-3">
                    <span class="text-gray-700 dark:text-gray-400"> Direccion </span>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Direccion Postal" name="address" value="{{ old('address', isset($supplier) ? $supplier->address : '') }}" max="100" required="">
	                @if($errors->has('address'))
		             	<span class="text-xs text-red-600 dark:text-red-400">
		                    {{ $errors->first('address') }}
		                </span>
	                @endif
                </label>
               
                <div class="flex mb-4">

                    <div class="w-1/2 mr-1">
                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400"> Correo electrónico</span>
                            <input type="email" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Direccion de Correo electrónico" name="email" value="{{ old('email', isset($supplier) ? $supplier->email : '') }}" max="100" required="">
                            @if($errors->has('email'))
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                        </label>
                    </div>

                    <div class="w-1/2 mr-1">
                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400"> Telefono </span>
                            <input type="text" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Telefono del proveedor" name="phone" value="{{ old('phone', isset($supplier) ? $supplier->phone : '') }}" max="100" required="">
                            @if($errors->has('phone'))
                                 <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('phone') }}
                                </span>
                            @endif
                        </label>
                    </div>
                </div>
                
                <label class="block text-sm my-3">
                    <span class="text-gray-700 dark:text-gray-400"> Origen del Transporte </span>

                    <label class="block text-sm my-3">
                        <span class="text-gray-700 dark:text-gray-400"> Puertos asignados </span>
                        <select class="select2 " name="port_id[]" multiple="multiple">
                            @forelse ($ports as $port)
                            
                            <option value="{{$port->id}}" {{ (old('port_id') || isset($supplier) && $supplier->ports->contains($port->id)) ? 'selected' : ''}}>{{$port->name}}</option>
                            @empty
                            @endforelse
                        </select>
                        @if($errors->has('address'))
                             <span class="text-xs text-red-600 dark:text-red-400">
                                {{ $errors->first('address') }}
                            </span>
                        @endif
                    </label>
                    
                    <div class="px-2" id="add_to">
                        <div class="flex mb-4">
                            <div class="w-1/4 mr-1">
                                <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Tipo:</label>
                                <select id="location" name="services_id" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray ">

                                    @foreach($place as $id => $name)

                                        <option value="{{ $name }}" {{old('location') == $name ? 'selected' : ''}}>
                                            {{ $name }}
                                        </option>
    
                                    @endforeach
                                </select>
                                <span id="services_idError" class="text-xs text-red-600 dark:text-red-400">
                                    <strong></strong>
                                </span>
                            </div>
                           
                            <div class="w-3/4 ml-1">
                                <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" > Dirección </label>

                                <input  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input map-input"
                                 placeholder="Dirección Origen"
                                  id="_address"
                                  onfocus="this.value=''" >

                                  <input type="hidden"  name="latitude" id="latitude" value="{{ old('latitude') }}" />
                                  <input type="hidden"  name="longitude" id="longitude" value="{{ old('longitude') }}" />
                                  <input type="hidden" id='province' name="province" value="{{ old('province') }}" />
                                  <input type="hidden" id='country_code' name="country_code" value="{{ old('country_code') }}" />
                                  <input type="hidden" id='locality' name="locality" value="{{ old('locality') }}" >
                                
                                <span id="amountError" class="text-xs text-red-600 dark:text-red-400">
                                    <strong></strong>
                                </span>
                                
                            </div>

                            <div class="w-1/4 ml-1">
                                <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" > Cod Postal </label>

                                <input type="text" placeholder="Codigo postal" id='postal_code' name="post_code" value="{{ old('post_code') }}" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input">

                            </div>

                            <button id="add" type="button" class="btn-add flex ml-2 px-3 py-1 my-8 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue" 
                                data-remote="#" data-id="#" autocomplete="off"
                                title="Agregar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                     </svg>

                                </button>
                        </div>
                    </div>

                </label>
                <div class="px-2 w-full overflow-x-auto">
                  <table id="table" class="w-full whitespace-no-wrap">
                        
                        <tbody
                        class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @isset($supplier)
                            @forelse($supplier->supplierAddress as $suppAdd)
                            <tr id="{{ $suppAdd->id }}">
                                <td>
                                    <input type="hidden" name="idto[]" value="{{ $suppAdd->id }}"> {{ $suppAdd->place }}
                                </td>
                                 <td>
                                    {{ $suppAdd->address }}
                                 </td>
                                <td>
                                    <button type="button" class="deleteBtn btn-add flex ml-2 px-3 py-1 my-8 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red" onclick="remove({{ $suppAdd->id }})">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button>
                                </td>
                            </tr>
                             
                            @empty
                                
                            @endforelse
                        @endisset
                            
                        </tbody>
                      </table>
                </div>
                <div class="flex  justify-start">
                        <button type="submit" class="flex  px-5 py-2  text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2h2m3-4H9a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-1m-1 4l-3 3m0 0l-3-3m3 3V3" />
                                </svg>
                            <span> Guardar </span>
                        </button>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
@parent


<script type="text/javascript">

    (function() {
        // your page initialization code here
        // the DOM will be available here
        initialize();
        $('.select2').select2();

    })();

    function remove(id){

        //Obj of data to send in future like a dummyDb
        const data = { id: id };
        
        //POST request with body equal on data in JSON format
        fetch('{{ route("supplier.remove") }}', {
          method: 'POST',
          headers: {
            "X-CSRF-Token": $('input[name="_token"]').val(),
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(data),
        })
        .then((response) => response.json())
        //Then with the data from the response in JSON...
        .then((data) => {
            onDeleteRow(id);
        })
        //Then with the error genereted...
        .catch((error) => {
          console.error('Error:', error);
        });

    }
    
    const tbodyEl = document.querySelector("tbody");
    const tableEl = document.getElementById("table");

     // Agrega nuevo registro Direccion orgen tansporte 
    $('#add_to').on('click', '.btn-add[data-remote]', function (e) {
        e.preventDefault();

        const user = document.getElementById("location");
        var value  = user.options[user.selectedIndex].value;

        const address  = document.getElementById("_address").value;
        const latit    = document.getElementById("latitude").value;
        const logit    = document.getElementById("longitude").value; 
        const post_cod = document.getElementById("postal_code").value;  
        const country_code = document.getElementById("country_code").value; 
        const locality  = document.getElementById("locality").value; 

        if (address.length <= 0 || post_cod.length <= 0 ) { return;  }

        tbodyEl.innerHTML += `
            <tr id="${Date.now()}">
                <td><input type="hidden" name="place[]" value="${value}">  ${value}</td>
                <td>
                    <input type="hidden" name="origin_address[]" value="${address}"> ${address} ${post_cod}
                    <input type="hidden" class="form-input" name="latitude[]" id="latitude" value="${latit}" />
                    <input type="hidden" class="form-input" name="longitude[]" id="longitude" value="${logit}" />
                    <input type="hidden" class="form-input" name="postal_code[]" id="longitude" value="${post_cod}" />
                    <input type="hidden" class="form-input" name="country_code[]" value="${country_code}" />
                    <input type="hidden" class="form-input" name="locality[]" value="${locality}" />
                </td>
                <td>
                    <button type="button" class="deleteBtn btn-add flex ml-2 px-3 py-1 my-8 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red" onclick="onDeleteRow(${Date.now()})">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button>
                </td>
            </tr>
        `;

        address.value = '';
        latit.value   = '';
        logit.value   = '';
        post_cod.value = '';

      });


    function onDeleteRow(id) {
        var row = document.getElementById(id);
        row.parentNode.removeChild(row);
    }

</script>

@endsection

</x-app-layout>
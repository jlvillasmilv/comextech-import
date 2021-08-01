<x-app-layout title="Import">
    <div class="container px-6 mx-auto ">
        <h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{route('supplier.index')}}">Proveedores</a>  
        </h2>
        <div class="flex justify-center px-6 m-auto my-2 ">
            <div class=" w-2/3 mx-3 px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800    ">
                <h3 class="my-4  font-semibold text-gray-700 dark:text-gray-200">
                    Nuevo Proveedor
                </h3>
                <form class="form-horizontal" role="form" method="POST" action="{{ isset($supplier) ? route('supplier.update', $supplier->id) : route('supplier.store') }}" >
                    @csrf
                     @if(isset($supplier))
                       @method('PUT')
                    @endif
                <label class="block text-sm my-3">
                    <span class="text-gray-700 dark:text-gray-400"> Nombre</span>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Empresa" name="name" value="{{ old('name', isset($supplier) ? $supplier->name : '') }}" max="100" required="">
                    @if($errors->has('name'))
                             <span class="text-xs text-red-600 dark:text-red-400">
                                {{ $errors->first('name') }}
                            </span>
                        @endif
                </label>
                <label class="block text-sm my-3">
                    <span class="text-gray-700 dark:text-gray-400"> Banco</span>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Cuenta Bancaria" name="bank" value="{{ old('bank', isset($supplier) ? $supplier->bank : '') }}" max="100" required="">
	                 @if($errors->has('bank'))
		             	<span class="text-xs text-red-600 dark:text-red-400">
		                    {{ $errors->first('bank') }}
		                </span>
	                @endif
                </label>
                <label class="block text-sm my-3">
                    <span class="text-gray-700 dark:text-gray-400"> ISIN </span>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder=" Número de identificación de valores internacionales
                    "  name="isin" value="{{ old('isin', isset($supplier) ? $supplier->isin : '') }}" max="100" required="">
	            @if($errors->has('isin'))
		             	<span class="text-xs text-red-600 dark:text-red-400">
		                    {{ $errors->first('isin') }}
		                </span>
	                @endif
                </label>
                <label class="block text-sm my-3">
                    <span class="text-gray-700 dark:text-gray-400"> Direccion </span>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Direccion Postal" name="address" value="{{ old('address', isset($supplier) ? $supplier->address : '') }}" max="100" required="">
	                @if($errors->has('address'))
		             	<span class="text-xs text-red-600 dark:text-red-400">
		                    {{ $errors->first('address') }}
		                </span>
	                @endif
                </label>
                <label class="block text-sm my-3">
                    <span class="text-gray-700 dark:text-gray-400"> IBAN </span>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Código Internacional de Cuenta Bancaria" name="iban" value="{{ old('iban', isset($supplier) ? $supplier->iban : '') }}" max="100" required="">
	                @if($errors->has('iban'))
		             	<span class="text-xs text-red-600 dark:text-red-400">
		                    {{ $errors->first('iban') }}
		                </span>
	                @endif
                </label>
                <label class="block text-sm my-3">
                    <span class="text-gray-700 dark:text-gray-400"> Direccion de Correo </span>
                    <input type="email" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Direccion de Correo electrónico" name="email" value="{{ old('email', isset($supplier) ? $supplier->email : '') }}" max="100" required="">
	                @if($errors->has('email'))
		             	<span class="text-xs text-red-600 dark:text-red-400">
		                    {{ $errors->first('email') }}
		                </span>
	                @endif
                </label>
                <label class="block text-sm my-3">
                    <span class="text-gray-700 dark:text-gray-400"> Telefono </span>
                    <input type="text" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Telefono del proveedor" name="phone" value="{{ old('phone', isset($supplier) ? $supplier->phone : '') }}" max="100" required="">
	                @if($errors->has('phone'))
		             	<span class="text-xs text-red-600 dark:text-red-400">
		                    {{ $errors->first('phone') }}
		                </span>
	                @endif
                </label>
                <label class="block text-sm my-3">
                    <span class="text-gray-700 dark:text-gray-400"> Origen del Transporte </span>
                    
                    <div class="px-2" id="add_to">
                        <div class="flex mb-4">
                            <div class="w-1/4 mr-1">
                                <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Tipo:</label>
                                <select id="location" name="services_id" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray ">

                                    @foreach($place as $id => $name)

                                        <option value="{{ $name }}">{{ $name }}</option>
    
                                    @endforeach
                                </select>
                                <span id="services_idError" class="text-xs text-red-600 dark:text-red-400">
                                    <strong></strong>
                                </span>
                            </div>
                           
                            <div class="w-3/4 ml-1">
                                <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" > Dirección </label>

                                <input  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                 placeholder="Dirección Origen"
                                  id="_address"
                                  onfocus="this.value=''" >

                                <span id="amountError" class="text-xs text-red-600 dark:text-red-400">
                                    <strong></strong>
                                </span>
                                
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

                    {{-- <div class="pac-card" id="pac-card">
                        <input
                        class="form-control  col-md-6"
                        style="margin:auto; width:800px;"
                        id="pac-input" type="text"
                        placeholder="Enter a location" />
                      </div>
                      <div id="map"></div>
                  
                      <center>
                        <h2>Coordenadas</h2>
                        <h3>Latitude</h3>
                        <p id="textLatitude">Latitude</p>
                        <h3>Longitude</h3>
                        <p id="textLongitude">Longitude</p>
                      </center> --}}
                  
                </label>
                <div class="px-2 w-full overflow-x-auto">
                  <table id="table" class="w-full whitespace-no-wrap">
                        
                        <tbody 
                        class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @isset($supplier)
                            @forelse($supplier->supplierAddress as $suppAdd)
                            <tr>
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
                        <button type="submit" class="flex  px-5 py-2  text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
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
          console.log('Success:', data);
        })
        //Then with the error genereted...
        .catch((error) => {
          console.error('Error:', error);
        });

    }
    
    const tbodyEl = document.querySelector("tbody");
    const tableEl = document.querySelector("table");

     // Agrega nuevo registro Direccion orgen tansporte 
    $('#add_to').on('click', '.btn-add[data-remote]', function (e) {
          e.preventDefault();

              const user = document.getElementById("location");
              var value  = user.options[user.selectedIndex].value;

              const address = document.getElementById("_address").value; 

              if (address.length <= 0) {
                return;
              }


           tbodyEl.innerHTML += `
            <tr>
                <td><input type="hidden" name="place[]" value="${value}">  ${value}</td>
                <td>
                    <input type="hidden" name="origin_address[]" value="${address}"> ${address}
                </td>
                <td>
                    <button type="button" class="deleteBtn btn-add flex ml-2 px-3 py-1 my-8 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button>
                </td>

            </tr>
        `;

        address.value = '';

      });


    function onDeleteRow(e) {
        if (!e.target.classList.contains("deleteBtn")) {
          return;
        }

        const btn = e.target;
        btn.closest("tr").remove();
      }

      //formEl.addEventListener("submit", onAddWebsite);
       tableEl.addEventListener("click", onDeleteRow);

</script>



{{-- <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=KEY_GOOGLE=places&v=weekly"
      defer
    ></script>

    <script>
        // This example requires the Places library. Include the libraries=places
        // parameter when you first load the API. For example:
        // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
        function initMap() {
          const map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: -33.8688, lng: 151.2195 },
            zoom: 13,
          });
          const input = document.getElementById("pac-input");
          const autocomplete = new google.maps.places.Autocomplete(input);
          // Bind the map's bounds (viewport) property to the autocomplete object,
          // so that the autocomplete requests use the current map bounds for the
          // bounds option in the request.
          autocomplete.bindTo("bounds", map);
          // Set the data fields to return when the user selects a place.
          autocomplete.setFields([
            "address_components",
            "geometry",
            "icon",
            "name",
          ]);
  
          autocomplete.setTypes(["address"]);
  
          const infowindow = new google.maps.InfoWindow();
  
          const marker = new google.maps.Marker({
            map,
            anchorPoint: new google.maps.Point(0, -29),
          });
          autocomplete.addListener("place_changed", () => {
  
            infowindow.close();
            marker.setVisible(false);
            const place = autocomplete.getPlace();
  
            if (!place.geometry) {
              // User entered the name of a Place that was not suggested and
              // pressed the Enter key, or the Place Details request failed.
              window.alert(
                "No details available for input: '" + place.name + "'"
              );
              return;
            }
  
            const coords = place.geometry.location
            document.getElementById("textLatitude").innerHTML = coords.lat();
            document.getElementById("textLongitude").innerHTML = coords.lng();
  
            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
              map.fitBounds(place.geometry.viewport);
            } else {
              map.setCenter(place.geometry.location);
              map.setZoom(17); // Why 17? Because it looks good.
            }
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);
            let address = "";
  
            if (place.address_components) {
              address = [
                (place.address_components[0] &&
                  place.address_components[0].short_name) ||
                  "",
                (place.address_components[1] &&
                  place.address_components[1].short_name) ||
                  "",
                (place.address_components[2] &&
                  place.address_components[2].short_name) ||
                  "",
              ].join(" ");
            }
  
            infowindow.open(map, marker);
          });
  
        }
      </script> --}}

@endsection

</x-app-layout>
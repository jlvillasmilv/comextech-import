<x-app-layout title="Import">
    <div class="container px-6 mx-auto ">
        <h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{route('address.index')}}">Direcciones de destino</a>  
        </h2>
        <div class="flex justify-center px-6 m-auto my-2 ">
            <div class=" w-2/3 mx-3 px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 ">
                <h3 class="my-4  font-semibold text-gray-700 dark:text-gray-200">
                    Nueva direccion
                </h3>
                <form class="form-horizontal" role="form" method="POST" action="{{ isset($companyAddress) ? route('address.update', $companyAddress->id) : route('address.store') }}" >
                    @csrf
                     @if(isset($companyAddress))
                       @method('PUT')
                    @endif

                <label class="block text-sm my-3">
                  <div class="px-2" id="add_to">
                      <div class="flex mb-4">
                          <div class="w-3/4 mr-1">
                              <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Pais de origen:</label>
                              <select name="country_id" class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-select select2  @error('country_id') is-invalid @enderror">
  
                                @foreach($country as $id => $name)
            
                                    @if(old('country_id', isset($companyAddress->country_id) && $companyAddress->country_id == $id) )
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
                          </div>
                         
                          <div class="w-1/4 ml-1">
                              <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" > Codigo postal </label>

                              <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Codigo postal"  id='postal_code' name="postal_code" value="{{ old('postal_code', isset($companyAddress) ? $companyAddress->postal_code : '') }}" max="50" required="">

                              @if($errors->has('postal_code'))
                              <span class="text-xs text-red-600 dark:text-red-400">
                                   {{ $errors->first('postal_code') }}
                               </span>
                             @endif
                              
                          </div>

                      </div>
                  </div>
                
              </label>



              <label class="block text-sm my-3">
                <span class="text-gray-700 dark:text-gray-400">Lugar</span>

                <select name="place" class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-select select2  @error('place') is-invalid @enderror">

                @foreach($place as $name)

                    @if(old('place', isset($data->place) && $data->place == $id) )
                        <option value="{{ $name }}" selected>{{ $name }}</option>
                    @else
                        <option value="{{ $name }}">{{ $name }}</option>
                    @endif

                    @endforeach
                </select>
                
                @if($errors->has('place'))
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{ $errors->first('place') }}
                    </span>
                @endif
            </label>

            <label class="block text-sm my-3">
                    <span class="text-gray-700 dark:text-gray-400"> Direccion </span>
                    <input type="text" id="address-input" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input  map-input" placeholder="Direccion Postal" name="address" value="{{ old('address', isset($companyAddress) ? $companyAddress->address : '') }}" max="255" required="">
	                @if($errors->has('address'))
		             	<span class="text-xs text-red-600 dark:text-red-400">
		                    {{ $errors->first('address') }}
		                </span>
	                @endif
            </label>

           
            <input type="hidden" class="form-input" name="address_latitude" id="address_latitude" value="{{ old('address_latitude', isset($companyAddress) ? $companyAddress->address_latitude : 0) }}" />
            <input type="hidden" class="form-input" name="address_longitude" id="address_longitude" value="{{ old('address_longitude', isset($companyAddress) ? $companyAddress->address_longitude : 0) }}" />
               
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
(function() {
   // your page initialization code here
   // the DOM will be available here
   initialize() 

})();

function initialize() {

    $('form').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });
    
    const locationInputs = document.getElementsByClassName("map-input");

    const autocompletes = [];
    const geocoder = new google.maps.Geocoder;
    let postalField;

postalField = document.querySelector("#postal_code");

    for (let i = 0; i < locationInputs.length; i++) {

        const input = locationInputs[i];
        const fieldKey = input.id.replace("-input", "");
        const isEdit = document.getElementById('address_latitude').value != '' && document.getElementById('address_longitude').value != '';

        const autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.key = fieldKey;
        autocompletes.push({input: input, autocomplete: autocomplete});

    }

    for (let i = 0; i < autocompletes.length; i++) {
        const input = autocompletes[i].input;
        const autocomplete = autocompletes[i].autocomplete;
        const map = autocompletes[i].map;
        const marker = autocompletes[i].marker;

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            // marker.setVisible(false);
            const place = autocomplete.getPlace();
            let postcode = "";

            // Get each component of the address from the place details,
            // and then fill-in the corresponding field on the form.
            // place.address_components are google.maps.GeocoderAddressComponent objects
            for (const component of place.address_components) {
                const componentType = component.types[0];
                
                switch (componentType) {
                
                case "postal_code": {
                    postcode = `${component.long_name}${postcode}`;
                    break;
                }

                case "postal_code_suffix": {
                    postcode = `${postcode}-${component.long_name}`;
                    break;
                }
                
                }
            }

            postalField.value = postcode;
            
            document.querySelector("#address_latitude").value = place.geometry['location'].lat();
            document.querySelector("#address_longitude").value = place.geometry['location'].lng();

        });
    }
}


</script>

@endsection

</x-app-layout>
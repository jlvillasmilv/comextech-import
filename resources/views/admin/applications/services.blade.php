@if (isset($application->paymentProvider) and count($application->paymentProvider) > 0)

<div class="bg-white border border-gray-200 mb-2" x-data="{selected:null}">
        <ul class="shadow-box">
                        
        <li class="relative border-b border-gray-200">

                <a x-on:click.prevent="selected !== 1 ? selected = 1 : selected = null" type="button" class="w-full px-8 py-6 text-left">
                <div class="flex items-center justify-between">
                    <span class="font-bold text-gray-800 dark:text-gray-400">Pago proveedor </span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path></svg>
                </div>
            </a>

            <div class="relative overflow-hidden transition-all max-h-0 duration-700" style="" x-ref="container1" x-bind:style="selected == 1 ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : ''">
                <div class="p-6">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr
                                class="text-xs font-semibold tracking-wide text-left text-white  uppercase border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800"
                            >
                                <th class="px-4 py-3">Pago</th>
                                <th class="">Porcentaje</th>
                                <th class="px-4 py-3">Moneda</th>
                                <th class="px-4 py-3">Monto</th>
                                <th class="px-4 py-3">Forma</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        
                            @forelse ($application->paymentProvider as $key => $item)

                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3">
                                    Pago Nro {{$key + 1}}
                                </td>
                                <td class="px-4 py-3">
                                    {{$item->percentage}} %
                                </td>
                                <td class="px-4 py-3">
                                    {{ $application->currency->code }} {{ $application->currency->symbol }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ number_format($application->amount * ($item->percentage / 100),0,",",".") }}
                                </td>
                                <td class="px-4 py-3">
                                    {{$item->payment_release}}
                                </td>
                            </tr>
                                
                            @empty
                                
                            @endforelse
                            
                        </tbody>
                    </table>
                   
                </div>
            </div>

        </li>

</ul>

</div>

@endif

{{-- Transporte  --}}
@if (isset($application->transport->id))

<div class="bg-white border border-gray-200 mb-2" x-data="{selected:null}">
    <ul class="shadow-box">
                    
    <li class="relative border-b border-gray-200">

            <a x-on:click.prevent="selected !== 1 ? selected = 1 : selected = null" type="button" class="w-full px-8 py-6 text-left">
            <div class="flex items-center justify-between">
                <span class="font-bold text-gray-800 dark:text-gray-400">Transporte </span>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path></svg>
            </div>
        </a>

        <div class="relative overflow-hidden transition-all max-h-0 duration-700" style="" x-ref="container1" x-bind:style="selected == 1 ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : ''">
            @if (isset($application->transport->transCompany->id))
            <div class="px-6 items-center justify-between">
                <span class="font-bold text-gray-800 dark:text-gray-400">Compañía de Transporte: </span>
                <label class="text-grey-darker text-sm dark:text-gray-300"> {{$application->transport->transCompany->name}}</label>
            </div>
            @endif
            <div class="p-6">
                <div class="flex mb-2">
                    <div class="w-1/2 mr-1">
                        <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300"> Origen de Envio</label>
                        <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">

                            @if($application->transport->fav_origin_address)

                                {{ $application->transport->originAddress->address }}
                                
                            @else

                                {{ $application->transport->origin_address }}
                                
                            @endif

                           
                        </p>
                    </div>
                    <div class="w-1/2 ml-1">
                        <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" >Destino de Envio</label>
                        <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">


                            @if($application->transport->fav_dest_address)

                                {{ $application->transport->destAddress->address }}
                            
                            @else

                                {{ $application->transport->dest_address }}
                                
                            @endif

                        </p>
                    </div>
                </div>
                @if ($application->type_transport != 'COURIER')
                <div class="flex mb-2">
                    <div class="w-1/2 mr-1">
                        <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300"> {{ $application->type_transport == 'AEREO' ? 'Aereopuerto' :'Puerto'}} Origen </label>
                        <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">

                            {{ $application->transport->originPort->name }} - {{ $application->transport->originPort->unlocs }}

                        </p>
                    </div>
                    <div class="w-1/2 ml-1">
                        <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" >{{ $application->type_transport == 'AEREO' ? 'Aereopuerto' :'Puerto'}}  Destino</label>
                        <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">


                            {{ $application->transport->destPort->name }} - {{ $application->transport->destPort->unlocs }}

                        </p>
                    </div>
                </div>
               
                @endif

                <div class="flex mb-2">
                    <div class="w-1/2 mr-1">
                        
                        <input
                            disabled
                            type="checkbox"
                            {{ $application->transport->insurance ? 'checked="true"' : '' }}
                            class="form-checkbox h-4 w-4 text-gray-800"
                        />
                        <span class="ml-2">Seguro</span
                        >
                        <input
                            disabled
                            type="checkbox"
                            {{ $application->transport->local_transp ? 'checked="true"' : '' }}
                            class="form-checkbox h-4 w-4 text-gray-800"
                        />
                        <span class="ml-2">Transporte Local</span
                        >
                    </div>
                    <div class="w-1/2 ml-1">
                        <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" >Fecha Estimada</label>
                        <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                            {{ date('d-m-Y', strtotime($application->transport->estimated_date)) }}
                        </p>
                    </div>
                </div>

            </div>

        </div>

    </li>

</ul>

</div>

@endif

{{-- Fin de  transporte--}}

{{-- PROCESO INTERNACION Aduana  --}}
@if (isset($application->internmentProcess->id))

<div class="bg-white border border-gray-200 mb-2" x-data="{selected:null}">
    <ul class="shadow-box">
                    
    <li class="relative border-b border-gray-200">

            <a x-on:click.prevent="selected !== 1 ? selected = 1 : selected = null" type="button" class="w-full px-8 py-6 text-left">
            <div class="flex items-center justify-between">
                <span class="font-bold text-gray-800 dark:text-gray-400"> Internación </span>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path></svg>
            </div>
        </a>

        <div class="relative overflow-hidden transition-all max-h-0 duration-700" style="" x-ref="container1" x-bind:style="selected == 1 ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : ''">

            <div class="p-6">
                <div class="flex mb-2">
                    <div class="w-1/2 mr-1">
                        <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300"> Agente de Aduana</label>
                        <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                            {{  $application->internmentProcess->customs_house ? 'COMEXTECH S' : '' }}
                            {{$application->internmentProcess->customAgent->name}}
                        </p>
                    </div>
                    <div class="w-1/2 ml-1">
                        <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" >Pago de Agente de Aduana</label>
                        <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                            {{ number_format($application->internmentProcess->agent_payment,0,",",".") }}  
                        </p>
                    </div>
                </div>
            </div>

            {{-- download --}}
            @if (isset($application->internmentProcess->fileStoreInternment))
            <div class="p-6">
                <div class="flex mb-2">
                    @forelse ($application->internmentProcess->fileStoreInternment as $file)

                    <div class="w-auto mr-1">
                        <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300"> {{$file->intl_treaty}}</label>
                        <a href="{{ route('download.file.internment', [$file->id, $file->intl_treaty]) }}"
                            title="Descarga documento"
                          class="flex sm:w-32 px-2 py-2 text-white transition-colors duration-150 bg-blue-1300 rounded-lg active:bg-blue-1300 hover:bg-blue-1200 focus:outline-none focus:shadow-outline-blue" >
                             <span class="mr-2"> Descargar </span>
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                 <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                   stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                             </svg>
                         </a>
                    </div>
                        
                    @empty
                        
                    @endforelse
                </div>
            </div>
            @endif
        </div>

        <div class="relative overflow-hidden transition-all max-h-0 duration-700" style="" x-ref="container1" x-bind:style="selected == 1 ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : ''">

            <div class="p-6">
                <div class="flex mb-2">
                    <div class="w-1/2 mr-1">
                        <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300"> IVA</label>
                        <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                            <input
                            disabled
                            type="checkbox"
                            {{  $application->internmentProcess->iva ? 'checked="true"' : '' }}
                            class="form-checkbox h-4 w-4 text-gray-800"
                            />
                            {{ number_format($application->internmentProcess->iva_amt,0,",",".") }}
                        </p>
                    </div>
                    <div class="w-1/2 ml-1">
                        <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" >Ad Valorem</label>
                        <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                          
                            <input
                            disabled
                            type="checkbox"
                            {{  $application->internmentProcess->adv ? 'checked="true"' : '' }}
                            class="form-checkbox h-4 w-4 text-gray-800"
                            />
                            {{ number_format($application->internmentProcess->adv_amt,0,",",".") }} 
                        </p>
                    </div>
                </div>
            </div>

            
        </div>

    </li>

</ul>

</div>

@endif

{{-- Fin de  transporte--}}

{{-- Bodegaje Local  --}}
@if (isset($application->localWarehouse->id))

<div class="bg-white border border-gray-200 mb-2" x-data="{selected:null}">
    <ul class="shadow-box">
                    
    <li class="relative border-b border-gray-200">

            <a x-on:click.prevent="selected !== 1 ? selected = 1 : selected = null" type="button" class="w-full px-8 py-6 text-left">
            <div class="flex items-center justify-between">
                <span class="font-bold text-gray-800 dark:text-gray-400">Bodegaje Local </span>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path></svg>
            </div>
        </a>

        <div class="relative overflow-hidden transition-all max-h-0 duration-700" style="" x-ref="container1" x-bind:style="selected == 1 ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : ''">

            <div class="p-6">
                <div class="flex mb-2">
                    <div class="w-1/2 mr-1">
                        <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Ubicacion de Bodegaje</label>
                        <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                           <strong> {{  $application->localWarehouse->warehouse->name }} </strong> {{  $application->localWarehouse->warehouse->address }}
                        </p>
                    </div>
                    <div class="w-1/2 ml-1">
                        <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" >Preferencia de Despacho</label>
                        <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                            {{  $application->localWarehouse->transCompany->name }}  
                        </p>
                    </div>
                </div>
                
            </div>

        </div>

    </li>

</ul>

</div>

@endif

{{-- Fin Bodegaje Local --}}

{{-- Cargamento  --}}
@if (isset($application->loads) && count($application->loads) > 0)

<div class="bg-white border border-gray-200 mb-2" x-data="{selected:null}">
    <ul class="shadow-box">
                    
    <li class="relative border-b border-gray-200">

            <a x-on:click.prevent="selected !== 1 ? selected = 1 : selected = null" type="button" class="w-full px-8 py-6 text-left">
            <div class="flex items-center justify-between">
                <span class="font-bold text-gray-800 dark:text-gray-400">Cargamento </span>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path></svg>
            </div>
        </a>

        <div class="relative overflow-hidden transition-all max-h-0 duration-700" style="" x-ref="container1" x-bind:style="selected == 1 ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : ''">

            <div class="p-6">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-white  uppercase border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800"
                        >
                           
                            <th class="px-4 py-3">{{ $application->type_transport == 'CONTAINER' ? 'Tipo de Container' : 'Tipo de Carga' }} </th>
                            <th class="px-4 py-3">CBM</th>
                            <th class="px-4 py-3">Dimension Unitaria (L W H)</th>
                            <th class="px-4 py-3">Peso Unitario</th>
                            <th class="px-4 py-3">Stackable</th>

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    
                        @forelse ($application->loads as $key => $item)

                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">
                                {{ $application->type_transport == 'CONTAINER' ? $item->container->description : $item->categoryLoad->name }} 
                                
                            </td>
                            <td class="px-4 py-3">
                               {{$item->cbm}}
                            </td>
                            <td class="px-4 py-3">
                                {{$item->length}} x  {{$item->width}} x {{$item->height}} 
                            </td>
                            <td class="px-4 py-3">
                                {{$item->weight}} {{$item->weight_units}}
                            </td>
                            <td class="px-4 py-3">
                                {{$item->stackable}}
                            </td>
                        </tr>
                            
                        @empty
                            
                        @endforelse
                        
                    </tbody>
                </table>
               
            </div>
        </div>

    </li>

</ul>

</div>

@endif

{{-- Fin crgamento --}}
<x-app-layout title="Detalle rastreo">
	<div class="container grid px-6 mx-auto">
        <h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{url()->previous()}}">Seguimiento de Courier</a>  
        </h2>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                ID de rastreo #   {{ $data->TrackingNumber }}
            </h4>

            <h4 class="mb-4 text-sm  text-gray-600 dark:text-gray-300">
               Operacíon #   {{ $application->code }}
            </h4>

            <div class="">
                  <img
                    src=" {{ asset('img/fedex-logo.png') }}"
                    alt="fedex-logo"
                    class="mx-auto h-12 w-24 pb-2"
                  />
            </div>
           
        </div>
       
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                   
                <div class="px-2">
                    <div class="flex mb-4">
                        <div class="w-1/2 mr-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Status:</label>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                            {{ $data->StatusDetail->DelayDetail->ServiceDelayStatus == 'ON_TIME' 
                                ? 'A TIEMPO' : 
                                $data->StatusDetail->Description}}
                            </p>    
                            
                            @if(isset($data->StatusDetail->AncillaryDetails))
                                @forelse ($data->StatusDetail->AncillaryDetails as $key => $item)
                                <div class="flex">
                                @if($item->ActionDescription)
                                <svg class="w-6 h-6 text-red-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>  
                                <p class="text-grey-dark mb-2 text-sm dark:text-gray-300"> 
                            
                                {{$item->ActionDescription}} 
                                </p>
                                @else
                                 {{$item->ReasonDescription}} 
                                @endif
                                </div>
                               

                                @empty
                                    
                                @endforelse
                            @endif
                        </div>
                        <div class="w-1/2 ml-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" >Entrega programada:</label>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                               
                                {{  setlocale(LC_ALL,"es_ES") }}
                             
                                {{  $data->StatusDetail->Code != 'CD'
                                    ? date('d-m-Y H:i', strtotime($data->DatesOrTimes[0]->DateOrTimestamp))
                                    : 'Pendiente'
                                 }}
                            </p>
                        </div>
                    </div>
                </div>
               
                <div class="px-2">
                    <div class="text-center mb-4">
                        <div class=" mr-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">
                                 {{  $data->StatusDetail->Code != 'CD'
                                    ? 'EN TRÁNSITO'
                                    : 'RETRASO DE DESPACHO'
                                 }}</label>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                {{ $data->StatusDetail->Description}}
                            </p>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                               {{ $data->StatusDetail->Location->City }},  {{$data->StatusDetail->Location->StateOrProvinceCode}} {{$data->StatusDetail->Location->CountryCode}}
                            </p>
                        </div>
                        
                    </div>
                </div>

                <div class="px-2">
                    <div class="flex mb-4">
                        <div class="w-1/2 mr-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">
                                De
                            </label>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                {{ $data->ShipperAddress->City}}, {{ $data->ShipperAddress->StateOrProvinceCode}}  {{ $data->ShipperAddress->CountryCode}}
                            </p>
                           
                        </div>
                        <div class="w-1/2 ml-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" >Para</label>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                            {{ $data->DestinationAddress->City}}, {{ $data->DestinationAddress->StateOrProvinceCode}}  {{ $data->DestinationAddress->CountryCode}}
                            </p>
                        </div>
                    </div>
                </div>

            
                @if (isset($data->Events) && count($data->Events) > 0)

                <div class="bg-white border border-gray-200 mb-2" x-data="{selected:null}">
                        <ul class="shadow-box">
                                        
                        <li class="relative border-b border-gray-200">

                                <a x-on:click.prevent="selected !== 1 ? selected = 1 : selected = null" type="button" class="w-full px-8 py-6 text-left">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-gray-800 dark:text-gray-400">Historial de desplazamiento </span>
                                    
                                </div>
                            </a>

                            <div class="relative overflow-hidde overflow-hidden transition-all max-h-0 duration-700" style="" x-ref="container1" x-bind:style="selected == 1 ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : ''">
                                <div class="p-6 overflow-x-auto">
                                    <table class="w-full whitespace-no-wrap">
                                        <thead>
                                            <tr
                                                class="text-xs font-semibold tracking-wide text-left text-white  uppercase border-b dark:border-gray-700 bg-blue-1300 dark:text-gray-400 dark:bg-gray-800"
                                            >
                                                <th class="px-4 py-3">Fecha</th>
                                                <th class="px-4 py-3">Hora</th>
                                                <th class="px-4 py-3">Lugar</th>
                                                <th class="px-4 py-3">Descripción</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                        
                                            @forelse ($data->Events as $key => $item)

                                            <tr class="text-gray-700 dark:text-gray-400">
                                                <td class="px-4 py-3">
                                                    {{ date('d/m/Y', strtotime($item->Timestamp))}} 
                                                </td>
                                                <td class="px-4 py-3">
                                                    {{ date('H:i', strtotime($item->Timestamp))}} 
                                                </td>
                                                <td class="px-4 py-3">
                                                    {{ $item->Address->City }},  {{ $item->Address->StateOrProvinceCode }}  {{ $item->Address->CountryCode }}
                                                </td>
                                                <td class="px-4 py-3 ">
                                                    <p class="break-normal md:break-all">
                                                        {{ $item->EventDescription }} 
                                                    </p>
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

            </div>
        </div>

    </div>
</x-app-layout>
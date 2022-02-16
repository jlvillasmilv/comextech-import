<x-app-layout title="Detalle rastreo">
	<div class="container grid px-6 mx-auto">
        <h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{url()->previous()}}">Seguimiento de DHL</a>  
        </h2>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                ID de rastreo #   {{ $data['AWBNumber'] }}
            </h4>
           
        </div>
       
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                   
                <div class="px-2">
                    <div class="flex mb-4">
                        <div class="w-1/2 mr-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Status:</label>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                {{
                                    $status['ServiceEvent']['EventCode'] == 'RR' || $status['EventCode'] == 'OK' 
                                    ? 'ENTREGADO'
                                    : $status['ServiceEvent']['Description'] 
                                }}
                            </p>    
                            
                           
                        </div>
                        <div class="w-1/2 ml-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" >Entrega programada:</label>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                               
                                {{   date('d-m-Y H:i', strtotime($data['ShipmentInfo']['EstDlvyDate'])) }}
                            </p>
                        </div>
                    </div>
                </div>
               
                <div class="px-2">
                    <div class="text-center mb-4">
                        <div class=" mr-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">
                               
                               </label>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                              
                            </p>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                              
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
                               {{$data['ShipmentInfo']['OriginServiceArea']['Description']}}
                            </p>
                           
                        </div>
                        <div class="w-1/2 ml-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" >Para</label>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                {{$data['ShipmentInfo']['DestinationServiceArea']['Description']}}
                            </p>
                        </div>
                    </div>
                </div>

            
                @if (isset($data['ShipmentInfo']['ShipmentEvent']) && count($data['ShipmentInfo']['ShipmentEvent']) > 0)

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
                                                class="text-xs font-semibold tracking-wide text-left text-white  uppercase border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800"
                                            >
                                                <th class="px-4 py-3">Fecha</th>
                                                <th class="px-4 py-3">Hora</th>
                                                <th class="px-4 py-3">Lugar</th>
                                                <th class="px-4 py-3">Descripción</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                        
                                            @forelse ($data['ShipmentInfo']['ShipmentEvent'] as $key => $item)

                                            <tr class="text-gray-700 dark:text-gray-400">
                                                <td class="px-4 py-3">
                                                    {{ date('d/m/Y', strtotime($item['Date']))}} 
                                                </td>
                                                <td class="px-4 py-3">
                                                    {{ $item['Time']}} 
                                                </td>
                                                <td class="px-4 py-3">
                                                    {{ $item['ServiceArea']['Description'] }}
                                                </td>
                                                <td class="px-4 py-3 ">
                                                    <p class="break-normal md:break-all">
                                                        {{ $item['ServiceEvent']['Description']  }} 
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
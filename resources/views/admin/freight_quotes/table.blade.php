<div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">{{ $data->type_transport == 'CONTAINER' ? 'Tipo de Container' : 'Tipo de Carga' }} </th>
                            <th class="px-4 py-3">Dimension Unitaria (L W H)</th>
                            <th class="px-4 py-3">Peso Unitario</th>
                            <th class="px-4 py-3">Stackable</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @forelse ($data->shipment as $key => $item)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3">
                                    {{ $data->type_transport == 'CONTAINER' ? $item->container->description : $item->categoryLoad->name }} 
                                    
                                </td>
                                <td class="px-4 py-3">
                                    @if ($data->type_transport != 'CONTAINER')
                                        {{$item->length}} x  {{$item->width}} x {{$item->height}} 
                                        <br>
                                        CBM: {{$item->cbm}}
                                    @endif
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
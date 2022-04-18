<div class="w-full mb-8 overflow-hidden rounded-lg ring-1 ring-black ring-opacity-5">
    <div class="w-full overflow-x-auto">
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr
                class="text-sm font-semibold tracking-wide text-left text-white  uppercase border-b dark:border-gray-700 bg-blue-1300 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">Servicio </th>
                    <th class="px-4 py-3">Fecha </th>
                    <th class="px-4 py-3">Moneda / Monto </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                @forelse($application->summary as $detail)
                <tr class="text-gray-700 dark:text-gray-400">
                    
                    <td class="px-4 py-3 text-sm">
                        <p class="font-semibold">{{ $detail->service->name }}</p>
                    </td>
                    <td class="px-4 py-3 text-xs">
                        <div class="flex items-center text-sm">                                 
                            {{ date('d-m-Y', strtotime($detail->fee_date)) }}
                        </div>
                        
                    </td>
                  
                    <td class="px-4 py-3 text-sm">
                         {{number_format($detail->amount, $detail->currency->code == 'CLP' ? 0 : 2 ,",",".") }}
                         {{ $detail->currency->code }} 
                    </td>
                    
                </tr>

                @empty
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3 text-sm" colspan="3">No entries found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
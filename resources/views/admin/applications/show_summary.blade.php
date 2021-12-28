<div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
    <div class="w-full overflow-x-auto">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr
                class="text-sm font-semibold tracking-wide text-left text-white  uppercase border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800">
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
                        {{ $detail->currency->code }}  {{ $detail->currency->symbol }}   {{number_format($detail->amount,0,",",".") }}
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
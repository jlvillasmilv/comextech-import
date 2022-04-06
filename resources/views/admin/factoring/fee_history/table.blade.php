<div class="w-full overflow-x-auto">
    <table  id="table" class="w-full whitespace-no-wrap">
        <thead>
            <tr
                class="text-xs text-center font-semibold tracking-wide text-left text-white border-b dark:border-gray-700 bg-blue-1300 dark:text-gray-400 dark:bg-gray-800">
                <th class="px-4 py-3">N°</th>
                <th class="px-4 py-3">Tasa </th>
                <th class="px-4 py-3">Tasa Mora </th>
                <th class="px-4 py-3">Descuento</th>
                <th class="px-4 py-3">Comisión </th>
                <th class="px-4 py-3">Fecha </th>
                <th class="px-4 py-3">&nbsp;  </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
            @forelse($data->feeshistory->sortDesc() as $fees)

          <tr class="text-gray-700 dark:text-gray-400 text-xs text-center">
            <td class="px-2 py-3 text-center">
                {{ $fees->id}}
            </td>
            <td class="px-2 py-3 text-center">
                {{  number_format($fees->rate,2,",",".").' %' }}
            </td>
            <td class="px-2 py-3 text-center">
                {{  number_format($fees->mora_rate,2,",",".").' %' }}
            </td>
            <td class="px-2 py-3 text-center">
                {{  number_format($fees->discount,2,",",".").' %' }}
            </td>
            <td class="px-2 py-3 text-center">
                {{  number_format($fees->commission,0,",",".") }}
            </td>
            <td class="px-2 py-3 text-center">
                {{  $fees->fee_date }}
            </td>
            <td class="px-4 py-3 text-center">
                <a class="btn btn-sm btn-secondary" href="{{ route('admin.factoring.fee_edit', $fees->id) }}">
                    <i class="far fa-edit" ></i>
                </a>
            </td>

            </tr>
          @empty
              
          @endforelse
            
        </tbody>
      </table>
      
  </div>
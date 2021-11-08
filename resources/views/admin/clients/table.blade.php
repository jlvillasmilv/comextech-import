<div class="w-full overflow-x-auto">
    <table  id="table" class="w-full whitespace-no-wrap">
        <thead>
            <tr
                class="text-xs text-center font-semibold tracking-wide text-left text-white border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800">
                <th class="px-4 py-3">N°</th>
                <th class="px-4 py-3">Fecha escritura</th>
                <th class="px-4 py-3">Notaria </th>
                <th class="px-4 py-3">N° repertorio </th>
                <th class="px-4 py-3">Fecha Registro</th>
                <th class="px-4 py-3">&nbsp; </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
            @forelse($company->user->client_legal_info as $lega_info)

          <tr class="text-gray-700 dark:text-gray-400 text-xs text-center">
                <td class="px-2 py-3 text-center">
                    {{ $lega_info->id}}
                </td>
                <td class="px-4 py-3 text-center ">
                    {{ $lega_info->writing_date}}
                </td>
                <td class="px-4 py-3 text-center ">
                    {{ $lega_info->notary}}
                </td>
                <td class="px-4 py-3 text-center ">
                    {{ $lega_info->repertoire_number}}
                </td>
                
                 <td class="px-4 py-3 text-center ">
                    <a  href="{{ route('admin.clients.legal', $lega_info->id) }}"
                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                        aria-label="Edit">
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                            </path>
                        </svg>
                    </a>
                </td>
            </tr>
          @empty
              
          @endforelse
            
        </tbody>
      </table>
      
  </div>
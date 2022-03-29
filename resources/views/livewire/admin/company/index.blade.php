<div class="container grid px-6 mx-auto">
    <h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
       Clientes
     </h2>

     <div class="flex justify-between items-end">
         <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
             Listado de Clientes
         </h4>
     </div>

  <div class="flex flex-wrap ">
       <div class="w-full md:w-1/2 px-3">
             <select wire:model="perPage" class="flex w-1/2 pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-blue-300 focus:outline-none focus:shadow-outline-blue form-select ">
               @foreach($paginationOptions as $value)
                   <option value="{{ $value }}">{{ $value }}</option>
               @endforeach
           </select>
       </div>
       <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
            <div class="relative w-full max-w-xl mr-6 focus-within:text-blue-500 ">
                 <div class="absolute inset-y-0 flex items-center pl-2">
                     <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                         <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                     </svg>
                 </div>
                 <input  class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-blue-300 focus:outline-none focus:shadow-outline-blue form-input" type="text" placeholder="Busqueda" aria-label="Search" wire:model.debounce.300ms="search" />
             </div>
       </div>
      
   </div>

   <div class="w-full overflow-hidden rounded-lg shadow-xs">
       <div class="w-full overflow-x-auto">
           <table class="w-full whitespace-no-wrap" id="table">
               <thead>
                   <tr
                       class="text-xs font-semibold tracking-wide text-left text-white uppercase border-b dark:border-gray-700 bg-blue-1300 dark:text-blue-1300 dark:bg-gray-800">
                       
                       <th class="px-4 py-3">RUT
                           @include('components.table.sort', ['field' => 'name'])
                       </th>
                       <th class="px-4 py-3">
                            Nombre
                           @include('components.table.sort', ['field' => 'code'])
                       </th>
                       <th class="px-4 py-3">
                             Usuario
                        </th>
                       <th class="px-4 py-3">Actions</th>
                   </tr>
               </thead>
               <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                   @forelse($clients as $client)
                   <tr class="text-gray-700 dark:text-gray-400">
                       
                       <td class="px-4 py-3 text-sm">
                            <p class="font-semibold">{{ $client->tax_id }}</p>
                        </td>
                       <td class="px-4 py-3 text-sm">
                           <p class="font-semibold">{{ $client->name }}</p>
                       </td>
                       <td class="px-4 py-3 text-xs">
                           <div class="flex items-center text-sm">
                              @forelse ($client->users as $user)
                                {{ $user->name }} / {{ $user->email }}
                              @empty
                                  
                              @endforelse                                 
                              
                           </div>
                           
                       </td>
    
                       <td class="px-4 py-3">
                           <div class="flex items-center space-x-4 text-sm">
                               @can('client.show')
                               <a  href="{{ route('admin.clients.show', $client->id) }}" 
                                   class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                   aria-label="Edit">
                                  
                                   <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                       viewBox="0 0 20 20">

                                         <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        
                                         <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                       
                                   </svg>
                               </a>
                               @endcan
                               @can('client.edit')

                                <a  href="{{ route('admin.clients.edit', $client->id) }}" 
                                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-gray-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                    aria-label="Edit">
                                
                                    <svg class="w-5 h-5"
                                         aria-hidden="true"
                                         fill="currentColor"
                                         viewBox="0 0 20 20">
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                        </path>
                                    </svg>
                                </a>

                               @endcan
                               @if ($client->user->credentialStores()->where('provider_name', 'SII')->first())
                                
                               
                               @can('client.show')
                               <a  href="#" 
                                   class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray btn-sync"
                                    data-type="Ventas"
                                    data-remote="{{ route('admin.factoring.ventas.detalle').'?client_id='.$client->user->id.'&month=12'}}" 
                                    title="Sincorinzar ultimos 24 meses del Sii"
                                   aria-label="Edit">
                                  
                                   <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                  </svg>
                               </a>

                               <a  href="#" 
                                   class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-300 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray btn-sync"
                                    data-type="Compras"
                                    data-remote="{{ route('admin.factoring.compras.detalle').'?client_id='.$client->user->id.'&month=12'}}" 
                                    title="Sincorinzar ultimos 24 meses del Sii compras"
                                   aria-label="Edit">
                                  
                                   <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2h2m3-4H9a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-1m-1 4l-3 3m0 0l-3-3m3 3V3" />
                                  </svg>
                               </a>
                               @endcan

                               @endif

                               <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                
                              </svg>
                              
                           </div>
                       </td>
                   </tr>

                   @empty
                   <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3 text-sm" colspan="5">No entries found.</td>
                    </tr>
               @endforelse
               </tbody>
           </table>
       </div>
       {{ $clients->links() }}
   </div>
</div>
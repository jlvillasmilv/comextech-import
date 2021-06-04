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
             <select wire:model="perPage" class="flex w-1/2 pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-select ">
               @foreach($paginationOptions as $value)
                   <option value="{{ $value }}">{{ $value }}</option>
               @endforeach
           </select>
       </div>
       <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
            <div class="relative w-full max-w-xl mr-6 focus-within:text-purple-500 ">
                 <div class="absolute inset-y-0 flex items-center pl-2">
                     <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                         <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                     </svg>
                 </div>
                 <input  class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input" type="text" placeholder="Search for projects" aria-label="Search" wire:model.debounce.300ms="search" />
             </div>
       </div>
      
   </div>

   <div class="w-full overflow-hidden rounded-lg shadow-xs">
       <div class="w-full overflow-x-auto">
           <table class="w-full whitespace-no-wrap">
               <thead>
                   <tr
                       class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                       
                       <th class="px-4 py-3">IT
                           @include('components.table.sort', ['field' => 'name'])
                       </th>
                       <th class="px-4 py-3">
                            Nombre
                           @include('components.table.sort', ['field' => 'code'])
                       </th>
                       <th class="px-4 py-3">
                             Correo
                           @include('components.table.sort', ['field' => 'symbol'])
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
                              {{ $client->email }}
                           </div>
                           
                       </td>
                       <td class="px-4 py-3 text-sm">
                           {{ $client->user->name }}
                       </td>
                       <td class="px-4 py-3">
                           <div class="flex items-center space-x-4 text-sm">
                               @can('client.show')
                               <a  href="{{ route('admin.clients.show', $client->id) }}" 
                                   class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                   aria-label="Edit">
                                  
                                   <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                       viewBox="0 0 20 20">

                                         <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        
                                         <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                       
                                   </svg>
                               </a>
                               @endcan
                              
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
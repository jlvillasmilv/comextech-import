<x-app-layout title="Listado de Solicitudes">

    {{-- download --}}
 @if (isset($application->internmentProcess->fileStoreInternment))
 <div class="p-6">
     <div class="flex mb-2">
         @forelse ($application->internmentProcess->fileStoreInternment as $file)

         <div class="w-auto mr-1">
             <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300"> 
                 {{$file->intl_treaty}}
             </label>
             <a href="{{ route('download.file.internment', [$file->internment_id, $file->intl_treaty]) }}"
                 title="Descarga documento"
               class="flex sm:w-32 px-2 py-2 text-white transition-colors duration-150 bg-blue-1300 rounded-lg active:bg-blue-1300 hover:bg-blue-1200 focus:outline-none focus:shadow-outline-blue" >
                  <span class="mr-2"> Descargar </span>
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path
                         stroke-linecap="round"
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
   
</x-app-layout>
 
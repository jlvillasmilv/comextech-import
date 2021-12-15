<x-app-layout title="Tarifas aereo">
    <div class="container grid px-6 mx-auto">
        <h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
          Tarifas
        </h2>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Listado tarifas FCL
            </h4>

            
            <form action="{{ route('admin.rates.fcl.file.import')}}" method="post" enctype="multipart/form-data">
                @csrf
                @if($errors->has('file'))
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{ $errors->first('file') }}
                    </span>
                @endif
                <div class="flex justify-center">
                    <div class="mb-1 w-96">
                    
                      <input class="form-control
                      block
                      mt-3
                      w-full
                      px-2
                      py-1
                      text-sm
                      font-normal
                      text-gray-700
                      bg-white bg-clip-padding
                      border border-solid border-gray-300
                      rounded
                      transition
                      ease-in-out
                      m-0
                      focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                      accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                      id="formFileSm"
                      type="file"
                      name="file" >
                      
                    </div>
                    <button  class="flex  px-2 py-2 m-2  text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-blue">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>   
                        <span>Enviar </span>
                    </button>
                  </div>

               

            </form>

            <a  href="{{ route('admin.rates.fcl.create') }}" class="flex  px-2 py-2 m-2  text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-blue">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>   
                <span>Nuevo registro </span>
                
            </a>

        </div>
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full whitespace-no-wrap">
                <livewire:admin.rates.fcl-table searchable="from" />
            </div>
        </div>

    </div>
</x-app-layout>

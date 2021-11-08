<x-app-layout title="Solicitudes">

  <div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            
    </h2>
    
    <div class="grid gap-6 mb-8 ">
      <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <div class="flex justify-between items-end">
          <h2 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
            Base de calculo
          </h2>

          @can('fees_history.create')

          <div class="flex items-center justify-center mb-4">
            <a  href="{{ route('admin.factoring.payers.export') }}" class="flex  px-2 py-2 m-2  text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-300 border border-transparent rounded-lg active:bg-green-300 hover:bg-green-400 focus:outline-none focus:shadow-outline-blue">
              <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
              </svg>   
              <span> Descargar </span>
            </a>


            <a  href="{{ route('admin.factoring.fee_history.create') }}" class="flex  px-2 py-2 m-2  text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-blue">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
              </svg>   
              <span>Nuevo </span>
            </a>
          </div>
    
         @endcan


        </div>
        
        <div>
          <form method="POST"  action="{{route('admin.factoring.feehistory.import.excel')}}" accept-charset="UTF-8" enctype="multipart/form-data">
              <input type="hidden"  name="_token" value="{{ csrf_token() }}">

              <div class="flex items-center justify-start mb-4">

                <label class="w-64 flex flex-col items-center px-4 py- bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-white">
                  <svg class="w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                  <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                  </svg>
                  <span class="mt-2 text-base leading-normal"> Archivo de Pagadores</span>
                  <input type='file'
                  class="hidden"
                    name="payers_excel"
                    accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                    />
              </label>

              <button type="submit" class="flex  px-2 py-2 m-2  text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                Enviar
              </button>
              </div>
              
              
            </form>
      </div>
              
        <div class="w-full overflow-x-auto">
            <livewire:admin.factoring.fee-history-table />
                    
        </div>
      </div>
    </div>
  </div>
     
</x-app-layout>
<x-app-layout title="Solicitudes">

  <div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            
    </h2>
    
    <div class="grid gap-6 mb-8 ">
      <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <div class="flex justify-between items-end">
          <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
            Base de calculo
          </h4>
          <a  href="{{ route('admin.factoring.fee_history.create') }}" class="flex  px-2 py-2 m-2  text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-blue">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>   
            <span>Nuevo registro </span>
          </a>
        </div>
        
              
        <div class="w-full overflow-x-auto">
            <livewire:admin.factoring.fee-history-table
                exportable
                />
                    
        </div>
      </div>
    </div>
  </div>
     
</x-app-layout>
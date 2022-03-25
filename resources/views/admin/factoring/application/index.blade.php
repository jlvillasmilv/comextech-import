<x-app-layout title="Solicitudes">


<div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        
    </h2>

    <div class="grid gap-6 mb-8 ">
      <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
            Listado de Solicitudes
        </h4>
    
          
          <div class="w-full overflow-x-auto">
            <livewire:admin.factoring.application-table />
                
            </div>
        </div>
    </div>
</div>
 
</x-app-layout>


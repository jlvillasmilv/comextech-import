<x-app-layout title="Solicitudes">

    <div class="container grid sm:px-1 md:px-4 mx-auto">

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Solicitudes de clientes
            </h4>
        </div>
       
        <livewire:admin.factoring.application-table searchable="name" />
            
    </div>
    
</x-app-layout>

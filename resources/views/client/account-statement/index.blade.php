<x-app-layout title="Cartola">
    <div class="container grid px-6 mx-auto">
        <h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Cartola
        </h2>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Movimientos
            </h4>
        </div>
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full whitespace-no-wrap">
                <livewire:client.account-statement-table />
            </div>
        </div>

    </div>
   
</x-app-layout>
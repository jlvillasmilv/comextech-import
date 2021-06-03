<x-app-layout title="Import">
    <div class="container px-6 mx-auto ">
        <div class="flex justify-center px-6 m-auto my-8 ">
            <div class=" w-2/3 mx-3 px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800    ">
                <h3 class="my-4  font-semibold text-gray-700 dark:text-gray-200">
                    Nuevo Proveedor
                </h3>
                <label class="block text-sm my-3">
                    <span class="text-gray-700 dark:text-gray-400"> Nombre</span>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Empresa" />
                </label>
                <label class="block text-sm my-3">
                    <span class="text-gray-700 dark:text-gray-400"> Banco</span>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Cuenta Bancaria" />
                </label>
                <label class="block text-sm my-3">
                    <span class="text-gray-700 dark:text-gray-400"> ISIN </span>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder=" Número de identificación de valores internacionales
                    " />
                </label>
                <label class="block text-sm my-3">
                    <span class="text-gray-700 dark:text-gray-400"> Direccion </span>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Direccion Postal" />
                </label>
                <label class="block text-sm my-3">
                    <span class="text-gray-700 dark:text-gray-400"> IBAN </span>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Código Internacional de Cuenta Bancaria" />
                </label>
                <label class="block text-sm my-3">
                    <span class="text-gray-700 dark:text-gray-400"> Direccion de Origen </span>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Origen de importacion" />
                </label>
                <div class="flex  justify-start">
                        <button class="flex  px-5 py-2  text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2h2m3-4H9a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-1m-1 4l-3 3m0 0l-3-3m3 3V3" />
                                </svg>
                            <span> Guardar </span>
                        </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
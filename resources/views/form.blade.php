
 
    <div class="w-1/2 mx-3 px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
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
       
            <!-- Divs are used just to display the examples. Use only the button. -->
       <div class="flex justify-end">
        <button class="flex  px-4 py-2 my-8 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2h2m3-4H9a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-1m-1 4l-3 3m0 0l-3-3m3 3V3" />
                </svg>
            <span> Guardar </span>
        </button>
       </div>
    </div>
    
 
    <div class="w-1/2 mb-8 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Pago</th>
                        <th class="">Porcentaje</th>
                        <th class="px-4 py-3">Moneda</th>
                        <th class="px-4 py-3">Monto</th>
                        <th class="px-4 py-3">Forma</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm">
                                <!-- Avatar with inset shadow -->
                                <div>
                                    <p class="font-semibold"> Adelantado </p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">
                                        6/10/2020
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-2 py-2 text-sm">
                            10 %
                        </td>
                        <td class="px-4 py-3 text-sm">
                            USD
                        </td>
                        <td class="px-4 py-3 text-sm">
                            $ 369.95
                        </td>
                        <td class="px-4 py-3 text-xs">
                            <span
                                class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:text-white dark:bg-green-600">
                                Contado
                            </span>
                        </td>   
                    </tr>
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm">
                                <!-- Avatar with inset shadow -->
                                <div>
                                    <p class="font-semibold"> Pago 1 </p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">
                                        6/10/2020
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-2 py-2 text-sm">
                            10 %
                        </td>
                        <td class="px-4 py-3 text-sm">
                            USD
                        </td>
                        <td class="px-4 py-3 text-sm">
                            $ 369.95
                        </td>
                        <td class="px-4 py-3 text-xs">
                            <span
                                class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:text-white dark:bg-yellow-600">
                                Financiado
                            </span>
                        </td>   
                    </tr>
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm">
                                <!-- Avatar with inset shadow -->
                                <div>
                                    <p class="font-semibold"> Adelantado </p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">
                                        6/10/2020
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-2 py-2 text-sm">
                            10 %
                        </td>
                        <td class="px-4 py-3 text-sm">
                            USD
                        </td>
                        <td class="px-4 py-3 text-sm">
                            $ 369.95
                        </td>
                        <td class="px-4 py-3 text-xs">
                            <span
                                class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:text-white dark:bg-green-600">
                                Contado
                            </span>
                        </td>   
                    </tr>
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm">
                                <!-- Avatar with inset shadow -->
                                <div>
                                    <p class="font-semibold"> Pago 1 </p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">
                                        6/10/2020
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-2 py-2 text-sm">
                            10 %
                        </td>
                        <td class="px-4 py-3 text-sm">
                            USD
                        </td>
                        <td class="px-4 py-3 text-sm">
                            $ 369.95
                        </td>
                        <td class="px-4 py-3 text-xs">
                            <span
                                class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:text-white dark:bg-yellow-600">
                                Financiado
                            </span>
                        </td>   
                    </tr>
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm">
                                <!-- Avatar with inset shadow -->
                                <div>
                                    <p class="font-semibold"> Adelantado </p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">
                                        6/10/2020
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-2 py-2 text-sm">
                            10 %
                        </td>
                        <td class="px-4 py-3 text-sm">
                            USD
                        </td>
                        <td class="px-4 py-3 text-sm">
                            $ 369.95
                        </td>
                        <td class="px-4 py-3 text-xs">
                            <span
                                class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:text-white dark:bg-green-600">
                                Contado
                            </span>
                        </td>   
                    </tr>
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm">
                                <!-- Avatar with inset shadow -->
                                <div>
                                    <p class="font-semibold"> Pago 1 </p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">
                                        6/10/2020
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-2 py-2 text-sm">
                            10 %
                        </td>
                        <td class="px-4 py-3 text-sm">
                            USD
                        </td>
                        <td class="px-4 py-3 text-sm">
                            $ 369.95
                        </td>
                        <td class="px-4 py-3 text-xs">
                            <span
                                class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:text-white dark:bg-yellow-600">
                                Financiado
                            </span>
                        </td>   
                    </tr>
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm">
                                <!-- Avatar with inset shadow -->
                                <div>
                                    <p class="font-semibold"> Adelantado </p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">
                                        6/10/2020
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-2 py-2 text-sm">
                            10 %
                        </td>
                        <td class="px-4 py-3 text-sm">
                            USD
                        </td>
                        <td class="px-4 py-3 text-sm">
                            $ 369.95
                        </td>
                        <td class="px-4 py-3 text-xs">
                            <span
                                class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:text-white dark:bg-green-600">
                                Contado
                            </span>
                        </td>   
                    </tr>
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm">
                                <!-- Avatar with inset shadow -->
                                <div>
                                    <p class="font-semibold"> Pago 1 </p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">
                                        6/10/2020
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-2 py-2 text-sm">
                            10 %
                        </td>
                        <td class="px-4 py-3 text-sm">
                            USD
                        </td>
                        <td class="px-4 py-3 text-sm">
                            $ 369.95
                        </td>
                        <td class="px-4 py-3 text-xs">
                            <span
                                class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:text-white dark:bg-yellow-600">
                                Financiado
                            </span>
                        </td>   
                    </tr>
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm">
                                <!-- Avatar with inset shadow -->
                                <div>
                                    <p class="font-semibold"> Adelantado </p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">
                                        6/10/2020
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-2 py-2 text-sm">
                            10 %
                        </td>
                        <td class="px-4 py-3 text-sm">
                            USD
                        </td>
                        <td class="px-4 py-3 text-sm">
                            $ 369.95
                        </td>
                        <td class="px-4 py-3 text-xs">
                            <span
                                class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:text-white dark:bg-green-600">
                                Contado
                            </span>
                        </td>   
                    </tr>
                  
                     
                </tbody>
            </table>
        </div>
        
    </div>
 

<template>
    <div class="flex">
         <div class="w-1/2   bg-white p-3 dark:text-gray-400 dark:bg-gray-800">
            <div class="  px-4 py-3 text-gray-500 text-lg">   </div>
            <div class="mb-8 overflow-hidden rounded-lg shadow-xs">
                    <div class="flex w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr class="text-xs font-semibold tracking-wide text-left text-white  uppercase border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-4 py-3">
                                        Fuente
                                    </th>
                                    <th class="text-center "> Monto </th>
                                    <th class="px-4 py-3 text-center"> Pago </th>
                                 </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            <!-- Avatar with inset shadow -->
                                            <div>
                                                <p class="font-semibold tex-2x1"> Contado </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 text-sm text-center">
                                        <p class=" tex-2x1 text-center">  47.000 </p>
                                        
                                    </td>
                                    <td class="px-2 py-2 text-sm text-center">
                                        <p class=" tex-2x1">  65.614 </p>
                                    </td>
                                </tr>
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            <!-- Avatar with inset shadow -->
                                            <div>
                                                <p class="font-semibold"> Factura </p>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-2 py-2 text-sm text-center">
                                        5.300
                                    </td>
                                    <td class="px-4 py-3 text-sm text-center ">
                                            5.300
                                    </td>
                                    
                                </tr>
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            <!-- Avatar with inset shadow -->
                                            <div>
                                                <p class="font-semibold"> Financiamiento </p>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-2 py-2 text-sm text-center">
                                        10-07-2021
                                    </td>
                                    <td class="px-4 py-3 text-sm text-center ">
                                            Contado
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
        <div class="w-1/2   bg-white dark:text-gray-400 dark:bg-gray-800 p-3 rounded-lg">
            <div class="  px-4 py-3 text-gray-500 text-lg">   </div>
            <div class="mb-8 overflow-hidden rounded-lg shadow-xs">
                    <div class="flex w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr
                                    class="text-xs font-semibold tracking-wide text-left text-white  uppercase border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-4 py-3">
                                        Concepto
                                    </th>
                                    <th class="text-center "> Monto MO</th>
                                    <th class="px-4 py-3 text-center">Monto $$</th>
                                    <th class="px-4 py-3 text-center ">Fecha</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            <!-- Avatar with inset shadow -->
                                            <div>
                                                <p class="font-semibold tex-2x1"> Pago a proveedor </p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-3">
                                                    Adelantado
                                                </p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                                    Saldo
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 text-sm text-center">
                                        <p class="font-semibold tex-2x1 text-center">  47.000 </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-3">
                                            35.000
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                                17.000
                                        </p>
                                    </td>
                                    <td class="px-2 py-2 text-sm text-center">
                                        <p class="font-semibold tex-2x1">  65.614 </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-3">
                                                48.862
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                                23.733
                                        </p>
                                    </td>
                                    <td class="px-2 py-2 text-sm text-center">
                                        <p class="font-semibold tex-2x1">  - </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-3">
                                            20-03-2021
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            20-19-2021
                                        </p>
                                    </td>
                                </tr>
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            <!-- Avatar with inset shadow -->
                                            <div>
                                                <p class="font-semibold"> Seguro de Transporte </p>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-2 py-2 text-sm text-center">
                                        5.300
                                    </td>
                                    <td class="px-4 py-3 text-sm text-center ">
                                            5.300
                                    </td>
                                    <td class="px-4 py-3 text-sm text-center">
                                        10-03-2021
                                    </td>
                                </tr>
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            <!-- Avatar with inset shadow -->
                                            <div>
                                                <p class="font-semibold"> Servicio AGA </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 text-sm text-center">
                                        5.300
                                    </td>
                                    <td class="px-4 py-3 text-sm text-center ">
                                            5.300
                                    </td>
                                    <td class="px-4 py-3 text-sm text-center">
                                        10-03-2021
                                    </td>
                                        
                                </tr>
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            <!-- Avatar with inset shadow -->
                                            <div>
                                                <p class="font-semibold"> IVA Internacional </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 text-sm text-center">
                                        5.300
                                    </td>
                                    <td class="px-4 py-3 text-sm text-center ">
                                            5.300
                                    </td>
                                    <td class="px-4 py-3 text-sm text-center">
                                        10-03-2021
                                    </td>
                                        
                                </tr>
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            <!-- Avatar with inset shadow -->
                                            <div>
                                                <p class="font-semibold"> Aranceles </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 text-sm text-center">
                                        5.300
                                    </td>
                                    <td class="px-4 py-3 text-sm text-center ">
                                            5.300
                                    </td>
                                    <td class="px-4 py-3 text-sm text-center">
                                        10-03-2021
                                    </td>
                                </tr>
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            <!-- Avatar with inset shadow -->
                                            <div>
                                                <p class="font-semibold"> Transporte Local </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 text-sm text-center">
                                        5.300
                                    </td>
                                    <td class="px-4 py-3 text-sm text-center ">
                                            5.300
                                    </td>
                                    <td class="px-4 py-3 text-sm text-center">
                                        10-03-2021
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
       
    </div>
        
     
</template>

<script>
export default {

}
</script>

<style>

</style>
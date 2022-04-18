<x-app-layout title="Services">
    <div class="container grid px-6 mx-auto">
        <h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Detalles de Solicitud
        </h2>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                  Solicitudes Nro 1
            </h4>
            <a   href="{{ route('services.show')}}" class="flex  px-2 py-2 m-2  text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-blue">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>   
                <span> Nuevo Solicitud </span>
            </a>
        </div>
    <div class="flex">
        <div class="w-1/2   bg-white p-3 dark:text-gray-400 dark:bg-gray-800">
           <div class="  px-4 py-3 text-gray-500 text-lg">   </div>
           <div class="mb-8 overflow-hidden rounded-lg ring-1 ring-black ring-opacity-5">
                   <div class="flex w-full overflow-x-auto">
                       <table class="w-full whitespace-nowrap">
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
           <div class="mb-8 overflow-hidden rounded-lg ring-1 ring-black ring-opacity-5">
                   <div class="flex w-full overflow-x-auto">
                       <table class="w-full whitespace-nowrap">
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
    </div>
</x-app-layout>
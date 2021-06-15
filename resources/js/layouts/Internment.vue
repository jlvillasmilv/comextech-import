<template>
     <div class="container grid px-6 mx-auto">
        <!-- Cards with title -->
        <!-- <div class="flex bg-white mb-4">
              <div class="w-full p-4 rounded-lg shadow-xs dark:bg-gray-800 min-w-0 "></div>
        </div> -->
        <div class="grid gap-6 mb-8 md:grid-cols-2">
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-3 font-semibold text-gray-900 dark:text-gray-300"> Informacion de Aduana </h4>
                <div class="flex flex-wrap -mx-3  ">
                    <div class="w-full md:w-full px-3 md:mb-0">
                             <h3 class="my-4  text-gray-500 text-sm">
                                    Agente de Aduana
                            </h3>
                            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input " placeholder="Ingrese los datos de su agente aduana  " />
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600" ><span class="ml-2 text-xs text-black  text-gray-500"> Quiero que Comextech me asigne mi agente de aduana </span>
                    </div>
                    <div class="w-full md:w-full px-3 md:mb-0"> 
                             <h3 class="my-4  text-gray-500 text-sm">
                                    Pago de Agente de Aduana
                            </h3>
                            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input " placeholder="Monto" />
                            <!-- <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600" ><span class="ml-2 text-xs text-black"> Ingrese los datos de su agente aduana  </span> -->
                    </div>
               
                </div>
            </div>
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-3 font-semibold text-gray-900 dark:text-gray-300"> Requisitos   </h4>
                <div>
                    <h3 class="my-4  text-gray-500 text-sm"> 
                        Certificado 
                    </h3>
                    <div class="text-gray-600 dark:text-gray-400 flex space-x-5 justify-start">
                        <label class="inline-flex items-center mt-3">
                            <input type="radio" class="form-checkbox h-5 w-5 text-blue-600" id="1" name="1"> <span class="ml-2 text-black"> Origen</span>
                        </label>
                        <label class="inline-flex items-center mt-3">
                            <input type="radio" class="form-checkbox h-5 w-5 text-blue-600" id="1" name="1"> <span class="ml-2 text-black"> Fitosanitario</span>
                        </label>
                        <label class="inline-flex items-center mt-3">
                            <input type="radio" class="form-checkbox h-5 w-5 text-blue-600" id="1" name="1"> <span class="ml-2 text-black"> Form F</span>
                        </label>
                    </div>
                </div>
                <div  >
                    <h3  class="my-4  text-gray-500 text-sm">
                        Tratados Internacional
                    </h3>
                    <div class="text-gray-600 dark:text-gray-400 flex space-x-5 justify-start  ">
                        <label class="inline-flex items-center mt-3">
                            <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" ><span class="ml-2 text-black"> Mercosur</span>
                        </label>
                        <label class="inline-flex items-center mt-3">
                            <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" ><span class="ml-2 text-black"> Eur1 </span>
                        </label>
                        <label class="inline-flex items-center mt-3">
                            <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" ><span class="ml-2 text-black"> Form1 F</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
</template>
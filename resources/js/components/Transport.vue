<template>
  <div class="container grid px-6 my-1 ">
        
            <div class="flex flex-wrap -mx-3">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400"> Origen de Envio </span>
                        <input 
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" 
                            placeholder="Nombre o codigo Puerto/Aeropuerto"
                        />
                    </label>
                    <div class="mt-2 text-sm">
                        <label class="inline-flex items-center text-gray-500 dark:text-gray-400">
                            <input type="checkbox" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="accountType" value="personal" />
                            <span class="ml-2"> Incluir Gastos Locales</span>
                        </label>
                        <label class="inline-flex items-center ml-6 text-gray-500 dark:text-gray-400">
                            <input type="checkbox" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="accountType" value="busines" />
                            <span class="ml-2"> Factory/Warehouse (EXW)</span>
                        </label>
                    </div>
                </div>
                <div class="w-full md:w-1/2 px-3">
                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400"> Destino de Envio</span>
                            <input 
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" 
                                placeholder="Nombre o codigo Puerto/Aeropuerto" 
                            />
                    </label>
                    <div class="mt-2 text-sm">
                        <label class="inline-flex items-center text-gray-500 dark:text-gray-400">
                            <input type="checkbox" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="accountType" value="personal" />
                            <span class="ml-2"> Incluir Gastos Locales</span>
                        </label>
                        <label class="inline-flex items-center ml-6 text-gray-500 dark:text-gray-400">
                            <input type="checkbox" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="accountType" value="busines" />
                            <span class="ml-2"> Fabricar/Almacen </span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-1/4 px-3 mb-6 md:mb-0">
                    <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400"> Fecha Estimada de Embarcacion </span>
                        <input  type="date" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" 
                            placeholder="Nombre o codigo Puerto/Aeropuerto"
                        />
                    </label>
                </div>
                <div class="w-1/3 px-2">
                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400"> Descripcion de la carga </span>
                            <input 
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" 
                                placeholder="Introduzca la descripcion aqui" 
                            />
                    </label>
                </div>
                <div class="w-1/6 mt-8">
                     <label class="ml-6 text-gray-500 dark:text-gray-400">
                            <input type="checkbox" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="accountType" value="busines" />
                            <span class="ml-2">   Seguro</span>
                        </label>
                </div>
            </div>
         
  <!-- <div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full px-3">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
        Password
      </label>
      <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-password" type="password" placeholder="******************">
      <p class="text-gray-600 text-xs italic">Make it as long and as crazy as you'd like</p>
    </div>
  </div>
  <div class="flex flex-wrap -mx-3 mb-2">
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-city">
        City
      </label>
      <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-city" type="text" placeholder="Albuquerque">
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
        State
      </label>
      <div class="relative">
        <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
          <option>Nw Mexico</option>
          <option>Missouri</option>
          <option>Texas</option>
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
        </div>
      </div>
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-zip">
        Zip
      </label>
      <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-zip" type="text" placeholder="90210">
    </div>
  </div> -->


<!-- 
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Forms
        </h2>  

         <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
            Elements
        </h4>
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class=" w-full">
                <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Name</span>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Jane Doe" />
                </label>
                <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Name</span>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Jane Doe" />
                </label>
            </div>
           

            <div class="mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    Account Type
                </span>
                <div class="mt-2">
                    <label class="inline-flex items-center text-gray-600 dark:text-gray-400">
                        <input type="radio" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="accountType" value="personal" />
                        <span class="ml-2">Personal</span>
                    </label>
                    <label class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400">
                        <input type="radio" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="accountType" value="busines" />
                        <span class="ml-2">Business</span>
                    </label>
                </div>
            </div>

            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    Requested Limit
                </span>
                <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                    <option>$1,000</option>
                    <option>$5,000</option>
                    <option>$10,000</option>
                    <option>$25,000</option>
                </select>
            </label>

            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    Multiselect
                </span>
                <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" multiple>
                    <option>Option 1</option>
                    <option>Option 2</option>
                    <option>Option 3</option>
                    <option>Option 4</option>
                    <option>Option 5</option>
                </select>
            </label>

            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Message</span>
                <textarea class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" rows="3" placeholder="Enter some long form content."></textarea>
            </label>

            <div class="flex mt-6 text-sm">
                <label class="flex items-center dark:text-gray-400">
                    <input type="checkbox" class="text-purple-600 form-checkbox focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" />
                    <span class="ml-2">
                        I agree to the
                        <span class="underline">privacy policy</span>
                    </span>
                </label>
            </div>
        </div>  

         <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
            Validation
        </h4>
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
             <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    Invalid input
                </span>
                <input class="block w-full mt-1 text-sm border-red-600 dark:text-gray-300 dark:bg-gray-700 focus:border-red-400 focus:outline-none focus:shadow-outline-red form-input" placeholder="Jane Doe" />
                <span class="text-xs text-red-600 dark:text-red-400">
                    Your password is too short.
                </span>
            </label>

             <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    Valid input
                </span>
                <input class="block w-full mt-1 text-sm border-green-600 dark:text-gray-300 dark:bg-gray-700 focus:border-green-400 focus:outline-none focus:shadow-outline-green form-input" placeholder="Jane Doe" />
                <span class="text-xs text-green-600 dark:text-green-400">
                    Your password is strong.
                </span>
            </label>
  
             <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    Helper text
                </span>
                <input class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input" placeholder="Jane Doe" />
                <span class="text-xs text-gray-600 dark:text-gray-400">
                    Your password must be at least 6 characters long.
                </span>
            </label>
        </div>

         <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
            Icons
        </h4>
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Icon left</span>
                 <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                    <input class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input" placeholder="Jane Doe" />
                    <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                </div>
            </label>

            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Icon right</span>
                 <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                    <input class="block w-full pr-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input" placeholder="Jane Doe" />
                    <div class="absolute inset-y-0 right-0 flex items-center mr-3 pointer-events-none">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                </div>
            </label>
        </div>

         <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
            Buttons
        </h4>
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    Button left
                </span>
                <div class="relative">
                    <input class="block w-full pl-20 mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input" placeholder="Jane Doe" />
                    <button class="absolute inset-y-0 px-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-l-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                        Click
                    </button>
                </div>
            </label>

            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    Button right
                </span>
                <div class="relative text-gray-500 focus-within:text-purple-600">
                    <input class="block w-full pr-20 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input" placeholder="Jane Doe" />
                    <button class="absolute inset-y-0 right-0 px-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-r-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Click
                    </button>
                </div>
            </label>
        </div> -->

    
    </div>
</template>

<script>
export default {

}
</script>

<style>

</style>
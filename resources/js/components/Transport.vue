<template>
<div class="flex px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800" >
    <div class="container grid px-6 my-1 ">
        <div class="w-full  3 mb-6 md:mb-0">
            <div class="flex flex-wrap">
                <h1 class="flex-auto text-2xl text-blue-900 ">
                    Cotizador Online
                </h1>
            </div>
            <div class="flex  mt-3 dark:text-gray-400  ">
                <ul class="flex  space-x-2 mt-3 ">
                        <li  class="cursor-pointer px-5 text-gray-900 border-b-2  border-blue-500">
                            AEREO
                        </li>
                    
                        <!-- <li  class="cursor-pointer px-5 text-gray-500 border-b-2 text-b-500 border-blue-500 ">
                                Currier
                        </li>
                    
                        <li  class="cursor-pointer px-5 text-gray-500 border-b-2">
                                Consolidado
                        </li> -->
                </ul>
            </div>
            <div class="flex w-full justify-items-center inline-flex dark:text-gray-400 space-x-5 mt-2 ">
                <div class="inline w-1/6">
                    <span class=" text-sm my-2 font-semibold "> Calcular por</span>
                    <div class="block space-x-0">
                        <button  @click="modeCalculate = !modeCalculate"  :class="['focus:outline-none  font-medium py-2 px-4 rounded-2 rounded-lg', !modeCalculate ? 'bg-blue-800 text-white' : 'bg-gray-50']">
                            Envio
                        </button>
                        <button @click="modeCalculate = !modeCalculate"  :class="['focus:outline-none font-medium py-2 px-4 rounded-2 rounded-lg', modeCalculate ? 'bg-blue-800 text-white' : 'bg-gray-50']">
                            Unidad
                        </button>  
                    </div>
                </div>
                <div class="inline w-1/6">
                    <!-- <span class="text-sm  "> Tipo de Carga  </span> -->
                    <div class="mt-6">
                        <v-select label="name"   placeholder="Tipo de Carga" :options="[]" > ">
                            <template  v-slot:no-options="{ search, searching }" >
                                <template v-if="searching" class="text-sm font-semibold ">
                                Lo sentimos no hay opciones que coincidan <strong>{{ search }}</strong>.
                            </template>
                            <em style="opacity: 0.5;" v-else> No posee proveedores en tu lista</em>
                                </template>
                        </v-select>
                    </div>
                </div>
                <div class="inline">
                    <span class="text-sm text-center font-semibold "> Dimension Unitaria  </span>
                    <div class="flex">
                        <input class="h-9 w-13 focus:outline-none border rounded-l-lg flex items-center text-center  text-sm" value="" maxlength="1" max="9" min="0"  placeholder="L" >  
                        <input class="h-9 w-13 focus:outline-none border rounded-none flex items-center text-center  text-sm" value="" maxlength="1" max="9" min="0"  placeholder="W"  > 
                        <input class="h-9 w-13 focus:outline-none border rounded-r-lg flex items-center text-center  text-sm" value="" maxlength="1" max="9" min="0"  placeholder="H">  
                    </div>
                    <label class="inline-flex text-sm items-center mx-2 mt-2">
                    <input type="radio" name="radio"  class="form-checkbox h-4 w-4 text-gray-800"  id="1" checked ><span class="ml-2 text-gray-700"> cm </span>
                    </label>
                    <label class="inline-flex text-sm items-center mx-2  mt-2">
                        <input type="radio" name="radio" class="form-checkbox h-4 w-4 text-gray-800"  id="1"  ><span class="ml-2 text-gray-700"> pulg </span>
                    </label>
                </div>
                <div class="inline text-center">
                    <span class="text-sm text-center font-semibold "> CBM </span>
                    <input class="h-9 w-15 focus:outline-none border  rounded-lg flex text-center  text-sm" value="0"   placeholder="CBM" >  
                </div>
                <div class="inline">
                    <span class="text-sm font-semibold">    Peso Unitario </span>
                    <input class="h-9 w-17 focus:outline-none border rounded-lg flex text-center   text-sm" value="0" >  
                        <label class="inline-flex text-sm items-center mx-2 mt-2">
                        <input type="radio" name="k" id="k" class="form-checkbox h-4 w-4 text-gray-800" checked><span class="ml-2 text-gray-700"> kg </span>
                    </label>
                        <label class="inline-flex text-sm items-center mx-2  mt-2">
                        <input type="radio" name="k" id="k" class="form-checkbox h-4 w-4 text-gray-800"  ><span class="ml-2 text-gray-700"> lbs </span>
                    </label>
                </div>
                <div class="flex">
        
                        <label class="inline-flex text-sm items-center ">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-gray-800" checked><span class="ml-2 text-gray-700 ">Non Stackable</span>
                    </label>
                </div>
            </div>
            <div class="flex w-full justify-items-center inline-flex dark:text-gray-400 space-x-5 mt-2 ">
                <div class="inline w-1/6">
                   
                </div>
                <div class="inline w-1/6">
                    <!-- <span class="text-sm  "> Tipo de Carga  </span> -->
                    <div class="mt-6">
                        <v-select label="name"   placeholder="Tipo de Carga" :options="[]" > ">
                            <template  v-slot:no-options="{ search, searching }" >
                                <template v-if="searching" class="text-sm font-semibold ">
                                Lo sentimos no hay opciones que coincidan <strong>{{ search }}</strong>.
                            </template>
                            <em style="opacity: 0.5;" v-else> No posee proveedores en tu lista</em>
                                </template>
                        </v-select>
                    </div>
                </div>
                <div class="inline">
                    <span class="text-sm text-center font-semibold "> Dimension Unitaria  </span>
                    <div class="flex">
                        <input class="h-9 w-13 focus:outline-none border rounded-l-lg flex items-center text-center  text-sm" value="" maxlength="1" max="9" min="0"  placeholder="L" >  
                        <input class="h-9 w-13 focus:outline-none border rounded-none flex items-center text-center  text-sm" value="" maxlength="1" max="9" min="0"  placeholder="W"  > 
                        <input class="h-9 w-13 focus:outline-none border rounded-r-lg flex items-center text-center  text-sm" value="" maxlength="1" max="9" min="0"  placeholder="H">  
                    </div>
                    <label class="inline-flex text-sm items-center mx-2 mt-2">
                    <input type="radio" name="radio"  class="form-checkbox h-4 w-4 text-gray-800"  id="1" checked ><span class="ml-2 text-gray-700"> cm </span>
                    </label>
                    <label class="inline-flex text-sm items-center mx-2  mt-2">
                        <input type="radio" name="radio" class="form-checkbox h-4 w-4 text-gray-800"  id="1"  ><span class="ml-2 text-gray-700"> pulg </span>
                    </label>
                </div>
                <div class="inline text-center">
                    <span class="text-sm text-center font-semibold "> CBM </span>
                    <input class="h-9 w-15 focus:outline-none border  rounded-lg flex text-center  text-sm" value="0"   placeholder="CBM" >  
                </div>
                <div class="inline">
                    <span class="text-sm font-semibold">    Peso Unitario </span>
                    <input class="h-9 w-17 focus:outline-none border rounded-lg flex text-center   text-sm" value="0" >  
                        <label class="inline-flex text-sm items-center mx-2 mt-2">
                        <input type="radio" name="k" id="k" class="form-checkbox h-4 w-4 text-gray-800" checked><span class="ml-2 text-gray-700"> kg </span>
                    </label>
                        <label class="inline-flex text-sm items-center mx-2  mt-2">
                        <input type="radio" name="k" id="k" class="form-checkbox h-4 w-4 text-gray-800"  ><span class="ml-2 text-gray-700"> lbs </span>
                    </label>
                </div>
                <div class="flex">
        
                        <label class="inline-flex text-sm items-center ">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-gray-800" checked><span class="ml-2 text-gray-700 ">Non Stackable</span>
                    </label>
                </div>
            </div>
            <!-- <div class="flex w-full justify-items-center inline-flex dark:text-gray-400 space-x-5 my-3 ">
                
                
            </div> -->
        </div>
        <div class="flex flex-wrap -mx-3">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400 font-semibold "> Origen de Envio </span>
                    <input 
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" 
                        placeholder="Nombre o codigo Puerto/Aeropuerto"
                    />
                </label>
                <div class="mt-2 text-sm">
                    <label class="inline-flex items-center text-gray-500 dark:text-gray-400">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-gray-800"  > 
                        <span class="ml-2   "> Incluir Gastos Locales</span>
                    </label>
                    <label class="inline-flex items-center ml-6 text-gray-500 dark:text-gray-400">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-gray-800"  > 
                        <span class="ml-2"> Factory/Warehouse (EXW)</span>
                    </label>
                </div>
            </div>
            <div class="w-full md:w-1/2 px-3">
                <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400 font-semibold"> Destino de Envio</span>
                        <input 
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" 
                            placeholder="Nombre o codigo Puerto/Aeropuerto" 
                        />
                </label>
                <div class="mt-2 text-sm">
                    <label class="inline-flex items-center text-gray-500 dark:text-gray-400">
                         <input type="checkbox" class="form-checkbox h-4 w-4 text-gray-800"  > <span class="ml-2"> Incluir Gastos Locales</span>
                    </label>
                    <label class="inline-flex items-center ml-6 text-gray-500 dark:text-gray-400">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-gray-800"  > <span class="ml-2"> Fabricar/Almacen </span>
                    </label>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-1/4 px-3 mb-6 md:mb-0">
            <label class="block text-sm">
            <span class="text-gray-700 dark:text-gray-400 font-semibold" > Fecha Estimada de Embarcacion </span>
                <input  type="date" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" 
                    placeholder="Nombre o codigo Puerto/Aeropuerto"
                />
            </label>
        </div>
        <div class="w-1/3 px-2">
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400 font-semibold"> Descripcion de la carga </span>
                    <input 
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" 
                        placeholder="Introduzca la descripcion aqui" 
                    />
            </label>
        </div>
        <div class="w-1/6 mt-8">
                <label class="ml-6 text-gray-500 dark:text-gray-400">
                   <input type="checkbox" class="form-checkbox h-4 w-4 text-gray-800"  ><span class="ml-2 text-gray-700 "> Seguro </span>
                </label>
        </div>
    </div>
  </div>       
</div>
</template>

<script>
export default {
    data(){
        return{
            modeCalculate:true
        }
    }
}
</script>

<style>

</style>
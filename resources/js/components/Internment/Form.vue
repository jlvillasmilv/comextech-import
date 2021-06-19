<template>
    <div>
        <div class="flex flex-wrap -mx-3 ">
            <div class="w-1/2 px-3 mb-2 md:mb-0">
                <label class="block text-sm">
                    <span
                        class="text-gray-700 dark:text-gray-400 font-semibold"
                    >
                        Agente de Aduana
                    </span>
                    <input
                        class="block w-full mt-1 mb-3 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        placeholder="Datos del Agente de Aduana "
                    />
                    <input
                        type="checkbox"
                        class="form-checkbox h-4 w-4   text-blue-600"
                    /><span class="ml-2 text-xs text-black  text-gray-500">
                        Quiero que Comextech me asigne mi agente de aduana
                    </span>
                </label>
            </div>
            <div class="w-1/2 px-3">
                <span
                    class="text-gray-700 dark:text-gray-400 font-semibold text-sm"
                >
                    Tratado Internacional
                </span>
                <div
                    class="text-gray-600 dark:text-gray-400 flex space-x-5 justify-start  "
                >
                    <label class="inline-flex items-center mt-3">
                        <input
                            type="checkbox"
                            class="form-checkbox h-5 w-5 text-blue-600"
                        /><span class="ml-2 text-black"> Mercosur</span>
                    </label>
                    <label class="inline-flex items-center mt-3">
                        <input
                            type="checkbox"
                            class="form-checkbox h-5 w-5 text-blue-600"
                        /><span class="ml-2 text-black"> Eur1 </span>
                    </label>
                    <label class="inline-flex items-center mt-3">
                        <input
                            type="checkbox"
                            class="form-checkbox h-5 w-5 text-blue-600"
                        /><span class="ml-2 text-black"> Form1 F</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap -mx-3 ">
            <div class="w-1/2 px-3 mb-2 md:mb-0">
                <label class="block text-sm">
                    <span
                        class="text-gray-700 dark:text-gray-400 font-semibold"
                    >
                        Pago de Agente de Aduana
                    </span>
                    <input
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        placeholder="Monto"
                    />
                </label>
            </div>
            <div class="w-1/2 px-3 ">
                <span
                    class="text-gray-700 dark:text-gray-400 font-semibold text-sm"
                >
                    Certificado
                </span>
                <div
                    class="text-gray-600 dark:text-gray-400 flex space-x-5 justify-start "
                >
                    <label class="inline-flex items-center mt-3">
                        <input
                            type="radio"
                            class="form-checkbox h-5 w-5 text-blue-600"
                            id="1"
                            name="1"
                        />
                        <span class="ml-2 text-black"> Origen</span>
                    </label>
                    <label class="inline-flex items-center mt-3">
                        <input
                            type="radio"
                            class="form-checkbox h-5 w-5 text-blue-600"
                            id="1"
                            name="1"
                        />
                        <span class="ml-2 text-black"> Fitosanitario</span>
                    </label>
                    <label class="inline-flex items-center mt-3">
                        <input
                            type="radio"
                            class="form-checkbox h-5 w-5 text-blue-600"
                            id="1"
                            name="1"
                        />
                        <span class="ml-2 text-black"> Form F</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {};
</script>

<style></style>

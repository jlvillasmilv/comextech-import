<template>
    <div class="w-1/2 overflow-x-auto ">
        <div
            class="  mx-3 px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800    "
        >
            <h3 class="my-4  font-semibold text-gray-700 dark:text-gray-200">
                Pagos al Proveedor
            </h3>
            <div class="flex flex-wrap -mx-3  ">
                <div class="w-full md:w-1/2 px-3 md:mb-0">
                    <span class="text-gray-700 dark:text-gray-400 text-xs">
                        Porcentaje de Pago Nro 1</span
                    >
                    <input
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input text-center"
                        placeholder="%"
                        v-model.number="form.percentage"
                        step="1"
                        type="number"
                    />
                </div>
                <div class="w-full md:w-1/2 px-3 md:mb-0">
                    <span class="text-gray-700 dark:text-gray-400 text-xs">
                        Monto de Operacion
                    </span>
                    <span class="block w-full mt-1 text-lg  text-center">
                        {{ 0 }}</span
                    >
                </div>
            </div>
            <div class="flex flex-wrap -mx-3  ">
                <div class="w-full md:w-1/2 px-3">
                    <span class="text-gray-700 dark:text-gray-400 text-xs">
                        Fecha a Pagar Porcentaje</span
                    >
                    <input
                        v-model="form.datePay"
                        type="date"
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        placeholder="Empresa"
                    />
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <span class="text-gray-700 dark:text-gray-400 text-xs">
                        Forma de Pago
                    </span>
                    <div class="relative">
                        <select
                            v-model="form.typePay"
                            class="block appearance-none w-full border border-gray-150 dark:border-gray-600  text-gray-700 p-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="grid-state"
                        >
                            <option value="Carta de Credito">
                                Carta de Credito
                            </option>
                            <option value="Transferencia">
                                Transferencia
                            </option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
                        >
                            <svg
                                class="fill-current h-4 w-4"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                                />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 my-5">
                <button
                    class="flex  px-5 py-2  text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                    @click="$emit('Add', form)"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2h2m3-4H9a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-1m-1 4l-3 3m0 0l-3-3m3 3V3"
                        />
                    </svg>
                    <span> Agregar a Tabla de Pagos </span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        amountTotal: {
            required: false,
            default: 0
        }
    },
    data() {
        return {
            form: {
                percentage: "",
                percentageInitial: 100,
                datePay: "",
                typePay: ""
            }
        };
    }
};
</script>

<style></style>

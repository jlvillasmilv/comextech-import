<template>
    <div class=" flex w-full">
        <div class="w-1/2 overflow-x-auto ">
            <div
                class="  mx-3 px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800    "
            >
                <h3 class="my-2 font-semibold text-gray-700 dark:text-gray-200">
                    Pagos al Proveedor
                </h3>
                <h3
                    :class="[
                        percentageInitial - discount >= 0
                            ? 'text-black'
                            : 'text-red-600  ',
                        ' text-xs dark:text-gray-200'
                    ]"
                >
                    Porcentaje Restante : {{ percentageInitial - discount }}
                </h3>
                <h3 class="my-2   text-gray-400 dark:text-gray-200">
                    Monto Total a Pagar : {{ amountTotal }} $
                </h3>
                <div class="flex flex-wrap -mx-3  ">
                    <div class="w-full md:w-1/2 px-3 md:mb-0">
                        <span class="text-gray-700 dark:text-gray-400 text-xs">
                            Porcentaje de Pago Nro {{ counter + 1 }}</span
                        >
                        <input
                            :class="[]"
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input text-center"
                            placeholder="%"
                            v-model.number="discount"
                            step="1"
                            type="number"
                        />
                    </div>
                    <div class="w-full md:w-1/2 px-3 md:mb-0">
                        <span class="text-gray-700 dark:text-gray-400 text-xs">
                            Monto del Porcentaje Agregado
                        </span>
                        <span class="block w-full mt-1 text-lg  text-center">
                            {{ amountRound }}
                        </span>
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
             <div class="flex flex-wrap -mx-3  ">
               
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <span class="text-gray-700 dark:text-gray-400 text-xs">
                        Restricion de Liberacion de pago
                    </span>
                    <div class="relative">
                        <select
                            v-model="form.payment_release"
                            class="block appearance-none w-full border border-gray-150 dark:border-gray-600  text-gray-700 p-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="grid-state"
                        >
                            <option value="Contra Documento">
                                Contra Documento
                            </option>
                            <option value="Contra Inspeccion">
                                Contra Inspeccion
                            </option>
                             <option value="Sin Restriccion">
                                Sin Restriccion
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

            <div class="flex  space-x-2  px-3 mb-6 md:mb-0 my-5">
                <button
                    v-if="discount > 0"
                    class=" flex  px-5 py-2  text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                    @click="submitTable()"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
>>>>>>> fbbc66f1e393effd39e42fb474d294a56352453e
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
                        <span> Agregar Pago a Tabla </span>
                    </button>

                    <button
                        v-if="percentageInitial == 0"
                        class=" flex   px-5 py-2  text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-purple"
                        @click="submitPayment()"
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
                        <span> Guardar Pagos</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="w-1/2">
            <div class="mb-8 overflow-hidden rounded-lg shadow-xs">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr
                                class="text-xs font-semibold tracking-wide text-left text-white  uppercase border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800"
                            >
                                <th class="px-4 py-3">Pago</th>
                                <th class="">Porcentaje</th>
                                <th class="px-4 py-3">Moneda</th>
                                <th class="px-4 py-3">Monto</th>
                                <th class="px-4 py-3">Forma</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody
                            v-if="data.length"
                            class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                        >
                            <tr
                                v-for="(item, key) in data"
                                :key="key"
                                class="text-gray-700 dark:text-gray-400"
                            >
                                <td class="px-4 py-3">
                                    <div class="flex items-center text-sm">
                                        <div>
                                            <p class="font-semibold input">
                                                Pago Nro {{ key + 1 }}
                                            </p>
                                            <p
                                                class="text-xs text-gray-600 dark:text-gray-400"
                                            >
                                                {{ item.datePay }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-2 py-2 text-sm">
                                    {{ item.percentage }} %
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ currencies.code }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{
                                        Math.round(
                                            amountTotal *
                                                (item.percentage / 100)
                                        )
                                    }}
                                </td>
                                <td class="px-4 py-3 text-xs">
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:text-white dark:bg-green-600"
                                    >
                                        {{ item.typePay }}
                                    </span>
                                </td>
                                <td>
                                    <svg
                                        @click="deleteRow(item)"
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
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                        />
                                    </svg>
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
    props: {
        application_id: {
            type: Number,
            required: true
        },
        amountTotal: {
            required: true,
            default: 0
        },
        currencies: {
            required: true
        }
    },
    data() {
        return {
            form: {
                percentage: "",
                datePay: "",
                typePay: "",
                payment_release: "", 
                manyPayment: "",
                id: "",
                application_id: this.application_id
            },
            percentageInitial: 100,
            discount: "",
            counter: 0,
            data: [],
            percentajeDelete: {}
        };
    },
    methods: {
        deleteRow(item) {
            this.data = this.data.filter(e => e.id !== item.id);
            this.percentajeDelete = item;
        },
        submitTable() {
            if (this.percentageInitial - this.discount >= 0) {
                this.percentageInitial = this.percentageInitial - this.discount;
                this.counter = ++this.counter;

                this.data.push({
                    ...this.form,
                    percentage: this.discount,
                    id: this.data.length
                });

                this.discount = 0;
                this.form = {
                    percentage: "",
                    datePay: "",
                    typePay: "",
                    payment_release: "",
                    manyPayment: "",
                    id: "",
                    application_id: this.application_id
                };
            }
        },
        submitPayment() {
            axios
                .post("/applications/payment_provider", this.data)
                .then(res => {
                    this.$emit("incomingMenu");
                })
                .catch(err => {
                    console.log(err);
                });
        }
    },
    computed: {
        amountRound() {
            return Math.round(this.amountTotal * (this.discount / 100)) + "  " + this.currencies.code;
        }
    },
    watch: {
        percentajeDelete(newValue, oldValue) {
            this.data.splice(newValue.id, 1);
            this.percentageInitial =
                this.percentageInitial + newValue.percentage;
        }
    }
};
</script>

<style></style>

<template>
    <div>
        <div class="flex flex-wrap -mx-3">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block text-sm">
                    <span
                        class="text-gray-700 dark:text-gray-400 font-semibold "
                    >
                        Origen de Envio
                    </span>
                    <input
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        :placeholder="
                            this.expenses.originWarehouse
                                ? 'Nombre o codigo Puerto/Aeropuerto'
                                : 'Direccion, Codigo Postal'
                        "
                    />
                </label>
                <div class="mt-2 text-sm">
                    <label
                        class="inline-flex items-center text-gray-500 dark:text-gray-400"
                    >
                        <input
                            ref="origin"
                            @click="changeExpenses('origin')"
                            :checked="expenses.origin"
                            v-model="expenses.origin"
                            type="checkbox"
                            class="form-checkbox h-4 w-4 text-gray-800"
                        />
                        <span class="ml-2"> Incluir Gastos Locales</span>
                    </label>
                    <label
                        class="inline-flex items-center ml-6 text-gray-500 dark:text-gray-400"
                    >
                        <input
                            @click="changeExpensesWarehouse('origin')"
                            :checked="expenses.originWarehouse"
                            v-model="expenses.originWarehouse"
                            type="checkbox"
                            class="form-checkbox h-4 w-4 text-gray-800"
                        />
                        <span class="ml-2"> Factory/Warehouse (EXW)</span>
                    </label>
                </div>
            </div>
            <div class="w-full md:w-1/2 px-3">
                <label class="block text-sm">
                    <span
                        class="text-gray-700 dark:text-gray-400 font-semibold"
                    >
                        Destino de Envio</span
                    >
                    <input
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        :placeholder="
                            this.expenses.destinacionWarehouse
                                ? 'Nombre o codigo Puerto/Aeropuerto'
                                : 'Direccion, Codigo Postal'
                        "
                    />
                </label>
                <div class="mt-2 text-sm">
                    <label
                        class="inline-flex items-center text-gray-500 dark:text-gray-400"
                    >
                        <input
                            ref="destinacion"
                            @click="changeExpenses('destinacion')"
                            :checked="expenses.destinacion"
                            v-model="expenses.destinacion"
                            type="checkbox"
                            class="form-checkbox h-4 w-4 text-gray-800"
                        />
                        <span class="ml-2"> Incluir Gastos Locales</span>
                    </label>
                    <label
                        class="inline-flex items-center ml-6 text-gray-500 dark:text-gray-400"
                    >
                        <input
                            @click="changeExpensesWarehouse('destinacion')"
                            :checked="expenses.destinacionWarehouse"
                            v-model="expenses.destinacionWarehouse"
                            type="checkbox"
                            class="form-checkbox h-4 w-4 text-gray-800"
                        />
                        <span class="ml-2"> Fabricar/Almacen </span>
                    </label>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-1/4 px-3 mb-6 md:mb-0">
                <label class="block text-sm">
                    <span
                        class="text-gray-700 dark:text-gray-400 font-semibold"
                    >
                        Fecha Estimada de Embarcacion
                    </span>
                    <input
                        type="date"
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        placeholder="Nombre o codigo Puerto/Aeropuerto"
                    />
                </label>
            </div>
            <div class="w-1/3 px-2">
                <label class="block text-sm">
                    <span
                        class="text-gray-700 dark:text-gray-400 font-semibold"
                    >
                        Descripcion de la carga
                    </span>
                    <input
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        placeholder="Introduzca la descripcion aqui"
                    />
                </label>
            </div>
            <div class="w-1/6 mt-8">
                <label class="ml-6 text-gray-500 dark:text-gray-400">
                    <input
                        type="checkbox"
                        class="form-checkbox h-4 w-4 text-gray-800"
                        @click="safe = !safe"
                    />
                    <span class="ml-2 text-gray-700 "> Seguro </span>
                </label>
            </div>
            <div class="w-1/6  " v-show="safe">
                <span class="text-sm font-semibold"> Valor de Carga </span>
                <input
                    class="h-9 w-16.5 focus:outline-none border rounded-sm flex text-center   text-sm"
                    placeholder="USD"
                />
            </div>
        </div>
    </div>
</template>


<script>
 

export default {
    data() {
        return {
            safe:false,
            expenses: {
                origin: false,
                destinacion: false,
                originWarehouse: false,
                destinacionWarehouse: false
            },
        };
    },
    methods: {
        changeExpensesWarehouse(value) {
            if (value == "origin") {
                this.expenses.originWarehouse = !this.expenses.originWarehouse;
                this.expenses.origin = this.expenses.originWarehouse
                    ? true
                    : false;
            } else {
                this.expenses.destinacionWarehouse = !this.expenses
                    .destinacionWarehouse;
                this.expenses.destinacion = this.expenses.destinacionWarehouse
                    ? true
                    : false;
            }
        },
        changeExpenses(value) {
            if (value == "origin") {
                if (this.expenses.originWarehouse)
                    this.expenses.originWarehouse = false;
                this.$refs.origin.checked = true;
            } else {
                if (this.expenses.destinacionWarehouse)
                    this.expenses.destinacionWarehouse = false;
                this.$refs.destinacion.checked = true;
            }
        }
    },
};
</script>

<style></style>

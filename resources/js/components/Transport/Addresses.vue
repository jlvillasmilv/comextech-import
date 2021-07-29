<template>
    <div class="container grid px-6 my-1 ">
  
        <Load @dataForm="getDataLoad" />
        <div v-if="Load.weight" >
            <div>
                <div class="flex flex-wrap -mx-3 my-8 ">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block text-sm">
                            <span
                                class="text-gray-700 dark:text-gray-400 font-semibold "
                            >
                                Origen de Envio
                            </span>
                            <input
                                v-model="expenses.addressOrigin"
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                :placeholder="
                                    expenses.originWarehouse
                                        ? 'Nombre o codigo Puerto/Aeropuerto'
                                        : 'Direccion, Codigo Postal'
                                "
                            />
                             <span
                                    class="text-xs text-red-600 dark:text-red-400"
                                    v-if="expenses.errors.has('addressOrigin')"
                                    v-html="expenses.errors.get('addressOrigin')"
                                ></span>
                        </label>
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block text-sm">
                            <span
                                class="text-gray-700 dark:text-gray-400 font-semibold"
                            >
                                Destino de Envio</span
                            >
                            <input
                                v-model="expenses.addressDestination"
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                :placeholder="
                                     expenses.destinacionWarehouse
                                        ? 'Nombre o codigo Puerto/Aeropuerto'
                                        : 'Direccion, Codigo Postal'
                                "
                            />
                            <span
                                    class="text-xs text-red-600 dark:text-red-400"
                                    v-if="expenses.errors.has('addressDestination')"
                                    v-html="expenses.errors.get('addressDestination')"
                                ></span>
                        </label>
                    </div>
                </div>
                <div v-if="expenses.addressDestination !== '' " class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-1/4 px-3 mb-6 md:mb-0">
                        <label class="block text-sm">
                            <span
                                class="text-gray-700 dark:text-gray-400 font-semibold"
                            >
                                Fecha Estimada de Embarcacion
                            </span>
                            <input
                                type="date"
                                v-model="expenses.estimated_date"
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                placeholder="Nombre o codigo Puerto/Aeropuerto"
                            />
                            <span
                                    class="text-xs text-red-600 dark:text-red-400"
                                    v-if="expenses.errors.has('estimated_date')"
                                    v-html="expenses.errors.get('estimated_date')"
                                ></span>
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
                                v-model="expenses.description"
                                maxlength="250"
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
                                v-model="safe"
                            />
                            <span class="ml-2 text-gray-700 "> Seguro </span>
                        </label>
                    </div>
                     
                </div>
            </div>
            <div class="flex justify-center">
                 <!-- <button
                    @click="$emit('incomingMenu',false)"
                    class="w-1/3 h-12 px-4 text-white transition-colors text-lg duration-150 bg-gray-700 rounded-lg focus:shadow-outline hover:bg-gray-800"
                >
                    Atras
                </button> -->
                <button
                    @click="submitForm()"
                    class="w-1/3 h-12 px-4 text-white transition-colors text-lg duration-150 bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800"
                >
                    Cotizar
                </button>
                
            </div>
        </div>
    </div>
</template>

<script>
import Load from "./Load.vue";

export default {
    components: { Load },
    props: {
        application_id: {
            type: Number,
            required: true,
        },
        origin_transport: {
            type: String,
            required: false,
        },
    },
    data() {
        return {
            safe: false,
            expenses: new Form({
                origin: false,
                destinacion: false,
                originWarehouse: false,
                destinacionWarehouse: false,
                application_id: this.application_id,
                addressOrigin: this.origin_transport,
                addressDestination: "",
                estimated_date: "",
                description: "",
                dataLoad: []
            }),
            Load:false
    
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
        },
        getDataLoad(payload) {
            this.expenses.addressDestination = ''
            this.Load = payload[0]
            this.expenses.dataLoad = payload;

        },
        async submitForm() {
            try {
            const response = await this.expenses.post("/applications/transports");

            Toast.fire({
                        icon: 'success',
                        title: 'Datos Agregados'
                    })

                this.$emit("incomingMenu");

             } catch (error) {
                console.error(error);
            }
        }
    }
};
</script>

<style></style>

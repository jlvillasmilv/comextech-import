<template>
    <div class="w-2/4 overflow-x-auto ">
        <div
            class="  mx-3 px-4 py-3 mb-8 bg-white rounded-lg  dark:bg-gray-800    "
        >
            <h3 class="my-2 font-semibold text-gray-700 dark:text-gray-200">
                Destino
            </h3>
            <div class="flex flex-wrap -mx-3  ">
                <div class="w-full px-3 md:mb-0">
                    <span class="text-gray-700 dark:text-gray-400 my-2 text-sm">
                        Ubicacion de Destino
                    </span>
                    <select
                                        v-model="form.warehouse_id"
                                        @change="toogleMenuTabs()"
                                        class="block appearance-none w-full border border-gray-150 dark:border-gray-600  text-gray-700 p-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    >
                                        <option
                                            v-for="item in warehouses"
                                            :value="item"
                                            :key="item.name"
                                        >
                                            {{ item.address }}
                                        </option>
                                    </select>
                     
                    <span
                        class="text-xs text-red-600 dark:text-red-400"
                        v-if="form.errors.has('warehouse_id')"
                        v-html="form.errors.get('warehouse_id')"
                    ></span>
                </div>
            </div>
            <div class="flex mt-6">
                <label class="flex items-center">
                    <input type="checkbox" class="form-checkbox" />
                    <span class="ml-2">
                        Servicio de Peonetas (4 Personas)
                    </span>
                </label>
            </div>
            <div class="flex mt-6">
                <label class="flex items-center">
                    <input type="checkbox" class="form-checkbox" />
                    <span class="ml-2">
                        Servicio Grua Horquilla
                    </span>
                </label>
            </div>
            <div class="flex  space-x-2  px-3 mb-6 md:mb-0 my-5">
                <button
                    class=" flex   px-5 py-2  text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-purple"
                    @click="submitForm()"
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
                    <span> Insertar datos de Entrega </span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        application_id: {
            type: Number,
            required: false
        }
    },
    data() {
        return {
            form: new Form({
                trans_company_id: "",
                warehouse_id: "",
                application_id: this.application_id
            }),
            data: [],
            percentajeDelete: {},
            warehouses: [],
            agencyTransport: []
        };
    },
    methods: {
        async submitForm() {
            try {
                const response = await this.form.post("/local_warehouse");
                this.$store.dispatch("callIncomingOrNextMenu", true)
                Toast.fire({
                    icon: "success",
                    title: "Datos Agregados"
                });
            } catch (error) {
                console.error(error);
            }
        }
    },
    async created() {
        try {
            let warehouses = await axios.get("/api/warehouses");
            let agencyTransport = await axios.get("/api/trans_companies");
            this.warehouses = warehouses.data;
            this.agencyTransport = agencyTransport.data;
        } catch (error) {
            console.log(error);
        }
    }
};
</script>

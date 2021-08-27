<template>
    <div class="container grid px-6 my-1 ">
        <Load/>
        <div v-show="isActivateAddress"  >
            <div>
                <div class="flex flex-wrap -mx-3 my-8 ">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block text-sm">
                            <span
                                class="text-gray-700 dark:text-gray-400 font-semibold "
                            >
                                {{
                                    application.condition === "FOB"
                                        ? " Puertos de Proveedor"
                                        : " Almacen o Fabrica del Proveedor"
                                }}
                            </span>

                            <input
                                v-if="!expenses.favoriteAddressOrigin"
                                v-model="expenses.addressOrigin"
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                            />

                            <v-select
                                v-else
                                label="address"
                                class="mt-2 text-sm"
                                :options="Adrereses"
                                v-model="expenses.addressOrigin"
                                :reduce="adrereses => adrereses.id"
                            >
                                <template
                                    v-slot:no-options="{ search, searching }"
                                >
                                    <template v-if="searching" class="text-sm">
                                        Lo sentimos no hay opciones que
                                        coincidan
                                        <strong>{{ search }}</strong
                                        >.
                                    </template>
                                    <em style="opacity: 0.5;" v-else>
                                        No posee
                                        {{
                                            application.condition === "FOB"
                                                ? "Puertos"
                                                : "Almacenes o Fabricas"
                                        }}
                                        en tu lista</em
                                    >
                                </template>
                            </v-select>
                            <label
                                class="inline-flex text-sm items-center mx-2 mt-2"
                            >
                                <input
                                    type="checkbox"
                                    class="form-checkbox h-4 w-4 text-gray-800"
                                    v-model="expenses.favoriteAddressOrigin"
                                    @change="expenses.addressOrigin = '' "
                                /><span class="ml-2 text-gray-700">
                                    Tus
                                    {{
                                        application.condition === "FOB"
                                            ? "Puertos"
                                            : "Almacenes o Fabricas"
                                    }}
                                    Favoritos
                                </span>
                            </label>
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
                                Destino de Envio
                            </span>
                            <input
                                v-if="!expenses.favoriteAddressDestin"
                                v-model="expenses.addressDestination"
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                :placeholder="
                                    expenses.favoriteAddressDestin
                                        ? 'Nombre o codigo Puerto/Aeropuerto'
                                        : 'Direccion, Codigo Postal'
                                "
                            />
                            <v-select
                                v-else
                                label="address"
                                class="mt-2 text-sm"
                                :options="addressDestination"
                                v-model="expenses.addressDestination"
                                :reduce="e => e.id"
                            >
                                <template
                                    v-slot:no-options="{ search, searching }"
                                >
                                    <template v-if="searching" class="text-sm">
                                        Lo sentimos no hay opciones que
                                        coincidan
                                        <strong>{{ search }}</strong
                                        >.
                                    </template>
                                    <em style="opacity: 0.5;" v-else>
                                        No posee
                                        {{
                                            application.condition === "FOB"
                                                ? "Puertos"
                                                : "Almacenes o Fabricas"
                                        }}
                                        en tu lista</em
                                    >
                                </template>
                            </v-select>
                            <label
                                class="inline-flex text-sm items-center mx-2 mt-2"
                            >
                                <input
                                    type="checkbox"
                                    class="form-checkbox h-4 w-4 text-gray-800"
                                    v-model="expenses.favoriteAddressDestin"
                                    @change="expenses.addressDestination = ''"
                                /><span class="ml-2 text-gray-700">
                                    Direccion de Destino Favoritas
                                </span>
                            </label>
                            <span
                                class="text-xs text-red-600 dark:text-red-400"
                                v-if="expenses.errors.has('addressDestination')"
                                v-html="
                                    expenses.errors.get('addressDestination')
                                "
                            ></span>
                        </label>
                    </div>
                </div>
                <div
                    v-if="expenses.addressDestination !== ''"
                    class="flex flex-wrap -mx-3 mb-6"
                >
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
                                v-model="expenses.insurance"
                            />
                            <span class="ml-2 text-gray-700 ">Seguro </span>
                        </label>
                    </div>
                    <div class="w-1/6 mt-8" v-if="expenses.insurance">
                        <span class="ml-2 text-gray-700 ">
                            {{ $store.state.application.amount }}
                            {{ $store.state.currency.code }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex justify-center">
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
import { mapState } from "vuex"

export default {
    components: { Load },
    props: {
        application: {
            type: Object,
            required: true
        },
        originTransport: {
            type: Array,
            required: false
        }
    },
    data() {
        return {
            Load: false,
            safe: false,
        };
    },
    methods: {
        async submitForm() {
            try {
                this.expenses.dataLoad = this.$store.state.load.loads
                await this.expenses.post("/applications/transports");
                Toast.fire({
                    icon: "success",
                    title: "Datos Agregados"
                });
                this.$store.dispatch("callIncomingOrNextMenu", true);
            } catch (error) {
                console.error(error);
            }
        }
    },
    computed: {
        ...mapState('address', ['expenses', 'addressDestination']),
        Adrereses() {
            if (this.application.condiction == "FOB") {
                return this.originTransport.filter(
                    item => item.place == "PUERTO"
                );
            } else {
                return this.originTransport.filter(
                    item => item.place !== "PUERTO"
                );
            }
        },
        isActivateAddress(){
            const  { loads } = this.$store.state.load
            if(loads.length){
                if(loads[loads.length - 1].weight)   return true
                else false
            }
            return false
        }
    },
    async created() {
        console.log(this.application.id, 'MAURICO')
        this.expenses.application_id = this.application.id
           await this.$store.dispatch('address/getAddressDestination')    
    }
};
</script>

<style></style>

<template>
    <div class="container grid px-6 my-1">
        <Load v-if="Load == true" />
        <!-- Notification validation error -->
        <span
            class="text-xs text-red-600 dark:text-red-400"
            v-if="expenses.errors.has('dataLoad.0.length')"
            v-html="expenses.errors.get('dataLoad.0.length')"
        ></span>
        <span
            class="text-xs text-red-600 dark:text-red-400"
            v-if="expenses.errors.has('dataLoad.0.width')"
            v-html="expenses.errors.get('dataLoad.0.width')"
        ></span>
        <span
            class="text-xs text-red-600 dark:text-red-400"
            v-if="expenses.errors.has('dataLoad.0.height')"
            v-html="expenses.errors.get('dataLoad.0.height')"
        ></span>
        <span
            class="text-xs text-red-600 dark:text-red-400"
            v-if="expenses.errors.has('dataLoad.0.weight')"
            v-html="expenses.errors.get('dataLoad.0.weight')"
        ></span>
        <span
            class="text-xs text-red-600 dark:text-red-400"
            v-if="expenses.errors.has('fedex')"
            v-html="expenses.errors.get('fedex')"
        ></span>
        <div v-show="isActivateAddress">
            <div>
                <div
                    v-if="expenses.dataLoad.length == 0 || formAdress == true"
                    class="flex flex-wrap -mx-3 my-8"
                >
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block text-sm">
                            <span
                                class="text-gray-700 dark:text-gray-400 font-semibold"
                            >
                                {{
                                    data.condition === 'FOB'
                                        ? ' Puertos de Proveedor'
                                        : ' Almacen o Fabrica del Proveedor'
                                }}
                            </span>
                            <vue-google-autocomplete
                                v-if="!expenses.fav_address_origin"
                                v-model="expenses.address_origin"
                                id="addressOrigin"
                                classname="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                v-on:placechanged="getAddressOrigin"
                                placeholder="Direccion, Codigo Postal"
                            >
                            </vue-google-autocomplete>
                            <div v-else class="relative">
                                <select
                                    v-model="expenses.address_origin"
                                    class="
                      block
                      w-full
                      border border-gray-150
                      text-gray-700
                      p-2
                      mt-1
                      pr-8
                      rounded
                      leading-tight
                      focus:outline-none
                      focus:bg-white
                      focus:border-gray-500
                  "
                                >
                                    <option
                                        v-for="item in origin_transport"
                                        :value="item.id"
                                        :key="item.id"
                                        class=" "
                                    >
                                        {{ item.address }}
                                    </option>
                                </select>
                            </div>
                            <label
                                class="inline-flex text-sm items-center mx-2 mt-2"
                            >
                                <!-- Aqui -->
                                <input
                                    type="checkbox"
                                    class="form-checkbox h-4 w-4 text-gray-800"
                                    v-model="expenses.fav_address_origin"
                                    @change="expenses.address_origin = ''"
                                /><span class="ml-2 text-gray-700">
                                    Tus
                                    {{
                                        data.condition === 'FOB'
                                            ? 'Puertos'
                                            : 'Almacenes o Fabricas'
                                    }}
                                    Favoritos
                                </span>
                            </label>
                            <span
                                class="text-xs text-red-600 dark:text-red-400"
                                v-if="expenses.errors.has('address_origin')"
                                v-html="expenses.errors.get('address_origin')"
                            ></span>
                        </label>
                    </div>
                    <!-- Destino de Envio -->
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block text-sm">
                            <span
                                class="text-gray-700 dark:text-gray-400 font-semibold"
                            >
                                Destino de Envio
                            </span>

                            <vue-google-autocomplete
                                v-if="!expenses.fav_dest_address"
                                v-model="expenses.address_destination"
                                id="addressDestination"
                                classname="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                :placeholder="
                                    expenses.fav_dest_address
                                        ? 'Nombre o codigo Puerto/Aeropuerto'
                                        : 'Direccion, Codigo Postal'
                                "
                                v-on:placechanged="getAddressDestination"
                            >
                            </vue-google-autocomplete>

                            <div v-else class="relative">
                                <select
                                    v-model="expenses.address_destination"
                                    class="
                      block
                      w-full
                      border border-gray-150
                      text-gray-700
                      p-2
                      pr-8
                      rounded
                      mt-1
                      leading-tight
                      focus:outline-none
                      focus:bg-white
                      focus:border-gray-500
                  "
                                >
                                    <option
                                        v-for="item in addressDestination"
                                        :value="item.id"
                                        :key="item.id"
                                        class=" "
                                    >
                                        {{ item.address }}
                                    </option>
                                </select>
                            </div>
                            <label
                                class="inline-flex text-sm items-center mx-2 mt-2"
                            >
                                <input
                                    type="checkbox"
                                    class="form-checkbox h-4 w-4 text-gray-800"
                                    v-model="expenses.fav_dest_address"
                                    @change="expenses.address_destination = ''"
                                /><span class="ml-2 text-gray-700">
                                    Direccion de Destino Favoritas
                                </span>
                            </label>
                        </label>

                        <span
                            class="text-xs text-red-600 dark:text-red-400"
                            v-if="expenses.errors.has('address_destination')"
                            v-html="expenses.errors.get('address_destination')"
                        ></span>
                    </div>
                </div>
                <div
                    v-if="
                        (expenses.address_destination !== '' &&
                            expenses.dataLoad.length <= 0) ||
                            adressDate == true
                    "
                    class="flex flex-wrap -mx-3 mb-6"
                >
                    <div class="w-1/4 px-3 mb-6 md:mb-0">
                        <label class="block text-sm">
                            <span
                                class="text-gray-700 dark:text-gray-400 font-semibold"
                            >
                                Fecha Estimada
                            </span>
                            <input
                                type="date"
                                v-model="expenses.estimated_date"
                                class="
                  block
                  w-full
                  mt-1
                  text-sm
                  dark:border-gray-600
                  dark:bg-gray-700
                  focus:border-purple-400
                  focus:outline-none
                  focus:shadow-outline-purple
                  dark:text-gray-300
                  dark:focus:shadow-outline-gray
                  form-input
                "
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
                                class="
                  block
                  w-full
                  mt-1
                  text-sm
                  dark:border-gray-600
                  dark:bg-gray-700
                  focus:border-purple-400
                  focus:outline-none
                  focus:shadow-outline-purple
                  dark:text-gray-300
                  dark:focus:shadow-outline-gray
                  form-input
                "
                                placeholder="Introduzca la descripcion aqui"
                            />
                        </label>
                        <span
                            class="text-xs text-red-600 dark:text-red-400"
                            v-if="expenses.errors.has('description')"
                            v-html="expenses.errors.get('description')"
                        ></span>
                    </div>
                    <div class="w-1/6 mt-8">
                        <label class="ml-6 text-gray-500 dark:text-gray-400">
                            <input
                                type="checkbox"
                                class="form-checkbox h-4 w-4 text-gray-800"
                                v-model="expenses.insurance"
                            />
                            <span class="ml-2 text-gray-700">Seguro </span>
                        </label>
                    </div>
                    <div class="w-1/6 mt-8" v-if="expenses.insurance">
                        <span class="ml-2 text-gray-700">
                            {{ data.amount }}
                            {{ currency.code }}
                        </span>
                    </div>
                </div>
            </div>
            <div
                :class="[
                    expenses.dataLoad.length <= 0
                        ? 'flex justify-center'
                        : 'flex justify-center my-12 innline w-1/7 mt-5'
                ]"
            >
                <button
                    v-show="expenses.dataLoad.length > 0"
                    @click="showDireccion()"
                    class="mr-4 w-24 h-12 text-white transition-colors text-lg bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800"
                >
                    Editar
                </button>

                <button
                    @click="submitForm()"
                    :class="[
                        expenses.dataLoad.length <= 0
                            ? 'w-1/3 h-12 px-4 text-white transition-colors text-lg bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800'
                            : 'ml-4 w-24 h-12 text-white transition-colors text-lg bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800'
                    ]"
                >
                    Cotizar
                </button>
            </div>
            <div v-if="expenses.progress">
                Progress: {{ expenses.progress.percentage }}%
            </div>

            <!-- Bloque cotizacion de fedex -->
            <div
                v-if="expenses.dataLoad.length > 0"
                class="grid grid-cols-12 gap-7 py-8 my-14 focus:outline-none border rounded-sm"
            >
                <div class="col-span-2 text-center px-2">
                    <div class="mb-8 text-sm font-semibold">
                        <span>LLEGADA</span>
                    </div>
                    <span>{{ fedex.DeliveryTimestamp }}</span>
                </div>

                <div class="col-span-2 text-center">
                    <div class="mb-8 text-sm font-semibold">
                        <span>SERVICIO</span>
                    </div>
                    <span>{{ fedex.ServiceType }}</span>
                </div>

                <div class="col-span-3">
                    <div class="mb-8 text-center text-sm font-semibold">
                        CONCEPTOS
                    </div>
                    <div class="pl-10">Tarifa Transporte</div>
                    <div class="pl-10">Recargo Combustible</div>
                    <div class="pl-10">
                        <span>Recargo por alta demanda</span>
                    </div>
                    <div class="pl-10">Total Estimado</div>
                </div>

                <div class="col-span-2">
                    <div class="mb-8 text-center text-sm font-semibold">
                        <span>TARIFA</span>
                    </div>
                    <div class="text-right">{{ transportationRate }}</div>
                    <div class="text-right">{{ fedex.FUEL }}</div>
                    <div class="text-right">{{ fedex.PEAK }}</div>
                    <div class="text-right">
                        {{ fedex.TotalNetCharge }}
                    </div>
                </div>
                <div class="grid col-span-2 flex justify-items-center ml-20">
                    <img
                        src="../../../../public/img/fedex-logo.png"
                        alt="fedex-logo"
                        width="100%"
                        height="100%"
                        class="mt-12 mb-4"
                    />
                    <button
                        @click="fedexCotizacion()"
                        class="w-24 h-14 text-white transition-colors text-base bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800"
                    >
                        Cotizar FEDEX
                    </button>
                </div>
            </div>

            <!-- Bloque cotizacion de DHL -->
            <div
                v-if="expenses.dataLoad.length > 0"
                class="grid grid-cols-12 gap-7 py-8 my-14 focus:outline-none border rounded-sm"
            >
                <div class="col-span-2 text-center px-2">
                    <div class="mb-8 text-sm font-semibold">
                        <span>LLEGADA</span>
                    </div>
                    <span>{{ fedex.DeliveryTimestamp }}</span>
                </div>

                <div class="col-span-2 text-center">
                    <div class="mb-8 text-sm font-semibold">
                        <span>SERVICIO</span>
                    </div>
                    <span>{{ fedex.ServiceType }}</span>
                </div>

                <div class="col-span-3">
                    <div class="mb-8 text-center text-sm font-semibold">
                        CONCEPTOS
                    </div>
                    <div class="pl-10">Tarifa Transporte</div>
                    <div class="pl-10">Recargo Combustible</div>
                    <div class="pl-10">
                        <span>Recargo por alta demanda</span>
                    </div>
                    <div class="pl-10">Total Estimado</div>
                </div>

                <div class="col-span-2">
                    <div class="mb-8 text-center text-sm font-semibold">
                        <span>TARIFA</span>
                    </div>
                    <div class="text-right">{{ transportationRate }}</div>
                    <div class="text-right">{{ fedex.FUEL }}</div>
                    <div class="text-right">{{ fedex.PEAK }}</div>
                    <div class="text-right">
                        {{ fedex.TotalNetCharge }}
                    </div>
                </div>
                <div class="grid col-span-2 flex justify-items-center ml-20">
                    <img
                        src="../../../../public/img/dhl-express.jpg"
                        alt="fedex-logo"
                        width="80%"
                        height="80%"
                    />
                    <button
                        @click="fedexCotizacion()"
                        class="w-24 h-14 text-white transition-colors text-base bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800"
                    >
                        Cotizar DHL
                    </button>
                </div>
            </div>

            <!-- Bloque cotizacion de UPS -->
            <div
                v-if="expenses.dataLoad.length > 0"
                class="grid grid-cols-12 gap-7 py-8 my-14 focus:outline-none border rounded-sm"
            >
                <div class="col-span-2 text-center px-2">
                    <div class="mb-8 text-sm font-semibold">
                        <span>LLEGADA</span>
                    </div>
                    <span>{{ fedex.DeliveryTimestamp }}</span>
                </div>

                <div class="col-span-2 text-center">
                    <div class="mb-8 text-sm font-semibold">
                        <span>SERVICIO</span>
                    </div>
                    <span>{{ fedex.ServiceType }}</span>
                </div>

                <div class="col-span-3">
                    <div class="mb-8 text-center text-sm font-semibold">
                        CONCEPTOS
                    </div>
                    <div class="pl-10">Tarifa Transporte</div>
                    <div class="pl-10">Recargo Combustible</div>
                    <div class="pl-10">
                        <span>Recargo por alta demanda</span>
                    </div>
                    <div class="pl-10">Total Estimado</div>
                </div>

                <div class="col-span-2">
                    <div class="mb-8 text-center text-sm font-semibold">
                        <span>TARIFA</span>
                    </div>
                    <div class="text-right">{{ transportationRate }}</div>
                    <div class="text-right">{{ fedex.FUEL }}</div>
                    <div class="text-right">{{ fedex.PEAK }}</div>
                    <div class="text-right">
                        {{ fedex.TotalNetCharge }}
                    </div>
                </div>
                <div class="grid col-span-2 flex justify-items-center ml-20">
                    <img
                        src="../../../../public/img/ups-logo.jpg"
                        alt="fedex-logo"
                        width="70%"
                        class="mt-2 mb-2"
                    />
                    <button
                        @click="fedexCotizacion()"
                        class="w-24 h-14 text-white transition-colors text-base bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800"
                    >
                        Cotizar UPS
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueGoogleAutocomplete from 'vue-google-autocomplete';
import Load from './Load.vue';
import { mapState } from 'vuex';
import Button from '../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Button.vue';
import Container from '../Container.vue';

export default {
    components: { Load, VueGoogleAutocomplete, Button },
    props: {
        Container,
        originTransport: {
            type: Array,
            required: false
        }
    },
    data() {
        return {
            address: '',
            Load: true,
            safe: false,
            fedex: Object,
            transportationRate: '',
            formAdress: true,
            adressDate: false
        };
    },
    methods: {
        async submitForm() {
            try {
                this.formAdress = false; /* Ocultar formulario de direccion */
                this.adressDate = false; /* Ocultar formulario de fecha y descripcion */
                this.Load = false; /* Ocultar formulario de cargas y dimensiones */

                this.expenses.dataLoad = this.$store.state.load.loads;
                const { data } = await this.expenses.post('/get-fedex-rate'); // get data from fedex quote and rate api
                this.fedex = data;
                this.fedex.DeliveryTimestamp = this.$luxon(
                    this.fedex.DeliveryTimestamp
                );

                this.transportationRate =
                    this.fedex.TotalBaseCharge -
                    this.fedex.TotalFreightDiscounts;
                this.transportationRate = this.transportationRate.toFixed(2); // transformando la tarifa de transporte en 2 decimales

                const dhl = await this.expenses.post('/get-dhl-quote'); // get data from fedex quote and rate api
                console.log(dhl.data);

                console.log(
                    this.$store.state.load.loads,
                    ' ENVIO DE INTERNAMIA'
                );
            } catch (error) {
                console.error(error);
            }
        },
        /**
         * Show from address
         */
        showDireccion() {
            this.formAdress = !this
                .formAdress; /* Ocultar/Mostrar formulario de direccion */
            this.adressDate = !this
                .adressDate; /* Ocultar/Mostrar formulario de fecha y descripcion */
            this.Load = !this
                .Load; /* Ocultar/Mostrar formulario de cargas y dimensiones */
        },

        async fedexCotizacion() {
            try {
                await this.expenses.post('/applications/transports');
                Toast.fire({
                    icon: 'success',
                    title: 'Datos Agregados'
                });
                this.$store.dispatch(
                    'exchange/getSummary',
                    this.data.application_id
                );
                this.$store.dispatch('callIncomingOrNextMenu', true);
            } catch (error) {
                console.log(error);
            }
        },
        /**
         * When the location found
         * @param {Object} addressData Data of the found location
         * @param {Object} placeResultData PlaceResult object
         * @param {String} id Input container ID
         */
        getAddressOrigin: function(addressData, placeResultData, id) {
            this.expenses.address_origin = placeResultData.formatted_address;
            this.expenses.origin_latitude = addressData.latitude;
            this.expenses.origin_longitude = addressData.longitude;

            for (const component of placeResultData.address_components) {
                const componentType = component.types[0];

                switch (componentType) {
                    case 'country':
                        this.expenses.origin_ctry_code = component.short_name;
                        break;

                    case 'locality':
                        this.expenses.origin_locality = component.long_name;
                        break;

                    case 'postal_code': {
                        this.expenses.origin_postal_code = component.long_name;
                        break;
                    }
                }
            }
        },
        getAddressDestination: function(addressData, placeResultData, id) {
            for (const component of placeResultData.address_components) {
                const componentType = component.types[0];

                switch (componentType) {
                    case 'country':
                        this.expenses.dest_ctry_code = component.short_name;
                        break;

                    case 'locality':
                        this.expenses.dest_locality = component.long_name;
                        break;

                    case 'postal_code': {
                        this.expenses.dest_postal_code = component.long_name;
                        break;
                    }
                }
            }

            this.expenses.address_destination =
                placeResultData.formatted_address;
            this.expenses.dest_latitude = addressData.latitude;
            this.expenses.dest_longitude = addressData.longitude;
            //this.expenses.dest_ctry_code = placeResultData.address_components.
        }
    },
    computed: {
        ...mapState('address', ['expenses', 'addressDestination']),
        ...mapState('application', ['data', 'currency', 'origin_transport']),
        addreses() {
            if (this.data.condiction == 'FOB') {
                return this.addressDestination.filter(
                    item => item.place == 'PUERTO'
                );
            } else {
                return this.addressDestination.filter(
                    item => item.place !== 'PUERTO'
                );
            }
        },
        isActivateAddress() {
            const { loads } = this.$store.state.load;
            if (loads.length) {
                if (loads[loads.length - 1].weight) return true;
                else false;
            }
            return false;
        }
    },
    async created() {
        this.expenses.application_id = this.data.application_id;
        await this.$store.dispatch('address/getAddressDestination');
    }
};
</script>

<style></style>

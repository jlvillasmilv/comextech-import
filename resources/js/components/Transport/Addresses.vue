<template>
    <div class="container grid px-6 my-1">
        <transition name="fade">
            <Load v-if="Load == true" />
        </transition>
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
                <transition name="fade">
                    <div
                        v-if="
                            !expenses.dataLoad ||
                                expenses.dataLoad.length == 0 ||
                                formAdress == true
                        "
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
                                    v-html="
                                        expenses.errors.get('address_origin')
                                    "
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
                                        @change="
                                            expenses.address_destination = ''
                                        "
                                    /><span class="ml-2 text-gray-700">
                                        Direccion de Destino Favoritas
                                    </span>
                                </label>
                            </label>

                            <span
                                class="text-xs text-red-600 dark:text-red-400"
                                v-if="
                                    expenses.errors.has('address_destination')
                                "
                                v-html="
                                    expenses.errors.get('address_destination')
                                "
                            ></span>
                        </div>
                    </div>
                </transition>
                <transition name="fade">
                    <div
                        v-if="
                            (!expenses.dataLoad &&
                                expenses.address_destination !== '') ||
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
                                    v-html="
                                        expenses.errors.get('estimated_date')
                                    "
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
                            <label
                                class="ml-6 text-gray-500 dark:text-gray-400"
                            >
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
                </transition>
            </div>
            <div
                :class="[
                    !expenses.dataLoad || expenses.dataLoad.length <= 0
                        ? 'flex justify-center'
                        : 'flex justify-center my-12 innline w-1/7 mt-5'
                ]"
            >
                <button
                    v-if="!expenses.dataLoad"
                    class="hidden"
                    @click="HideAddress()"
                >
                    Editar
                </button>

                <button
                    v-else-if="expenses.dataLoad.length > 0"
                    @click="HideAddress()"
                    class="mr-4 w-24 h-12 text-white transition-colors text-lg bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800"
                >
                    Editar
                </button>

                <button
                    @click="submitForm()"
                    :class="[
                        !expenses.dataLoad
                            ? 'w-1/3 h-12 px-4 text-white transition-colors text-lg bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800'
                            : expenses.dataLoad.length <= 0
                            ? 'vld-parent w-1/3 h-12 px-4 text-white transition-colors text-lg bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800'
                            : 'ml-4 w-24 h-12 text-white transition-colors text-lg bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800'
                    ]"
                >
                    Cotizar
                </button>
            </div>
            <!-- <div v-if="expenses.progress">
                Progress: {{ expenses.progress.percentage }}%
            </div> -->

            <!-- Bloque cotizacion de fedex -->
            <transition name="fade">
                <div class="flex justify-center">
                    <div
                        v-if="
                            showApisQuote == true &&
                                fedex.DeliveryTimestamp &&
                                fedex.ServiceType &&
                                transportationRate &&
                                fedex.FUEL &&
                                fedex.PEAK &&
                                fedex.Discount &&
                                TotalEstimed &&
                                fedex.TotalNetCharge &&
                                (!expenses.dataLoad ||
                                    expenses.dataLoad.length > 0)
                        "
                        :class="[
                            !expenses.dataLoad
                                ? 'hidden'
                                : 'w-10/12 py-4 my-4 focus:outline-none border rounded-sm'
                        ]"
                    >
                        <div
                            class="w-2/12 inline-block align-top text-center text-sm px-2"
                        >
                            <div class="mb-8 text-sm font-semibold">
                                <span>LLEGADA</span>
                            </div>
                            <span>{{ fedex.DeliveryTimestamp }}</span>
                        </div>

                        <div
                            class="w-2/12 inline-block align-top text-center text-sm"
                        >
                            <div class="mb-8 text-sm font-semibold">
                                <span>SERVICIO</span>
                            </div>
                            <span>{{ fedex.ServiceType }}</span>
                        </div>

                        <div class="w-3/12 inline-block align-top text-sm">
                            <div class="mb-8 text-center text-sm font-semibold">
                                CONCEPTOS
                            </div>
                            <div>
                                <table>
                                    <tr>
                                        <td class="pl-4">
                                            Tarifa Transporte
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pl-4">
                                            Recargo Combustible
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pl-4">
                                            Recargo por alta demanda
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pl-4">Descuento</td>
                                    </tr>
                                    <tr>
                                        <td class="pl-4">
                                            Total Estimado
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="w-2/12 inline-block align-top text-sm">
                            <div class="mb-8 text-center text-sm font-semibold">
                                <span>TARIFA</span>
                            </div>
                            <table>
                                <tr>
                                    <td>
                                        <p class="text-right">
                                            {{ transportationRate }}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ fedex.FUEL }}</td>
                                </tr>
                                <tr>
                                    <td>{{ fedex.PEAK }}</td>
                                </tr>
                                <tr>
                                    <td>{{ fedex.Discount }}</td>
                                </tr>
                                <tr>
                                    <td>{{ TotalEstimed }}</td>
                                </tr>
                            </table>

                            <!-- <div class="text-right">
                                
                            </div>
                            <div class="text-right"></div>
                            <div class="text-right">{{ fedex.PEAK }}</div>
                            <div class="text-right">-{{ fedex.Discount }}</div>
                            <div class="text-right">
                                {{ TotalEstimed }}
                            </div> -->
                        </div>
                        <div
                            class="w-2/12 inline-block align-top text-center text-sm px-2"
                        >
                            <img
                                src="../../../../public/img/fedex-logo.png"
                                alt="fedex-logo"
                                width="47%"
                                height="47%"
                                class="mt-12 mb-4"
                            />

                            <button
                                @click="submitQuote(fedex.TotalNetCharge, 2)"
                                class="w-24 h-14 text-white transition-colors text-base bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800"
                            >
                                Cotizar FEDEX
                            </button>
                        </div>
                    </div>
                </div>
            </transition>

            <!-- Bloque cotizacion de DHL -->
            <transition name="fade">
                <div class="flex justify-center">
                    <div
                        v-if="
                            showApisQuote == true &&
                                dhl.DeliveryDate &&
                                dhl.DeliveryTime &&
                                (!expenses.dataLoad ||
                                    expenses.dataLoad.length > 0)
                        "
                        :class="[
                            !expenses.dataLoad
                                ? 'hidden'
                                : 'w-10/12 py-4 my-4 focus:outline-none border rounded-sm'
                        ]"
                    >
                        <div
                            class="w-2/12 inline-block align-top text-center text-sm px-2"
                        >
                            <div class="mb-8 text-sm font-semibold">
                                <span>LLEGADA</span>
                            </div>
                            <span>{{ dhl.DeliveryDate }}</span>
                            <span>{{ dhl.DeliveryTime }}</span>
                        </div>

                        <div
                            class="w-2/12 inline-block align-top text-center text-sm"
                        >
                            <div class="mb-8 text-sm font-semibold">
                                <span>SERVICIO</span>
                            </div>
                            <span>{{ dhl.ProductShortName }}</span>
                        </div>

                        <div class="w-3/12 inline-block align-top text-sm">
                            <div class="mb-8 text-center text-sm font-semibold">
                                CONCEPTOS
                            </div>
                            <div>
                                <table>
                                    <tr>
                                        <td class="pl-4">
                                            Tarifa Transporte
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pl-4">
                                            Recargo Combustible
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pl-4">
                                            Recargo por alta demanda
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pl-4">Descuento</td>
                                    </tr>
                                    <tr>
                                        <td class="pl-4">
                                            Total Estimado
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="w-2/12 inline-block align-top text-sm">
                            <div class="mb-8 text-center text-sm font-semibold">
                                <span>TARIFA</span>
                            </div>
                            <table>
                                <tr>
                                    <td>
                                        <p class="text-right">
                                            {{ dhl.ShippingCharge }}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ dhl['FUEL SURCHARGE'] }}</td>
                                </tr>
                                <tr>
                                    <td>{{ dhl.WeightCharge }}</td>
                                </tr>
                                <tr>
                                    <td>- {{ dhl.Discount }}%</td>
                                </tr>
                                <tr>
                                    <td>{{}}</td>
                                </tr>
                            </table>

                            <!-- <div class="text-right">
                                
                            </div>
                            <div class="text-right"></div>
                            <div class="text-right">{{ fedex.PEAK }}</div>
                            <div class="text-right">-{{ fedex.Discount }}</div>
                            <div class="text-right">
                                {{ TotalEstimed }}
                            </div> -->
                        </div>
                        <div
                            class="w-2/12 inline-block align-top text-center text-sm px-2"
                        >
                            <img
                                src="../../../../public/img/dhl-express.jpg"
                                alt="fedex-logo"
                                width="47%"
                                height="47%"
                                class="mt-12 mb-4"
                            />

                            <button
                                @click="submitQuote(fedex.TotalNetCharge, 2)"
                                class="w-24 h-14 text-white transition-colors text-base bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800"
                            >
                                Cotizar DHL
                            </button>
                        </div>
                    </div>
                </div>
            </transition>

            <!-- Bloque cotizacion de UPS -->
            <transition name="fade">
                <div class="flex justify-center">
                    <div
                        v-if="
                            showApisQuote == true &&
                                fedex.DeliveryTimestamp &&
                                fedex.ServiceType &&
                                transportationRate &&
                                fedex.FUEL &&
                                fedex.PEAK &&
                                fedex.Discount &&
                                TotalEstimed &&
                                fedex.TotalNetCharge &&
                                (!expenses.dataLoad ||
                                    expenses.dataLoad.length > 0)
                        "
                        :class="[
                            !expenses.dataLoad
                                ? 'hidden'
                                : 'w-10/12 py-4 my-4 focus:outline-none border rounded-sm'
                        ]"
                    >
                        <div
                            class="w-2/12 inline-block align-top text-center text-sm px-2"
                        >
                            <div class="mb-8 text-sm font-semibold">
                                <span>LLEGADA</span>
                            </div>
                            <span>{{ fedex.DeliveryTimestamp }}</span>
                        </div>

                        <div
                            class="w-2/12 inline-block align-top text-center text-sm"
                        >
                            <div class="mb-8 text-sm font-semibold">
                                <span>SERVICIO</span>
                            </div>
                            <span>{{ fedex.ServiceType }}</span>
                        </div>

                        <div class="w-3/12 inline-block align-top text-sm">
                            <div class="mb-8 text-center text-sm font-semibold">
                                CONCEPTOS
                            </div>
                            <div>
                                <table>
                                    <tr>
                                        <td class="pl-4">
                                            Tarifa Transporte
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pl-4">
                                            Recargo Combustible
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pl-4">
                                            Recargo por alta demanda
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pl-4">Descuento</td>
                                    </tr>
                                    <tr>
                                        <td class="pl-4">
                                            Total Estimado
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="w-2/12 inline-block align-top text-sm">
                            <div class="mb-8 text-center text-sm font-semibold">
                                <span>TARIFA</span>
                            </div>
                            <table>
                                <tr>
                                    <td>
                                        <p class="text-right">
                                            {{ transportationRate }}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ fedex.FUEL }}</td>
                                </tr>
                                <tr>
                                    <td>{{ fedex.PEAK }}</td>
                                </tr>
                                <tr>
                                    <td>{{ fedex.Discount }}</td>
                                </tr>
                                <tr>
                                    <td>{{ TotalEstimed }}</td>
                                </tr>
                            </table>

                            <!-- <div class="text-right">
                                
                            </div>
                            <div class="text-right"></div>
                            <div class="text-right">{{ fedex.PEAK }}</div>
                            <div class="text-right">-{{ fedex.Discount }}</div>
                            <div class="text-right">
                                {{ TotalEstimed }}
                            </div> -->
                        </div>
                        <div
                            class="w-2/12 inline-block align-top text-center text-sm px-2"
                        >
                            <img
                                src="../../../../public/img/ups-logo.jpg"
                                alt="fedex-logo"
                                width="47%"
                                height="47%"
                                class="mt-12 mb-4"
                            />

                            <button
                                @click="submitQuote(fedex.TotalNetCharge, 2)"
                                class="w-24 h-14 text-white transition-colors text-base bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800"
                            >
                                Cotizar UPS
                            </button>
                        </div>
                    </div>
                </div>
            </transition>
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
            fedex: {} /* response object api fedex */,
            dhl: {} /* response object api DHL */,
            transportationRate: '' /* transportation rate Fedex */,
            TotalEstimed: '' /* estimated total Fedex */,
            formAdress: true /* Form addresses */,
            adressDate: false /* Form date and description */,
            showApisQuote: false /* api quote block */
        };
    },
    methods: {
        /* Quote to wait for the apis (button cotizar) */
        async submitForm() {
            /* Vue-loader config */
            let loader = this.$loading.show({
                canCancel: true,
                transition: 'fade',
                color: '#046c4e',
                loader: 'spinner',
                lockScroll: true,
                enforceFocus: true,
                height: 100,
                width: 100
            });

            this.formAdress = false; /* Hide address form */
            this.adressDate = false; /* Hide date and description form */
            this.Load = false; /* Hide form loads and dimensions */
            try {
                this.showApisQuote = true;
                this.expenses.dataLoad = this.$store.state.load.loads;

                /* get data from fedex quote and rate api */
                const fedexApi = await this.expenses.post('/get-fedex-rate');

                /* It is validated if the request was successful to show the quote block (FEDEX) */
                if (fedexApi.status == 200) {
                    /* The variable is equalized to later use it in the template */
                    this.fedex = fedexApi.data;

                    /* transforming the time into format "day-month-yyyy" */
                    this.fedex.DeliveryTimestamp = this.$luxon(
                        this.fedex.DeliveryTimestamp
                    );

                    /* transforming the transport rate to 2 decimal places */
                    this.transportationRate =
                        this.fedex.TotalBaseCharge -
                        this.fedex.TotalFreightDiscounts;
                    this.transportationRate = this.transportationRate.toFixed(
                        2
                    );

                    /* Calculating the discount on the estimated total */
                    this.fedex.Discount =
                        this.fedex.TotalNetCharge * (this.fedex.Discount / 100);
                    this.fedex.Discount = this.fedex.Discount.toFixed(2);

                    /* Applying the discount on the estimated total */
                    this.TotalEstimed =
                        this.fedex.TotalNetCharge - this.fedex.Discount;
                    this.TotalEstimed = this.TotalEstimed.toFixed(2);
                }

                /* get data from DHL quote and rate api */
                const DhlApi = await this.expenses.post('/get-dhl-quote');

                if (DhlApi.status == 200) {
                    this.dhl = DhlApi.data;
                }
                /* Vue-loader hidden */
                loader.hide();

                console.log(
                    this.$store.state.load.loads,
                    ' ENVIO DE INTERNAMIA'
                );
            } catch (error) {
                console.error(error);
            }
        },
        /**
         * Show / Hide from address (button "Editar")
         */
        HideAddress() {
            this.formAdress = !this.formAdress; /* Hide / Show Address Form */
            this.adressDate = !this
                .adressDate; /* Hide / Show date and description form */
            this.Load = !this.Load; /* Hide / Show loads and dimensions form */
            /* Here the dataLoad is set to 0 to edit the view */
            this.expenses.dataLoad = this.expenses.dataLoad.length == 0;
        },

        /**
         * Send api quote (button Cotizar fedex, dhl, ups)
         * @param {Number} appAmount selected service amount if fedex, dhl or ups
         * @param {Number} transCompanyId number of the service that is selected:
         * @param {2} FEDEX
         * @param {3} DHL
         * @param {4} UPS
         */
        async submitQuote(appAmount, transCompanyId) {
            this.expenses.app_amount = appAmount;
            this.expenses.trans_company_id = transCompanyId;
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

            /* Condicionales para mostrar el formulario de addresses dependiendo de la validacion del peso */
            if (loads.length) {
                if (
                    loads[loads.length - 1].weight_units == 'KG' &&
                    loads[loads.length - 1].weight < 2
                )
                    return false;
                if (
                    loads[loads.length - 1].weight_units == 'KG' &&
                    loads[loads.length - 1].weight >= 2 &&
                    loads[loads.length - 1].weight <= 2268
                )
                    return true;
                if (
                    loads[loads.length - 1].weight_units == 'LB' &&
                    loads[loads.length - 1].weight < 4.4
                )
                    return false;
                if (
                    loads[loads.length - 1].weight_units == 'LB' &&
                    loads[loads.length - 1].weight >= 4.4 &&
                    loads[loads.length - 1].weight <= 5000
                )
                    return true;
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

<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 1s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}
</style>

<template>
  <div>
    <div
      v-if="!expenses.dataLoad || expenses.dataLoad.length == 0 || $store.state.address.formAddress"
      class="flex flex-col items-center my-2"
    >
      <!-- Direccion de origen -->
      <div class="w-11/12 lg:w-8/12 mb-4 md:px-4 lg:px-0">
        <!-- <div class="mt-2 mr-8 flex justify-start w-1/12"></div> -->
        <div>
          <span class="text-sm font-semibold">Origen</span>
          <div v-if="!expenses.fav_origin_address" class="flex">
            <vue-google-autocomplete
              v-model="expenses.origin_address"
              id="addressOrigin"
              classname="w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input pac-target-input"
              v-on:placechanged="getAddressOrigin"
              placeholder="Direccion de Origen"
            >
            </vue-google-autocomplete>
          </div>
          <div v-else class="flex">
            <select
              v-model="expenses.origin_address"
              class="text-sm block w-full mt-1 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray"
            >
              <option v-for="item in origin_transport" :value="item.id" :key="item.id">
                {{ item.address }}
              </option>
            </select>
          </div>
          <label class="inline-flex text-sm items-center mx-2 mt-2">
            <input
              type="checkbox"
              class="form-checkbox h-4 w-4 text-gray-800"
              v-model="expenses.fav_origin_address"
              @change="expenses.origin_address = ''"
            />
            <span class="ml-2 text-gray-700">
              {{ data.condition === 'FOB' ? 'Puertos favoritos' : 'Origen favorito' }}
            </span>
          </label>
          <span
            class="text-xs text-red-600 dark:text-red-400"
            v-if="expenses.errors.has('origin_address')"
            v-html="expenses.errors.get('origin_address')"
          ></span>
        </div>
        <!-- <div class="flex justify-center w-1/12">
            <h3 class="mt-2"></h3>
          </div> -->
      </div>

      <!-- Codigo postal origen -->
      <div
        v-if="postalCodeOrigin && !expenses.fav_origin_address"
        class="w-11/12 lg:w-8/12 mb-4 md:px-4 lg:px-0"
      >
        <div>
          <span class="text-sm font-semibold">Código postal origen</span>
          <div class="flex">
            <input
              class="w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input pac-target-input"
              type="number"
              max="15"
              v-model="expenses.origin_postal_code"
              placeholder="Código postal de origen"
            />
          </div>
          <span
            class="text-xs text-red-600 dark:text-red-400"
            v-if="expenses.errors.has('origin_postal_code')"
            v-html="expenses.errors.get('origin_postal_code')"
          ></span>
        </div>
        <!-- <div class="mt-2 mr-8 flex justify-start w-1/12"></div> -->
        <!-- <div class="flex justify-center w-1/12">
            <h3 class="mt-2"></h3>
          </div> -->
      </div>

      <!-- Destino de envio -->
      <div class="w-11/12 lg:w-8/12 mb-4 md:px-4 lg:px-0">
        <div>
          <span class="text-sm font-semibold">Destino</span>
          <div v-if="!expenses.fav_dest_address" class="flex">
            <vue-google-autocomplete
              v-model="expenses.dest_address"
              id="addressDestination"
              classname="w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input pac-target-input"
              :placeholder="
                expenses.fav_dest_address
                  ? 'Nombre o codigo Puerto/Aeropuerto'
                  : 'Direccion, Codigo Postal'
              "
              v-on:placechanged="getAddressDestination"
            >
            </vue-google-autocomplete>
          </div>
          <div v-else class="flex">
            <select
              v-model="expenses.dest_address"
              class="text-sm block w-full mt-1 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray"
            >
              <option v-for="item in addressDestination" :value="item.id" :key="item.id">
                {{ item.address }}
              </option>
            </select>
          </div>
          <label class="inline-flex text-sm items-center mx-2 mt-2">
            <input
              type="checkbox"
              class="form-checkbox h-4 w-4 text-gray-800"
              v-model="expenses.fav_dest_address"
              @change="expenses.dest_address = ''"
            /><span class="ml-2 text-gray-700">Destino favorito</span>
          </label>
        </div>
        <!-- <div class="mt-2 mr-8 flex justify-start w-1/12"></div> -->
        <!-- <div class="flex justify-center w-1/12">
            <h3 class="mt-2"></h3>
          </div> -->
        <span
          class="text-xs text-red-600 dark:text-red-400"
          v-if="expenses.errors.has('dest_address')"
          v-html="expenses.errors.get('dest_address')"
        ></span>
      </div>

      <!-- codigo postal de destino -->
      <div
        v-if="postalCodeDestination && !expenses.fav_dest_address"
        class="w-11/12 lg:w-8/12 mb-4 md:px-4 lg:px-0"
      >
        <div>
          <span class="text-sm font-semibold">Código postal origen</span>
          <div class="flex">
            <input
              class="
                form-input
                w-full
                block
                border border-gray-150
                text-gray-700
                text-sm
                p-2
                mt-1
                pr-8
                rounded
                leading-tight
                focus:outline-none focus:bg-white focus:border-gray-500
                dark:text-gray-300
                dark:border-gray-600
                dark:bg-gray-700
                dark:focus:shadow-outline-gray
              "
              type="number"
              max="15"
              v-model="expenses.dest_postal_code"
              placeholder="Código postal de destino"
            />
          </div>
          <span
            class="text-xs text-red-600 dark:text-red-400"
            v-if="expenses.errors.has('dest_postal_code')"
            v-html="expenses.errors.get('dest_postal_code')"
          ></span>
        </div>
        <!-- <div class="mt-2 mr-8 flex justify-start w-1/12"></div> -->
        <!-- <div class="flex justify-center w-1/12">
            <h3 class="mt-2"></h3>
          </div> -->
      </div>
    </div>

    <!-- Date and description -->
    <transition name="fade">
      <FormDate v-if="$store.state.address.addressDate" />
    </transition>

    <!-- Botones editar y cotizar -->
    <div
      :class="[
        !expenses.dataLoad || expenses.dataLoad.length <= 0
          ? 'flex justify-center'
          : 'flex justify-center my-5 innline w-1/7 mt-5'
      ]"
    >
      <button v-if="!expenses.dataLoad" class="hidden" @click="HideAddress()">Editar</button>

      <button
        v-else-if="expenses.dataLoad.length > 0"
        @click="HideAddress()"
        class="
          mr-4
          w-32
          h-12
          text-white
          transition-colors
          text-lg
          bg-blue-1000
          rounded-lg
          focus:shadow-outline
          hover:bg-blue-1100 active:bg-blue-1000
          "
      >
        Editar
      </button>
      <button
        @click="submitForm()"
        :class="[
          !expenses.dataLoad
            ? 'flex items-center justify-center vld-parent sm:w-44 h-12 px-4 text-white transition-colors text-lg bg-blue-1300 rounded-lg focus:shadow-outline hover:bg-blue-1200 active:bg-blue-1300'
            : expenses.dataLoad.length <= 0
            ? 'flex items-center justify-center vld-parent sm:w-44 h-12 px-4 text-white transition-colors text-lg bg-blue-1300 rounded-lg focus:shadow-outline hover:bg-blue-1200 active:bg-blue-1300'
            : 'flex items-center justify-center ml-4 w-32 h-12 text-white transition-colors text-lg bg-blue-1300 rounded-lg focus:shadow-outline hover:bg-blue-1200 active:bg-blue-1300'
        ]"
      >
        <!-- <svg
          v-if="busy"
          class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
        >
          <circle
            class="opacity-25"
            cx="12"
            cy="12"
            r="10"
            stroke="currentColor"
            stroke-width="4"
          ></circle>
          <path
            class="opacity-75"
            fill="currentColor"
            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
          ></path>
        </svg> -->
        Cotizar
      </button>
    </div>

    <!-- Bloque cotizacion de fedex -->
    <!-- <transition name="fade"> -->
    <div name="fade" class="sm:flex sm:justify-center">
      <div
        v-if="
          showFedexQuote == true &&
            fedex.DeliveryTimestamp &&
            fedex.ServiceType &&
            fedex.FUEL &&
            fedex.PEAK &&
            fedex.Discount &&
            TotalEstimed &&
            fedex.TotalNetCharge
        "
        :class="[
          !expenses.dataLoad
            ? 'hidden'
            : 'lg:w-9/12 md:9/12 py-4 my-4 focus:outline-none border rounded-sm'
        ]"
      >
        <div class="sm:w-2/12 sm:inline-block align-top text-center text-sm px-2 mb-8">
          <div class="mb-8 text-sm font-semibold">
            <span>LLEGADA</span>
          </div>
          <span>{{ fedex.DeliveryTimestamp }}</span>
        </div>

        <div class="sm:w-2/12 sm:inline-block align-top text-center text-sm mb-8">
          <div class="mb-8 text-sm font-semibold">
            <span>SERVICIO</span>
          </div>
          <span>{{ fedex.ServiceType }}</span>
        </div>

        <div class="sm:w-5/12 inline-block align-top px-2">
          <table>
            <thead>
              <tr>
                <th class="text-sm font-semibold">
                  <div class="mb-8 text-sm font-semibold">
                    <span>CONCEPTOS</span>
                  </div>
                </th>
                <th class="w-28 sm:w-28 text-sm font-semibold">
                  <div class="mb-8 text-sm font-semibold">
                    <span>TARIFA</span>
                  </div>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-left text-sm">Tarifa Transporte</td>
                <td class="text-right text-sm">
                  {{ transportQuote }}
                </td>
              </tr>
              <tr>
                <td class="text-left text-sm">Recargo Combustible</td>
                <td class="text-right text-sm">
                  {{ fedex.FUEL }}
                </td>
              </tr>
              <tr>
                <td class="text-left text-sm">Recargo por alta demanda</td>
                <td class="text-right text-sm">
                  {{ fedex.PEAK }}
                </td>
              </tr>
              <!-- <tr>
                  <td class="text-left text-sm">Descuento</td>
                  <td class="text-right text-sm">
                    {{ fedex.Discount }}
                  </td>
                </tr> -->
              <tr>
                <td class="text-left text-sm">Total Estimado</td>
                <td class="text-right text-sm">
                  {{ TotalEstimed }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="sm:w-2/12 h-full inline-block align-top text-center text-sm px-2">
          <div class="flex flex-col h-full justify-around">
            <div class="flex flex-auto self-end items-center mt-8">
              <img
                src="../../../../public/img/fedex-logo.png"
                alt="fedex-logo"
                class="mx-auto my-2 w-4/12 sm:w-9/12"
              />
            </div>
            <div class="flex flex-auto items-center justify-center">
              <button
                @click="submitQuote(TotalEstimed, 2)"
                :class="[
                  busyFedex
                    ? 'flex flex-col items-center w-24 px-2 h-16 text-white transition-colors text-sm bg-blue-1300 rounded-lg focus:shadow-outline hover:bg-blue-1200 active:bg-blue-1300'
                    : 'w-24 px-2 h-14 text-white transition-colors text-sm bg-blue-1300 rounded-lg focus:shadow-outline hover:bg-blue-1200 active:bg-blue-1300'
                ]"
                :disabled="busyFedex"
              >
                Cotizar FEDEX
                <svg
                  v-if="busyFedex"
                  class="animate-spin h-5 w-5 text-white"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                >
                  <circle
                    class="opacity-25"
                    cx="12"
                    cy="12"
                    r="10"
                    stroke="currentColor"
                    stroke-width="4"
                  ></circle>
                  <path
                    class="opacity-75"
                    fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                  ></path>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- </transition> -->

    <!-- Bloque cotizacion de DHL -->
    <div name="fade" class="sm:flex sm:justify-center">
      <div
        v-if="
          showDHLQuote == true &&
            dhl.DeliveryDate &&
            dhl.DeliveryTime &&
            dhl.ProductShortName &&
            dhl.WeightCharge &&
            dhl['FUEL SURCHARGE'] &&
            dhl['EMERGENCY SITUATION'] &&
            dhl.Discount &&
            dhl.ComextechDiscount
        "
        :class="[
          !expenses.dataLoad
            ? 'hidden'
            : 'lg:w-9/12 md:9/12 py-4 my-4 focus:outline-none border rounded-sm'
        ]"
      >
        <div class="sm:w-2/12 sm:inline-block align-top text-center text-sm px-2 mb-8">
          <div class="mb-8 text-sm font-semibold">
            <span>LLEGADA</span>
          </div>
          <span>{{ dhl.DeliveryDate }}</span>
          <span>{{ dhl.DeliveryTime }}</span>
        </div>

        <div class="sm:w-2/12 sm:inline-block align-top text-center text-sm mb-8">
          <div class="mb-8 text-sm font-semibold">
            <span>SERVICIO</span>
          </div>
          <span>{{ dhl.ProductShortName }}</span>
        </div>

        <div class="sm:w-5/12 inline-block align-top px-2">
          <table>
            <thead>
              <tr>
                <th class="text-sm font-semibold">
                  <div class="mb-8 text-sm font-semibold">
                    <span>CONCEPTOS</span>
                  </div>
                </th>
                <th class="w-28 sm:w-28 text-sm font-semibold">
                  <div class="mb-8 text-sm font-semibold">
                    <span>TARIFA</span>
                  </div>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-left text-sm">Tarifa de Transporte</td>
                <td class="text-right text-sm">
                  {{ transportDHL }}
                </td>
              </tr>
              <tr>
                <td class="text-left text-sm">Recargo por Combustible</td>
                <td class="text-right text-sm">
                  {{ dhl['FUEL SURCHARGE'] }}
                </td>
              </tr>
              <tr>
                <td class="text-left text-sm">Situación de emergencia</td>
                <td class="text-right text-sm">
                  {{ dhl['EMERGENCY SITUATION'] }}
                </td>
              </tr>
              <!-- <tr>
                  <td class="text-left text-sm">Descuento</td>
                  <td class="text-right text-sm">
                    {{ dhl.ComextechDiscount }}
                  </td>
                </tr> -->
              <tr>
                <td class="text-left text-sm">Total Estimado</td>
                <td class="text-right text-sm">
                  {{ dhl.ComextechTotal }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="sm:w-2/12 h-full inline-block align-top text-center text-sm px-2">
          <div class="flex flex-col h-full justify-around">
            <div class="flex flex-auto self-end items-center mt-8">
              <img
                src="../../../../public/img/dhl-express.jpg"
                alt="dhl-logo"
                class="mx-auto my-2 w-4/12 sm:w-9/12"
              />
            </div>
            <div class="flex flex-auto items-center justify-center">
              <button
                @click="submitQuote(dhl.ComextechTotal, 3)"
                class="
                  flex 
                  flex-col 
                  items-center 
                  justify-center 
                  w-24
                  h-14
                  px-2
                  text-white
                  transition-colors
                  text-sm
                  bg-blue-1300
                  rounded-lg
                  focus:shadow-outline
                  hover:bg-blue-1200 active:bg-blue-1300
                "
                :disabled="busyDHL"
              >
                Cotizar DHL
                <svg
                  v-if="busyDHL"
                  class="animate-spin h-5 w-5 text-white"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                >
                  <circle
                    class="opacity-25"
                    cx="12"
                    cy="12"
                    r="10"
                    stroke="currentColor"
                    stroke-width="4"
                  ></circle>
                  <path
                    class="opacity-75"
                    fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                  ></path>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Fin Bloque cotizacion de DHL -->
  </div>
</template>

<script>
import FormDate from './FormDate.vue';
import VueGoogleAutocomplete from 'vue-google-autocomplete';
import VueNumeric from 'vue-numeric';
import { mapState } from 'vuex';
import Button from '../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Button.vue';
import Form from '../Internment/Form.vue';

export default {
  components: { VueGoogleAutocomplete, Button, VueNumeric, FormDate, Form },
  props: {
    address: String
  },
  data() {
    return {
      fedex: {} /* response object api fedex */,
      dhl: {} /* response object api DHL */,
      transportDHL: '' /* transportation rate Fedex */,
      BaseChargeTotal: '',
      TotalEstimed: '' /* estimated total Fedex */,
      // showApisQuote: false,
      transportQuote: 0,
      showFedexQuote: false,
      showDHLQuote: false,
      busyFedex: false,
      busyDHL: false
    };
  },
  methods: {
    /**
     * Send api quote (button Cotizar fedex, dhl, ups)
     * @param {Number} appAmount selected service amount if fedex, dhl or ups
     * @param {Number} transCompanyId number of the service that is selected:
     * @param {2} FEDEX
     * @param {3} DHL
     * @param {4} UPS
     */
    async submitQuote(appAmount, transCompanyId) {
      try {
        if (transCompanyId === 2) this.busyFedex = true;
        if (transCompanyId === 3) this.busyDHL = true;

        this.expenses.dataLoad = this.$store.state.load.loads;
        this.expenses.app_amount = appAmount;
        this.expenses.trans_company_id = transCompanyId;
        const { data } = await this.expenses.post('/applications/transports');
        Toast.fire({
          icon: 'success',
          title: 'Datos Agregados'
        });

        this.$store.dispatch('load/setLoad', data);
        this.$store.dispatch('callIncomingOrNextMenu', true);
      } catch (error) {
        console.error(error);
      } finally {
        this.busyFedex = false;
        this.busyDHL = false;
      }
    },

    /* Quote to wait for the apis (button cotizar) */
    submitForm() {
      /* Vue-loader config */
      let loader = this.$loading.show({
        canCancel: true,
        transition: 'fade',
        color: '#4db2dc',
        loader: 'spinner',
        lockScroll: true,
        enforceFocus: true,
        height: 100,
        width: 100
      });

      /* Hide / Show loads and dimensions form */
      this.$store.dispatch('load/showLoadCharge', false);
      this.$store.dispatch('address/showAddress', false);

      this.expenses.dataLoad = this.$store.state.load.loads;

      /* get data from fedex quote and rate api */
      const fedexApi = this.expenses
        .post('/get-fedex-rate')
        .then((response) => {
          return response.data;
        })
        .catch((error) => console.error(error));

      /* get data from DHL quote and rate api */
      const DhlApi = this.expenses
        .post('/get-dhl-quote')
        .then((response) => {
          return response.data;
        })
        .catch((error) => console.error(error));

      Promise.all([fedexApi, DhlApi])
        .then((data) => {
          /* It is validated if the request was successful to show the quote block (FEDEX) */
          if (data[0]) {
            // this.showApisQuote = true;
            this.showFedexQuote = true;

            /* The variable is equalized to later use it in the template */
            this.fedex = data[0];

            /* transforming the time into format "day-month-yyyy" */
            this.fedex.DeliveryTimestamp = this.$luxon(this.fedex.DeliveryTimestamp);

            this.transportQuote = this.fedex.TotalBaseCharge - this.fedex.Discount;
            // this.transportQuote = parseFloat(this.transportQuote);
            this.transportQuote = this.transportQuote.toFixed(2);

            this.TotalEstimed = this.fedex.TotalEstimed.toFixed(2);
          }

          if (data[1]) {
            this.showDHLQuote = true;
            this.dhl = data[1];

            this.transportDHL =
              parseFloat(this.dhl.WeightCharge) + parseFloat(this.dhl.TotalDiscount);
            // this.dhl.Discount = (this.transportDHL * 60) / 100;
            // this.dhl.Discount = parseFloat(this.dhl.Discount).toFixed(
            //     2
            // );

            this.dhl.ComextechDiscount = this.dhl.ComextechDiscount.toFixed(2);

            this.transportDHL = this.transportDHL - this.dhl.ComextechDiscount;

            this.transportDHL = this.transportDHL.toFixed(2);
          }

          /* Vue-loader hidden */
          loader.hide();
        })
        .catch((error) => {
          this.HideAddress();
          loader.hide();
          console.error(error);
        });
    },

    /**
     * Show / Hide from address (button "Editar")
     */
    HideAddress() {
      this.$store.dispatch('address/showAddress', true);

      this.fedex = {};

      this.dhl = {};

      this.$store.dispatch('load/showLoadCharge', true); /* Hide / Show loads and dimensions form */

      // this.showApisQuote = false;
      this.showFedexQuote = false;
      this.showDHLQuote = false;

      // /* Here the dataLoad is set to 0 to edit the view */
      // this.expenses.dataLoad = this.expenses.dataLoad.length == 0;
    },

    /**
     * When the location found
     * @param {Object} addressData Data of the found location
     * @param {Object} placeResultData PlaceResult object
     * @param {String} id Input container ID
     */
    getAddressOrigin(addressData, placeResultData, id) {
      this.$store.dispatch('address/getAddressOrigin', { addressData, placeResultData });
    },

    getAddressDestination(addressData, placeResultData, id) {
      this.$store.dispatch('address/getAddressDestination2', { addressData, placeResultData });
    }
  },
  computed: {
    ...mapState('address', [
      'expenses',
      'addressDestination',
      'portsDestination',
      'portsOrigin',
      'props',
      'postalCodeOrigin',
      'postalCodeDestination'
    ]),
    ...mapState('application', ['data', 'currency', 'origin_transport', 'busy'])
  },
  async created() {
    await this.$store.dispatch('address/getAddressDestination');
  }
};
</script>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.7s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>

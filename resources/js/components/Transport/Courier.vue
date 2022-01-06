<template>
  <div>
    <div>
      <div
        v-if="
          !expenses.dataLoad || expenses.dataLoad.length == 0 || $store.state.address.formAddress
        "
        class="flex flex-wrap -mx-3 my-8"
      >
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
          <label class="block text-sm">
            <span class="text-gray-700 dark:text-gray-400 font-semibold">
              {{
                data.condition === 'FOB'
                  ? ' Puertos de Proveedor'
                  : ' Almacen o Fabrica del Proveedor'
              }}
            </span>
            <vue-google-autocomplete
              v-if="!expenses.fav_origin_address"
              v-model="expenses.origin_address"
              id="addressOrigin"
              classname="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
              v-on:placechanged="getAddressOrigin"
              placeholder="Direccion, Codigo Postal"
            >
            </vue-google-autocomplete>
            <div v-else class="relative">
              <select
                v-model="expenses.origin_address"
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
                  focus:outline-none focus:bg-white focus:border-gray-500
                "
              >
                <option v-for="item in origin_transport" :value="item.id" :key="item.id" class="">
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
              /><span class="ml-2 text-gray-700">
                Tus
                {{ data.condition === 'FOB' ? 'Puertos' : 'Almacenes o Fabricas' }}
                Favoritos
              </span>
            </label>
            <span
              class="text-xs text-red-600 dark:text-red-400"
              v-if="expenses.errors.has('origin_address')"
              v-html="expenses.errors.get('origin_address')"
            ></span>
          </label>
        </div>
        <!-- Destino de Envio -->
        <div class="w-full md:w-1/2 px-3">
          <label class="block text-sm">
            <span class="text-gray-700 dark:text-gray-400 font-semibold"> Destino de Envio </span>

            <vue-google-autocomplete
              v-if="!expenses.fav_dest_address"
              v-model="expenses.dest_address"
              id="addressDestination"
              classname="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
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
                v-model="expenses.dest_address"
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
                  focus:outline-none focus:bg-white focus:border-gray-500
                "
              >
                <option v-for="item in addressDestination" :value="item.id" :key="item.id" class="">
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
              /><span class="ml-2 text-gray-700"> Direccion de Destino Favoritas </span>
            </label>
          </label>

          <span
            class="text-xs text-red-600 dark:text-red-400"
            v-if="expenses.errors.has('dest_address')"
            v-html="expenses.errors.get('dest_address')"
          ></span>
        </div>
      </div>
      <div v-if="$store.state.address.addressDate" class="flex flex-wrap -mx-3 mb-6">
        <div class="w-1/4 px-3 mb-6 md:mb-0">
          <label class="block text-sm">
            <span class="text-gray-700 dark:text-gray-400 font-semibold">
              Fecha estimada de recogida
            </span>
            <input
              type="date"
              v-model="expenses.estimated_date"
              class="
                block
                w-full
                mt-1
                text-sm
                dark:border-gray-600 dark:bg-gray-700
                focus:border-blue-400 focus:outline-none focus:shadow-outline-blue
                dark:text-gray-300 dark:focus:shadow-outline-gray
                form-input
              "
              placeholder="Nombre o codigo Puerto/Aeropuerto"
              :min="minDate"
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
            <span class="text-gray-700 dark:text-gray-400 font-semibold">
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
                dark:border-gray-600 dark:bg-gray-700
                focus:border-blue-400 focus:outline-none focus:shadow-outline-blue
                dark:text-gray-300 dark:focus:shadow-outline-gray
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
              @click="convertInsurance(data.amount, currency.code)"
            />
            <span class="ml-2 text-gray-700">Seguro (1,5%)</span>
          </label>
        </div>
        <div class="w-1/6 mt-8" v-if="expenses.insurance">
          <span class="ml-2 text-gray-700">
            {{ data.amount }} USD
            <!-- {{ currency.code }} -->
          </span>
        </div>
      </div>

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
            w-24
            h-12
            text-white
            transition-colors
            text-lg
            bg-green-700
            rounded-lg
            focus:shadow-outline
            hover:bg-green-800
          "
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
                  class="
                    w-24
                    px-2
                    h-14
                    text-white
                    transition-colors
                    text-sm
                    bg-green-700
                    rounded-lg
                    focus:shadow-outline
                    hover:bg-green-800
                  "
                >
                  Cotizar FEDEX
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
                  @click="submitQuote(dhl.ComextechTotal, 2)"
                  class="
                    w-24
                    px-2
                    h-14
                    text-white
                    transition-colors
                    text-sm
                    bg-green-700
                    rounded-lg
                    focus:shadow-outline
                    hover:bg-green-800
                  "
                >
                  Cotizar DHL
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Fin Bloque cotizacion de DHL -->
    </div>
  </div>
</template>

<script>
import VueGoogleAutocomplete from 'vue-google-autocomplete';
import VueNumeric from 'vue-numeric';
import { mapState } from 'vuex';
import Button from '../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Button.vue';

export default {
  components: { VueGoogleAutocomplete, Button, VueNumeric },
  props: {
    address: String
  },
  data() {
    return {
      minDate: new Date().toISOString().substr(0, 10),
      fedex: {} /* response object api fedex */,
      dhl: {} /* response object api DHL */,
      transportDHL: '' /* transportation rate Fedex */,
      BaseChargeTotal: '',
      TotalEstimed: '' /* estimated total Fedex */,
      // showApisQuote: false,
      transportQuote: 0,
      showFedexQuote: false,
      showDHLQuote: false,
      showShipping: false
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
        this.expenses.dataLoad = this.$store.state.load.loads;
        this.expenses.app_amount = appAmount;
        this.expenses.trans_company_id = transCompanyId;
        const { data } = await this.expenses.post('/applications/transports');
        Toast.fire({
          icon: 'success',
          title: 'Datos Agregados'
        });

        this.$store.dispatch('exchange/getSummary', this.data.application_id);
        this.$store.dispatch('load/setLoad', data);
        this.$store.dispatch('callIncomingOrNextMenu', true);
      } catch (error) {
        console.error(error);
      }
    },

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

      this.$store.dispatch(
        'load/showLoadCharge',
        false
      ); /* Hide / Show loads and dimensions form */
      this.$store.dispatch('address/showAddress', false);
      try {
        // this.showApisQuote = true;
        this.expenses.dataLoad = this.$store.state.load.loads;

        /* get data from fedex quote and rate api */
        const fedexApi = await this.expenses.post('/get-fedex-rate');

        /* get data from DHL quote and rate api */
        const DhlApi = await this.expenses.post('/get-dhl-quote');

        /* It is validated if the request was successful to show the quote block (FEDEX) */
        if (fedexApi.status == 200) {
          this.showFedexQuote = true;

          /* The variable is equalized to later use it in the template */
          this.fedex = fedexApi.data;

          /* transforming the time into format "day-month-yyyy" */
          this.fedex.DeliveryTimestamp = this.$luxon(this.fedex.DeliveryTimestamp);

          this.transportQuote = this.fedex.TotalBaseCharge - this.fedex.Discount;
          // this.transportQuote = parseFloat(this.transportQuote);
          this.transportQuote = this.transportQuote.toFixed(2);

          this.TotalEstimed = this.fedex.TotalEstimed.toFixed(2);

          /* Vue-loader hidden */
          loader.hide();
        }

        if (DhlApi.status == 200) {
          this.showDHLQuote = true;
          this.dhl = DhlApi.data;

          this.transportDHL =
            parseFloat(this.dhl.WeightCharge) + parseFloat(this.dhl.TotalDiscount);
          // this.dhl.Discount = (this.transportDHL * 60) / 100;
          // this.dhl.Discount = parseFloat(this.dhl.Discount).toFixed(
          //     2
          // );

          this.dhl.ComextechDiscount = this.dhl.ComextechDiscount.toFixed(2);

          this.transportDHL = this.transportDHL - this.dhl.ComextechDiscount;

          this.transportDHL = this.transportDHL.toFixed(2);
          /* Vue-loader hidden */
          loader.hide();
        }
      } catch (error) {
        console.error(error);
        this.HideAddress();
        loader.hide();
      }
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
    getAddressOrigin: function(addressData, placeResultData, id) {
      this.expenses.origin_address = placeResultData.formatted_address;

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

          case 'administrative_area_level_2': {
            this.expenses.dest_province = component.long_name;
            break;
          }

          case 'postal_code': {
            this.expenses.dest_postal_code = component.long_name;
            break;
          }
        }
      }

      this.expenses.dest_address = placeResultData.formatted_address;
    },
    async convertInsurance(currencie, currency) {
      try {
        const insuranceConvert = await axios.get(
          `/custom-convert-currency/${currencie}/${currency}`
        );

        console.log(insuranceConvert);
      } catch (error) {
        console.log(error);
      }
    }
  },
  computed: {
    ...mapState('address', [
      'expenses',
      'addressDestination',
      'portsDestination',
      'portsOrigin',
      'props'
    ]),
    ...mapState('application', ['data', 'currency', 'origin_transport'])
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

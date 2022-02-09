<template>
  <div>
    <div
      v-if="!expenses.dataLoad || expenses.dataLoad.length == 0 || formAddress"
      class="flex flex-col items-center my-2"
    >
      <!-- Direccion de origen -->
      <div class="w-11/12 lg:w-8/12 mb-4 md:px-4 lg:px-0">
        <!-- <div class="mt-2 mr-8 flex justify-start w-1/12"></div> -->
        <div>
          <span class="text-sm font-semibold">Origen</span>
          <GoogleAutocomplete />
        </div>
      </div>

      <!-- Codigo postal origen -->
      <div v-if="postalCodeOrigin" class="w-11/12 lg:w-8/12 mb-4 md:px-4 lg:px-0">
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
      </div>

      <!-- Destino de envio -->
      <div class="w-11/12 lg:w-8/12 mb-4 md:px-4 lg:px-0">
        <div>
          <span class="text-sm font-semibold">Destino</span>

          <GoogleAutocomplete :Addresses="false" />
        </div>
      </div>

      <!-- codigo postal de destino -->
      <div v-if="postalCodeDestination" class="w-11/12 lg:w-8/12 mb-4 md:px-4 lg:px-0">
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
      </div>
    </div>

    <!-- Date and description -->
    <transition name="fade">
      <FormDate v-if="$store.state.freightQuotes.addressDate" />
    </transition>

    <!-- Botones editar y cotizar -->
    <div
      v-if="buttons"
      :class="[
        !expenses.dataLoad || expenses.dataLoad.length <= 0
          ? 'flex justify-center'
          : 'flex justify-center my-5 innline w-1/7 mt-5'
      ]"
    >
      <button
        v-show="!expenses.dataLoad"
        @click="HideAddress()"
        :class="[
          expenses.dataLoad.length > 0
            ? 'mr-4 w-32 h-12 text-white transition-colors text-lg bg-blue-1000 rounded-lg focus:shadow-outline hover:bg-blue-1100 active:bg-blue-1000'
            : ''
        ]"
      >
        Editar
      </button>

      <button
        v-show="expenses.dataLoad.length > 0"
        @click="HideAddress()"
        :class="[
          expenses.dataLoad.length > 0
            ? 'mr-4 w-32 h-12 text-white transition-colors text-lg bg-blue-1000 rounded-lg focus:shadow-outline hover:bg-blue-1100 active:bg-blue-1000'
            : ''
        ]"
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
        :disabled="busy"
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
              <!-- <img
                src="../../../../public/img/fedex-logo.png"
                alt="fedex-logo"
                class="mx-auto my-2 w-4/12 sm:w-9/12"
              /> -->
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
                  bg-blue-1300
                  rounded-lg
                  focus:shadow-outline
                  hover:bg-blue-1200
                  active:bg-blue-1300
                "
              >
                Cotizar
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
              <!-- <img
                src="../../../../public/img/dhl-express.jpg"
                alt="dhl-logo"
                class="mx-auto my-2 w-4/12 sm:w-9/12"
              /> -->
            </div>
            <div class="flex flex-auto items-center justify-center">
              <button
                @click="submitQuote(dhl.ComextechTotal, 3)"
                class="
                  w-24
                  px-2
                  h-14
                  text-white
                  transition-colors
                  text-sm
                  bg-blue-1300
                  rounded-lg
                  focus:shadow-outline
                  hover:bg-blue-1200
                  active:bg-blue-1300
                "
              >
                Cotizar
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Fin Bloque cotizacion de DHL -->

    <!-- fcl table quote   -->
    <section v-if="showTable" class="md:flex md:justify-center">
      <div class="md:flex md:w-10/12 overflow-x-auto rounded-lg shadow-xs">
        <table class="table-auto md:w-full whitespace-no-wrap">
          <thead>
            <tr class="text-sm text-center font-semibold tracking-wide text-white">
              <th
                class="
                w-1/12
                px-4 
                py-3
                border-b
                dark:border-gray-700
                bg-blue-1300
                dark:text-gray-400 dark:bg-gray-800
                "
              >
                {{ this.$store.state.application.selectedCondition.name }}
              </th>
              <th
                class="
                w-4/12
                px-4 
                py-3
                border-b
                dark:border-gray-700
                bg-blue-1300
                dark:text-gray-400 dark:bg-gray-800
                "
              >
                CONCEPTO
              </th>
              <th
                class="
                w-2/12
                px-4 
                py-3
                border-b
                dark:border-gray-700
                bg-blue-1300
                dark:text-gray-400 dark:bg-gray-800
                "
              >
                TARIFA
              </th>
              <th
                class="
                w-1/12
                px-4 
                py-3
                border-b
                dark:border-gray-700
                bg-blue-1300
                dark:text-gray-400 dark:bg-gray-800
                "
              >
                MONEDA
              </th>
            </tr>
          </thead>
          <tbody class="text-center bg-white dark:bg-gray-800">
            <tr class="text-sm text-gray-700 dark:text-gray-400">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">VALOR CIF</td>
              <td class="font-semibold px-4 py-3">{{ tableQuote.transport.cif }}</td>
              <td class="px-4 py-3">USD</td>
            </tr>
            <tr class="text-sm text-gray-700 dark:text-gray-400 divide-y dark:divide-gray-700">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">TRANSPORTE INTERNACIONAL</td>
              <td
                :class="[
                  !tableQuote.transport.transport_amount
                    ? 'text-red-600 font-semibold px-4 py-3'
                    : 'font-semibold px-4 py-3'
                ]"
              >
                {{
                  tableQuote.transport.transport_amount
                    ? formatPrice(tableQuote.transport.transport_amount)
                    : 'POR COTIZAR'
                }}
              </td>
              <td class="px-4 py-3">USD</td>
            </tr>
            <tr class="text-sm text-gray-700 dark:text-gray-400 divide-y dark:divide-gray-700">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">SEGURO</td>
              <td
                :class="[
                  !tableQuote.transport.insurance
                    ? 'text-red-600 font-semibold px-4 py-3'
                    : 'font-semibold px-4 py-3'
                ]"
              >
                {{
                  tableQuote.transport.insurance
                    ? formatPrice(tableQuote.transport.insurance)
                    : 'POR COTIZAR'
                }}
              </td>
              <td class="px-4 py-3">USD</td>
            </tr>
            <tr class="text-sm text-gray-700 dark:text-gray-400 divide-y dark:divide-gray-700">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">GASTOS LOCALES</td>
              <td
                :class="[
                  !tableQuote.transport.oth_exp
                    ? 'text-red-600 font-semibold px-4 py-3'
                    : 'font-semibold px-4 py-3'
                ]"
              >
                {{
                  tableQuote.transport.oth_exp
                    ? formatPrice(tableQuote.transport.oth_exp)
                    : 'POR COTIZAR'
                }}
              </td>
              <td class="px-4 py-3">CLP</td>
            </tr>
            <!-- <tr class="text-sm text-gray-700 dark:text-gray-400 divide-y dark:divide-gray-700">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">TRANSPORTE LOCAL</td>
              <td
                :class="[
                  !tableQuote.transport.local_transp
                    ? 'text-red-600 font-semibold px-4 py-3'
                    : 'font-semibold px-4 py-3'
                ]"
              >
                {{
                  tableQuote.transport.local_transp
                    ? formatPrice(tableQuote.transport.local_transp)
                    : 'POR COTIZAR'
                }}
              </td>
              <td class="px-4 py-3">CLP</td>
            </tr> -->
          </tbody>
        </table>
      </div>
    </section>

    <!-- form  -->
    <div v-if="showForm" class="flex flex-col items-center justify-center w-full mt-10">
      <form action="" class="w-6/12 flex flex-col mb-6">
        <label for="" class="flex flex-col"
          >Nombre
          <input
            v-model="expenses.client.name"
            class="form-input"
            type="text"
            placeholder="Nombre"
          />
          <span v-if="expenses.client.name === ''" class="text-red-400">Ingrese su nombre*</span>
        </label>
        <label for="" class="flex flex-col"
          >Correo
          <input
            v-model="expenses.client.email"
            class="form-input"
            type="email"
            placeholder="Correo"
          />
          <span v-if="expenses.client.email === ''" class="text-red-400">Ingrese su correo*</span>
        </label>
        <label for="" class="flex flex-col"
          >Telefono
          <input
            v-model="expenses.client.phone_number"
            class="form-input"
            type="text"
            :maxlength="15"
            placeholder="Telefono"
          />
          <span v-if="expenses.client.phone_number === ''" class="text-red-400"
            >Ingrese su telefono*</span
          >
        </label>
      </form>
      <button
        @click="saveForm()"
        :class="[
          !expenses.dataLoad
            ? 'flex items-center justify-center vld-parent sm:w-44 h-12 px-4 text-white transition-colors text-lg bg-blue-1300 rounded-lg focus:shadow-outline hover:bg-blue-1200 active:bg-blue-1300'
            : expenses.dataLoad.length <= 0
            ? 'flex items-center justify-center vld-parent sm:w-44 h-12 px-4 text-white transition-colors text-lg bg-blue-1300 rounded-lg focus:shadow-outline hover:bg-blue-1200 active:bg-blue-1300'
            : 'flex items-center justify-center ml-4 w-32 h-12 text-white transition-colors text-lg bg-blue-1300 rounded-lg focus:shadow-outline hover:bg-blue-1200 active:bg-blue-1300'
        ]"
        :disabled="busy"
      >
        <svg
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
        </svg>
        Cotizar
      </button>
    </div>
  </div>
</template>

<script>
import FormDate from './FormDate.vue';
import GoogleAutocomplete from '../common/GoogleAutocomplete.vue';

import { mapState } from 'vuex';

export default {
  components: { GoogleAutocomplete, FormDate },
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
      showForm: false,
      showTable: false,
      tableQuote: {},
      buttons: true
    };
  },
  methods: {
    async saveForm() {
      const response = await this.expenses.post('/freight-quotes');
      this.$store.dispatch('application/busyButton', true);
      if (
        response.status == 200 &&
        (this.expenses.client.name !== '' ||
          this.expenses.client.email !== '' ||
          this.expenses.client.phone_number !== '')
      ) {
        // Toast.fire({
        //   icon: 'success',
        //   title: 'Datos Agregados'
        // });

        setTimeout(() => {
          Swal.fire({
            title: 'Comextech le enviará un correo para contactarlo',
            // text: '¿Quiere solicitar una tarifa para su operación al Equipo ComexTech?',
            icon: 'warning',
            // showCancelButton: true,
            confirmButtonColor: '#3085d6',
            // cancelButtonColor: '#d33',
            // cancelButtonText: 'Cancelar',
            confirmButtonText: 'Aceptar'
          });

          window.location.href = '/freight-quotes';
        }, 3000);
      } else {
        this.$store.dispatch('application/busyButton', false);
        Swal.fire({
          title: 'Si desea cotizar con nosotros, llene el siguente formulario',
          // text: '¿Quiere solicitar una tarifa para su operación al Equipo ComexTech?',
          icon: 'warning',
          // showCancelButton: true,
          confirmButtonColor: '#3085d6',
          // cancelButtonColor: '#d33',
          // cancelButtonText: 'Cancelar',
          confirmButtonText: 'Aceptar'
        });
      }
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
      try {
        this.expenses.dataLoad = this.$store.state.load.loads;
        this.expenses.app_amount = appAmount;
        this.expenses.trans_company_id = transCompanyId;
        const quoteTable = await this.expenses.post('/freight-quotes/calculate');

        if (quoteTable.status == 200) {
          this.tableQuote = quoteTable.data;
          this.showForm = true;
          this.showTable = true;
          this.showFedexQuote = false;
          this.showDHLQuote = false;
          this.buttons = false;
        }

        Swal.fire({
          title: 'Si desea cotizar con nosotros, llene el siguente formulario',
          // text: '¿Quiere solicitar una tarifa para su operación al Equipo ComexTech?',
          icon: 'warning',
          // showCancelButton: true,
          confirmButtonColor: '#3085d6',
          // cancelButtonColor: '#d33',
          // cancelButtonText: 'Cancelar',
          confirmButtonText: 'Aceptar'
        });

        // this.$store.dispatch('load/setLoad', data);
        // this.$store.dispatch('callIncomingOrNextMenu', true);
      } catch (error) {
        console.error(error);
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
      this.$store.dispatch('application/busyButton', true);

      /* Hide / Show loads and dimensions form */
      this.$store.dispatch('load/showLoadCharge', false);
      this.$store.dispatch('freightQuotes/showAddress', false);

      this.expenses.dataLoad = this.$store.state.load.loads;

      /* get data from fedex quote and rate api */
      const fedexApi = this.expenses
        .post('/api/get-fedex-rate')
        .then((response) => {
          return response.data;
        })
        .catch((error) => console.error(error));

      /* get data from DHL quote and rate api */
      const DhlApi = this.expenses
        .post('/api/get-dhl-quote')
        .then((response) => {
          return response.data;
        })
        .catch((error) => console.error(error));

      Promise.all([fedexApi, DhlApi])
        .then((data) => {
          this.$store.dispatch('application/busyButton', false);
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
          this.$store.dispatch('application/busyButton', false);
          console.error(error);
        });
    },

    /**
     * Show / Hide from address (button "Editar")
     */
    HideAddress() {
      this.$store.dispatch('freightQuotes/showAddress', true);

      this.fedex = {};

      this.dhl = {};

      this.$store.dispatch('load/showLoadCharge', true); /* Hide / Show loads and dimensions form */

      // this.showApisQuote = false;
      this.showFedexQuote = false;
      this.showDHLQuote = false;
      this.showForm = false;

      // /* Here the dataLoad is set to 0 to edit the view */
      // this.expenses.dataLoad = this.expenses.dataLoad.length == 0;
    },

    formatPrice(value, currency) {
      return Number(value).toLocaleString(navigator.language, {
        minimumFractionDigits: currency == 'CLP' ? 0 : 2,
        maximumFractionDigits: currency == 'CLP' ? 0 : 2
      });
    }
  },
  computed: {
    ...mapState('freightQuotes', [
      'expenses',
      'portsDestination',
      'portsOrigin',
      'addressDestination',
      'addressDate',
      'formAddress',
      'postalCodeOrigin',
      'postalCodeDestination',
      'showShipping'
    ]),
    ...mapState('application', ['data', 'busy'])
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

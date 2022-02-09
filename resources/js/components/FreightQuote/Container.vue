<template>
  <section>
    <!-- form if data.condition is EXW -->
    <section v-if="data.condition == 'EXW'">
      <transition name="fade">
        <div
          v-if="
            !expenses.dataLoad || expenses.dataLoad.length == 0 || $store.state.address.formAddress
          "
          class="flex flex-col items-center my-2"
        >
          <!-- Direccion de origen -->
          <h3 class="mb-10 text-center">Direcciones y Puertos</h3>
          <div class="w-11/12 lg:w-8/12 mb-4 md:px-4 lg:px-0">
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
            </div>
            <span
              class="text-xs text-red-600 dark:text-red-400"
              v-if="expenses.errors.has('origin_postal_code')"
              v-html="expenses.errors.get('origin_postal_code')"
            ></span>
          </div>

          <!-- Aeropuerto / Puerto origen -->
          <div class="w-11/12 lg:w-8/12 mb-4 md:px-4 lg:px-0">
            <div>
              <span class="text-sm font-semibold">Puerto Origen</span>
              <div class="flex">
                <v-select
                  class="text-sm w-full"
                  label="name"
                  v-model="expenses.origin_port_id"
                  placeholder="Puerto Origen"
                  :options="portsOrigin"
                  :reduce="(portsOrigin) => portsOrigin.id"
                >
                  <template v-slot:no-options="{ search, searching }">
                    <template v-if="searching" class="text-sm">
                      Lo sentimos no hay opciones que coincidan
                      <strong>{{ search }}</strong
                      >.
                    </template>
                    <em style="opacity: 0.5" v-else> Puertos </em>
                  </template>
                  <template v-slot:option="portsOrigin">
                    {{ portsOrigin.name }}
                  </template>
                </v-select>
              </div>
            </div>
          </div>

          <!-- Aeropuerto / Puerto destino -->
          <div class="w-11/12 lg:w-8/12 mb-4 md:px-4 lg:px-0">
            <div>
              <span class="text-sm font-semibold"> Puerto Destino</span>
              <div class="flex">
                <v-select
                  class="text-sm w-full"
                  label="name"
                  v-model="expenses.dest_port_id"
                  placeholder="Puerto Destino"
                  :options="portsDestination"
                  :reduce="(portsDestination) => portsDestination.id"
                >
                  <template v-slot:no-options="{ search, searching }">
                    <template v-if="searching" class="text-sm">
                      Lo sentimos no hay opciones que coincidan
                      <strong>{{ search }}</strong
                      >.
                    </template>
                    <em style="opacity: 0.5" v-else> Puertos </em>
                  </template>
                  <template v-slot:option="portsDestination">
                    {{ portsDestination.name }}
                  </template>
                </v-select>
              </div>

              <span
                class="text-xs text-red-600 dark:text-red-400"
                v-if="expenses.errors.has('dest_port_id')"
                v-html="expenses.errors.get('dest_port_id')"
              ></span>
            </div>
          </div>

          <!-- transporte local -->
          <div class="flex justify-center w-full py-4">
            <button
              @click="!showShipping ? SHOW_LOCAL_SHIPPING(true) : SHOW_LOCAL_SHIPPING(false)"
              class="
                lg:w-2/12
                bg-transparent
                focus:outline-none
                uppercase
                text-xs
                hover:bg-blue-1000
                text-blue-1000
                font-semibold
                hover:text-white
                py-2
                px-2
                border border-blue-1000
                hover:border-transparent
                rounded active:bg-blue-1100
              "
            >
              Transporte Local
            </button>
            <hr class="md:w-8/12 md:mt-4 md:mb-4 md:border-solid md:border-t-2" />
          </div>

          <!-- Destino de Envio -->
          <div v-if="showShipping" class="w-11/12 lg:w-8/12 mb-4 md:px-4 lg:px-0">
            <div>
              <span class="text-sm font-semibold">Destino</span>
              <GoogleAutocomplete :Addresses="false" />
            </div>
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
          </div>
        </div>
      </transition>

      <!-- Date and description -->
      <transition name="fade">
        <FormDate v-if="$store.state.address.addressDate" />
      </transition>
    </section>

    <!-- botones cotizar/editar -->
    <section
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
        @click="submitQuote()"
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
    </section>

    <!-- fcl table quote   -->
    <section v-if="fclTableQuote" class="md:flex md:justify-center">
      <div class="md:flex md:w-10/12 overflow-x-auto rounded-lg shadow-xs">
        <table v-if="data.condition == 'EXW'" class="table-auto md:w-full whitespace-no-wrap">
          <thead>
            <tr class="text-sm text-center font-semibold tracking-wide text-left text-white">
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
              <td class="px-4 py-3">TRAMO LOCAL (ORIGEN)</td>
              <td class="text-red-600 font-semibold px-4 py-3">POR COTIZAR</td>
              <td class="px-4 py-3">USD</td>
            </tr>
            <tr class="text-sm text-gray-700 dark:text-gray-400 divide-y dark:divide-gray-700">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">TRANSPORTE INTERNACIONAL</td>
              <td
                :class="[
                  !fclQuote.transport.transport_amount
                    ? 'text-red-600 font-semibold px-4 py-3'
                    : 'font-semibold px-4 py-3'
                ]"
              >
                {{
                  fclQuote.transport.transport_amount
                    ? formatPrice(fclQuote.transport.transport_amount)
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
                  !fclQuote.transport.insurance
                    ? 'text-red-600 font-semibold px-4 py-3'
                    : 'font-semibold px-4 py-3'
                ]"
              >
                {{
                  fclQuote.transport.insurance
                    ? formatPrice(fclQuote.transport.insurance)
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
                  !fclQuote.transport.oth_exp
                    ? 'text-red-600 font-semibold px-4 py-3'
                    : 'font-semibold px-4 py-3'
                ]"
              >
                {{
                  fclQuote.transport.oth_exp
                    ? formatPrice(fclQuote.transport.oth_exp)
                    : 'POR COTIZAR'
                }}
              </td>
              <td class="px-4 py-3">CLP</td>
            </tr>
            <tr class="text-sm text-gray-700 dark:text-gray-400 divide-y dark:divide-gray-700">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">TRANSPORTE LOCAL</td>
              <td
                :class="[
                  !fclQuote.transport.local_transp
                    ? 'text-red-600 font-semibold px-4 py-3'
                    : 'font-semibold px-4 py-3'
                ]"
              >
                {{
                  fclQuote.transport.local_transp
                    ? formatPrice(fclQuote.transport.local_transp)
                    : 'POR COTIZAR'
                }}
              </td>
              <td class="px-4 py-3">CLP</td>
            </tr>
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
  </section>
</template>

<script>
import FormDate from './FormDate.vue';
import GoogleAutocomplete from '../common/GoogleAutocomplete.vue';
import { mapMutations, mapState } from 'vuex';

export default {
  components: { GoogleAutocomplete, FormDate },
  data() {
    return {
      fclQuote: {},
      fclTableQuote: false
    };
  },
  methods: {
    ...mapMutations('application', ['BUSY_BUTTON']),
    ...mapMutations('freightQuotes', ['SHOW_LOCAL_SHIPPING']),

    async saveForm() {
      const response = await this.expenses.post('/freight-quotes');
      this.BUSY_BUTTON(true);
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
        this.BUSY_BUTTON(false);
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

      // this.$store.dispatch('application/busyButton', true);
      this.BUSY_BUTTON(true);
      this.$store.state.freightQuotes.showAddress = false;
      this.$store.state.load.showLoadCharge = false;

      try {
        this.expenses.dataLoad = this.$store.state.load.loads;
        this.expenses.app_amount = appAmount;
        this.expenses.trans_company_id = transCompanyId;

        const fclResponse = await this.expenses.post('/freight-quotes');

        /* Show fclTableQuote  */
        if (fclResponse.status == 200) {
          this.fclTableQuote = true;
          this.fclQuote = fclResponse.data;

          this.BUSY_BUTTON(false);
          this.showForm = true;

          /* Vue-loader hidden */
          loader.hide();
        }

        // // Message to validate if transport_amount is 0
        // if (fclResponse.data.transport.transport_amount === 0) {
        //   Swal.fire({
        //     title: '¿Quiere solicitar una tarifa para su operación al Equipo ComexTech?',
        //     // text: '¿Quiere solicitar una tarifa para su operación al Equipo ComexTech?',
        //     icon: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     cancelButtonText: 'Cancelar',
        //     confirmButtonText: 'Enviar'
        //   }).then((result) => {
        //     if (result.isConfirmed) {
        //       // Swal.fire('Deleted!', 'Your file has been deleted.', 'success');
        //       Toast.fire({
        //         icon: 'success',
        //         title: 'Datos Agregados'
        //       });
        //     }
        //   });
        // } else {
        //   Toast.fire({
        //     icon: 'success',
        //     title: 'Datos Agregados'
        //   });
        // }
        // this.$store.dispatch('load/setLoad', fclResponse.data);
        // // this.$store.dispatch('callIncomingOrNextMenu', true);
      } catch (error) {
        this.HideAddress();
        console.error(error);
      } finally {
        this.BUSY_BUTTON(false);
        loader.hide();
      }
    },

    /**
     * Show / Hide from address (button "Editar")
     */
    HideAddress() {
      this.$store.state.freightQuotes.showAddress = true;
      this.$store.state.load.showLoadCharge = true;
      this.fclTableQuote = false;
    },

    showShippingMethod() {
      this.$store.state.freightQuotes.showLocalShipping = true;
    },
    HideShippingMethod() {
      this.$store.state.freightQuotes.showLocalShipping = false;
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
      'addressDestination',
      'portsOrigin',
      'portsOriginTemp',
      'portsDestination',
      'portsDesTemp',
      'addressDate',
      'formAddress',
      'postalCodeOrigin',
      'postalCodeDestination',
      'showShipping',
      'showForm',
      'showTable',
      'buttons'
    ]),
    ...mapState('application', ['data', 'currency', 'origin_transport', 'busy'])
  }
};
</script>

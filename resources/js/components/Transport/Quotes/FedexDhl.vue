<template>
  <section class="py-8 lg:py-0">
    <div>
      <div>
        <h1 class="lg:pl-16 text-xl font-medium text-blue-1300">
          Cotización Fedex
        </h1>
      </div>
      <div class="sm:flex sm:flex-col sm:items-center mb-8">
        <div
          class="lg:w-10/12 md:9/12 py-6 my-4 focus:outline-none rounded-2xl shadow-xl flex justify-center flex-wrap"
        >
          <div class="sm:w-2/12 sm:inline-block align-top text-center text-sm px-2 mb-8">
            <div class="mb-8 text-sm font-semibold">
              <span>LLEGADA</span>
            </div>
            <span
              :class="[
                this.$store.state.address.showFedexQuote
                  ? ''
                  : 'text-black text-center text-xl font-bold'
              ]"
              >{{
                this.$store.state.address.showFedexQuote ? fedex.DeliveryTimestamp : '- - -'
              }}</span
            >
          </div>

          <div class="sm:w-2/12 sm:inline-block align-top text-center text-sm mb-8">
            <div class="mb-8 text-sm font-semibold">
              <span>SERVICIO</span>
            </div>
            <span
              :class="[
                this.$store.state.address.showFedexQuote
                  ? ''
                  : 'text-black text-center text-xl font-bold'
              ]"
              >{{ this.$store.state.address.showFedexQuote ? fedex.ServiceType : '- - -' }}</span
            >
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
                  <td class="text-left text-sm pl-4">Tarifa Transporte</td>
                  <td
                    :class="[
                      this.$store.state.address.showFedexQuote
                        ? 'text-right text-sm pr-4'
                        : 'text-black text-center text-xl font-bold'
                    ]"
                  >
                    {{ this.$store.state.address.showFedexQuote ? transportQuote : '- - -' }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left text-sm pl-4">Recargo Combustible</td>
                  <td
                    :class="[
                      this.$store.state.address.showFedexQuote
                        ? 'text-right text-sm pr-4'
                        : 'text-black text-center text-xl font-bold'
                    ]"
                  >
                    {{ this.$store.state.address.showFedexQuote ? fedex.FUEL : '- - -' }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left text-sm pl-4">Recargo alta demanda</td>
                  <td
                    :class="[
                      this.$store.state.address.showFedexQuote
                        ? 'text-right text-sm pr-4'
                        : 'text-black text-center text-xl font-bold'
                    ]"
                  >
                    {{ this.$store.state.address.showFedexQuote ? fedex.PEAK : '- - -' }}
                  </td>
                </tr>
                <!-- <tr>
                  <td class="text-left text-sm pl-4">Descuento</td>
                  <td :class="[
                        this.$store.state.address.showFedexQuote
                          ? 'text-right text-sm pr-4'
                          : 'text-black text-center text-xl font-bold'
                      ]">
                    {{ fedex.Discount }}
                  </td>
                </tr> -->
                <tr>
                  <td class="text-left text-sm pl-4">Total Estimado</td>
                  <td
                    :class="[
                      this.$store.state.address.showFedexQuote
                        ? 'text-right text-sm pr-4'
                        : 'text-black text-center text-xl font-bold'
                    ]"
                  >
                    {{ this.$store.state.address.showFedexQuote ? totalEstimed : '- - -' }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="sm:w-2/12 inline-block align-top text-center text-sm px-2">
            <div class="flex h-28 flex-col justify-evenly items-center sm:mt-8">
              <div class="">
                <img
                  src="../../../../../public/img/fedex-logo.png"
                  alt="fedex-logo"
                  class="mx-auto my-2 w-4/12 sm:w-9/12"
                />
              </div>
              <div class="">
                <button
                  @click="submitQuote(totalEstimed, 2)"
                  :class="[
                    isBusyFedex
                      ? 'flex flex-col items-center w-20 px-2 h-16 text-white transition-colors text-sm bg-blue-1300 rounded-lg focus:shadow-outline hover:bg-blue-1200 active:bg-blue-1300'
                      : this.$store.state.address.showFedexQuote
                      ? 'w-20 px-2 h-14 text-white transition-colors text-sm bg-blue-1300 rounded-lg focus:shadow-outline hover:bg-blue-1200 active:bg-blue-1300'
                      : 'w-20 px-2 h-14 text-white transition-colors text-sm bg-gray-400 rounded-lg'
                  ]"
                  :disabled="
                    isBusyFedex
                      ? isBusyFedex
                      : !this.$store.state.address.showFedexQuote
                      ? true
                      : false
                  "
                >
                  Cotizar FEDEX
                  <svg
                    v-if="isBusyFedex"
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
        <span
          class="text-base text-red-400 dark:text-red-400"
          v-if="expenses.errors.has('fedex')"
          v-html="expenses.errors.get('fedex')"
        ></span>
      </div>
    </div>

    <!-- Bloque cotizacion de DHL -->
    <div>
      <div>
        <h1 class="lg:pl-16 text-xl font-medium text-blue-1300">
          Cotización DHL
        </h1>
      </div>
      <div class="sm:flex sm:flex-col sm:items-center mb-8">
        <div
          class="lg:w-10/12 md:9/12 py-6 my-4 focus:outline-none rounded-2xl shadow-xl flex justify-center flex-wrap"
        >
          <div class="sm:w-2/12 sm:inline-block align-top text-center text-sm px-2 mb-8">
            <div class="mb-8 text-sm font-semibold">
              <span>LLEGADA</span>
            </div>
            <span
              :class="[
                this.$store.state.address.showDhlQuote
                  ? ''
                  : 'text-black text-center text-xl font-bold'
              ]"
              >{{ this.$store.state.address.showDhlQuote ? dhl.DeliveryDate : '- - -' }}</span
            >
            <!-- <span
                :class="[
                  this.$store.state.address.showDhlQuote
                    ? ''
                    : 'text-black text-center text-xl font-bold'
                ]"
                >{{ this.$store.state.address.showDhlQuote ? dhl.DeliveryTime : '- - -' }}</span
              > -->
          </div>
          <div class="sm:w-2/12 sm:inline-block align-top text-center text-sm mb-8">
            <div class="mb-8 text-sm font-semibold">
              <span>SERVICIO</span>
            </div>
            <span
              :class="[
                this.$store.state.address.showDhlQuote
                  ? ''
                  : 'text-black text-center text-xl font-bold'
              ]"
              >{{ this.$store.state.address.showDhlQuote ? dhl.ProductShortName : '- - -' }}</span
            >
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
                  <td class="text-left text-sm pl-4">Tarifa de Transporte</td>
                  <td
                    :class="[
                      this.$store.state.address.showDhlQuote
                        ? 'text-right text-sm pr-4'
                        : 'text-black text-center text-xl font-bold'
                    ]"
                  >
                    {{ this.$store.state.address.showDhlQuote ? transportDhl : '- - -' }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left text-sm pl-4">Recargo Combustible</td>
                  <td
                    :class="[
                      this.$store.state.address.showDhlQuote
                        ? 'text-right text-sm pr-4'
                        : 'text-black text-center text-xl font-bold'
                    ]"
                  >
                    {{ this.$store.state.address.showDhlQuote ? dhl['FUEL SURCHARGE'] : '- - -' }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left text-sm pl-4">Situación Emergencia</td>
                  <td
                    :class="[
                      this.$store.state.address.showDhlQuote
                        ? 'text-right text-sm pr-4'
                        : 'text-black text-center text-xl font-bold'
                    ]"
                  >
                    {{
                      this.$store.state.address.showDhlQuote ? dhl['EMERGENCY SITUATION'] : '- - -'
                    }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left text-sm pl-4">Total Estimado</td>
                  <td
                    :class="[
                      this.$store.state.address.showDhlQuote
                        ? 'text-right text-sm pr-4'
                        : 'text-black text-center text-xl font-bold'
                    ]"
                  >
                    {{ this.$store.state.address.showDhlQuote ? dhl.ComextechTotal : '- - -' }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="sm:w-2/12 inline-block align-top text-center text-sm px-2">
            <div class="flex h-28 flex-col justify-evenly items-center sm:mt-8">
              <div class="">
                <img
                  src="../../../../../public/img/dhl-express.jpg"
                  alt="dhl-logo"
                  class="mx-auto my-2 w-4/12 sm:w-9/12"
                />
              </div>
              <div class="">
                <button
                  @click="submitQuote(dhl.ComextechTotal, 3)"
                  :class="[
                    isBusyDhl
                      ? 'flex flex-col items-center w-20 px-2 h-16 text-white transition-colors text-sm bg-blue-1300 rounded-lg focus:shadow-outline hover:bg-blue-1200 active:bg-blue-1300'
                      : this.$store.state.address.showDhlQuote
                      ? 'w-20 px-2 h-14 text-white transition-colors text-sm bg-blue-1300 rounded-lg focus:shadow-outline hover:bg-blue-1200 active:bg-blue-1300'
                      : 'w-20 px-2 h-14 text-white transition-colors text-sm bg-gray-400 rounded-lg'
                  ]"
                  :disabled="
                    isBusyDhl ? isBusyDhl : !this.$store.state.address.showDhlQuote ? true : false
                  "
                >
                  Cotizar DHL
                  <svg
                    v-if="isBusyDhl"
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
        <span
          class="text-base text-red-400 dark:text-red-400"
          v-if="expenses.errors.has('dhl')"
          v-html="expenses.errors.get('dhl')"
        ></span>
      </div>
    </div>
  </section>
</template>
<script>
import { mapState } from 'vuex';
export default {
  data() {
    return {
      transportDhl: 0 /* transportation rate DHL */,
      totalEstimed: 0 /* estimated total Fedex */,
      transportQuote: 0,
      isBusyFedex: false,
      isBusyDhl: false
    };
  },
  methods: {
    /**
     * Send api quote (button Cotizar fedex, dhl, ups)
     * @param {Number} appAmount selected service amount if fedex, dhl or ups
     * @param {Number} transCompanyId number of the service that is selected:
     * @param {2} FEDEX
     * @param {3} DHL
     */
    async submitQuote(appAmount, transCompanyId) {
      try {
        if (transCompanyId === 2) this.isBusyFedex = true;
        if (transCompanyId === 3) this.isBusyDhl = true;

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
    }
  },
  computed: {
    ...mapState('address', ['expenses', 'fedex', 'dhl', 'showFedexQuote', 'showDhlQuote'])
  },
  mounted() {
    if (this.showFedexQuote) {
      this.fedex.DeliveryTimestamp = this.$luxon(this.fedex.DeliveryTimestamp);

      this.transportQuote =
        parseFloat(this.fedex.TotalBaseCharge) - parseFloat(this.fedex.Discount);

      this.transportQuote = this.transportQuote.toFixed(2);

      this.totalEstimed = this.fedex.TotalEstimed.toFixed(2);
    }
    if (this.showDhlQuote) {
      this.dhl.DeliveryDate = this.$luxon(this.dhl.DeliveryDate);
      this.transportDhl = parseFloat(this.dhl.WeightCharge) + parseFloat(this.dhl.TotalDiscount);

      // this.dhl.ComextechDiscount = this.dhl.ComextechDiscount.toFixed(2);

      this.transportDhl = parseFloat(this.transportDhl - this.dhl.ComextechDiscount);
      this.transportDhl = parseFloat(this.transportDhl).toFixed(2);
    }
  }
};
</script>

<template>
  <section class="py-8 lg:py-0">
    <!-- Fedex table quote -->
    <transition name="fade">
      <div v-if="isFedexQuote">
        <div>
          <h1 class="lg:pl-16 text-xl font-medium text-blue-1300">
            Cotización Fedex
          </h1>
        </div>
        <div class="sm:flex sm:flex-col sm:items-center mb-8">
          <div
            class="lg:w-11/12 md:9/12 py-6 my-4 focus:outline-none rounded-2xl shadow-xl flex justify-center flex-wrap"
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
                  this.$store.state.address.showFedexQuote
                    ? $luxon(fedex.DeliveryTimestamp)
                    : '- - -'
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
                    class="mx-auto my-2 w-2/12 sm:w-11/12"
                  />
                </div>
                <div class="">
                  <transition name="fade">
                    <button
                      v-if="isButtonFedex && isFedexQuote"
                      @click="selectQuote(totalEstimed, 2)"
                      :class="[
                        isBusyFedex
                          ? 'flex flex-col items-center justify-center w-24 px-2 h-15 text-white transition-colors text-sm bg-blue-1300 rounded-lg focus:shadow-outline hover:bg-blue-1200 active:bg-blue-1300'
                          : this.$store.state.address.showFedexQuote
                          ? 'w-24 px-2 h-14 text-white transition-colors text-sm bg-blue-1300 rounded-lg focus:shadow-outline hover:bg-blue-1200 active:bg-blue-1300'
                          : 'w-24 px-2 h-14 text-white transition-colors text-sm bg-gray-400 rounded-lg'
                      ]"
                    >
                      Seleccionar
                    </button>
                  </transition>
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
    </transition>

    <!-- DHL table quote -->
    <transition name="fade">
      <div v-if="isDhlQuote">
        <div>
          <h1 class="lg:pl-16 text-xl font-medium text-blue-1300">
            Cotización DHL
          </h1>
        </div>
        <div class="sm:flex sm:flex-col sm:items-center mb-8">
          <div
            class="lg:w-11/12 md:9/12 py-6 my-4 focus:outline-none rounded-2xl shadow-xl flex justify-center flex-wrap"
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
                >{{
                  this.$store.state.address.showDhlQuote ? $luxon(dhl.DeliveryDate) : '- - -'
                }}</span
              >
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
                        this.$store.state.address.showDhlQuote
                          ? dhl['EMERGENCY SITUATION']
                          : '- - -'
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
                    class="mx-auto my-2 w-3/12 sm:w-11/12"
                  />
                </div>
                <div class="">
                  <transition name="fade">
                    <button
                      v-if="isButtonDhl && showDhlQuote"
                      @click="selectQuote(dhl.ComextechTotal, 3)"
                      :class="[
                        isBusyDhl
                          ? 'flex flex-col items-center justify-center w-24 px-2 h-15 text-white transition-colors text-sm bg-blue-1300 rounded-lg focus:shadow-outline hover:bg-blue-1200 active:bg-blue-1300'
                          : this.$store.state.address.showDhlQuote
                          ? 'w-24 px-2 h-14 text-white transition-colors text-sm bg-blue-1300 rounded-lg focus:shadow-outline hover:bg-blue-1200 active:bg-blue-1300'
                          : 'w-24 px-2 h-14 text-white transition-colors text-sm bg-gray-400 rounded-lg'
                      ]"
                    >
                      Seleccionar
                    </button>
                  </transition>
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
    </transition>
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
      isButtonFedex: true,
      isButtonDhl: true,
      isFedexQuote: true,
      isDhlQuote: true,
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
    async selectQuote(appAmount, transCompanyId) {
      if (transCompanyId === 2) {
        this.isDhlQuote = false;
        this.$store.commit('address/SELECT_COURIER', transCompanyId);
        this.isButtonFedex = false;
      }
      if (transCompanyId === 3) {
        this.isFedexQuote = false;
        this.$store.commit('address/SELECT_COURIER', transCompanyId);
        this.isButtonDhl = false;
      }
      this.expenses.dataLoad = this.$store.state.load.loads;
      this.expenses.app_amount = appAmount;
      this.expenses.trans_company_id = transCompanyId;
      try {
        const { data } = await this.expenses.post('/applications/transports');
        Toast.fire({
          icon: 'success',
          title: 'Cotización seleccionada'
        });
        this.$store.dispatch('load/setLoad', data);
      } catch (error) {
        console.error(error);
      } finally {
        this.isBusyFedex = false;
        this.isBusyDhl = false;
      }
    }
  },
  computed: {
    ...mapState('address', ['expenses', 'fedex', 'dhl', 'showFedexQuote', 'showDhlQuote'])
  },
  mounted() {
    if (this.showFedexQuote) {
      this.transportQuote =
        parseFloat(this.fedex.TotalBaseCharge) - parseFloat(this.fedex.Discount);

      this.transportQuote = this.transportQuote.toFixed(2);

      this.totalEstimed = this.fedex.TotalEstimed.toFixed(2);
    }
    if (this.showDhlQuote) {
      this.transportDhl = parseFloat(this.dhl.WeightCharge) + parseFloat(this.dhl.TotalDiscount);

      // this.dhl.ComextechDiscount = this.dhl.ComextechDiscount.toFixed(2);

      this.transportDhl = parseFloat(this.transportDhl - this.dhl.ComextechDiscount);
      this.transportDhl = parseFloat(this.transportDhl).toFixed(2);
    }

    if (this.expenses.trans_company_id === 2) {
      this.isButtonFedex = false;
      this.isDhlQuote = false;
    }

    if (this.expenses.trans_company_id === 3) {
      this.isButtonDhl = false;
      this.isFedexQuote = false;
    }
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

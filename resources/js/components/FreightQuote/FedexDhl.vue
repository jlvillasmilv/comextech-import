<template>
  <section>
    <transition name="fade">
      <div class="sm:flex sm:justify-center">
        <div
          v-if="
            showFedexQuote &&
              fedex.DeliveryTimestamp &&
              fedex.ServiceType &&
              fedex.FUEL &&
              fedex.PEAK &&
              TotalEstimed
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
    </transition>

    <!-- Bloque cotizacion de DHL -->
    <transition name="fade">
      <div class="sm:flex sm:justify-center">
        <div
          v-if="
            showDhlQuote &&
              transportDHL &&
              dhl['FUEL SURCHARGE'] &&
              dhl['EMERGENCY SITUATION'] &&
              dhl.ComextechTotal
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
    </transition>
  </section>
</template>

<script>
import mixinFreight from './mixins/submitQuotes';
import { mapState } from 'vuex';
export default {
  mixins: [mixinFreight],
  data() {
    return {
      transportDHL: '' /* transportation rate DHL */,
      BaseChargeTotal: '',
      TotalEstimed: '' /* estimated total Fedex */,
      transportQuote: 0
    };
  },
  computed: {
    ...mapState('freightQuotes', ['expenses', 'fedex', 'dhl', 'showFedexQuote', 'showDhlQuote'])
  },
  mounted() {
    if (this.fedex) {
      this.fedex.DeliveryTimestamp = this.$luxon(this.fedex.DeliveryTimestamp);

      this.transportQuote =
        parseFloat(this.fedex.TotalBaseCharge) - parseFloat(this.fedex.Discount);

      this.transportQuote = this.transportQuote.toFixed(2);

      this.TotalEstimed = this.fedex.TotalEstimed.toFixed(2);
    }
    if (this.dhl) {
      this.transportDHL = parseFloat(this.dhl.WeightCharge) + parseFloat(this.dhl.TotalDiscount);

      // this.dhl.ComextechDiscount = this.dhl.ComextechDiscount.toFixed(2);

      this.transportDHL = parseFloat(this.transportDHL - this.dhl.ComextechDiscount);
      this.transportDHL = parseFloat(this.transportDHL).toFixed(2);
    }
  }
};
</script>

<style></style>

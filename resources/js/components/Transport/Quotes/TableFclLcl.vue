<template>
  <section class="md:flex md:justify-center">
    <loader />
    <div class="md:flex md:w-10/12 overflow-x-auto rounded-lg shadow-xs">
      <table class="table-auto md:w-full whitespace-no-wrap">
        <thead>
          <tr class="text-sm text-center font-semibold tracking-wide text-white">
            <th
              class="w-1/12
                px-4 
                py-3
                border-b
                dark:border-gray-700
                bg-blue-1300
                dark:text-gray-400 dark:bg-gray-800"
            >
              {{ this.$store.state.application.selectedCondition.name }}
            </th>
            <th
              class="w-4/12
                px-4 
                py-3
                border-b
                dark:border-gray-700
                bg-blue-1300
                dark:text-gray-400 dark:bg-gray-800"
            >
              CONCEPTO
            </th>
            <th
              class="w-2/12
                px-4 
                py-3
                border-b
                dark:border-gray-700
                bg-blue-1300
                dark:text-gray-400 dark:bg-gray-800"
            >
              TARIFA
            </th>
            <th
              class="w-1/12
                px-4 
                py-3
                border-b
                dark:border-gray-700
                bg-blue-1300
                dark:text-gray-400 dark:bg-gray-800"
            >
              MONEDA
            </th>
          </tr>
        </thead>
        <tbody class="text-center bg-white dark:bg-gray-800">
          <tr v-if="data.condition == 'EXW'" class="text-sm text-gray-700 dark:text-gray-400">
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
                !tableFclLcl.transport.transport_amount
                  ? 'text-red-600 font-semibold px-4 py-3'
                  : 'font-semibold px-4 py-3'
              ]"
            >
              {{
                tableFclLcl.transport.transport_amount
                  ? $options.filters.setPrice(tableFclLcl.transport.transport_amount, 'USD')
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
                !tableFclLcl.transport.insurance
                  ? 'text-red-600 font-semibold px-4 py-3'
                  : 'font-semibold px-4 py-3'
              ]"
            >
              {{
                tableFclLcl.transport.insurance
                  ? $options.filters.setPrice(tableFclLcl.transport.insurance, 'USD')
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
                !tableFclLcl.transport.oth_exp
                  ? 'text-red-600 font-semibold px-4 py-3'
                  : 'font-semibold px-4 py-3'
              ]"
            >
              {{
                tableFclLcl.transport.oth_exp
                  ? $options.filters.setPrice(tableFclLcl.transport.oth_exp, 'CLP')
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
                !tableFclLcl.transport.local_transp
                  ? 'text-red-600 font-semibold px-4 py-3'
                  : 'font-semibold px-4 py-3'
              ]"
            >
              {{
                tableFclLcl.transport.local_transp
                  ? $options.filters.setPrice(tableFclLcl.transport.local_transp, 'CLP')
                  : 'POR COTIZAR'
              }}
            </td>
            <td class="px-4 py-3">CLP</td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>
</template>

<script>
import { mapState } from 'vuex';
import Loader from '../../common/utils/Loader.vue';
export default {
  data() {
    return {};
  },
  components: { Loader },
  computed: {
    ...mapState('address', ['showLclFclQuote', 'tableFclLcl']),
    ...mapState('application', ['data'])
  }
};
</script>

<style></style>

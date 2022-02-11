<template>
  <section class="md:flex md:justify-center">
    <div class="md:flex md:w-10/12 overflow-x-auto rounded-lg shadow-xs">
      <table class="table-auto md:w-full whitespace-no-wrap">
        <thead>
          <tr class="text-sm text-center font-semibold tracking-wide text-white">
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
                w-4/12
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
                w-2/12
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
        <tbody class="text-center bg-white divide-y dark:bg-gray-800">
          <tr class="text-sm text-gray-700 dark:text-gray-400">
            <td class="px-4 py-3">VALOR CIF</td>
            <td class="font-semibold px-4 py-3">{{ table.transport.cif }}</td>
            <td class="px-4 py-3">USD</td>
          </tr>
          <tr class="text-sm text-gray-700 dark:text-gray-400">
            <td class="px-4 py-3">TRANSPORTE INTERNACIONAL</td>
            <td
              :class="[
                !table.transport.transport_amount
                  ? 'text-red-600 font-semibold px-4 py-3'
                  : 'font-semibold px-4 py-3'
              ]"
            >
              {{
                table.transport.transport_amount
                  ? formatPrice(table.transport.transport_amount)
                  : 'POR COTIZAR'
              }}
            </td>
            <td class="px-4 py-3">USD</td>
          </tr>
          <tr class="text-sm text-gray-700 dark:text-gray-400">
            <td class="px-4 py-3">SEGURO</td>
            <td
              :class="[
                !table.transport.insurance
                  ? 'text-red-600 font-semibold px-4 py-3'
                  : 'font-semibold px-4 py-3'
              ]"
            >
              {{
                table.transport.insurance ? formatPrice(table.transport.insurance) : 'POR COTIZAR'
              }}
            </td>
            <td class="px-4 py-3">USD</td>
          </tr>
          <tr class="text-sm text-gray-700 dark:text-gray-400">
            <td class="px-4 py-3">GASTOS LOCALES</td>
            <td
              :class="[
                !table.transport.oth_exp
                  ? 'text-red-600 font-semibold px-4 py-3'
                  : 'font-semibold px-4 py-3'
              ]"
            >
              {{ table.transport.oth_exp ? formatPrice(table.transport.oth_exp) : 'POR COTIZAR' }}
            </td>
            <td class="px-4 py-3">CLP</td>
          </tr>
          <!-- <tr class="text-sm text-gray-700 dark:text-gray-400 dark:divide-gray-700">
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
</template>

<script>
import { mapState, mapActions } from 'vuex';
export default {
  data() {
    return {};
  },
  methods: {
    formatPrice(value, currency) {
      return Number(value).toLocaleString(navigator.language, {
        minimumFractionDigits: currency == 'CLP' ? 0 : 2,
        maximumFractionDigits: currency == 'CLP' ? 0 : 2
      });
    }
  },
  computed: {
    ...mapState('freightQuotes', ['table'])
  }
};
</script>

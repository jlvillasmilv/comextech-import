<template>
  <section class="md:flex md:justify-center">
    <div class="md:flex md:w-10/12 overflow-x-auto rounded-lg ring-1 ring-black ring-opacity-5">
      <table class="table-auto md:w-full whitespace-nowrap">
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
                  ? $options.filters.setPrice(table.transport.transport_amount, 'USD')
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
                table.transport.insurance
                  ? $options.filters.setPrice(table.transport.insurance, 'USD')
                  : 'POR COTIZAR'
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
              {{
                table.transport.oth_exp
                  ? $options.filters.setPrice(table.transport.oth_exp, 'CLP')
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

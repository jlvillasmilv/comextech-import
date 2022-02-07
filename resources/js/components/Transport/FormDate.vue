<template>
  <div class="lg:w-11/12 flex flex-col flex-wrap">
    <div class="lg:justify-end lg:flex mb-2 mr-4">
      <!-- Fecha -->
      <div class="lg:w-3/12 flex justify-center mb-6">
        <div class="w-11/12 md:w-10/12">
          <span class="text-sm text-gray-700 dark:text-gray-400 font-semibold">
            Fecha de envío
          </span>
          <label class="flex">
            <input
              type="date"
              v-model="expenses.estimated_date"
              class="w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input pac-target-input"
              placeholder="Fecha de envío"
              :min="minDate"
            />
          </label>
          <span
            class="text-xs text-red-600 dark:text-red-400"
            v-if="expenses.errors.has('estimated_date')"
            v-html="expenses.errors.get('estimated_date')"
          ></span>
        </div>
      </div>
      <!-- Descripcion -->
      <div class="lg:w-4/12 flex justify-center mb-6">
        <div class="w-11/12 md:w-10/12">
          <span class="text-sm text-gray-700 dark:text-gray-400 font-semibold">
            Descripcion
          </span>
          <label class="flex">
            <input
              v-model="expenses.description"
              maxlength="250"
              class="w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input pac-target-input"
              placeholder="Descripcion del cargamento"
            />
          </label>
          <span
            class="text-xs text-red-600 dark:text-red-400"
            v-if="expenses.errors.has('description')"
            v-html="expenses.errors.get('description')"
          >
          </span>
        </div>
      </div>
      <!-- Seguro -->
      <div class="lg:w-3/12 flex justify-center mt-6">
        <div class="w-11/12 md:w-10/12">
          <label class="w-44 sm:flex text-gray-500 dark:text-gray-400">
            <input
              type="checkbox"
              class="sm:mt-1 form-checkbox h-4 w-4 text-gray-800"
              v-model="expenses.insurance"
              @click="convertInsurance(data.amount, currency.code)"
            />
            <span v-if="data.type_transport == 'COURIER'" class="ml-2 text-gray-700">
              Seguro (1,5%)
            </span>
            <span v-else class="ml-2 text-gray-700">Seguro (0,35%)</span>
          </label>
          <div class="w-44 flex flex-col justify-center px-3 md:mb-0">
            <span class="ml-2 text-gray-700">
              {{ expenses.insurance ? `${formatPrice(data.amount)} USD` : '' }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';
export default {
  data() {
    return {};
  },
  methods: {
    formatPrice(value, currency) {
      //   this.$store.dispatch('address/getFormatPrice', { value, currency });
      return Number(value).toLocaleString(navigator.language, {
        minimumFractionDigits: currency == 'CLP' ? 0 : 2,
        maximumFractionDigits: currency == 'CLP' ? 0 : 2
      });
    },
    async convertInsurance(currencie, currency) {
      try {
        const insuranceConvert = await axios.get(
          `/custom-convert-currency/${currencie}/${currency}`
        );
        console.log(insuranceConvert);
      } catch (error) {
        console.error(error);
      }
    }
  },
  computed: {
    ...mapState('address', ['expenses', 'minDate']),
    ...mapState('application', ['data', 'currency'])
  }
};
</script>

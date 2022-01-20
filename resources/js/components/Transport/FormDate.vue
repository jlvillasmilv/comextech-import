<template>
  <div>
    <div class="ml-6 flex flex-wrap justify-center -mx-3 mb-6">
      <div class="w-1/4 px-3 mb-6 md:mb-0">
        <label class="block text-sm">
          <span class="text-gray-700 dark:text-gray-400 font-semibold">
            Fecha de envío
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
      <div class="w-1/4 px-2">
        <label class="block text-sm">
          <span class="text-gray-700 dark:text-gray-400 font-semibold">
            Descripcion
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
            placeholder="Descripcion del cargamento"
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
          <span v-if="data.type_transport == 'COURIER'" class="ml-2 text-gray-700">
            Seguro (1,5%)
          </span>
          <span v-else class="ml-2 text-gray-700">Seguro (0,35%)</span>
        </label>
      </div>
      <div class="w-1/6 mt-8">
        <span v-show="expenses.insurance" class="ml-2 text-gray-700">
          {{ formatPrice(data.amount) }} USD
        </span>
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

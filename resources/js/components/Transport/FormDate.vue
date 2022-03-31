<template>
  <div class="lg:w-11/12 flex flex-col">
    <div class="lg:justify-end lg:flex mb-2 lg:mr-16 flex-wrap">
      <!-- Fecha -->
      <div class="lg:w-5/12 flex justify-center mb-6">
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
      <div class="lg:w-5/12 flex justify-center mb-6">
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
      <div class="lg:w-11/12 flex justify-center mt-4">
        <div class="w-11/12 md:w-10/12 lg:ml-14 h-12">
          <label class="w-44 sm:flex text-gray-500 dark:text-gray-400">
            <input
              type="checkbox"
              class="sm:mt-1 form-checkbox h-4 w-4 text-gray-800"
              v-model="expenses.insurance"
              @click="convertInsurance(data.amount, currency.code)"
            />
            <span class="ml-2 text-gray-700">
              {{ data.type_transport == 'COURIER' ? 'Seguro (1,5%)' : 'Seguro (0.35%)' }}
            </span>
          </label>
          <div class="w-44 flex flex-col justify-center px-3 md:mb-0">
            <span class="ml-2 text-gray-700">
              <!-- {{ expenses.insurance ? $options.filters.setPrice(data.amount, 'USD') : '' }} -->
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
    async convertInsurance(currencie, currency) {
      try {
        const insuranceConvert = await axios.get(
          `/custom-convert-currency/${currencie}/${currency}`
        );
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

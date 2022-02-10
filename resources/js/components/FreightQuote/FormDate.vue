<template>
  <div class="lg:w-11/12 flex flex-col flex-wrap">
    <div class="lg:w-8/12 flex justify-center md:px-4 mb-6 md:mb-0">
      <!-- <div class="mt-2 mr-8 flex justify-start w-1/12"></div> -->
      <div class="w-11/12 lg:w-1/2">
        <span class="text-sm font-semibold">Valor del cargamento</span>
        <input
          v-model.number="expenses.cargo_value"
          type="text"
          :min="0"
          :max="99999999"
          class="w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input pac-target-input"
          placeholder="Valor de la carga USD"
        />
        <label class="w-44 sm:flex text-gray-500 dark:text-gray-400 mt-2">
          <input
            type="checkbox"
            class="sm:mt-1 form-checkbox h-4 w-4 text-gray-800"
            v-model="expenses.insurance"
          />
          <span v-if="data.type_transport == 'COURIER'" class="ml-2 text-gray-700">
            Seguro (1,5%)
          </span>
          <span v-else class="ml-2 text-gray-700">Seguro (0,35%)</span>
        </label>
      </div>
    </div>

    <div class="lg:justify-end lg:flex mb-2">
      <!-- Fecha -->
      <div class="lg:w-4/12 flex justify-center lg:justify-start mb-6 md:px-4 lg:px-0">
        <div class="w-11/12">
          <span class="text-sm text-gray-700 dark:text-gray-400 font-semibold">
            Fecha de envío
          </span>
          <input
            type="date"
            v-model="expenses.estimated_date"
            class="w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input pac-target-input"
            placeholder="Fecha de envío"
            :min="minDate"
          />
          <!-- <label class="flex">
          </label> -->
          <span
            class="text-xs text-red-600 dark:text-red-400"
            v-if="expenses.errors.has('estimated_date')"
            v-html="expenses.errors.get('estimated_date')"
          ></span>
        </div>
      </div>
      <!-- Descripcion -->
      <div class="lg:w-6/12 flex justify-center lg:justify-start mb-6 md:px-4">
        <div class="w-11/12 lg:w-8/12">
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
      <!-- <div class="lg:w-2/12 flex flex-col justify-center px-3 md:mb-0">
        <label class="sm:w-44 sm:flex sm:ml-6 text-gray-500 dark:text-gray-400">
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
      </div>
      <div class="lg:w-2/12 flex flex-col justify-center px-3 md:mb-0">
        <span class="ml-2 text-gray-700">
          {{ expenses.insurance ? `${formatPrice(data.amount)} USD` : '' }}
        </span>
      </div> -->
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
    ...mapState('freightQuotes', ['expenses', 'minDate']),
    ...mapState('application', ['data', 'currency'])
  }
};
</script>

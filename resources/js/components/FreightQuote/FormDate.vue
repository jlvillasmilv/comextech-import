<template>
  <div class="lg:w-11/12 flex flex-col flex-wrap">
    <div class="lg:w-8/12 flex justify-center md:px-4 mb-6 md:mb-0">
      <div class="w-11/12 lg:w-1/2">
        <span class="text-sm font-semibold">Valor del cargamento</span>
        <input
          v-model.number="expenses.cargo_value"
          type="text"
          class="w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input pac-target-input"
          placeholder="Valor de la carga USD"
        />
        <label class="w-44 sm:flex text-gray-500 dark:text-gray-400 mt-2">
          <input
            type="checkbox"
            class="sm:mt-1 form-checkbox h-4 w-4 text-gray-800"
            v-model="expenses.insurance"
          />
          <span class="ml-2 text-gray-700">
            {{ expenses.type_transport == 'COURIER' ? 'Seguro (1,5%)' : 'Seguro (0,35%)' }}
          </span>
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
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';
export default {
  data() {
    return {};
  },
  computed: {
    ...mapState('freightQuotes', ['expenses', 'minDate'])
  }
};
</script>

<template>
  <div class="mx-3 px-4 py-3 mb-8 bg-white rounded-lg dark:bg-gray-800">
    <h3 class="my-2 font-semibold text-gray-700 dark:text-gray-200">Destino</h3>
    <div class="flex flex-wrap -mx-3">
      <div class="px-3 md:mb-0 ">
        <span class="text-gray-700 dark:text-gray-400 my-2 text-sm"> Ubicacion de Destino </span>
        <select
          v-model="form.warehouse_id"
          class="
              block
              w-full
              md:w-2/4
              border border-gray-150
              dark:border-gray-600
              text-gray-700
              p-2
              pr-8
              rounded
              leading-tight
              focus:outline-none focus:bg-white focus:border-gray-500
              dark:text-gray-300
              dark:border-gray-600
              dark:bg-gray-700
              dark:focus:shadow-outline-gray
              form-select
            "
        >
          <option v-for="item in warehouses" :value="item.id" :key="item.name">
            {{ item.address }}
          </option>
        </select>

        <span
          class="text-xs text-red-600 dark:text-red-400"
          v-if="form.errors.has('warehouse_id')"
          v-html="form.errors.get('warehouse_id')"
        ></span>
      </div>
    </div>
    <div class="flex mt-6">
      <label class="flex items-center">
        <input type="checkbox" class="form-checkbox" v-model="form.peoneta_service" />
        <span class="ml-2"> Servicio de Peonetas (4 Personas) </span>
      </label>
    </div>
    <div class="flex mt-6">
      <label class="flex items-center">
        <input type="checkbox" class="form-checkbox" v-model="form.forklift_service" />
        <span class="ml-2"> Servicio Grua Horquilla </span>
      </label>
    </div>
    <div class="flex space-x-2 px-3 mb-6 md:mb-0 mt-5">
      <button
        class="
            flex 
            justify-center 
            items-center
            w-44 
            h-12 
            px-4
            text-lg
            leading-5
            text-white
            transition-colors
            duration-150
            bg-blue-1300
            border border-transparent
            rounded-lg
            active:bg-blue-1300
            hover:bg-blue-1200
            focus:outline-none focus:shadow-outline-blue
          "
        :disabled="busy"
        @click="submitForm()"
      >
        <svg
          v-if="!busy"
          xmlns="http://www.w3.org/2000/svg"
          class="mx-2 h-6 w-6"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2h2m3-4H9a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-1m-1 4l-3 3m0 0l-3-3m3 3V3"
          />
        </svg>
        <svg
          v-if="busy"
          class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
        >
          <circle
            class="opacity-25"
            cx="12"
            cy="12"
            r="10"
            stroke="currentColor"
            stroke-width="4"
          ></circle>
          <path
            class="opacity-75"
            fill="currentColor"
            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
          ></path>
        </svg>
        <span> Guardar </span>
      </button>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
  computed: {
    ...mapState('internalStorage', ['form']),
    ...mapState('application', ['data', 'busy'])
  },
  props: {
    application_id: {
      type: Number,
      required: false
    }
  },
  data() {
    return {
      // data: [],
      percentajeDelete: {},
      warehouses: [],
      agencyTransport: []
    };
  },
  methods: {
    async submitForm() {
      try {
        this.$store.dispatch('application/busyButton', true);
        const response = await this.form.post('/local-warehouse');
        Toast.fire({
          icon: 'success',
          title: 'Datos Agregados'
        });
        this.form.id = response.data;
        this.$store.dispatch('exchange/getSummary', this.data.application_id);
        this.$store.dispatch('callIncomingOrNextMenu', true);
      } catch (error) {
        console.error(error);
        Toast.fire({
          icon: 'error',
          title: 'Se ha producido un error al procesar los datos'
        });
      } finally {
        this.$store.dispatch('application/busyButton', false);
      }
    }
  },
  async created() {
    try {
      let warehouses = await axios.get('/api/warehouses');
      let agencyTransport = await axios.get('/api/trans_companies');
      this.warehouses = warehouses.data;
      this.agencyTransport = agencyTransport.data;
      this.form.application_id = this.data.application_id;
    } catch (error) {
      console.log(error);
    }
  }
};
</script>

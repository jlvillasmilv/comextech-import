<template>
  <div class="container grid px-6 my-1">

    <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <Load v-if="$store.state.load.showLoad" />
    </div>
    
    <!-- Notification validation error -->
    <span
      class="text-xs text-red-600 dark:text-red-400"
      v-if="expenses.errors.has('dataLoad.0.length')"
      v-html="expenses.errors.get('dataLoad.0.length')"
    ></span>
    <span
      class="text-xs text-red-600 dark:text-red-400"
      v-if="expenses.errors.has('dataLoad.0.width')"
      v-html="expenses.errors.get('dataLoad.0.width')"
    ></span>
    <span
      class="text-xs text-red-600 dark:text-red-400"
      v-if="expenses.errors.has('dataLoad.0.height')"
      v-html="expenses.errors.get('dataLoad.0.height')"
    ></span>
    <span
      class="text-xs text-red-600 dark:text-red-400"
      v-if="expenses.errors.has('dataLoad.0.weight')"
      v-html="expenses.errors.get('dataLoad.0.weight')"
    ></span>
    <span
      class="text-xs text-red-600 dark:text-red-400"
      v-if="expenses.errors.has('fedex')"
      v-html="expenses.errors.get('fedex')"
    ></span>
    <span
      class="text-xs text-red-600 dark:text-red-400"
      v-if="expenses.errors.has('dhl')"
      v-html="expenses.errors.get('dhl')"
    ></span>
    <div v-show="isActivateAddress">
      <!-- Cotizacion courier -->
      <div v-if="data.type_transport == 'COURIER'">
        <Courier />
      </div>
      <!-- Cotizacion Aereo -->
      <div v-if="data.type_transport == 'AEREO'">
        <Aereo />
      </div>
      <!-- Cotizacion container -->
      <div v-if="data.type_transport == 'CONTAINER'">
        <FCL />
      </div>
      <!-- Cotizacion consolidado -->
      <div v-if="data.type_transport == 'CONSOLIDADO'">
        <LCL />
      </div>
      <!-- Cotizacion terrestre -->
      <div v-if="data.type_transport == 'TERRESTRE'">
        <Terrestre />
      </div>
    </div>
  </div>
</template>

<script>
import VueGoogleAutocomplete from 'vue-google-autocomplete';
import Load from './Load.vue';
import Courier from './Courier.vue';
import Aereo from './Aereo.vue';
import FCL from './Container.vue';
import LCL from './Consolidado.vue';
import Terrestre from './Terrestre.vue';
import { mapState } from 'vuex';
import Button from '../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Button.vue';
import Container from '../Container.vue';

export default {
  components: {
    Load,
    Courier,
    Aereo,
    FCL,
    LCL,
    Terrestre,
    VueGoogleAutocomplete,
    Button
  },
  props: {
    Container
  },
  data() {
    return {
      address: ''
    };
  },
  methods: {},
  computed: {
    ...mapState('address', ['expenses', 'addressDestination', 'portsDestination', 'portsOrigin']),
    ...mapState('application', ['data', 'currency', 'origin_transport']),
    addreses() {
      if (this.data.condiction == 'FOB') {
        return this.addressDestination.filter((item) => item.place == 'PUERTO');
      } else {
        return this.addressDestination.filter((item) => item.place !== 'PUERTO');
      }
    },
    isActivateAddress() {
      const { loads } = this.$store.state.load;

      /* Condicionales para mostrar el formulario de addresses dependiendo de la validacion del peso */
      if (loads.length && this.data.type_transport == 'COURIER') {
        if (loads[loads.length - 1].weight_units == 'KG' && loads[loads.length - 1].weight < 0.01)
          return false;
        if (
          loads[loads.length - 1].weight_units == 'KG' &&
          loads[loads.length - 1].weight >= 0.01 &&
          loads[loads.length - 1].weight <= 2268
        )
          return true;
        if (loads[loads.length - 1].weight_units == 'LB' && loads[loads.length - 1].weight < 0.02)
          return false;
        if (
          loads[loads.length - 1].weight_units == 'LB' &&
          loads[loads.length - 1].weight >= 0.02 &&
          loads[loads.length - 1].weight <= 5000
        )
          return true;
        else false;
      }

      if (
        loads.length &&
        (this.data.type_transport == 'AEREO' ||
          this.data.type_transport == 'CONTAINER' ||
          this.data.type_transport == 'CONSOLIDADO')
      ) {
        if (loads[loads.length - 1].weight_units == 'KG' && loads[loads.length - 1].weight < 0.01)
          return false;
        if (
          loads[loads.length - 1].weight_units == 'KG' &&
          loads[loads.length - 1].weight >= 0.01 &&
          loads[loads.length - 1].weight <= 24000
        )
          return true;
        if (loads[loads.length - 1].weight_units == 'LB' && loads[loads.length - 1].weight < 0.02)
          return false;
        if (
          loads[loads.length - 1].weight_units == 'LB' &&
          loads[loads.length - 1].weight >= 0.02 &&
          loads[loads.length - 1].weight <= 52910
        )
          return true;
        else false;
      }
      return false;
    }
  },
  async created() {
    this.expenses.application_id = this.data.application_id;

    const type = this.data.type_transport == 'AEREO' ? 'A' : 'P';
    await this.$store.dispatch(
      'address/setModeSelected',
      this.$store.state.application.data.type_transport
    );
    await this.$store.dispatch('address/getAddressDestination');
    await this.$store.dispatch('address/getPorts', type);
  }
};
</script>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.7s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>

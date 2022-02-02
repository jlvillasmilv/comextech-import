<template>
  <div class="w-full md:flex md:flex-col md:items-center px-1 md:px-6 my-1">
    <div
      v-if="$store.state.load.showLoad"
      class="md:w-8/12 p-4 bg-white rounded-lg shadow-md dark:bg-gray-800"
    >
      <Load />
    </div>
    <div class="w-8/12 mt-6 pt-2 pb-4 rounded-lg shadow-md" v-show="isActivateAddress">
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

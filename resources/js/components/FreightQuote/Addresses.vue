<template>
  <div class="w-full md:flex md:flex-col md:items-center px-1 md:px-6 my-1">
    <div
      v-if="$store.state.load.showLoad"
      class="lg:w-9/12 p-4 bg-white rounded-lg shadow-md dark:bg-gray-800"
    >
      <Load />
    </div>
    <div class="md:w-9/12 lg:w-9/12 mt-6 p-4 rounded-lg shadow-md" v-show="isActivateAddress">
      <!-- Cotizacion courier -->
      <div v-if="expenses.type_transport == 'COURIER'">
        <Courier />
      </div>
      <!-- Cotizacion container -->
      <div v-if="expenses.type_transport == 'CONTAINER'">
        <FCL />
      </div>
      <!-- Cotizacion consolidado -->
      <div v-if="expenses.type_transport == 'CONSOLIDADO'">
        <LCL />
      </div>
    </div>
  </div>
</template>

<script>
import Load from './Load.vue';
import Courier from './Courier.vue';
import FCL from './Container.vue';
import LCL from './Consolidado.vue';
import { mapState } from 'vuex';

export default {
  props: ['ipInfo'],
  components: {
    Load,
    Courier,
    FCL,
    LCL
  },
  data() {
    return {
      address: ''
    };
  },
  computed: {
    ...mapState('freightQuotes', [
      'expenses',
      'addressDestination',
      'portsDestination',
      'portsOrigin'
    ]),
    // ...mapState('application', ['data', 'currency', 'origin_transport']),
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
      if (loads.length && this.expenses.type_transport == 'COURIER') {
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
        (this.expenses.type_transport == 'AEREO' ||
          this.expenses.type_transport == 'CONTAINER' ||
          this.expenses.type_transport == 'CONSOLIDADO')
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
    const type = this.expenses.type_transport == 'AEREO' ? 'A' : 'P';

    await this.$store.dispatch('freightQuotes/getPorts', type);

    const request = await fetch(`https://ipinfo.io/json?token=${this.ipInfo}`);

    const json = await request.json();

    if (json.country) {
      this.expenses.client.ip = json.ip;
      this.expenses.client.region = json.region;
      this.expenses.client.country = json.country;
    }
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

<template>
  <div class="w-full md:flex md:flex-col md:items-center px-1 md:px-6 my-1">
    <transition name="fade">
      <div
        v-if="$store.state.load.showLoad"
        class="lg:w-9/12 p-4 bg-white rounded-lg shadow-md dark:bg-gray-800"
      >
        <load />
      </div>
    </transition>
    <transition name="fade">
      <div
        class="lg:w-9/12 md:w-full mt-6 p-4 bg-white rounded-lg shadow-md"
        v-if="isActivateAddress"
      >
        <addresses />
      </div>
    </transition>
  </div>
</template>

<script>
import Load from './Load.vue';
import Addresses from './Addresses.vue';
import { mapState } from 'vuex';
import Container from '../Container.vue';

export default {
  components: {
    Load,
    Addresses
  },
  props: {
    Container
  },
  data() {
    return {
      address: ''
    };
  },
  computed: {
    ...mapState('address', ['expenses', 'addressDestination', 'portsDestination', 'portsOrigin']),
    ...mapState('application', ['data', 'currency', 'origin_transport']),
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

      if (loads.length && this.data.type_transport !== 'COURIER') {
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

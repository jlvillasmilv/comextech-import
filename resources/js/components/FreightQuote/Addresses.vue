<template>
  <div class="container px-1 md:px-6 my-1">
    <div class="p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
      <Load />
    </div>
    <div>
      <!-- Cotizacion courier -->
      <div v-if="type_transport == 'COURIER'">
        <Courier />
      </div>
      
      <!-- Cotizacion container -->
      <div v-if="type_transport == 'CONTAINER'">
        <FCL />
      </div>
      <!-- Cotizacion consolidado -->
      <div v-if="type_transport == 'CONSOLIDADO'">
        <LCL />
      </div>
     
    </div>
  </div>
</template>

<script>
import VueGoogleAutocomplete from 'vue-google-autocomplete';
import Load from './Load';
import Courier from './Courier';
import FCL from './Container';
import LCL from './Consolidado';
import Container from '../Container.vue';

export default {
  components: {
    Load,
    Courier,
    FCL,
    LCL,
    VueGoogleAutocomplete,
  },
  props: {
    Container
  },
  data() {
    return {
      address: '',
      type_transport: 'CONTAINER'
    };
  },
  methods: {},
  computed: {
    // ...mapState('address', ['expenses', 'addressDestination', 'portsDestination', 'portsOrigin']),
    // ...mapState('application', ['data', 'currency', 'origin_transport']),
    
    // isActivateAddress() {
    //   const { loads } = this.$store.state.load;

    //   /* Condicionales para mostrar el formulario de addresses dependiendo de la validacion del peso */
    //   if (loads.length && this.data.type_transport == 'COURIER') {
    //     if (loads[loads.length - 1].weight_units == 'KG' && loads[loads.length - 1].weight < 0.01)
    //       return false;
    //     if (
    //       loads[loads.length - 1].weight_units == 'KG' &&
    //       loads[loads.length - 1].weight >= 0.01 &&
    //       loads[loads.length - 1].weight <= 2268
    //     )
    //       return true;
    //     if (loads[loads.length - 1].weight_units == 'LB' && loads[loads.length - 1].weight < 0.02)
    //       return false;
    //     if (
    //       loads[loads.length - 1].weight_units == 'LB' &&
    //       loads[loads.length - 1].weight >= 0.02 &&
    //       loads[loads.length - 1].weight <= 5000
    //     )
    //       return true;
    //     else false;
    //   }

    //   if (
    //     loads.length &&
    //     (this.data.type_transport == 'AEREO' ||
    //       this.data.type_transport == 'CONTAINER' ||
    //       this.data.type_transport == 'CONSOLIDADO')
    //   ) {
    //     if (loads[loads.length - 1].weight_units == 'KG' && loads[loads.length - 1].weight < 0.01)
    //       return false;
    //     if (
    //       loads[loads.length - 1].weight_units == 'KG' &&
    //       loads[loads.length - 1].weight >= 0.01 &&
    //       loads[loads.length - 1].weight <= 24000
    //     )
    //       return true;
    //     if (loads[loads.length - 1].weight_units == 'LB' && loads[loads.length - 1].weight < 0.02)
    //       return false;
    //     if (
    //       loads[loads.length - 1].weight_units == 'LB' &&
    //       loads[loads.length - 1].weight >= 0.02 &&
    //       loads[loads.length - 1].weight <= 52910
    //     )
    //       return true;
    //     else false;
    //   }
    //   return false;
    // }
  },
  async created() {
   
    const type = this.type_transport == 'AEREO' ? 'A' : 'P';

    // await this.$store.dispatch('address/getAddressDestination');
    // await this.$store.dispatch('address/getPorts', type);
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

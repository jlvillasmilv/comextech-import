<template>
  <div class="container grid px-6 my-1">
    <transition name="fade">
      <Load v-if="$store.state.load.showLoad" />
    </transition>
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
    Container,
    originTransport: {
      type: Array,
      required: false
    }
  },
  data() {
    return {
      address: '',
      minDate: new Date().toISOString().substr(0, 10),
      showShipping: false
    };
  },
  methods: {
    /**
     * Send api quote (button Cotizar fedex, dhl, ups)
     * @param {Number} appAmount selected service amount if fedex, dhl or ups
     * @param {Number} transCompanyId number of the service that is selected:
     * @param {2} FEDEX
     * @param {3} DHL
     * @param {4} UPS
     */
    async submitQuote(appAmount, transCompanyId) {
      try {
        this.expenses.dataLoad = this.$store.state.load.loads;
        this.expenses.app_amount = appAmount;
        this.expenses.trans_company_id = transCompanyId;
        const { data } = await this.expenses.post('/applications/transports');
        Toast.fire({
          icon: 'success',
          title: 'Datos Agregados'
        });

        this.$store.dispatch('exchange/getSummary', this.data.application_id);
        this.$store.dispatch('load/setLoad', data);
        this.$store.dispatch('callIncomingOrNextMenu', true);
      } catch (error) {
        console.error(error);
      }
    },
    /**
     * When the location found
     * @param {Object} addressData Data of the found location
     * @param {Object} placeResultData PlaceResult object
     * @param {String} id Input container ID
     */
    getAddressOrigin: function(addressData, placeResultData, id) {
      this.expenses.origin_address = placeResultData.formatted_address;

      for (const component of placeResultData.address_components) {
        const componentType = component.types[0];

        switch (componentType) {
          case 'country':
            this.expenses.origin_ctry_code = component.short_name;
            break;

          case 'locality':
            this.expenses.origin_locality = component.long_name;
            break;

          case 'postal_code': {
            this.expenses.origin_postal_code = component.long_name;
            break;
          }
        }
      }
    },
    getAddressDestination: function(addressData, placeResultData, id) {
      for (const component of placeResultData.address_components) {
        const componentType = component.types[0];

        switch (componentType) {
          case 'country':
            this.expenses.dest_ctry_code = component.short_name;
            break;

          case 'locality':
            this.expenses.dest_locality = component.long_name;
            break;

          case 'administrative_area_level_2': {
            this.expenses.dest_province = component.long_name;
            break;
          }

          case 'postal_code': {
            this.expenses.dest_postal_code = component.long_name;
            break;
          }
        }
      }

      this.expenses.dest_address = placeResultData.formatted_address;
    },

    getFavOriginPort: async function() {
      this.expenses.origin_port_id = '';
      if (this.expenses.fav_origin_port && this.data.supplier_id) {
        let idsupplier = this.data.supplier_id;
        const type = this.data.type_transport == 'AEREO' ? 'A' : 'P';
        await this.$store.dispatch('address/getFavOriginPort', {
          idsupplier,
          type
        });
      } else {
        await this.$store.dispatch('address/setOrigFavOritPorts');
      }
    },
    getFavDestPort: async function() {
      this.expenses.dest_port_id = '';
      const type = this.data.type_transport == 'AEREO' ? 'A' : 'P';
      if (this.expenses.fav_dest_port) {
        await this.$store.dispatch('address/getFavDestPorts', type);
      } else {
        await this.$store.dispatch('address/setOrigFavDestPorts');
      }
    },
    showShippingMethod() {
      this.showShipping = !this.showShipping;
    }
  },
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

      if (loads.length) {
        if (this.data.type_transport == 'CONTAINER') {
          if (loads[loads.length - 1].weight > 0) {
            return true;
          }
          return false;
        }
      }

      /* Condicionales para mostrar el formulario de addresses dependiendo de la validacion del peso */
      if (loads.length) {
        if (loads[loads.length - 1].weight_units == 'KG' && loads[loads.length - 1].weight < 2)
          return false;
        if (
          loads[loads.length - 1].weight_units == 'KG' &&
          loads[loads.length - 1].weight >= 2 &&
          loads[loads.length - 1].weight <= 2268
        )
          return true;
        if (loads[loads.length - 1].weight_units == 'LB' && loads[loads.length - 1].weight < 4.4)
          return false;
        if (
          loads[loads.length - 1].weight_units == 'LB' &&
          loads[loads.length - 1].weight >= 4.4 &&
          loads[loads.length - 1].weight <= 5000
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

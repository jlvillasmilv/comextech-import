<template>
  <div class="flex" v-if="Addresses">
    <vue-google-autocomplete
      v-model="expenses.origin_address"
      id="addressOrigin"
      classname="w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input pac-target-input"
      v-on:placechanged="getAddressOrigin"
      placeholder="Direccion de origen"
    />
    <span
      class="text-xs text-red-600 dark:text-red-400"
      v-if="expenses.errors.has('origin_address')"
      v-html="expenses.errors.get('origin_address')"
    ></span>
  </div>
  <div class="flex" v-else>
    <vue-google-autocomplete
      v-model="expenses.dest_address"
      id="addressDestination"
      classname="w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input pac-target-input"
      v-on:placechanged="getAddressDestination"
      placeholder="Direccion Destino"
    />
    <span
      class="text-xs text-red-600 dark:text-red-400"
      v-if="expenses.errors.has('dest_address')"
      v-html="expenses.errors.get('dest_address')"
    ></span>
  </div>
</template>

<script>
import VueGoogleAutocomplete from 'vue-google-autocomplete';
import { mapState } from 'vuex';

export default {
  components: { VueGoogleAutocomplete },
  props: {
    Addresses: {
      type: Boolean,
      default: true,
      required: false
    },
    Transport: {
      type: Boolean,
      default: true,
      required: false
    }
  },
  methods: {
    getAddressOrigin: function(addressData, placeResultData, id) {
      this.expenses.origin_address = placeResultData.formatted_address;
      this.expenses.origin_latitude = addressData.latitude;
      this.expenses.origin_longitude = addressData.longitude;

      for (const component of placeResultData.address_components) {
        const componentType = component.types[0];
        switch (componentType) {
          case 'country':
            this.expenses.origin_ctry_code = component.short_name;
            break;
          case 'postal_code': {
            this.expenses.origin_postal_code = component.long_name;
            break;
          }

          case 'locality': {
            this.expenses.origin_locality = component.long_name;
            break;
          }
        }

      }
      
      // this.postalCodeOrigin = !this.expenses.origin_postal_code ? true : false;
    },
    getAddressDestination: function(addressData, placeResultData, id) {
      this.expenses.dest_address = placeResultData.formatted_address;
      this.expenses.dest_latitude = addressData.latitude;
      this.expenses.dest_longitude = addressData.longitude;

      for (const component of placeResultData.address_components) {
        const componentType = component.types[0];

        switch (componentType) {
          case 'country': {
            this.expenses.dest_ctry_code = component.short_name;
            break;
          }

          case 'locality': {
            this.expenses.dest_locality = component.long_name;
            break;
          }

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

      // this.postalCodeDestination = !this.expenses.dest_postal_code ? true : false;
    }
  },
  computed: {
    ...mapState('freightQuotes', ['expenses', 'postalCodeOrigin', 'postalCodeDestination'])
  }
};
</script>

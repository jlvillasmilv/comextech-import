<template>
  <div v-if="Addresses">
    <vue-google-autocomplete
      v-model="expenses.origin_address"
      id="addressOrigin"
      classname="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
      v-on:placechanged="getAddressOrigin"
      placeholder="Direccion de origen"
    />
    <span
      class="text-xs text-red-600 dark:text-red-400"
      v-if="expenses.errors.has('origin_address')"
      v-html="expenses.errors.get('origin_address')"
    ></span>
  </div>
  <div v-else >
    <vue-google-autocomplete
      v-model="expenses.dest_address"
      id="addressDestination"
      classname="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
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
      required: false,
    },
  },
  methods: {
    getAddressOrigin: function (addressData, placeResultData, id) {
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
            this.expenses.origin_postal_code = `${component.long_name}${this.expenses.origin_postal_code}`;
            break;
          }
          case 'postal_code_suffix': {
            this.expenses.origin_postal_code = `${this.expenses.origin_postal_code}-${component.long_name}`;
            break;
          }
        }
      }

      if (!this.expenses.origin_postal_code) {
        this.postalCodeOrigin = true;
      } else {
        this.postalCodeOrigin = false;
      }
    },
    getAddressDestination: function (addressData, placeResultData, id) {
      this.expenses.dest_address = placeResultData.formatted_address;
      this.expenses.dest_latitude = addressData.latitude;
      this.expenses.dest_longitude = addressData.longitude;

      for (const component of placeResultData.address_components) {
        const componentType = component.types[0];
        switch (componentType) {
          case 'country':
            this.expenses.dest_ctry_code = component.short_name;
            break;
          case 'postal_code': {
            this.expenses.dest_postal_code = `${component.long_name}${this.expenses.dest_postal_code}`;
            break;
          }
          case 'postal_code_suffix': {
            this.expenses.dest_postal_code = `${this.expenses.dest_postal_code}-${component.long_name}`;
            break;
          }
        }
      }

      if (!this.expenses.dest_postal_code) {
        this.postalCodeDestination = true;
      } else {
        this.postalCodeDestination = false;
      }
    },
  },
  computed: {
    ...mapState('freightQuotes', ['expenses', 'addressDestination']),
  },
};
</script>

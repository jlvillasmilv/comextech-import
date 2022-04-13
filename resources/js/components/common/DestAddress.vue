<template>
  <!-- Address destination -->
  <div class="h-24">
    <span class="text-sm font-semibold">{{
      !isLocalAddress ? 'Bodegaje fullfilment' : 'Destino'
    }}</span>
    <div v-if="!expenses.fav_dest_address && isLocalAddress" class="flex">
      <vue-google-autocomplete
        v-model="expenses.dest_address"
        id="addressDestination"
        classname="w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input pac-target-input"
        placeholder="Direccion, Codigo Postal"
        v-on:placechanged="getAddressDestination"
      >
      </vue-google-autocomplete>
    </div>
    <div v-if="expenses.fav_dest_address" class="flex">
      <select
        v-model="expenses.dest_address"
        class="text-sm block w-full mt-1 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray"
      >
        <option v-for="item in addressDestination" :value="item.id" :key="item.id">
          {{ item.address }}
        </option>
      </select>
    </div>
    <div v-if="!isLocalAddress">
      <select
        class="text-sm block w-full mt-1 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray"
      >
        <option value="">We Storage</option>
        <option value="">Clic Oh</option>
      </select>
    </div>
    <label v-if="isLocalAddress" class="inline-flex text-sm items-center mx-2 mt-2">
      <input
        type="checkbox"
        class="form-checkbox h-4 w-4 text-gray-800"
        v-model="expenses.fav_dest_address"
        @change="expenses.dest_address = ''"
      /><span class="ml-2 text-gray-700">Destino favorito</span>
    </label>
    <span
      class="text-xs text-red-600 dark:text-red-400"
      v-if="expenses.errors.has('dest_address')"
      v-html="expenses.errors.get('dest_address')"
    ></span>
  </div>
  <!-- codigo postal de destino -->
  <!-- <div
            v-if="postalCodeDestination && !expenses.fav_dest_address"
            class="w-72 md:w-8/12 flex justify-center px-3 mb-6 md:mb-0"
          >
            <div class="w-full">
              <span class="text-sm font-semibold">Código postal origen</span>
              <div class="flex">
                <input
                  class="
                form-input
                w-full
                block
                border border-gray-150
                text-gray-700
                text-sm
                p-2
                mt-1
                pr-8
                rounded
                leading-tight
                focus:outline-none focus:bg-white focus:border-gray-500
                dark:text-gray-300
                dark:border-gray-600
                dark:bg-gray-700
                dark:focus:shadow-outline-gray
              "
                  type="number"
                  max="15"
                  v-model="expenses.dest_postal_code"
                  placeholder="Código postal de destino"
                />
              </div>
              <span
                class="text-xs text-red-600 dark:text-red-400"
                v-if="expenses.errors.has('dest_postal_code')"
                v-html="expenses.errors.get('dest_postal_code')"
              ></span>
            </div>
          </div> -->
</template>

<script>
import VueGoogleAutocomplete from 'vue-google-autocomplete';
import { mapState } from 'vuex';

export default {
  props: {
    isLocalAddress: {
      type: Boolean,
      required: true,
      default: () => true
    }
  },
  components: { VueGoogleAutocomplete },
  computed: {
    ...mapState('address', ['expenses', 'addressDestination', 'postalCodeDestination']),
    ...mapState('application', ['data', 'origin_transport'])
  },
  methods: {
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
  }
};
</script>

<template>
  <div>
    <!-- Address origin -->
    <span class="text-sm font-semibold">Origen</span>
    <div v-if="!expenses.fav_origin_address" class="flex">
      <vue-google-autocomplete
        v-model="expenses.origin_address"
        id="addressOrigin"
        classname="w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input pac-target-input"
        v-on:placechanged="getAddressOrigin"
        placeholder="Direccion, Codigo Postal"
      >
      </vue-google-autocomplete>
    </div>
    <div v-else class="flex">
      <select
        v-model="expenses.origin_address"
        class="text-sm block w-full mt-1 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray"
      >
        <option v-for="item in origin_transport" :value="item.id" :key="item.id">
          {{ item.address }}
        </option>
      </select>
    </div>
    <label class="inline-flex text-sm items-center mx-2 mt-2">
      <input
        type="checkbox"
        class="form-checkbox h-4 w-4 text-gray-800"
        v-model="expenses.fav_origin_address"
        @change="expenses.origin_address = ''"
      />
      <span class="ml-2 text-gray-700">
        {{ data.condition === 'FOB' ? 'Puertos favoritos' : 'Almacenes favoritos' }}
      </span>
    </label>
    <span
      class="text-xs text-red-600 dark:text-red-400"
      v-if="expenses.errors.has('origin_address')"
      v-html="expenses.errors.get('origin_address')"
    ></span>
  </div>
  <!-- Codigo postal origen -->
  <!-- <div
            v-if="postalCodeOrigin && !expenses.fav_origin_address"
            class="w-72 md:w-8/12 flex justify-center px-3 mb-6 md:mb-0"
          >
            <div class="w-full">
              <span class="text-sm font-semibold">Código postal origen</span>
              <div class="flex">
                <input
                  class="w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input pac-target-input"
                  type="number"
                  max="15"
                  v-model="expenses.origin_postal_code"
                  placeholder="Código postal de origen"
                />
              </div>
            </div>
            <span
              class="text-xs text-red-600 dark:text-red-400"
              v-if="expenses.errors.has('origin_postal_code')"
              v-html="expenses.errors.get('origin_postal_code')"
            ></span>
          </div> -->
</template>

<script>
import VueGoogleAutocomplete from 'vue-google-autocomplete';
import { mapState } from 'vuex';

export default {
  components: { VueGoogleAutocomplete },
  computed: {
    ...mapState('address', ['expenses', 'origin_transport', 'postalCodeOrigin']),
    ...mapState('application', ['data'])
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
    }
  }
};
</script>

<template>
  <section>
    <div>
      <transition
        v-if="!expenses.dataLoad || expenses.dataLoad.length == 0 || formAddress"
        name="fade"
      >
        <div class="flex flex-col items-center my-2">
          <!-- Direccion de origen -->
          <h3 v-if="expenses.type_transport !== 'COURIER'" class="mb-10 text-center">
            Direcciones y Puertos
          </h3>
          <div class="w-11/12 lg:w-8/12 mb-4 md:px-4 lg:px-0">
            <div>
              <span class="text-sm font-semibold">Origen</span>
              <GoogleAutocomplete />
            </div>
          </div>

          <!-- Codigo postal origen -->
          <div v-if="postalCodeOrigin" class="w-11/12 lg:w-8/12 mb-4 md:px-4 lg:px-0">
            <div>
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
          </div>

          <!-- Aeropuerto / Puerto origen -->
          <div
            v-if="expenses.type_transport !== 'COURIER'"
            class="w-11/12 lg:w-8/12 mb-4 md:px-4 lg:px-0"
          >
            <div>
              <span class="text-sm font-semibold">Puerto Origen</span>
              <div class="flex">
                <v-select
                  class="text-sm w-full"
                  label="name"
                  v-model="expenses.origin_port_id"
                  placeholder="Puerto Origen"
                  :options="portsOrigin"
                  :reduce="(portsOrigin) => portsOrigin.id"
                >
                  <template v-slot:no-options="{ search, searching }">
                    <template v-if="searching" class="text-sm">
                      Lo sentimos no hay opciones que coincidan
                      <strong>{{ search }}</strong
                      >.
                    </template>
                    <em style="opacity: 0.5" v-else> Puertos </em>
                  </template>
                  <template v-slot:option="portsOrigin">
                    {{ portsOrigin.name }}
                  </template>
                </v-select>
              </div>
            </div>
          </div>

          <!-- Aeropuerto / Puerto destino -->
          <div
            v-if="expenses.type_transport !== 'COURIER'"
            class="w-11/12 lg:w-8/12 mb-4 md:px-4 lg:px-0"
          >
            <div>
              <span class="text-sm font-semibold"> Puerto Destino</span>
              <div class="flex">
                <v-select
                  class="text-sm w-full"
                  label="name"
                  v-model="expenses.dest_port_id"
                  placeholder="Puerto Destino"
                  :options="portsDestination"
                  :reduce="(portsDestination) => portsDestination.id"
                >
                  <template v-slot:no-options="{ search, searching }">
                    <template v-if="searching" class="text-sm">
                      Lo sentimos no hay opciones que coincidan
                      <strong>{{ search }}</strong
                      >.
                    </template>
                    <em style="opacity: 0.5" v-else> Puertos </em>
                  </template>
                  <template v-slot:option="portsDestination">
                    {{ portsDestination.name }}
                  </template>
                </v-select>
              </div>

              <span
                class="text-xs text-red-600 dark:text-red-400"
                v-if="expenses.errors.has('dest_port_id')"
                v-html="expenses.errors.get('dest_port_id')"
              ></span>
            </div>
          </div>

          <!-- transporte local -->
          <div v-if="expenses.type_transport !== 'COURIER'" class="flex justify-center w-full py-4">
            <button
              @click="!showShipping ? SHOW_LOCAL_SHIPPING(true) : SHOW_LOCAL_SHIPPING(false)"
              class="
                lg:w-2/12
                bg-transparent
                focus:outline-none
                uppercase
                text-xs
                hover:bg-blue-1000
                text-blue-1000
                font-semibold
                hover:text-white
                py-2
                px-2
                border border-blue-1000
                hover:border-transparent
                rounded active:bg-blue-1100
              "
            >
              Transporte Local
            </button>
            <hr class="md:w-8/12 md:mt-4 md:mb-4 md:border-solid md:border-t-2" />
          </div>

          <!-- Destino de Envio -->
          <div
            v-if="showShipping || expenses.type_transport == 'COURIER'"
            class="w-11/12 lg:w-8/12 mb-4 md:px-4 lg:px-0"
          >
            <div>
              <span class="text-sm font-semibold">Destino</span>
              <GoogleAutocomplete :Addresses="false" />
            </div>
          </div>

          <!-- codigo postal de destino -->
          <div v-if="postalCodeDestination" class="w-11/12 lg:w-8/12 mb-4 md:px-4 lg:px-0">
            <div>
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
          </div>
        </div>
      </transition>

      <!-- Date and description -->
      <transition v-if="addressDate" name="fade">
        <FormDate />
      </transition>
    </div>

    <!-- botones cotizar/editar -->
    <transition v-if="buttons" name="fade">
      <div
        :class="[
          !expenses.dataLoad || expenses.dataLoad.length <= 0
            ? 'flex justify-center'
            : 'flex justify-center my-5 innline w-1/7 mt-5'
        ]"
      >
        <button
          @click="hideAddress()"
          :class="[
            !expenses.dataLoad
              ? 'hidden'
              : expenses.dataLoad.length > 0
              ? 'mr-4 w-32 h-12 text-white transition-colors text-lg bg-blue-1000 rounded-lg focus:shadow-outline hover:bg-blue-1100 active:bg-blue-1000'
              : ''
          ]"
        >
          {{ expenses.dataLoad.length > 0 ? 'Editar' : '' }}
        </button>

        <button
          @click="expenses.type_transport == 'COURIER' ? getCourierQuote() : submitQuote()"
          :class="[
            !expenses.dataLoad
              ? 'flex items-center justify-center vld-parent sm:w-44 h-12 px-4 text-white transition-colors text-lg bg-blue-1300 rounded-lg focus:shadow-outline hover:bg-blue-1200 active:bg-blue-1300'
              : expenses.dataLoad.length <= 0
              ? 'flex items-center justify-center vld-parent sm:w-44 h-12 px-4 text-white transition-colors text-lg bg-blue-1300 rounded-lg focus:shadow-outline hover:bg-blue-1200 active:bg-blue-1300'
              : 'flex items-center justify-center ml-4 w-32 h-12 text-white transition-colors text-lg bg-blue-1300 rounded-lg focus:shadow-outline hover:bg-blue-1200 active:bg-blue-1300'
          ]"
        >
          Cotizar
        </button>
      </div>
    </transition>

    <!-- Bloque cotizacion de fedex -->
    <transition v-if="showFedexDhlQuote" name="fade">
      <FedexDhl />
    </transition>

    <!-- fcl table quote   -->
    <transition v-if="showTable" name="fade">
      <Table />
    </transition>

    <!-- form  -->
    <transition v-if="showForm" name="fade">
      <Form />
    </transition>
  </section>
</template>

<script>
import FormDate from './FormDate.vue';
import Form from './FormUsers.vue';
import Table from './Table.vue';
import FedexDhl from './FedexDhl.vue';
import GoogleAutocomplete from '../common/GoogleAutocomplete.vue';
import mixinFreight from './mixins/submitQuotes';
import { mapState } from 'vuex';

export default {
  components: { GoogleAutocomplete, FormDate, Form, Table, FedexDhl },
  mixins: [mixinFreight],
  data() {
    return {};
  },
  methods: {
    async getCourierQuote() {
      /* Vue-loader config */
      let loader = this.$loading.show({
        canCancel: true,
        transition: 'fade',
        color: '#142c44',
        loader: 'spinner',
        lockScroll: true,
        enforceFocus: true,
        height: 100,
        width: 100
      });

      this.SHOW_LOAD_CHARGE(false);
      this.SHOW_ADDRESS(false);

      try {
        this.expenses.dataLoad = this.$store.state.load.loads;

        const fedexDhlQuote = await this.$store.dispatch(
          'freightQuotes/getFedexDhlQuote',
          this.expenses
        );

        if (!fedexDhlQuote) {
          this.hideAddress();
          loader.hide();
        }
      } catch (error) {
        console.error(error);
      } finally {
        loader.hide();
      }
    }
  },
  computed: {
    ...mapState('freightQuotes', [
      'expenses',
      'portsOrigin',
      'portsDestination',
      'addressDate',
      'formAddress',
      'postalCodeOrigin',
      'postalCodeDestination',
      'showShipping',
      'showForm',
      'showTable',
      'buttons',
      'showFedexDhlQuote'
    ])
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

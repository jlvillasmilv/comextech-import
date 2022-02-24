<template>
  <section>
    <!-- form if data.condition is EXW -->
    <div v-if="!expenses.dataLoad || expenses.dataLoad.length == 0 || formAddress">
      <transition name="fade">
        <div class="flex flex-col items-center my-2">
          <!-- Direccion de origen -->
          <h3 v-if="data.type_transport != 'COURIER'" class="mb-10 text-center">
            Direcciones y Puertos
          </h3>
          <div
            v-if="data.condition == 'EXW' || data.type_transport == 'COURIER'"
            class="w-11/12 lg:w-8/12 mb-4 md:px-4 lg:px-0"
          >
            <!-- Input origin address -->
            <origin-address />
          </div>

          <!-- Aeropuerto / Puerto origen -->
          <div
            v-if="data.type_transport != 'COURIER'"
            class="w-11/12 lg:w-8/12 mb-4 md:px-4 lg:px-0"
          >
            <div class="w-full">
              <span class="text-sm font-semibold"
                >{{ data.type_transport === 'AEREO' ? 'Aeropuerto' : 'Puerto' }} Origen</span
              >
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
              <label class="inline-flex text-sm items-center mx-2 mt-2">
                <input
                  type="checkbox"
                  class="form-checkbox h-4 w-4 text-gray-800"
                  v-model="expenses.fav_origin_port"
                  @change="getFavOriginPort"
                />
                <span class="ml-2 text-gray-700">
                  {{ data.type_transport === 'AEREO' ? 'Aeropuertos' : 'Puertos' }}
                  favoritos
                </span>
                <span
                  class="text-xs text-red-600 dark:text-red-400"
                  v-if="expenses.errors.has('origin_port_address')"
                  v-html="expenses.errors.get('origin_port_address')"
                ></span>
              </label>
            </div>
          </div>

          <!-- Aeropuerto / Puerto destino -->
          <div
            v-if="data.type_transport != 'COURIER'"
            class="w-11/12 lg:w-8/12 mb-4 md:px-4 lg:px-0"
          >
            <div class="w-full">
              <span class="text-sm font-semibold"
                >{{ data.type_transport === 'AEREO' ? 'Aeropuerto' : 'Puerto' }} Destino</span
              >
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
              <label class="inline-flex text-sm items-center mx-2 mt-2">
                <input
                  type="checkbox"
                  class="form-checkbox h-4 w-4 text-gray-800"
                  v-model="expenses.fav_dest_port"
                  @change="getFavDestPort"
                />
                <span class="ml-2 text-gray-700">
                  {{ data.type_transport === 'AEREO' ? 'Aeropuertos' : 'Puertos' }}
                  favoritos
                </span>
              </label>
              <span
                class="text-xs text-red-600 dark:text-red-400"
                v-if="expenses.errors.has('dest_port_id')"
                v-html="expenses.errors.get('dest_port_id')"
              ></span>
            </div>
          </div>

          <!-- transporte local -->
          <div v-if="data.type_transport != 'COURIER'" class="flex justify-center w-full py-4">
            <button
              @click="showShippingMethod()"
              class="
                md:w-2/12
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
            v-if="showShipping || data.type_transport == 'COURIER'"
            class="w-11/12 lg:w-8/12 mb-4 md:px-4 lg:px-0"
          >
            <dest-address />
          </div>
        </div>
      </transition>

      <!-- Date and description -->
      <transition v-if="dateAddress" name="fade">
        <form-date />
      </transition>
    </div>

    <!-- Courier quote component -->
    <transition v-if="showFedexDhlQuote" name="fade">
      <div>
        <fedex-dhl />
      </div>
    </transition>

    <transition v-if="showLclFclQuote" name="fade">
      <lcl-quote />
    </transition>

    <!-- botones cotizar/editar -->
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
        @click="data.type_transport === 'COURIER' ? getCourierQuote() : submitQuote()"
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
  </section>
</template>

<script>
import { mapMutations, mapState } from 'vuex';
import OriginAddress from '../common/OriginAddress.vue';
import DestAddress from '../common/DestAddress.vue';
import FormDate from './FormDate.vue';
import FedexDhl from './Quotes/FedexDhl.vue';
import LclQuote from './Quotes/LclQuote.vue';

export default {
  components: { OriginAddress, DestAddress, FormDate, FedexDhl, LclQuote },
  data() {
    return {
      showShipping: false,
      formAddress: true,
      dateAddress: true
    };
  },
  // mounted() {
  //   console.log(this.expenses.dataLoad);
  // },
  computed: {
    ...mapState('address', [
      'expenses',
      'addressDestination',
      'portsOrigin',
      'portsOriginTemp',
      'portsDestination',
      'portsDesTemp',
      'postalCodeOrigin',
      'postalCodeDestination',
      'showFedexDhlQuote',
      'showLclFclQuote'
    ]),
    ...mapState('application', ['data', 'currency', 'origin_transport', 'busy'])
  },
  methods: {
    ...mapMutations('address', ['HIDE_COURIER_QUOTES']),
    ...mapMutations('load', ['SHOW_LOAD_CHARGE']),

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

      this.formAddress = false;
      this.dateAddress = false;
      this.SHOW_LOAD_CHARGE(false);
      try {
        this.expenses.dataLoad = this.$store.state.load.loads;
        const fedexDhlQuote = await this.$store.dispatch('address/getFedexDhlQuote', this.expenses);

        if (!fedexDhlQuote) {
          loader.hide();
          this.hideAddress();
        }
      } catch (error) {
        console.error(error);
      } finally {
        loader.hide();
      }
    },

    async submitQuote() {
      /* Vue-loader config */
      let loader = this.$loading.show({
        canCancel: true,
        transition: 'fade',
        color: '#046c4e',
        loader: 'spinner',
        lockScroll: true,
        enforceFocus: true,
        height: 100,
        width: 100
      });

      this.formAddress = false;
      this.dateAddress = false;
      this.SHOW_LOAD_CHARGE(false);

      try {
        this.expenses.dataLoad = this.$store.state.load.loads;
        this.$store.dispatch('address/getLclFclTable', this.expenses);
        // this.expenses.app_amount = appAmount;
        // this.expenses.trans_company_id = transCompanyId;
        const fclLclQuote = await this.expenses.post('/applications/transports');
        console.log(fclLclQuote);

        // Message to validate if transport_amount is 0
        if (fclLclQuote.data.transport.transport_amount === 0) {
          Swal.fire({
            title: '¿Quiere solicitar una tarifa para su operación al Equipo ComexTech?',
            // text: '¿Quiere solicitar una tarifa para su operación al Equipo ComexTech?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Enviar'
          }).then((result) => {
            if (result.isConfirmed) {
              // Swal.fire('Deleted!', 'Your file has been deleted.', 'success');
              Toast.fire({
                icon: 'success',
                title: 'Datos Agregados'
              });
            }
          });
        } else {
          Toast.fire({
            icon: 'success',
            title: 'Datos Agregados'
          });
        }
        this.$store.dispatch('load/setLoad', fclLclQuote.data);
        // this.$store.dispatch('callIncomingOrNextMenu', true);
      } catch (error) {
        this.hideAddress();
        console.error(error);
      } finally {
        loader.hide();
      }
    },

    async getFavOriginPort() {
      this.expenses.origin_port_id = '';
      if (this.expenses.fav_origin_port && this.data.supplier_id) {
        let idsupplier = this.data.supplier_id;
        const type = 'P';
        await this.$store.dispatch('address/getFavOriginPort', {
          idsupplier,
          type
        });
      } else {
        await this.$store.dispatch('address/setOrigFavOritPorts');
      }
    },

    async getFavDestPort() {
      this.expenses.dest_port_id = '';
      const type = 'P';
      if (this.expenses.fav_dest_port) {
        await this.$store.dispatch('address/getFavDestPorts', type);
      } else {
        await this.$store.dispatch('address/setOrigFavDestPorts');
      }
    },
    /**
     * Show / Hide from address (button "Editar")
     */
    hideAddress() {
      this.formAddress = true;
      this.dateAddress = true;

      this.HIDE_COURIER_QUOTES(false);

      this.$store.dispatch('load/showLoadCharge', true); /* Hide / Show loads and dimensions form */

      // /* Here the dataLoad is set to 0 to edit the view */
      // this.expenses.dataLoad = this.expenses.dataLoad.length == 0;
    },

    showShippingMethod() {
      this.showShipping = !this.showShipping;
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

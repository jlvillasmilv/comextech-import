<template>
  <section>
    <!-- form if data.condition is EXW -->
    <transition name="fade">
      <div v-if="!expenses.dataLoad || isFormAddress">
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
          <div class="w-full flex flex-col items-center">
            <div v-if="data.type_transport != 'COURIER'" class="flex justify-center w-full py-4">
              <button
                @click="showShippingMethod()"
                class="
                lg:w-3/12
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

            <div v-if="showShipping" class="flex flex-wrap justify-center w-full my-4 sm:my-0">
              <div class="flex flex-col items-center justify-center w-6/12 sm:w-2/12 mx-2">
                <button
                  class="flex items-center justify-center w-32 h-20 px-2 border bg-blue-1000 rounded-md focus:outline-none"
                  type="button"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    class="h-14 w-14"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                    ></path>
                  </svg>
                </button>
              </div>
              <div class="flex justify-center items-center w-9/12 sm:w-2/12 mx-2">
                <button
                  class="w-32 h-20 px-2 border bg-blue-1000 rounded-md focus:outline-none"
                  type="button"
                >
                  <img src="../../../../public/img/weStorage.png" alt="" />
                </button>
              </div>
              <div class="flex flex-col justify-center w-32 h-28 mx-4">
                <button
                  class="w-32 h-20 px-2 border bg-blue-1000 rounded-md focus:outline-none"
                  type="button"
                >
                  <!-- style="background-color: #1e36d9;" -->
                  <img src="../../../../public/img/clic-oh.png" alt="" />
                </button>
              </div>
            </div>

            <!-- Destino de Envio -->
            <div
              v-if="showShipping || data.type_transport == 'COURIER'"
              class="w-11/12 lg:w-8/12 mb-4 md:px-4 lg:px-0"
            >
              <dest-address />
            </div>
          </div>
        </div>

        <!-- Date and description -->
        <div v-if="isDateAddress">
          <form-date />
        </div>
      </div>
    </transition>

    <!-- Courier quote component -->
    <transition name="fade">
      <div v-if="showFedexDhlQuote">
        <fedex-dhl />
      </div>
    </transition>

    <!-- Aereo, FCL and LCL quote -->
    <transition name="fade">
      <div v-if="showLclFclQuote">
        <table-fcl-lcl />
      </div>
    </transition>

    <!-- botones cotizar/editar -->
    <div class="flex justify-center my-5">
      <button
        @click="hideAddress()"
        :class="[
          isEdit
            ? 'mr-4 w-32 h-12 text-white transition-colors text-lg bg-blue-1000 rounded-lg focus:shadow-outline hover:bg-blue-1100 active:bg-blue-1000'
            : 'hidden'
        ]"
      >
        {{ isEdit ? 'Editar' : '' }}
      </button>
      <button
        @click="
          saveDataTransport
            ? saveData()
            : data.type_transport === 'COURIER'
            ? getCourierQuote()
            : submitQuote()
        "
        :class="[isDisabled ? saveButtonDisabled : isEdit ? saveButton : quoteButton]"
        :disabled="isDisabled"
      >
        {{ saveDataTransport ? 'Guardar' : 'Cotizar' }}
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
import TableFclLcl from './Quotes/TableFclLcl.vue';

export default {
  components: { OriginAddress, DestAddress, FormDate, FedexDhl, TableFclLcl },
  data() {
    return {
      showShipping: false,
      saveButton:
        'flex items-center justify-center ml-4 w-32 h-12 text-white transition-colors text-lg bg-blue-1300 rounded-lg focus:shadow-outline hover:bg-blue-1200 active:bg-blue-1300',
      saveButtonDisabled:
        'flex items-center justify-center ml-4 w-32 h-12 text-white transition-colors text-lg bg-gray-300 rounded-lg focus:shadow-outline',
      quoteButton:
        'flex items-center justify-center vld-parent sm:w-44 h-12 px-4 text-white transition-colors text-lg bg-blue-1300 rounded-lg focus:shadow-outline hover:bg-blue-1200 active:bg-blue-1300'
    };
  },
  computed: {
    ...mapState('address', [
      'expenses',
      'isFormAddress',
      'isDateAddress',
      'isEdit',
      'portsOrigin',
      'portsOriginTemp',
      'portsDestination',
      'portsDesTemp',
      'showFedexDhlQuote',
      'showLclFclQuote',
      'saveDataTransport',
      'isDisabled'
    ]),
    ...mapState('application', ['data'])
  },
  methods: {
    ...mapMutations('address', [
      'SHOW_ADDRESSES',
      'SHOW_BUTTON_EDIT',
      'HIDE_COURIER_QUOTES',
      'HIDE_TABLE_FCL_LCL'
    ]),
    ...mapMutations('load', ['SHOW_LOAD_CHARGE']),

    async getCourierQuote() {
      this.$store.dispatch('playPauseLoading', true);
      this.expenses.app_amount = '';
      this.expenses.trans_company_id = '';

      /* Show button (editar) */
      this.SHOW_BUTTON_EDIT(true);

      /* Hide addresses form */
      this.SHOW_ADDRESSES(false);

      /* Hide loads and dimensions form */
      this.SHOW_LOAD_CHARGE(false);
      try {
        this.expenses.dataLoad = this.$store.state.load.loads;
        const fedexDhlQuote = await this.$store.dispatch('address/getFedexDhlQuote', this.expenses);

        if (!fedexDhlQuote) {
          this.$store.dispatch('playPauseLoading', false);
          this.hideAddress();
        } else {
          this.$store.commit('address/ACTIVE_SAVE_DATA', true);
          this.$store.state.address.isDisabled = true;
        }
      } catch (error) {
        console.error(error);
      } finally {
        this.$store.dispatch('playPauseLoading', false);
      }
    },

    async submitQuote() {
      this.$store.dispatch('playPauseLoading', true);

      /* Show button (editar) */
      this.SHOW_BUTTON_EDIT(true);

      /* Hide addresses form */
      this.SHOW_ADDRESSES(false);

      /* Hide loads and dimensions form */
      this.SHOW_LOAD_CHARGE(false);

      try {
        this.expenses.dataLoad = this.$store.state.load.loads;
        this.$store.dispatch('address/getLclFclTable', this.expenses);
        // this.expenses.app_amount = appAmount;
        // this.expenses.trans_company_id = transCompanyId;
        const fclLclQuote = await this.expenses.post('/applications/transports');

        // Message to validate if transport_amount is 0
        if (fclLclQuote.data.transport.transport_amount === 0) {
          this.$store.dispatch('playPauseLoading', false);
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
        this.$store.commit('address/ACTIVE_SAVE_DATA', true);
        this.$store.state.address.isDisabled = false;
        // this.$store.dispatch('callIncomingOrNextMenu', true);
      } catch (error) {
        this.hideAddress();
        console.error(error);
      } finally {
        this.$store.dispatch('playPauseLoading', false);
      }
    },

    saveData() {
      this.$store.dispatch('callIncomingOrNextMenu', true);
      Toast.fire({
        icon: 'success',
        title: 'Datos Agregados'
      });
      this.$store.dispatch('playPauseLoading', true);
      this.$store.commit('address/ACTIVE_SAVE_DATA', false);
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
    Show / Hide form address (button "Editar")
     */
    hideAddress() {
      /* Show loads and dimensions form */
      this.SHOW_LOAD_CHARGE(true);

      /* Show addresses form */
      this.SHOW_ADDRESSES(true);

      /* Hide if courier quotes */
      this.HIDE_COURIER_QUOTES(false);

      /* Hide if table FCL and LCL */
      this.HIDE_TABLE_FCL_LCL(false);

      /* Hide button "editar" */
      this.SHOW_BUTTON_EDIT(false);

      /* Active button saveData */
      this.$store.commit('address/ACTIVE_SAVE_DATA', false);

      this.$store.state.address.isDisabled = false;

      this.expenses.trans_company_id = '';
    },

    /* Show/Hide button transporte local */
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

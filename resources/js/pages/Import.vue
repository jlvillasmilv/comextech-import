<template>
  <div class="md:container md:mx-auto text-gray-900 dark:text-gray-200">
    <loader />
    <tabs />

    <div class="w-full p-2">
      <container :bg="false" v-if="$store.state.tabActive == 'ICS01'">
        <form-payment />
      </container>
      <container :bg="false" v-if="$store.state.tabActive == 'ICS03'">
        <transport />
      </container>
      <container :bg="false" v-if="$store.state.tabActive == 'ICS04'">
        <form-internment :application_id="data.application_id" />
      </container>

      <container
        v-if="
          $store.state.tabActive == 'ICS05' &&
            $store.state.application.data.type_transport != 'COURIER'
        "
      >
        <internal-storage :application_id="data.application_id" />
      </container>

      <container v-if="$store.state.tabActive == 'ICS07'">
        <exchange :application_id="data.application_id" />
      </container>
    </div>
    <modal v-if="$store.state.statusModal" :title="title" class="transition ease-out duration-150">
      <template v-slot:body>
        <div class="mt-1">
          <form @submit.prevent="submitFormApplications" @keydown="data.onKeydown($event)">
            <!-- Servicios -->
            <h3 class="font-semibold text-blue-1300 text-lg dark:text-white">
              Servicios
            </h3>
            <!-- data-title="Tipo de servicio"
              data-intro="Acá seleccionas el tipo de servicio a cotizar" -->
            <div class="flex w-full">
              <div
                v-for="(item, id) in $store.state.application.selectedCondition.services"
                :key="id"
                class="flex flex-col w-4/12 sm:w-4/12 mr-4"
              >
                <!-- data-title="Pago al proveedor"
                  data-intro="Si activas el servicio de pago al proveedor, apareceran unos botones para que selecciones que tipo de pago con % escogeras" -->
                <div v-if="item.name === 'Proveedor'"></div>
                <button
                  type="button"
                  @click="
                    item.selected && !item.checked
                      ? selectedService(item)
                      : !item.selected
                      ? ''
                      : deleteService(item.sort)
                  "
                  :class="[
                    'flex flex-col items-center text-center text-sm font-semibold px-1 py-1 mx-0.5 my-2 border rounded focus:outline-none',
                    item.checked
                      ? 'bg-blue-1000 text-white border-blue-1000 hover:bg-transparent hover:text-black active:bg-transparent active:text-black'
                      : !item.selected
                      ? 'text-gray-400 bg-gray-300 border-gray-200'
                      : 'bg-transparent border-blue-1000 hover:bg-blue-1000 hover:text-white active:bg-blue-1000 active:text-white'
                  ]"
                >
                  <span class="iconify w-10 h-10 my-2" :data-icon="item.icon"></span>
                </button>
                <p
                  :class="[
                    item.selected ? 'text-center dark:text-white' : 'text-center text-gray-300'
                  ]"
                >
                  {{ item.name }}
                </p>
              </div>
            </div>
            <span
              class="text-xs text-red-600 dark:text-red-400"
              v-if="data.errors.has('services')"
              v-html="data.errors.get('services')"
            ></span>

            <!-- Proveedor -->
            <!-- data-title="Proveedor"
              data-intro="Acá seleccionas el proveedor" -->
            <div class="w-full mb-4 sm:my-4 flex flex-col sm:flex-row">
              <section class="sm:w-7/12 flex flex-col justify-center mt-4 sm:mt-0 sm:mb-0">
                <h3 class="mt-1 mb-1 font-semibold text-blue-1300 text-lg dark:text-white">
                  Proveedor
                </h3>
                <div class="inline-flex flex-col w-full dark:text-gray-200">
                  <v-select
                    class="w-full"
                    :disabled="data.statusSuppliers == 'without'"
                    label="name"
                    :placeholder="
                      data.statusSuppliers !== 'E-commerce'
                        ? 'Seleccionar Proveedor'
                        : 'Seleccione E-commerce'
                    "
                    :options="data.statusSuppliers !== 'E-commerce' ? suppliers : agencyElectronic"
                    v-model="data.supplier_id"
                    :reduce="(supplier) => supplier.id"
                  >
                    <template v-slot:no-options="{ search, searching }">
                      <template v-if="searching" class="text-sm">
                        Lo sentimos no hay opciones que coincidan
                        <strong>{{ search }}</strong
                        >.
                      </template>
                      <em style="opacity: 0.5" v-else> No posee proveedores en tu lista</em>
                    </template>
                  </v-select>
                  <div
                    class="inline-flex w-full md:w-8/12"
                    v-show="data.statusSuppliers == 'E-commerce'"
                  >
                    <input
                      v-model="data.ecommerce_url"
                      type="text"
                      placeholder="Ingrese url generado por e-commerce "
                      :disabled="data.statusSuppliers !== 'E-commerce'"
                      :class="[classStyle.input, classStyle.formInput, classStyle.wfull]"
                    />
                  </div>
                </div>
              </section>
              <section class="mt-4 w-6/12 sm:w-7/12 flex justify-center">
                <div
                  class="w-full sm:ml-10 flex sm:justify-center flex-wrap sm:content-end content-start"
                >
                  <label
                    v-for="(item, index) in statusSuppliers"
                    :key="index"
                    class="sm:w-52 inline-flex justify-start items-center sm:px-6"
                  >
                    <input
                      type="radio"
                      class="form-radio"
                      name="accountType"
                      v-model="data.statusSuppliers"
                      @click="toDisableProviderPayment(item.name, true)"
                      :value="item.name"
                    />
                    <span class="mx-2 mt-1">
                      {{ item.description }}
                    </span>
                  </label>
                </div>
              </section>
            </div>
            <span
              class="text-xs text-red-600 dark:text-red-400"
              v-if="data.errors.has('supplier_id')"
              v-html="data.errors.get('supplier_id')"
            ></span>
            <span
              class="text-xs text-red-600 dark:text-red-400"
              v-if="data.errors.has('ecommerce_url')"
              v-html="data.errors.get('ecommerce_url')"
            ></span>

            <!-- Pago -->
            <div class="w-full sm:my-4 flex flex-col sm:items-center sm:flex-row">
              <section class="sm:w-7/12 flex flex-col justify-center">
                <h3 class="font-semibold text-blue-1300 text-lg my-1">Mercadería</h3>
                <div class="w-full sm:w-2/6 md:w-2/6">
                  <!-- data-title="Tipo de moneda"
                  data-intro="Seleccionas el tipo de moneda con el que vas a cotizar la importacion" -->
                  <h3 class="mx-1 my-2.5 text-gray-500 text-base">
                    Moneda
                  </h3>
                  <!-- <h3 class="my-3 text-gray-500 text-sm">
                                    Moneda de Pago
                                </h3> -->

                  <v-select
                    label="name"
                    v-model="$store.state.application.currency"
                    placeholder="Moneda de Pago"
                    @input="handleCurrency"
                    :options="currencies"
                  >
                    <template v-slot:no-options="{ search, searching }">
                      <template v-if="searching" class="text-sm">
                        Lo sentimos no hay opciones que coincidan
                        <strong>{{ search }}</strong
                        >.
                      </template>
                      <em style="opacity: 0.5" v-else> Moneda </em>
                    </template>
                    <template v-slot:option="currencies">
                      {{ `${currencies.name} (${currencies.code}) ` }}
                    </template>
                  </v-select>
                  <span
                    class="text-xs text-red-600 dark:text-red-400"
                    v-if="data.errors.has('currency_id')"
                    v-html="data.errors.get('currency_id')"
                  ></span>
                </div>

                <!-- Condicion y monto -->
                <!-- data-title="Condicion de venta"
                    data-intro="Acá seleccionas la condicion de venta" -->
                <div class="flex sm:items-center sm:w-full">
                  <div
                    v-if="$store.state.application.data.type_transport != 'COURIER'"
                    :class="[
                      data.statusSuppliers == 'with'
                        ? 'flex flex-col w-6/12 sm:w-full'
                        : 'flex flex-col w-6/12 sm:w-full',
                      'md:mb-0'
                    ]"
                  >
                    <h3 class="my-2.5 text-gray-500 text-base">Condicion de Venta</h3>
                    <div class="relative w-7/12 sm:w-2/3">
                      <select
                        v-model="$store.state.application.selectedCondition"
                        @change="toogleMenuTabs()"
                        class="    
                      block
                      appearance-none
                      w-full
                      border border-gray-150
                      dark:border-gray-600
                      text-gray-700
                      p-2
                      pr-8
                      rounded
                      leading-tight
                      focus:outline-none focus:bg-white focus:border-gray-500
                      "
                      >
                        <!-- :class="[$store.state.address.expenses.mode_selected == 'COURIER' ? 'bg-gray-600' : 'bg-blue-400']" -->
                        <option
                          v-for="item in arrayServices"
                          :value="item"
                          :key="item.name"
                          :title="item.description"
                        >
                          {{ item.name }}
                        </option>
                      </select>
                      <span
                        class="text-xs text-red-600 dark:text-red-400"
                        v-if="data.errors.has('condition')"
                        v-html="data.errors.get('condition')"
                      ></span>
                      <div
                        class="
                        pointer-events-none
                        absolute
                        inset-y-0
                        right-0
                        flex
                        items-center
                        px-2
                        text-gray-700
                      "
                      >
                        <svg
                          class="fill-current h-4 w-4"
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 20 20"
                        >
                          <path
                            d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                          />
                        </svg>
                      </div>
                    </div>
                  </div>
                  <div v-else class="w-full flex flex-col justify-center">
                    <h3 class="text-gray-500 text-base p-2">Puerta a Puerta</h3>
                    <div class="relative"></div>
                  </div>

                  <!-- monto operacion -->
                  <!-- data-title="Monto de operacion"
                    data-intro="El monto de la mercaderia a importar" -->
                  <div class="px-1 flex flex-col w-6/12 sm:w-9/12 md:mb-0">
                    <h3 class="text-center my-2.5 text-gray-500 text-base">Monto</h3>
                    <vue-numeric
                      thousand-separator="."
                      v-bind:minus="false"
                      v-model="data.amount"
                      class="sm:block text-center text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none dark:text-gray-300 dark:focus:shadow-outline-gray form-input w-full sm:w-full"
                    />
                  </div>
                </div>
                <span
                  class="text-center text-xs my-1 text-red-600 dark:text-red-400"
                  v-if="data.errors.has('amount')"
                  v-html="data.errors.get('amount')"
                ></span>
              </section>

              <!-- Porcentajes -->
              <!-- data-title="Porcentajes para pago al proveedor"
                data-intro="Si seleccionas el tipo de servicio para pagar a un proveedor, debes seleccionar de que manera estara gestionado el pago" -->
              <section
                class="my-4 h-40 flex flex-col items-center md:mt-8 sm:my-0 sm:w-6/12 md:w-7/12"
              >
                <div class="w-6/12 flex flex-wrap justify-center sm:w-full md:w-7/12">
                  <!-- <h3 class="my-3 text-gray-500 text-sm">
                                    Porcentaje de Pago
                                </h3> -->

                  <!-- <div
                :class="[
                    paymentPercentage.valueInitial == data.valuePercentage.valueInitial
                      ? 'bg-blue-500 text-white'
                      : 'bg-transparent text-blue-700 ',
                    'w-3/12 hover:bg-blue-500 font-semibold hover:text-white px-1 py-2 text-sm mx-0.5 border border-blue-500 hover:border-transparent rounded my-2 text-center'
                  ]"
                  @click="handlePercentage()"
                >

                </div> -->
                  <button
                    type="button"
                    v-for="(item, id) in paymentPercentage2"
                    :key="id"
                    @click="handlePercentage(item)"
                    :class="[
                      !selectedCondition || !selectedCondition.services[0].checked
                        ? 'hidden'
                        : item.valueInitial == data.valuePercentage.valueInitial
                        ? 'bg-blue-1000 text-white hover:bg-blue-1100 w-4/12 font-semibold hover:text-white px-1 py-2 text-xs mx-0.5 border border-blue-1000 hover:border-transparent rounded my-2 text-center focus:outline-none'
                        : 'bg-transparent text-blue-1000 hover:bg-blue-1000 w-4/12 font-semibold hover:text-white px-1 py-2 text-xs mx-0.5 border border-blue-1000 hover:border-transparent rounded my-2 text-center focus:outline-none'
                    ]"
                    :disabled="!selectedCondition || !selectedCondition.services[0].checked"
                  >
                    {{ item.name }}
                  </button>
                </div>
                <div
                  :class="[
                    !selectedCondition || !selectedCondition.services[0].checked
                      ? 'hidden'
                      : 'flex justify-center w-full'
                  ]"
                >
                  <hr class="border-2 w-32" />
                </div>
                <div class="w-6/12 flex flex-wrap justify-center sm:w-full md:w-7/12">
                  <!-- <h3 class="my-3 text-gray-500 text-sm">
                                    Porcentaje de Pago
                                </h3> -->

                  <!-- <div
                :class="[
                    paymentPercentage.valueInitial == data.valuePercentage.valueInitial
                      ? 'bg-blue-500 text-white'
                      : 'bg-transparent text-blue-700 ',
                    'w-3/12 hover:bg-blue-500 font-semibold hover:text-white px-1 py-2 text-sm mx-0.5 border border-blue-500 hover:border-transparent rounded my-2 text-center'
                  ]"
                  @click="handlePercentage()"
                >

                </div> -->
                  <button
                    type="button"
                    v-for="(item, id) in paymentPercentage1"
                    :key="id"
                    @click="handlePercentage(item)"
                    :class="[
                      !selectedCondition || !selectedCondition.services[0].checked
                        ? 'hidden'
                        : item.valueInitial == data.valuePercentage.valueInitial
                        ? 'bg-blue-1000 text-white hover:bg-blue-1100 w-4/12 font-semibold hover:text-white px-1 py-2 text-xs mx-0.5 border border-blue-1000 hover:border-transparent rounded my-2 text-center focus:outline-none'
                        : 'bg-transparent text-blue-1000 hover:bg-blue-1000 w-4/12 font-semibold hover:text-white px-1 py-2 text-xs mx-0.5 border border-blue-1000 hover:border-transparent rounded my-2 text-center focus:outline-none'
                    ]"
                    :disabled="!selectedCondition || !selectedCondition.services[0].checked"
                  >
                    {{ item.name }}
                  </button>
                  <span
                    class="text-xs text-red-600 dark:text-red-400"
                    v-if="data.errors.has('valuePercentage')"
                    v-html="data.errors.get('valuePercentage')"
                  ></span>
                </div>
              </section>
            </div>

            <!-- Tipo de transporte -->
            <h3 class="my-3 font-semibold text-blue-1300 text-lg">Tipo de Transporte</h3>
            <!-- data-title="Tipo de transporte"
              data-intro="El tipo de transporte que vas a querer para importar tu mercaderia" -->
            <div class="flex flex-wrap justify-center w-full">
              <div
                v-for="service in typeTransport"
                :key="service.name"
                class="w-5/12 sm:w-3/12 flex flex-col justify-center mt-2 mb-3 lg:mb-8"
              >
                <button
                  :disabled="service.disabled || service.disabled === 1"
                  type="button"
                  :class="[
                    'mx-1 flex flex-col items-center border rounded px-3 py-2 border-b-2',
                    service.name == $store.state.application.data.type_transport
                      ? 'bg-blue-1300 border-blue-1300 hover:bg-blue-1200 text-white'
                      : service.disabled
                      ? 'bg-gray-300 border-gray-300 text-gray-500 hover:bg-gray-300'
                      : 'border-blue-1300 hover:bg-blue-1300 hover:text-white'
                  ]"
                  @click="typeSelected(service.name)"
                >
                  <span class="iconify w-10 h-10" :data-icon="service.icon"></span>
                </button>
                <p :class="[service.disabled ? 'text-gray-400' : '', 'text-center']">
                  {{ service.name }}
                </p>
              </div>
              <span
                class="text-xs text-red-600 dark:text-red-400"
                v-if="data.errors.has('type_transport')"
                v-html="data.errors.get('type_transport')"
              ></span>
            </div>
          </form>
        </div>
      </template>
      <template v-slot:footer>
        <a
          href="/applications"
          class="
            w-auto
            px-5
            py-3
            text-sm
            font-medium
            leading-5
            text-gray-700
            transition-colors
            duration-150
            bg-gray-300
            border border-gray-300
            rounded-lg
            dark:text-gray-800
            sm:px-4 sm:py-2 sm:w-auto
            hover:border-gray-400
            focus:border-gray-400
            active:text-gray-400
            focus:outline-none focus:shadow-outline-gray
          "
        >
          Cancelar
        </a>
        <button
          type="submit"
          @click="submitFormApplications()"
          class="
            flex
            transform
            motion-safe:hover:scale-110
            w-auto
            px-5
            py-3
            text-sm
            font-medium
            leading-5
            text-white
            transition-colors
            duration-150
            bg-blue-1300
            border
            border-blue-1300
            rounded-lg
            sm:w-auto sm:px-4 sm:py-2
            hover:bg-blue-1200
            hover:border-blue-1200
            focus:outline-none focus:shadow-outline-blue-1300
          "
          :disabled="busy"
        >
          <svg
            v-if="busy"
            class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
          >
            <circle
              class="opacity-25"
              cx="12"
              cy="12"
              r="10"
              stroke="currentColor"
              stroke-width="4"
            ></circle>
            <path
              class="opacity-75"
              fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
            ></path>
          </svg>
          Aceptar
        </button>
      </template>
    </modal>
  </div>
</template>
<script>
import Loader from '../components/common/utils/Loader.vue';
import Modal from '../components/Modal.vue';
import Container from '../components/Container.vue';
import Transport from '../components/Transport/index.vue';
import FormInternment from '../components/Internment/Form.vue';
import FormPayment from '../components/PaymentProvider/Form.vue';
import InternalStorage from '../components/InternalStorage.vue';
import Exchange from '../components/Exchange';
import servicedefault from '../data/services.json';
import Tabs from '../components/Tabs.vue';
import VueNumeric from 'vue-numeric';
import { mapState, mapMutations } from 'vuex';

export default {
  data() {
    return {
      statusSuppliers: [
        { description: 'Proveedor', name: 'with' },
        // { description: 'Sin Proveedor', name: 'without' },
        { description: 'E-commerce', name: 'E-commerce' }
      ],
      position: 0,
      title: 'Servicios para Cotizacion',
      next: false,
      classStyle: {
        span:
          'ml-15 mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none   dark:text-gray-300 dark:focus:shadow-outline-gray ',
        input:
          'block  text-center  mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none   dark:text-gray-300 dark:focus:shadow-outline-gray',
        wfull: 'w-full',
        formInput: ' form-input',
        label: 'block  text-gray-700 text-xs dark:text-gray-400'
      },
      paymentPercentage1: [
        { name: '10/90', valueInitial: 10 },
        { name: '20/80', valueInitial: 20 },
        { name: '30/70', valueInitial: 30 },
        { name: '40/60', valueInitial: 40 }
      ],
      paymentPercentage2: [
        { name: '100%', valueInitial: 100 },
        { name: 'OTROS', valueInitial: 0 }
      ],
      objectPayment: {
        id: 11,
        name: 'Pagos/Moneda',
        code: 'ICS07',
        selected: true,
        sort: 7
      },
      objectPayment2: {
        code: 'ICS05',
        id: 5,
        name: 'Servicios',
        pivot: {
          application_cond_sale_id: 1,
          category_service_id: 5
        },
        selected: true,
        sort: 5
      },
      buttonService: false
    };
  },
  components: {
    Loader,
    Modal,
    Container,
    Transport,
    FormInternment,
    FormPayment,
    InternalStorage,
    Exchange,
    Tabs,
    VueNumeric
  },
  methods: {
    ...mapMutations('address', ['HIDE_COURIER_QUOTES', 'HIDE_TABLE_FCL_LCL']),
    ...mapMutations('load', ['SHOW_LOAD_CHARGE']),

    selectedService(service) {
      this.$store.dispatch('selectService', service);
      this.$store.dispatch('application/updateService', service);
    },
    deleteService(id) {
      this.$store.dispatch('application/deleteService', id);
    },
    toDisableProviderPayment(value, provider = false) {
      this.clearEcommerceSupplier(provider);
      this.clearSelectedServices();
      if (value == 'without') {
        this.$store.state.application.tabs = this.tabs.map((item) =>
          item.code == 'ICS01' ? { ...item, selected: false } : item
        );
      } else {
        this.$store.state.application.tabs = this.selectedCondition.services;
      }
    },
    clearEcommerceSupplier(provider) {
      if (provider) this.data.ecommerce_url = '';
      this.data.supplier_id = '';
    },
    insertPaymentsToServices() {
      const { selectedServices } = this.$store.state;
      // Verificar si pagos ya esta agregado a servicios
      const exchange = selectedServices.find((e) => e.code == 'ICS07');
      if (!exchange) selectedServices.push(this.objectPayment);

      const findEntrega = selectedServices.find((service) => service.code == 'ICS05');
      const findTransport = selectedServices.find((e) => e.code == 'ICS03');
      if (findEntrega) {
        let positionEntrega = selectedServices.indexOf(this.objectPayment2);
        selectedServices.splice(positionEntrega, 1);
      }
      if (
        !findEntrega &&
        findTransport &&
        this.$store.state.application.data.type_transport !== 'COURIER'
      ) {
        selectedServices.push(this.objectPayment2);
      }
    },
    async submitFormApplications() {
      try {
        this.$store.dispatch('application/busyButton', true);

        //obtener id de la moneda seleccionada antes del submit
        this.data.currency_id = this.$store.state.application.currency.id;
        //obtener solo los codigo de los services
        this.data.services = this.servicesCode;
        // enviar form de data
        const { data } = await this.data.post('/applications');

        if (data) {
          this.insertPaymentsToServices();
          // Mostrar mensaje confirmacion
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Solicitud creada con exito!',
            showConfirmButton: false,
            timer: 1500
          });
          // Ir a la posicion 0 para mostrar el menu
          this.$store.state.tabActive = this.$store.state.selectedServices[
            this.$store.state.positionTabs
          ].code;
          // asignar id devuelta al form id
          this.data.application_id = data.id;
          this.$store.state.application.transfer_abroad = data.transfer_abroad;
          this.$store.dispatch('exchange/getSummary', data.id);

          //  cerrar modal
          this.$store.state.statusModal = !this.$store.state.statusModal;
          //  posicion de modal comienzan en 0
          this.$store.state.positionTabs = 0;

          if (data.supplier_id != null) {
            this.$store.dispatch('address/getOriginTransport', data.supplier_id);
          }
        }
      } catch (error) {
        Toast.fire({
          icon: 'error',
          title: 'Se ha producido un error al procesar los datos'
        });
      } finally {
        this.$store.dispatch('application/busyButton', false);
      }
    },
    clearEcommerceSupplier(provider) {
      if (provider) {
        this.data.ecommerce_url = '';
        this.data.supplier_id = '';
      }
    },
    clearSelectedServices() {
      this.$store.dispatch('clearService');
      // this.$store.state.selectedServices = [];
    },
    handlePercentage(item) {
      this.handleCurrency();
      this.data.valuePercentage = item;
      this.$store.state.payment.discount = item.valueInitial;
    },
    handleCurrency() {
      this.$store.state.payment.payment = [];
      this.$store.state.payment.percentageInitial = 100;
      // this.data.amount = 0;
    },
    toogleMenuTabs() {
      this.clearSelectedServices();
      this.$store.state.application.tabs = this.selectedCondition.services;
      this.data.condition = this.selectedCondition.name;
      this.toDisableProviderPayment(this.data.statusSuppliers);
    },
    typeSelected(value) {
      this.$store.state.application.data.type_transport = value;
      this.$store.state.load.item.mode_selected = value;
      this.$store.dispatch('address/setModeSelected', value);
      this.reset();
    },
    reset() {
      this.$store.state.load.loads = [];
      this.$store.dispatch('load/addLoad', this.$store.state.load.item);
      this.$store.state.load.showLoad = true;
      this.HIDE_COURIER_QUOTES(false);
      this.HIDE_TABLE_FCL_LCL(false);
    }
  },
  computed: {
    ...mapState('application', [
      'tabs',
      'data',
      'agencyElectronic',
      'suppliers',
      'arrayServices',
      'currencies',
      'origin_transport',
      'currency',
      'selectedCondition',
      'typeTransport',
      'busy',
      'transfer_abroad'
    ]),
    servicesCode() {
      return this.$store.state.selectedServices.map((item) => item.code);
    }
  },
  async mounted() {
    this.$store.dispatch('playPauseLoading', true);
    try {
      Promise.all([
        this.$store.dispatch('application/getSuppliers'),
        this.$store.dispatch('application/getServices'),
        this.$store.dispatch('application/getCurrencies'),
        this.$store.dispatch('application/getTypeTransport')
      ]);

      let application = document.getElementById('applications');

      if (application !== null) {
        const id = application.value;
        const { data } = await axios.post('/get-application/' + id);
        Promise.all([
          this.$store.dispatch('application/setData', data),
          this.$store.dispatch('application/getServicesSelecteds', data.services_code.split(','))
        ]);

        this.$store.state.selectedServices = this.tabs.filter((e) => e.checked);
        // this.toogleMenuTabs();
        this.$store.dispatch('payment/setPayment', data.payment_provider);
        this.$store.dispatch('load/setLoad', data);
        this.$store.dispatch('address/setTransport', data);
        this.$store.dispatch('internment/setData', data);
      } else {
        this.$store.state.application.tabs = servicedefault;
      }
    } catch (error) {
      console.error(error);
    } finally {
      this.$store.dispatch('playPauseLoading', false);
    }
  }
};
</script>

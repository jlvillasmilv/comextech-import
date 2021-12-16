<template>
  <div class="w-full p-4">
    <div
      class="mb-5"
      v-show="$store.getters.findService('ICS04') && !$store.getters.findService('ICS03')"
    >
      <Load />
    </div>

    <div
      class="flex flex-wrap -mx-3"
      :class="[!$store.getters.findService('ICS04') ? ' ' : 'justify-center']"
    >
      <section class="container grid px-6 mx-auto">
        <div class="flex justify-between items-end">
          <h4 class="mb-4 text-lg bg-gray-200 text-black-600 dark:text-gray-300">
            Asignación de Agente de Aduana
          </h4>
        </div>

        <div class="px-4 py-4 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
          <div class="md:flex md:items-center my-2">
            <div class="md:w-1/3">
              <input
                v-bind:value="true"
                v-model="expenses.customs_house"
                type="radio"
                class="form-checkbox h-5 w-5 text-blue-600"
              />
              <span class="mx-2 text-xs text-black text-gray-500">
                Comextech
              </span>
              <input
                v-bind:value="false"
                v-model="expenses.customs_house"
                type="radio"
                class="form-checkbox h-5 w-5 text-blue-600"
              />
              <span class="ml-2 text-xs text-black text-gray-500">
                Cliente
              </span>
            </div>
            <div class="flex md:2/3">
              <div class="w-auto px-1 mb-2 md:mb-0">
                <label class="block text-sm " v-if="!expenses.customs_house">
                  <span class="text-gray-700 dark:text-gray-400 font-semibold">
                    Seleccion
                  </span>
                  <select
                    v-model="expenses.custom_agent_id"
                    class="
                      block
                      w-full
                      border border-gray-150
                      text-gray-700
                      p-2
                      mt-1.5
                      pr-8
                      rounded
                      leading-tight
                      focus:outline-none
                      focus:bg-white
                      focus:border-gray-500
                    "
                  >
                    <option v-for="item in custom_agents" :value="item.id" :key="item.id" class="">
                      {{ item.contact_person }}
                    </option>
                  </select>
                  <span
                    class="text-xs text-red-600 dark:text-red-400"
                    v-if="expenses.errors.has('custom_agent_id')"
                    v-html="expenses.errors.get('custom_agent_id')"
                  ></span>
                </label>
                <label class="block text-sm " v-if="expenses.customs_house">
                  <span class="text-gray-700 dark:text-gray-400 font-semibold">
                    Seleccion
                  </span>
                  <select
                    v-model="expenses.custom_agent_id"
                    class="
                      block
                      w-36
                      border border-gray-150
                      text-gray-700
                      p-2
                      mt-1.5
                      pr-8
                      rounded
                      leading-tight
                      focus:outline-none
                      focus:bg-white
                      focus:border-gray-500
                    "
                  >
                    <!-- <option
                                            v-for="item in custom_agents"
                                            :value="item.id"
                                            :key="item.id"
                                            class=""
                                        >
                                            {{ item.contact_person }}
                                        </option> -->
                    <option value="">Asociado</option>
                  </select>
                  <span
                    class="text-xs text-red-600 dark:text-red-400"
                    v-if="expenses.errors.has('custom_agent_id')"
                    v-html="expenses.errors.get('custom_agent_id')"
                  ></span>
                </label>
              </div>

              <div class="w-auto px-1 mb-2 md:mb-0" v-if="!expenses.customs_house">
                <label class="block text-sm">
                  <span class="text-gray-700 dark:text-gray-400 font-semibold">
                    Costo Servicio
                  </span>
                  <input
                    v-model.number="expenses.agent_payment"
                    type="number"
                    class="
                block
                w-full
                mt-1
                text-sm
                dark:border-gray-600
                dark:bg-gray-700
                focus:border-blue-400
                focus:outline-none
                focus:shadow-outline-blue
                dark:text-gray-300
                dark:focus:shadow-outline-gray
                form-input
              "
                    placeholder="Monto"
                  />
                  <span
                    class="text-xs text-red-600 dark:text-red-400"
                    v-if="expenses.errors.has('agent_payment')"
                    v-html="expenses.errors.get('agent_payment')"
                  ></span>
                </label>
              </div>
              <div class="w-auto px-1 mx-4 mb-2 md:mb-0" v-if="expenses.customs_house">
                <label class="block text-sm">
                  <span class="text-gray-700 dark:text-gray-400 font-semibold">
                    Costo Servicio
                  </span>
                  <!-- <input
                                        v-model.number="expenses.agent_payment"
                                        type="number"
                                        class="
                block
                w-full
                mt-1
                text-sm
                dark:border-gray-600
                dark:bg-gray-700
                focus:border-blue-400
                focus:outline-none
                focus:shadow-outline-blue
                dark:text-gray-300
                dark:focus:shadow-outline-gray
                form-input
              "
                                        placeholder="Monto"
                                    /> -->
                  <div class="flex items-center">
                    <span class="mx-2">USD</span>
                    <input
                      value="250"
                      type="number"
                      class="
                block
                w-36
                mt-1
                text-sm
                dark:border-gray-600
                dark:bg-gray-700
                focus:border-blue-400
                focus:outline-none
                focus:shadow-outline-blue
                dark:text-gray-300
                dark:focus:shadow-outline-gray
                form-input
              "
                      placeholder="Monto"
                    />
                    <span
                      class="text-xs text-red-600 dark:text-red-400"
                      v-if="expenses.errors.has('agent_payment')"
                      v-html="expenses.errors.get('agent_payment')"
                    ></span>
                  </div>
                </label>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="container grid px-6 mx-auto">
        <div class="flex justify-between items-end">
          <h4 class="mb-4 text-lg bg-gray-200 text-black-600 dark:text-gray-300">
            Documentos necesarios
          </h4>
        </div>
        <div
          class="flex flex-wrap justify-center py-4 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800"
        >
          <div class="w-auto px-1 px-3">
            <input
              id="filecert"
              v-show="showInputFile"
              @change="certificateFile()"
              ref="file_cert"
              type="file"
              hidden
            />
            <div class="text-gray-600 dark:text-gray-400 flex space-x-5 justify-start">
              <label v-for="(item, key) in certif" :key="key" class="inline-flex items-center mt-3">
                <a
                  @click="openWindowFileCert(item)"
                  class="
                flex
                px-2
                py-2
                m-2
                text-sm
                font-medium
                leading-5
                text-white
                transition-colors
                duration-150
                border border-transparent
                rounded-lg
                focus:outline-none
                focus:shadow-outline-blue
              "
                  :class="[
                    item.submit ? 'bg-red-500 hover:bg-red-800' : 'bg-blue-500 hover:bg-blue-800'
                  ]"
                  ><svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    class="h-6 w-6"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      :d="[
                        item.submit
                          ? 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'
                          : 'M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z'
                      ]"
                    ></path>
                  </svg>
                  <span> {{ item.name }} </span>
                </a>
              </label>
            </div>
            <span
              class="text-xs text-red-600 dark:text-red-400"
              v-if="expenses.errors.has('file_certificate')"
              v-html="expenses.errors.get('file_certificate')"
            ></span>
          </div>
          <div class="w-auto px-1 px-3">
            <input
              id="fileid"
              v-show="showInputFile"
              @change="handleFile()"
              ref="file"
              type="file"
              hidden
            />
            <div class="text-gray-600 dark:text-gray-400 flex space-x-5 justify-start">
              <label
                v-for="(item, key) in treaties"
                :key="key"
                class="inline-flex items-center mt-3"
              >
                <a
                  @click="openWindowFile(item)"
                  class="
                flex
                px-2
                py-2
                m-2
                text-sm
                font-medium
                leading-5
                text-white
                transition-colors
                duration-150
                border border-transparent
                rounded-lg
                focus:outline-none
                focus:shadow-outline-blue
              "
                  :class="[
                    item.submit ? 'bg-red-500 hover:bg-red-800' : 'bg-blue-500 hover:bg-blue-800'
                  ]"
                  ><svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    class="h-6 w-6"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      :d="[
                        item.submit
                          ? 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'
                          : 'M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z'
                      ]"
                    ></path>
                  </svg>
                  <span> {{ item.name }} </span></a
                >
              </label>
            </div>

            <span
              class="text-xs text-red-600 dark:text-red-400"
              v-if="expenses.errors.has('file_descrip')"
              v-html="expenses.errors.get('file_descrip')"
            ></span>
          </div>
          <div class="w-auto px-1 px-3">
            <input
              id="fileid"
              v-show="showInputFile"
              @change="handleFile()"
              ref="file"
              type="file"
              hidden
            />
            <div class="text-gray-600 dark:text-gray-400 flex space-x-5 justify-start">
              <label
                v-for="(item, key) in treaties"
                :key="key"
                class="inline-flex items-center mt-3"
              >
                <a
                  @click="openWindowFile(item)"
                  class="
                flex
                px-2
                py-2
                m-2
                text-sm
                font-medium
                leading-5
                text-white
                transition-colors
                duration-150
                border border-transparent
                rounded-lg
                focus:outline-none
                focus:shadow-outline-blue
              "
                  :class="[
                    item.submit ? 'bg-red-500 hover:bg-red-800' : 'bg-blue-500 hover:bg-blue-800'
                  ]"
                  ><svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    class="h-6 w-6"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      :d="[
                        item.submit
                          ? 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'
                          : 'M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z'
                      ]"
                    ></path>
                  </svg>
                  <span> {{ item.name }} </span></a
                >
              </label>
            </div>

            <span
              class="text-xs text-red-600 dark:text-red-400"
              v-if="expenses.errors.has('file_descrip')"
              v-html="expenses.errors.get('file_descrip')"
            ></span>
          </div>
        </div>
      </section>
    </div>

    <section class="container grid px-6 mx-auto">
      <div class="flex justify-between items-end">
        <h4 class="mb-4 text-lg bg-gray-200 text-black-600 dark:text-gray-300">
          Cálculo de Impuestos
        </h4>
      </div>

      <div
        class="mx-10 w-2/3 flex"
        :class="[!$store.getters.findService('ICS04') ? '' : 'justify-start']"
      >
        <div class="w-full overflow-x-auto">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr
                class="
                    text-center
                    font-semibold
                    tracking-wide
                    border-b
                    dark:border-gray-700
                    dark:text-gray-400
                    dark:bg-gray-800
                  "
              >
                <th>
                  Moneda Dólar
                </th>
                <th>
                  &nbsp;
                </th>
                <th>
                  &nbsp;
                </th>
                <th colspan="2">
                  Moneda de Origen
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">{{ formatPrice(AppAmount, 'USD') }}</td>
                <td class="px-4 py-3">USD</td>
                <td class="px-4 py-3">Mercaderia</td>
                <td class="px-4 py-3">
                  {{ formatPrice(data.amount, currency.code) }}
                </td>
                <td class="px-4 py-3">{{ currency.code }}</td>
              </tr>
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">{{ formatPrice(transpAmount, 'USD') }}</td>
                <td class="px-4 py-3">USD</td>
                <td class="px-4 py-3">Transporte</td>
                <td class="px-4 py-3">
                  {{ formatPrice(transpAmount, 'USD') }}
                </td>
                <td class="px-4 py-3">USD</td>
              </tr>
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">{{ formatPrice(this.expenses.insure) }}</td>
                <td class="px-4 py-3">USD</td>
                <td class="px-4 py-3">Seguro</td>
                <td class="px-4 py-3">
                  {{ formatPrice(this.expenses.insure) }}
                </td>
                <td class="px-4 py-3">USD</td>
              </tr>
              <tr class="bg-gray-100">
                <td class="text-blue-700 font-semibold px-4 py-3">
                  {{ formatPrice(this.expenses.insure + transpAmount + AppAmount, 'USD') }}
                </td>
                <td class="text-blue-700 font-semibold px-4 py-3">
                  USD
                </td>
                <td class="text-blue-700 font-semibold px-4 py-3">
                  Valor CIF
                </td>
              </tr>
            </tbody>
            <!-- <tfoot
                            class="divide-y dark:divide-gray-700 dark:bg-gray-800"
                        >
                            <tr>
                                <td class="px-4 py-3">
                                    {{ formatPrice(expenses.cif_amt, 'CLP') }}
                                </td>
                                <td class="px-4 py-3">USD</td>
                                <td class="px-4 py-3">Valor CIF</td>
                            </tr>
                        </tfoot> -->
          </table>
        </div>
      </div>
      <div
        class="flex my-8"
        :class="[!$store.getters.findService('ICS04') ? ' ' : 'justify-start']"
      >
        <div class="flex flex-wrap flex-col my-2 w-10/12">
          <div class="flex justify-start items-center h-28 my-2">
            <div>
              <input
                type="checkbox"
                v-model="expenses.iva"
                class="form-checkbox h-5 w-5 text-blue-600"
              />
            </div>
            <div class="w-2/12">
              <p :class="[expenses.iva ? 'text-center mx-2' : 'text-center mx-2 text-gray-400']">
                {{ formatPrice(expenses.iva_amt, 'CLP') }}
              </p>
            </div>
            <div class="w-3/12">
              <h1 :class="[expenses.iva ? 'text-center mx-4' : 'text-center mx-4 text-gray-400']">
                IVA ( 19% )
              </h1>
            </div>
            <div class="w-2/12">
              <img class="h-full w-8/12" src="https://homer.sii.cl/responsive/images/logo.jpg" />
            </div>
            <div class="w-2/12">
              <button
                v-if="!expenses.iva"
                class="disabled:opacity-100 w-full h-10 text-white text-sm bg-gray-300 rounded-lg"
                disabled
              >
                No Financiar
              </button>
              <button
                v-if="expenses.iva"
                class="w-full h-10 text-white transition-colors text-sm duration-150 bg-gray-400 rounded-lg focus:shadow-outline hover:bg-gray-500"
              >
                No Financiar
              </button>
            </div>
          </div>
          <div class="flex justify-start items-center h-28 my-2">
            <div>
              <input
                type="checkbox"
                v-model="expenses.adv"
                class="form-checkbox h-5 w-5 text-blue-600"
              />
            </div>
            <div class="w-2/12">
              <p :class="[expenses.adv ? 'text-center mx-2' : 'text-center text-gray-400 mx-2']">
                {{ formatPrice(expenses.adv_amt, 'CLP') }}
              </p>
            </div>
            <div class="w-3/12">
              <h1 :class="[expenses.adv ? 'text-center mx-4' : 'text-center text-gray-400 mx-4']">
                Ad Valorem ( 6% )
              </h1>
            </div>
            <div class="w-2/12">
              <img
                class="h-full w-8/12"
                src="https://user-images.githubusercontent.com/53098149/132052671-8d382ada-a5c1-4d73-8c04-1b3112a793f7.jpeg"
              />
            </div>
            <div class="w-2/12">
              <button
                v-if="!expenses.adv"
                class="disabled:opacity-100 w-full h-10 text-white text-sm bg-gray-300 rounded-lg"
                disabled
              >
                Financiar
              </button>
              <button
                v-if="expenses.adv"
                class="w-full h-10 text-white transition-colors text-sm duration-150 bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800"
              >
                Financiar
              </button>
            </div>
          </div>
        </div>
        <!-- <div class="flex">
                    <div class="w-1/7 ml-8 mr-3">
                        <div class="w-1/7 space-y-9"></div>
                    </div>
                </div> -->
      </div>
      <div class="flex justify-center">
        <button
          @click="submitForm()"
          class="
          w-1/6
          h-12
          my-10
          text-white
          transition-colors
          text-lg
          duration-150
          bg-blue-700
          rounded-lg
          focus:shadow-outline
          hover:bg-green-800
        "
        >
          Guardar
        </button>
      </div>
    </section>
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex';
import Load from '../Transport/Load.vue';

export default {
  props: {
    application_id: {
      required: true,
      type: Number
    }
  },
  components: { Load },
  computed: {
    ...mapState('internment', ['expenses']),
    ...mapState('application', ['data', 'currency']),
    ...mapState('exchange', ['exchangeItem'])
  },
  data() {
    return {
      certif: [
        {
          name: 'Cargar Invoice',
          submit: false
        }
      ],
      treaties: [
        {
          name: 'Otro Documento',
          submit: false
        }
      ],
      certificate: {},
      custom_agents: [],
      showInputFile: false,
      nameFileUpload: '',
      transpAmount: 0,
      AppAmount: 0
    };
  },
  methods: {
    formatPrice(value, currency) {
      return Number(value).toLocaleString(navigator.language, {
        minimumFractionDigits: currency == 'CLP' ? 0 : 2,
        maximumFractionDigits: currency == 'CLP' ? 0 : 2
      });
    },
    changeCustomHouse() {},
    openWindowFile({ e, name: entry }) {
      this.nameFileUpload = entry;
      let value = this.treaties.find((a) => a.name == entry);
      if (!value.submit) {
        this.showInputFile = !this.showInputFile;
        let fileInputElement = this.$refs.file;
        fileInputElement.click();
      } else {
        this.handleStatusSubmitFile();
      }
    },
    openWindowFileCert({ e, name: entry }) {
      this.nameFileUpload = entry;
      let value = this.certif.find((a) => a.name == entry);
      if (!value.submit) {
        this.showInputFile = !this.showInputFile;
        let fileInputElement = this.$refs.file_cert;
        fileInputElement.click();
      } else {
        this.handleStatusCertificate();
      }
    },
    certificateFile() {
      const file = this.$refs.file_cert.files[0];
      if (file) {
        this.handleStatusCertificate();
        this.expenses.file_certificate = file;
        this.certificate = this.nameFileUpload;
      }
    },
    handleFile() {
      const file = this.$refs.file.files[0];
      if (file) {
        this.handleStatusSubmitFile();
        this.expenses.files.append(this.nameFileUpload, file);
        this.expenses.file_descrip.push(this.nameFileUpload);
      }
    },
    handleStatusSubmitFile(ref = null) {
      this.treaties = this.treaties.map((e) =>
        e.name === this.nameFileUpload ? { ...e, submit: !e.submit } : e
      );
    },
    handleStatusCertificate(ref = null) {
      this.certif = this.certif.map((e) =>
        e.name === this.nameFileUpload ? { ...e, submit: !e.submit } : e
      );
    },
    previewFiles(event) {
      const certificate = event.target.files[0];
      this.expenses.file_certificate = certificate;
    },
    async submitForm() {
      try {
        this.expenses.dataLoad = this.$store.state.load.loads;
        // console.log(
        //     this.$store.state.load.loads,
        //     ' ENVIO DE INTERNAMIA'
        // );
        const { data } = await this.expenses.post('/internment');
        Toast.fire({
          icon: 'success',
          title: 'Datos Agregados'
        });
        this.$store.dispatch('exchange/getSummary', this.data.application_id);
        if (!$store.getters.findService('ICS03')) {
          this.$store.dispatch('load/setLoad', data);
        }

        this.$store.dispatch('callIncomingOrNextMenu', true);
      } catch (error) {
        console.error(error);
      }
    }
  },
  watch: {
    'expenses.customs_house': {
      handler(after, before) {
        this.expenses.custom_agent_id = '';
        this.expenses.agent_payment = 0;
      },
      deep: true
    }
  },
  async mounted() {
    try {
      // agente de Aduana del cliente
      let agents = await axios.get('/agentslist');
      this.custom_agents = agents.data;
      //asignar id de solicitud
      this.expenses.application_id = this.application_id;
      this.expenses.transport = !this.$store.getters.findService('ICS03');
      // /custom-convert-currency
      const transp_cost = this.exchangeItem.find((tic) => tic.code === 'CS03-01');
      const insure_cost = this.exchangeItem.find((ic) => ic.code === 'CS03-02');

      this.expenses.insure = Number(insure_cost.amount);
      this.expenses.cif_amt = Number(this.data.amount);
      this.transpAmount = Number(transp_cost.amount);
      this.AppAmount = Number(this.data.amount);

      if (this.AppAmount > 0 && this.currency.code != 'USD') {
        const app_usd = await axios.get(
          `/api/convert-currency/${this.AppAmount}/${this.currency.code}/USD`
        );

        this.AppAmount = app_usd.data;
      }

      if (this.expenses.insure > 0 && this.currency.code != 'CLP') {
        const insure_clp = await axios.get(
          `/custom-convert-currency/${this.expenses.insure}/${this.currency.code}`
        );

        this.expenses.insure = insure_clp.data;
        this.expenses.cif_amt += insure_clp.data;
      }

      if (this.currency.code != 'CLP') {
        const commodity = await axios.get(
          `/custom-convert-currency/${this.expenses.cif_amt}/${this.currency.code}`
        );

        this.expenses.cif_amt = commodity.data;
      }

      if (transp_cost.amount > 0) {
        const transp = await axios.get(`/custom-convert-currency/${transp_cost.amount}/USD`);

        this.expenses.cif_amt += transp.data;
      }

      this.expenses.iva_amt = Math.round((this.expenses.cif_amt * 19) / 100);
      this.expenses.adv_amt = (this.expenses.cif_amt * 6) / 100;
    } catch (error) {
      console.log(error);
    }
  }
};
</script>

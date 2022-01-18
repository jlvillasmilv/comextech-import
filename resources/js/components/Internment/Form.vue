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

        <div class="px-4 py-2 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
          <div class="md:flex md:items-center my-2">
            <div class="md:w-auto">
              <input
                v-bind:value="true"
                v-model="expenses.customs_house"
                type="radio"
                class="form-checkbox h-5 w-5 text-blue-600"
                :disabled="expenses.courier_svc"
              />
              <span class="mx-2 text-xs text-black text-gray-500"> Comextech </span>
              <input
                v-bind:value="false"
                v-model="expenses.customs_house"
                type="radio"
                class="form-checkbox h-5 w-5 text-blue-600"
                :disabled="expenses.courier_svc"
              />
              <span class="ml-2 text-xs text-black text-gray-500"> Cliente </span>
            </div>

            <div class="md:w-1/5" v-if="expenses.courier_svc">
              <input
                v-bind:value="true"
                v-model="expenses.courier_svc"
                type="radio"
                class="form-checkbox h-5 w-5 text-blue-600"
                checked
              />
              <span class="mx-2 text-xs text-black text-gray-500"> Servicio incluido </span>
            </div>

            <div class="flex md:1/2">
              <div class="w-1/2 px-1 mb-2 md:mb-0">
                <label class="block text-sm" v-if="expenses.courier_svc">
                  <span class="text-gray-700 dark:text-gray-400 font-semibold"> Courier </span>
                  <select
                    v-model="expenses.trans_company_id"
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
                      focus:outline-none focus:bg-white focus:border-gray-500
                    "
                  >
                    <option
                      v-for="item in trans_companies"
                      :value="item.id"
                      :key="item.id"
                      class=""
                    >
                      {{ item.name }}
                    </option>
                  </select>
                  <span
                    class="text-xs text-red-600 dark:text-red-400"
                    v-if="expenses.errors.has('trans_company_id')"
                    v-html="expenses.errors.get('trans_company_id')"
                  ></span>
                </label>

                <label class="block text-sm" v-if="!expenses.courier_svc">
                  <span class="text-gray-700 dark:text-gray-400 font-semibold"> Seleccion </span>
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
                      focus:outline-none focus:bg-white focus:border-gray-500
                    "
                  >
                    <template v-if="!expenses.customs_house">
                      <option
                        v-for="item in custom_agents"
                        :value="item.id"
                        :key="item.id"
                        class=""
                      >
                        {{ item.contact_person }}
                      </option>
                    </template>

                    <option v-if="expenses.customs_house" value="">Asociado</option>
                  </select>
                  <span
                    class="text-xs text-red-600 dark:text-red-400"
                    v-if="expenses.errors.has('custom_agent_id')"
                    v-html="expenses.errors.get('custom_agent_id')"
                  ></span>
                </label>
              </div>

              <div class="w-auto px-1 mx-4 mb-2 md:mb-0">
                <label class="block text-sm">
                  <span class="text-gray-700 dark:text-gray-400 font-semibold">
                    Costo Servicio
                  </span>
                  <span class="mx-2">USD</span>
                  <input
                    v-model.number="expenses.agent_payment"
                    type="number"
                    class="
                      block
                      w-full
                      mt-1
                      text-sm
                      dark:border-gray-600 dark:bg-gray-700
                      focus:border-blue-400 focus:outline-none focus:shadow-outline-blue
                      dark:text-gray-300 dark:focus:shadow-outline-gray
                      form-input
                    "
                    :disabled="expenses.customs_house ? true : false"
                    placeholder="Monto"
                  />
                  <span
                    class="text-xs text-red-600 dark:text-red-400"
                    v-if="expenses.errors.has('agent_payment')"
                    v-html="expenses.errors.get('agent_payment')"
                  ></span>
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
          class="
            flex flex-wrap
            justify-center
            py-4
            mb-8
            bg-white
            rounded-lg
            shadow-md
            dark:bg-gray-800
          "
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
                    focus:outline-none focus:shadow-outline-blue
                  "
                  :class="[
                    item.submit ? 'bg-red-500 hover:bg-red-800' : 'bg-blue-500 hover:bg-blue-800',
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
                          : 'M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z',
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
                    focus:outline-none focus:shadow-outline-blue
                  "
                  :class="[
                    item.submit ? 'bg-red-500 hover:bg-red-800' : 'bg-blue-500 hover:bg-blue-800',
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
                          : 'M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z',
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
                    focus:outline-none focus:shadow-outline-blue
                  "
                  :class="[
                    item.submit ? 'bg-red-500 hover:bg-red-800' : 'bg-blue-500 hover:bg-blue-800',
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
                          : 'M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z',
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

    <section class="container grid px-3">
      <div class="flex justify-between items-end">
        <h4 class="mb-4 text-lg bg-gray-200 text-black-600 dark:text-gray-300">
          Cálculo de Impuestos
        </h4>
      </div>

      <div
        class="mx-4 w-3/4 flex"
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
                  dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800
                "
              >
                <th>Moneda Dólar</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th colspan="2">Moneda de Origen</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">{{ formatPrice(AppAmount, 'USD') }}</td>
                <td class="px-4 py-3">USD</td>
                <td class="px-4 py-3">Mercaderia</td>
                <td rowspan="3" class="px-4">
                  <div class="flex justify-center">
                    <svg
                      class="w-8 h-8"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                        clip-rule="evenodd"
                      ></path>
                    </svg>
                  </div>
                </td>
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
                  <span v-if="transport">
                    <input
                      v-model.number="transpAmount"
                      type="number"
                      class="
                        block
                        w-full
                        mt-1
                        text-sm
                        dark:border-gray-600 dark:bg-gray-700
                        focus:border-blue-400 focus:outline-none focus:shadow-outline-blue
                        dark:text-gray-300 dark:focus:shadow-outline-gray
                        form-input
                      "
                      placeholder="Monto Transporte"
                    />
                  </span>
                  <span v-else>
                    {{ formatPrice(transpAmount, 'USD') }}
                  </span>
                </td>
                <td class="px-4 py-3">USD</td>
              </tr>
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                  {{ formatPrice(this.insureAmount) }}
                </td>
                <td class="px-4 py-3">USD</td>
                <td class="px-4 py-3">Seguro</td>
                <td class="px-4 py-3">
                  <span v-if="insure">
                    <input
                      v-model.number="insureAmount"
                      type="number"
                      class="
                        block
                        w-full
                        mt-1
                        text-sm
                        dark:border-gray-600 dark:bg-gray-700
                        focus:border-blue-400 focus:outline-none focus:shadow-outline-blue
                        dark:text-gray-300 dark:focus:shadow-outline-gray
                        form-input
                      "
                      placeholder="Monto Seguro"
                    />
                  </span>
                  <span v-else>
                    {{ formatPrice(this.insureAmount) }}
                  </span>
                </td>
                <td class="px-4 py-3">USD</td>
              </tr>
              <tr class="bg-gray-100">
                <td class="text-blue-700 font-semibold px-4 py-3">
                  {{ expenses.cif_amt }}
                </td>
                <td class="text-blue-700 font-semibold px-4 py-3">USD</td>
                <td class="text-blue-700 font-semibold px-4 py-3">Valor CIF</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div
        class="flex my-4"
        :class="[!$store.getters.findService('ICS04') ? ' ' : 'justify-start']"
      >
        <div class="flex flex-wrap flex-col w-10/12">
          <span class="text-start font-semibold">Incluir</span>
          <div class="flex justify-start items-center my-4 ml-2">
            <div>
              <input
                type="checkbox"
                v-model="expenses.iva"
                class="form-checkbox h-5 w-5 text-blue-600"
              />
            </div>
            <div class="w-3/12">
              <p :class="[expenses.iva ? 'text-center mx-2' : 'text-center mx-2 text-gray-400']">
                {{ formatPrice(expenses.iva_amt, 'CLP') }} CLP
              </p>
            </div>
            <div class="w-4/12">
              <h1 :class="[expenses.iva ? 'text-center mx-4' : 'text-center mx-4 text-gray-400']">
                IVA ( 19% )
              </h1>
            </div>
            <div class="w-2/12">
              <img class="h-full w-8/12" src="https://homer.sii.cl/responsive/images/logo.jpg" />
            </div>
          </div>
          <div class="flex justify-start items-center my-4 ml-2">
            <div>
              <input
                type="checkbox"
                v-model="expenses.adv"
                class="form-checkbox h-5 w-5 text-blue-600"
              />
            </div>
            <div class="w-3/12">
              <p :class="[expenses.adv ? 'text-center mx-2' : 'text-center text-gray-400 mx-2']">
                {{ formatPrice(expenses.adv_amt, 'CLP') }} CLP
              </p>
            </div>
            <div class="w-4/12">
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
          </div>
        </div>
      </div>
      <div class="flex justify-start" v-if="data.type_transport != 'COURIER'">
        <div class="items-center ml-2 w-1/2">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr
                class="
                  text-left
                  font-semibold
                  tracking-wide
                  border-b
                  dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800
                "
              >
                <th class="px-4 py-1 bg-gray-200 text-black-600 dark:text-gray-300" colspan="2">
                  Gastos de Puerto
                </th>
              </tr>
            </thead>
            <tbody
              v-if="data.type_transport == 'CONSOLIDADO'"
              class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
            >
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">{{ formatPrice(docMgmtLcl, 'USD') }} USD</td>
                <td class="px-4 py-3">Gestión Documental (por cada BL)</td>
              </tr>
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">{{ formatPrice(docVisaLcl, 'USD') }} USD</td>
                <td class="px-4 py-3">Visación documental (por cada BL)</td>
              </tr>
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">{{ formatPrice(dispatchLcl, 'USD') }} USD</td>
                <td class="px-4 py-3">Despacho (por Ton&M3)</td>
              </tr>
            </tbody>
            <tbody
              v-if="data.type_transport == 'CONTAINER'"
              class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
            >
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">{{ formatPrice(docMgmtFcl, 'USD') }} USD</td>
                <td class="px-4 py-3">Gestión Documental (por cada BL)</td>
              </tr>
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">{{ formatPrice(loanFcl, 'USD') }} USD</td>
                <td class="px-4 py-3">Comodato ( X Conteiner)</td>
              </tr>
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">{{ formatPrice(gateInFcl, 'USD') }} USD</td>
                <td class="px-4 py-3">Gate In ( X Conteiner)</td>
              </tr>
            </tbody>
            <tfoot>
              <tr class="bg-gray-100">
                <td class="text-center text-blue-700 font-semibold px-4 py-3">
                  {{ formatPrice(expenses.port_charges, 'USD') }} USD
                </td>
                <td class="text-blue-700 font-semibold px-4 py-3">
                  Gastos de Puerto {{ data.type_transport == 'CONTAINER' ? 'FCL' : 'LCL' }}
                </td>
              </tr>
            </tfoot>
          </table>
        </div>
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
import { mapState } from 'vuex';
import Load from '../Transport/Load.vue';

export default {
  props: {
    application_id: {
      required: true,
      type: Number,
    },
  },
  components: { Load },
  computed: {
    ...mapState('internment', ['expenses']),
    ...mapState('application', ['data', 'currency']),
    ...mapState('exchange', ['exchangeItem']),
  },

  data() {
    return {
      certif: [
        {
          name: 'Cargar Invoice',
          submit: false,
        },
      ],
      treaties: [
        {
          name: 'Otro Documento',
          submit: false,
        },
      ],
      certificate: {},
      custom_agents: [],
      trans_companies: [],
      showInputFile: false,
      nameFileUpload: '',
      transpAmount: 0,
      insureAmount: 0,
      AppAmount: 0,
      docMgmtFcl: 25,
      loanFcl: 120,
      gateInFcl: 120,
      docMgmtLcl: 195,
      docVisaLcl: 30,
      dispatchLcl: 30,
      insure: false,
      transport: false,
    };
  },
  methods: {
    formatPrice(value, currency) {
      return Number(value).toLocaleString(navigator.language, {
        minimumFractionDigits: currency == 'CLP' ? 0 : 2,
        maximumFractionDigits: currency == 'CLP' ? 0 : 2,
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

        const { data } = await this.expenses.post('/internment');
        Toast.fire({
          icon: 'success',
          title: 'Datos Agregados',
        });
       

        if (!this.$store.getters.findService('ICS03')) {
          this.$store.dispatch('load/setLoad', data);
        }

        this.$store.dispatch('callIncomingOrNextMenu', true);
      } catch (error) {
        console.error(error);
      }
    },

    async taxCheck() {
      this.expenses.cif_amt = parseFloat(
        Number(this.AppAmount) + Number(this.transpAmount) + Number(this.insureAmount)
      ).toFixed(2);

      this.expenses.insurance = Number(this.insureAmount);
      this.expenses.transport_amt = Number(this.transpAmount);

      let cif_clp = await axios.get(`/custom-convert-currency/${this.expenses.cif_amt}/USD`);

      if (cif_clp.data <= 0) {
        cif_clp = await axios.get(`/api/convert-currency/${this.expenses.cif_amt}/USD/CLP`);
      }

      this.expenses.iva_amt = cif_clp.data * (19 / 100);
      this.expenses.adv_amt = cif_clp.data * (6 / 100);
    },

    async portCharge() {
      // get default amount
      let settings = await axios.get('/settings');

      if (settings.status == 200) {
        this.docMgmtFcl = parseInt(settings.data.doc_mgmt_fcl);
        this.loanFcl = parseInt(settings.data.loan_fcl);
        this.gateInFcl = parseInt(settings.data.gate_in_fcl);

        this.docMgmtLcl = parseInt(settings.data.doc_mgmt_lcl);
        this.docVisaLcl = parseInt(settings.data.doc_visa_lcl);
        this.dispatchLcl = parseInt(settings.data.dispatch_lcl);
      }

      this.expenses.port_charges = 0;

      if (this.data.type_transport == 'CONSOLIDADO') {
        const cargoCBM = this.$store.state.load.loads
          .map((item) => item.cbm)
          .reduce((prev, curr) => parseInt(prev) + parseInt(curr), 0);

        const cargoW = this.$store.state.load.loads
          .map((item) => item.weight)
          .reduce((prev, curr) => parseInt(prev) + parseInt(curr), 0);

        this.expenses.port_charges =
          (cargoCBM > cargoW ? cargoCBM : cargoW / 1000) * this.dispatchLcl +
          this.docMgmtLcl +
          this.docVisaLcl;
      }

      if (this.data.type_transport == 'CONTAINER') {
        this.expenses.port_charges = this.docMgmtFcl + this.loanFcl + this.gateInFcl;
      }
      // console.log(this.expenses.port_charges)
    },
  },
  watch: {
    'expenses.customs_house': {
      handler(after, before) {
        this.expenses.custom_agent_id = '';

        this.expenses.agent_payment = this.data.type_transport == 'COURIER' ? 0 : 250;
      },
      deep: true,
    },
    insureAmount: function (after, before) {
      this.debouncedGetTaxs();
    },
    transpAmount: function (after, before) {
      this.debouncedGetTaxs();
    },
    AppAmount: function (after, before) {
      this.debouncedGetTaxs();
    },
  },
  async mounted() {
    try {
      // agente de Aduana del cliente
      let agents = await axios.get('/agentslist');
      this.custom_agents = agents.data;

      // agente de Aduana del cliente
      const transCompanies = await axios.get('/api/category_load');
      this.trans_companies = transCompanies.data;

      if (this.data.type_transport == 'COURIER') {
        this.expenses.courier_svc = true;
        this.expenses.trans_company_id =
          this.$store.state.address.expenses.trans_company_id == ''
            ? 2
            : this.$store.state.address.expenses.trans_company_id;
      }

      //asignar id de solicitud
      this.expenses.application_id = this.application_id;
      this.expenses.transport = !this.$store.getters.findService('ICS03');
      // /custom-convert-currency
      const transp_cost = this.exchangeItem.find((tic) => tic.code === 'CS03-01');
      const insure_cost = this.exchangeItem.find((ic) => ic.code === 'CS03-02');

      this.insureAmount =
        Number(insure_cost.amount) == 0 ? this.expenses.insurance : Number(insure_cost.amount);
      this.transpAmount =
        Number(transp_cost.amount) == 0 ? this.expenses.transport_amt : Number(transp_cost.amount);
      this.AppAmount = Number(this.data.amount);

      this.insure = !this.$store.getters.findService('ICS03') ? true : false;
      this.transport = !this.$store.getters.findService('ICS03') ? true : false;

      if (this.AppAmount > 0 && this.currency.code != 'USD') {
        const app_usd = await axios.get(
          `/api/convert-currency/${this.AppAmount}/${this.currency.code}/USD`
        );

        this.AppAmount = app_usd.data;
      }

      this.taxCheck();

      if (this.data.type_transport != 'COURIER' || this.data.type_transport != 'TERRESTRE') {
        this.portCharge();
      }
    } catch (error) {
      console.error(error);
    }
  },
  created: function () {
    this.debouncedGetTaxs = _.debounce(this.taxCheck, 500);
    this.expenses.agent_payment = this.data.type_transport == 'COURIER' ? 0 : 250;
  },
};
</script>

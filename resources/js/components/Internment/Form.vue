<template>
  <section class="lg:flex lg:flex-col items-center justify-center w-full p-4">
    <loader />
    <!-- <div
      class="lg:w-8/12 p-4 bg-white rounded-lg shadow-md dark:bg-gray-800 mb-5"
      v-show="$store.getters.findService('ICS04') && !$store.getters.findService('ICS03')"
    >
      <load />
    </div> -->

    <div class="lg:w-10/12 flex flex-wrap justify-center -mx-3">
      <!-- asignacion de aduana -->
      <div class="flex flex-col w-full">
        <div class="flex justify-between items-end">
          <h2 class="mb-1 text-xl text-blue-1300 font-semibold">
            Asignación de Agente de Aduana
          </h2>
        </div>

        <div class="py-8 mb-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
          <div class="lg:flex lg:items-center my-1 px-8">
            <div class="px-1 lg:flex lg:flex-col lg:w-3/12">
              <div>
                <input
                  v-if="
                    data.type_transport !== 'COURIER' ||
                      (data.type_transport === 'COURIER' && amountsDollar.AppAmount >= 3000)
                  "
                  v-model="expenses.customs_house"
                  :value="true"
                  type="radio"
                  class="form-checkbox h-5 w-5 text-blue-600"
                />
                <input
                  v-if="data.type_transport === 'COURIER' && amountsDollar.AppAmount <= 2999"
                  type="radio"
                  class="form-checkbox h-5 w-5 text-blue-600"
                  disabled
                />
                <span class="mx-2 text-xs text-gray-500"> Comextech </span>
              </div>
              <div>
                <input
                  v-if="
                    data.type_transport !== 'COURIER' ||
                      (data.type_transport === 'COURIER' && amountsDollar.AppAmount >= 3000)
                  "
                  v-model="expenses.customs_house"
                  :value="false"
                  type="radio"
                  class="form-checkbox h-5 w-5 text-blue-600"
                />
                <input
                  v-if="data.type_transport === 'COURIER' && amountsDollar.AppAmount <= 2999"
                  type="radio"
                  class="form-checkbox h-5 w-5 text-blue-600"
                  disabled
                />
                <span class="mx-2 text-xs text-gray-500">Cliente</span>
              </div>
              <div v-if="data.type_transport === 'COURIER'">
                <input
                  v-if="amountsDollar.AppAmount <= 2999"
                  v-model="expenses.courier_svc"
                  :value="true"
                  type="radio"
                  class="form-checkbox h-5 w-5 text-blue-600"
                  :disabled="expenses.courier_svc && amountsDollar.AppAmount >= 2999"
                />
                <input
                  v-if="amountsDollar.AppAmount >= 3000"
                  type="radio"
                  class="form-checkbox h-5 w-5 text-blue-600"
                  disabled
                />
                <span class="mx-2 text-xs text-gray-500"> Servicio incluido </span>
              </div>
            </div>

            <div class="my-5 lg:my-0 lg:flex lg:justify-center lg:w-9/12">
              <div class="lg:w-5/12 xl:w-5/12 px-1 mb-2 lg:mb-0">
                <label
                  class="block text-sm"
                  v-if="data.type_transport === 'COURIER' && amountsDollar.AppAmount <= 2999"
                >
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
                    :disabled="
                      $store.state.address.expenses.trans_company_id == '' ? 'disabled' : ''
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

                <label
                  class="block text-sm"
                  v-if="
                    (data.type_transport === 'COURIER' && amountsDollar.AppAmount >= 3000) ||
                      data.type_transport !== 'COURIER'
                  "
                >
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

              <div class="lg:w-5/12 xl:w-4/12 px-1 mb-2 lg:mb-0">
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
                    placeholder="Monto"
                    :disabled="
                      expenses.customs_house ||
                        (data.type_transport === 'COURIER' && amountsDollar.AppAmount <= 2999)
                    "
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
      </div>

      <!-- importar archivos -->
      <div class="flex flex-col w-full">
        <div class="flex justify-between items-end">
          <h2 class="mb-1 text-xl text-blue-1300 font-semibold">
            Documentos necesarios
          </h2>
        </div>
        <div
          class="
            flex
            flex-wrap
            justify-center
            pt-4
            pb-8
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
            <div class="text-gray-600 dark:text-gray-400 flex flex-col justify-start">
              <label class="inline-flex justify-center items-center mt-3">
                <a
                  @click="openWindowFileCert(certif)"
                  :class="[
                    'w-42 flex items-center px-3.5 py-2 m-2 text-sm text-center font-medium leading-5 transition-colors duration-150 border rounded-lg focus:outline-none focus:shadow-outline-blue',
                    isCertFile && certif.submit
                      ? 'bg-transparent border-blue-1000 text-blue-1000 hover:bg-blue-1000 hover:text-white active:bg-blue-1000'
                      : 'bg-blue-1000 border-transparent text-white hover:bg-blue-1100 active:bg-blue-1000'
                  ]"
                  ><svg
                    v-if="!deleteCertif"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    class="h-6 w-6 mx-1"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      :d="[
                        certif.submit
                          ? 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'
                          : 'M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z'
                      ]"
                    ></path>
                  </svg>
                  <svg
                    v-if="deleteCertif"
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
                  <span> {{ certif.name }} </span>
                </a>
              </label>
              <span>{{ certFileName }}</span>
              <a
                :href="filesUpload.certFile ? filesUpload.certFile.file_store.disk : '#'"
                target="_blank"
                class="text-center"
                >{{ filesUpload.certFile ? filesUpload.certFile.intl_treaty : '' }}</a
              >
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
            <div class="text-gray-600 dark:text-gray-400 flex flex-col justify-start">
              <label class="inline-flex justify-center items-center mt-3">
                <a
                  @click="openWindowFile(treaties)"
                  :class="[
                    'w-42 flex items-center px-3.5 py-2 m-2 text-sm text-center font-medium leading-5 transition-colors duration-150 border rounded-lg focus:outline-none focus:shadow-outline-blue',
                    isSecFile && treaties.submit
                      ? 'bg-transparent border-blue-1000 text-blue-1000 hover:bg-blue-1000 hover:text-white active:bg-blue-1000'
                      : 'bg-blue-1000 border-transparent text-white hover:bg-blue-1100 active:bg-blue-1000'
                  ]"
                  ><svg
                    v-if="!deleteTreaties"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    class="h-6 w-6 mx-1"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      :d="[
                        treaties.submit
                          ? 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'
                          : 'M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z'
                      ]"
                    ></path>
                  </svg>
                  <svg
                    v-if="deleteTreaties"
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
                  <span> {{ treaties.name }} </span></a
                >
              </label>
              <span class="text-center">{{ file1Name }}</span>
              <a
                :href="filesUpload.file1Name ? filesUpload.file1Name.file_store.disk : '#'"
                target="_blank"
                class="text-center"
                >{{ filesUpload.file1Name ? filesUpload.file1Name.intl_treaty : '' }}</a
              >
            </div>

            <span
              class="text-xs text-red-600 dark:text-red-400"
              v-if="expenses.errors.has('files.0')"
              v-html="expenses.errors.get('files.0')"
            ></span>
          </div>
          <div class="w-auto px-1 px-3">
            <input
              id="fileid_2"
              v-show="showInputFile"
              @change="otherHandleFile()"
              ref="file_2"
              type="file"
              hidden
            />
            <div class="text-gray-600 dark:text-gray-400 flex flex-col justify-start">
              <label class="inline-flex justify-center items-center mt-3">
                <a
                  @click="openWindowFile2(otherFile)"
                  :class="[
                    'w-42 flex items-center px-3.5 py-2 m-2 text-sm text-center font-medium leading-5 transition-colors duration-150 border rounded-lg focus:outline-none focus:shadow-outline-blue',
                    isOtherFile && otherFile.submit
                      ? 'bg-transparent border-blue-1000 text-blue-1000 hover:bg-blue-1000 hover:text-white active:bg-blue-1000'
                      : 'bg-blue-1000 border-transparent text-white hover:bg-blue-1100 active:bg-blue-1000'
                  ]"
                  ><svg
                    v-if="!deleteOtherFile"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    class="h-6 w-6 mx-1"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      :d="[
                        otherFile.submit
                          ? 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'
                          : 'M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z'
                      ]"
                    ></path>
                  </svg>
                  <svg
                    v-if="deleteOtherFile"
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
                  <span> {{ otherFile.name }} </span></a
                >
              </label>
              <span class="text-center">{{ file2Name }}</span>
              <a
                :href="filesUpload.file2Name ? filesUpload.file2Name.file_store.disk : '#'"
                target="_blank"
                class="text-center"
                >{{ filesUpload.file2Name ? filesUpload.file2Name.intl_treaty : '' }}</a
              >
            </div>

            <span
              class="text-xs text-red-600 dark:text-red-400"
              v-if="expenses.errors.has('files.0')"
              v-html="expenses.errors.get('files.0')"
            ></span>
          </div>
        </div>
      </div>

      <!-- gestion y pago de impuestos -->
      <div class="w-full flex justify-center">
        <div class="flex flex-col justify-around sm:w-6/12 lg:w-4/12 py-4 pb-8 mb-8">
          <div class="my-4">
            <p class="text-xl font-semibold text-blue-1300 text-center">
              Gestión y pago de impuestos
            </p>
          </div>
          <div class="flex flex-wrap justify-around">
            <button
              @click="taxComex(false)"
              :class="[
                'w-28 h-10 my-1 border-2 border-blue-1300 rounded-md transition-colors duration-150 focus:outline-none hover:bg-blue-1200 hover:text-white ',
                !expenses.tax_comex ? 'bg-blue-1300 text-white' : 'text-blue-1300 bg-transparent'
              ]"
              type="button"
            >
              Cliente
            </button>
            <button
              @click="taxComex(true)"
              :class="[
                'w-28 h-10 my-1 border-2 border-blue-1300 rounded-md transition-colors duration-150 focus:outline-none hover:bg-blue-1200 hover:text-white ',
                expenses.tax_comex ? 'bg-blue-1300 text-white' : 'text-blue-1300 bg-transparent'
              ]"
              type="button"
            >
              Comextech
            </button>
          </div>
        </div>
      </div>

      <!-- table taxes and dutys -->
      <tax-table
        :amountsDollar="amountsDollar"
        :amountsClp="amountsClp"
        :paritys="paritys"
        :insure="insure"
        :transport="transport"
        :isTaxDutys="isTaxDutys"
      />

      <!-- taxes and dutys IVA Advalorem -->
      <taxes-dutys :amountsDollar="amountsDollar" />

      <!-- tabla gastos del puerto -->
      <div
        v-if="data.type_transport !== 'COURIER'"
        class="container flex flex-col items-center justify-center px-6 mx-auto my-6"
      >
        <details class="w-9/12">
          <summary class="mb-4 text-lg text-center text-black-600 dark:text-gray-300">
            Gastos de Puerto
          </summary>
          <div>
            <div class="container grid px-3">
              <div class="w-full md:w-3/4 md:mx-4 overflow-hidden rounded-lg ">
                <div class="w-full overflow-x-auto">
                  <table class="table-auto whitespace-no-wrap">
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
                        <th>
                          Gastos de Puerto
                        </th>
                        <th colspan="2"></th>
                      </tr>
                    </thead>
                    <tbody
                      v-if="data.type_transport !== 'CONTAINER'"
                      class="bg-white dark:bg-gray-800"
                    >
                      <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-2 py-3">
                          {{
                            data.type_transport != 'COURIER' ? formatPrice(docMgmtLcl, 'USD') : 0
                          }}
                          USD
                        </td>
                        <td class="px-2 py-3">Gestión Documental (por cada BL)</td>
                      </tr>
                      <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-2 py-3">
                          {{
                            data.type_transport != 'COURIER' ? formatPrice(docVisaLcl, 'USD') : 0
                          }}
                          USD
                        </td>
                        <td class="px-2 py-3">Visación documental (por cada BL)</td>
                      </tr>
                      <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-2 py-3">
                          {{
                            data.type_transport != 'COURIER' ? formatPrice(dispatchLcl, 'USD') : 0
                          }}
                          USD
                        </td>
                        <td class="px-2 py-3">Despacho (por Ton&M3)</td>
                      </tr>
                    </tbody>
                    <tbody
                      v-if="data.type_transport !== 'CONSOLIDADO'"
                      class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                    >
                      <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-2 py-3">
                          {{
                            data.type_transport == 'CONTAINER' ? formatPrice(docMgmtFcl, 'USD') : 0
                          }}
                          USD
                        </td>
                        <td class="px-2 py-3">Gestión Documental (por cada BL)</td>
                      </tr>
                      <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-2 py-3">
                          {{ data.type_transport == 'CONTAINER' ? formatPrice(loanFcl, 'USD') : 0 }}
                          USD
                        </td>
                        <td class="px-2 py-3">Comodato ( X Conteiner)</td>
                      </tr>
                      <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-2 py-3">
                          {{
                            data.type_transport == 'CONTAINER' ? formatPrice(gateInFcl, 'USD') : 0
                          }}
                          USD
                        </td>
                        <td class="px-2 py-3">Gate In ( X Conteiner)</td>
                      </tr>
                    </tbody>
                    <!-- <tfoot>
                  <tr class="bg-gray-100">
                    <td class="text-center text-blue-1000 font-semibold px-2 py-3">
                      {{ formatPrice(expenses.port_charges, 'USD') }} USD
                    </td>
                    <td class="text-blue-1000 font-semibold px-2 py-3">
                      Gastos de Puerto {{ data.type_transport == 'CONTAINER' ? 'FCL' : 'LCL' }}
                    </td>
                  </tr>
                </tfoot> -->
                  </table>
                </div>
              </div>
            </div>
          </div>
        </details>
        <table>
          <tfoot>
            <tr class="bg-gray-100">
              <td class="text-blue-1300 font-semibold px-2 py-3">
                {{ formatPrice(expenses.port_charges, 'USD') }} USD
              </td>
              <td class="text-blue-1300 font-semibold px-2 py-3">
                Gastos de Puerto {{ data.type_transport == 'CONTAINER' ? 'FCL' : 'LCL' }}
              </td>
            </tr>
          </tfoot>
        </table>
      </div>

      <div class="flex justify-center">
        <button
          class="
            flex 
            justify-center 
            items-center
            w-44 
            h-12 
            px-4
            my-10
            text-lg
            leading-5
            text-white
            transition-colors
            duration-150
            bg-blue-1300
            border border-transparent
            rounded-lg
            active:bg-blue-1300
            hover:bg-blue-1200
            focus:outline-none focus:shadow-outline-blue
          "
          :disabled="busy"
          @click="submitForm()"
        >
          <svg
            v-if="!busy"
            xmlns="http://www.w3.org/2000/svg"
            class="mx-2 h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2h2m3-4H9a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-1m-1 4l-3 3m0 0l-3-3m3 3V3"
            />
          </svg>
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
          <span> Guardar </span>
        </button>
      </div>
    </div>
  </section>
</template>

<script>
import { mapState, mapMutations } from 'vuex';
import mixinInternment from '../common/mixins/internment/index.js';
import Load from '../Transport/Load.vue';
import Loader from '../common/utils/Loader.vue';
import TaxTable from './TaxTable.vue';
import TaxesDutys from './TaxesDutys.vue';

export default {
  props: {
    application_id: {
      required: true,
      type: Number
    }
  },
  mixins: [mixinInternment],
  components: { Load, Loader, TaxTable, TaxesDutys },
  computed: {
    ...mapState('internment', ['expenses', 'files', 'filesUpload', 'isTaxDutys']),
    ...mapState('application', ['data', 'currency', 'busy']),
    ...mapState('exchange', ['exchangeItem'])
  },
  data() {
    return {
      certif: {
        name: 'Cargar Invoice',
        submit: false
      },
      treaties: {
        name: 'Otro Documento',
        submit: false
      },
      otherFile: {
        name: 'Otro Documento 2',
        submit: false
      },
      certificate: {},
      custom_agents: [],
      trans_companies: [],
      showInputFile: false,
      nameFileUpload: '',
      amountsDollar: {
        transpAmount: 0,
        insureAmount: 0,
        AppAmount: 0
      },
      amountsClp: {
        clpAmount: 0,
        clpTransport: 0,
        clpInsurance: 0,
        clpCif: 0
      },
      paritys: {
        parityAmountOrigin: 0,
        parityAmountDollar: 0
      },
      docMgmtFcl: 25,
      loanFcl: 120,
      gateInFcl: 120,
      docMgmtLcl: 195,
      docVisaLcl: 30,
      dispatchLcl: 30,
      insure: false,
      transport: false,
      certFileName: '',
      file1Name: '',
      file2Name: '',
      isCertFile: false,
      isSecFile: false,
      isOtherFile: false,
      deleteCertif: false,
      deleteTreaties: false,
      deleteOtherFile: false,
      isLoading: true
    };
  },
  methods: {
    ...mapMutations('internment', ['changeTax']),
    formatPrice(value, currency) {
      return Number(value).toLocaleString(navigator.language, {
        minimumFractionDigits: currency == 'CLP' ? 0 : 2,
        maximumFractionDigits: currency == 'CLP' ? 0 : 2
      });
    },
    async openWindowFileCert(value) {
      this.nameFileUpload = value.name;

      if (!value.submit) {
        this.showInputFile = !this.showInputFile;
        let fileInputElement = this.$refs.file_cert;
        fileInputElement.click();
      } else {
        this.handleStatusSubmitFile('certif');
        if (this.filesUpload.certFile) {
          try {
            this.deleteCertif = true;
            const { internment_id, intl_treaty } = this.filesUpload.certFile;
            await axios.delete(`/internment-file-remove/${internment_id}/${intl_treaty}`);
            this.filesUpload.certFile = '';
          } catch (error) {
            console.error(error);
          } finally {
            this.deleteCertif = false;
          }
        }
        this.expenses.file_certificate = '';
        this.certFileName = '';
        this.isCertFile = false;
      }
    },
    async openWindowFile(value) {
      this.nameFileUpload = value.name;

      if (!value.submit) {
        this.showInputFile = !this.showInputFile;
        let fileInputElement = this.$refs.file;
        fileInputElement.click();
      } else {
        this.handleStatusSubmitFile('file1');
        if (this.filesUpload.file1Name) {
          try {
            this.deleteTreaties = true;
            const { internment_id, intl_treaty } = this.filesUpload.file1Name;
            await axios.delete(`/internment-file-remove/${internment_id}/${intl_treaty}`);
            this.filesUpload.file1Name = '';
          } catch (error) {
            console.error(error);
          } finally {
            this.deleteTreaties = false;
          }
        }
        this.expenses.files = [];
        this.file1Name = '';
        this.isSecFile = false;
      }
    },
    async openWindowFile2(value) {
      this.nameFileUpload = value.name;

      if (!value.submit) {
        this.showInputFile = !this.showInputFile;
        let fileInputElement = this.$refs.file_2;
        fileInputElement.click();
      } else {
        this.handleStatusSubmitFile('file2');
        if (this.filesUpload.file2Name) {
          try {
            this.deleteOtherFile = true;
            const { internment_id, intl_treaty } = this.filesUpload.file2Name;
            await axios.delete(`/internment-file-remove/${internment_id}/${intl_treaty}`);
            this.filesUpload.file2Name = '';
          } catch (error) {
            console.error(error);
          } finally {
            this.deleteOtherFile = false;
          }
        }
        this.expenses.files = [];
        this.file2Name = '';
        this.isOtherFile = false;
      }
    },
    certificateFile() {
      let file = this.$refs.file_cert.files[0];
      this.certFileName = file.name;
      if (file) {
        this.isCertFile = true;
        this.handleStatusSubmitFile('certif');
        this.expenses.file_certificate = file;
        this.certificate = this.nameFileUpload;
        this.$refs.file_cert.value = null;
      }
    },
    handleFile() {
      const file = this.$refs.file.files[0];
      this.file1Name = file.name;
      if (file) {
        this.isSecFile = true;
        this.handleStatusSubmitFile('file1');
        this.expenses.files.push(file);
        this.expenses.file_descrip.push(this.nameFileUpload);
        this.$refs.file.value = null;
      }
    },
    otherHandleFile() {
      const file = this.$refs.file_2.files[0];
      this.file2Name = file.name;
      if (file) {
        this.isOtherFile = true;
        this.handleStatusSubmitFile('file2');
        this.expenses.files.push(file);
        this.expenses.file_descrip.push(this.nameFileUpload);
        this.$refs.file_2.value = null;
      }
    },
    handleStatusSubmitFile(ref = null) {
      if (ref == 'certif') {
        this.certif.submit = !this.certif.submit;
      }
      if (ref == 'file1') {
        this.treaties.submit = !this.treaties.submit;
      }
      if (ref == 'file2') {
        this.otherFile.submit = !this.otherFile.submit;
      }
    },

    previewFiles(event) {
      const certificate = event.target.files[0];
      this.expenses.file_certificate = certificate;
    },
    async submitForm() {
      try {
        this.$store.dispatch('application/busyButton', true);
        // this.expenses.dataLoad = this.$store.state.load.loads;

        const { data } = await this.expenses.post('/internment');
        Toast.fire({
          icon: 'success',
          title: 'Datos Agregados'
        });

        if (!this.$store.getters.findService('ICS03')) {
          this.$store.dispatch('load/setLoad', data);
        }

        this.$store.dispatch('callIncomingOrNextMenu', true);
      } catch (error) {
        Toast.fire({
          icon: 'error',
          title: 'Se ha producido un error al procesar los datos'
        });
      } finally {
        this.$store.dispatch('application/busyButton', false);
      }
    },

    async taxComex(value) {
      if (value) {
        this.changeTax(value);
        await this.convertAmountToClp(true);
        this.calculateParity();
        this.taxCheck(true);
        this.advalorem();
      }
      if (!value) {
        this.changeTax(value);
        this.convertAmountToClp(false);
        this.taxCheck(false);
      }
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
    },

    async convertAmountToClp(value) {
      if (value) {
        const amountClp = await axios.get(
          `/api/convert-currency/${this.amountsDollar.AppAmount}/USD/CLP`
        );
        this.amountsClp.clpAmount = amountClp.data;

        const transportClp = await axios.get(
          `/api/convert-currency/${this.amountsDollar.transpAmount}/USD/CLP`
        );
        this.amountsClp.clpTransport = transportClp.data;

        const insuranceClp = await axios.get(
          `/api/convert-currency/${this.amountsDollar.insureAmount}/USD/CLP`
        );
        this.amountsClp.clpInsurance = insuranceClp.data;

        this.amountsClp.clpCif =
          this.amountsClp.clpAmount + this.amountsClp.clpTransport + this.amountsClp.clpInsurance;
      }
      if (!value) {
        this.amountsClp.clpAmount = 0;
        this.amountsClp.clpTransport = 0;
        this.amountsClp.clpInsurance = 0;
        this.amountsClp.clpCif = 0;
      }
    },

    async calculateParity() {
      const parityOrigin = parseFloat(this.amountsDollar.AppAmount);
      const dataAmount = parseFloat(this.data.amount);

      this.paritys.parityAmountOrigin = (Math.trunc(parityOrigin) / dataAmount).toFixed(0);

      this.paritys.parityAmountDollar = (
        this.amountsClp.clpAmount / this.amountsDollar.AppAmount
      ).toFixed(0);
    }
  },
  watch: {
    'expenses.customs_house': {
      handler(after, before) {
        this.expenses.custom_agent_id = '';

        let serviceFee = 0;
        let cifMayor = 0;

         cifMayor = ((( Number(this.expenses.cif_amt) * 0.35)) *1.1)/ (100-(0.35*1.1));

         serviceFee =  cifMayor > 150
                 ? cifMayor
                 : 150;

        this.expenses.agent_payment = this.expenses.customs_house ? serviceFee + 80 : 0;
      },
      deep: true
    }
    // amountsDollar.insureAmount: function(after, before) {
    //   this.debouncedGetTaxs();
    // },
    // transpAmount: function(after, before) {
    //   this.debouncedGetTaxs();
    // },
    // amountsDollar.AppAmount: function(after, before) {
    //   this.debouncedGetTaxs();
    // }
  },
  async mounted() {
    this.$store.dispatch('playPauseLoading', true);
    try {
      if (this.filesUpload.certFile) {
        this.certif.submit = true;
        this.isCertFile = true;
      }

      if (this.filesUpload.file1Name) {
        this.treaties.submit = true;
        this.isSecFile = true;
      }

      if (this.filesUpload.file2Name) {
        this.otherFile.submit = true;
        this.isOtherFile = true;
      }

      await this.$store.dispatch('exchange/getSummary', this.application_id);

      const transpCostp = this.exchangeItem.find((tic) => tic.code === 'CS03-03');

      if (transpCostp.amount <= 0) {
        await axios.post('/set-application-summary', {
          application_id: btoa(this.application_id),
          currency_code: 'USD'
        });

        await this.$store.dispatch('exchange/getSummary', this.application_id);
      }

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
      // this.expenses.transport = !this.$store.getters.findService('ICS03');
      // /custom-convert-currency
      const transp_cost = this.exchangeItem.find((tic) => tic.code === 'CS03-03');
      const insure_cost = this.exchangeItem.find((ic) => ic.code === 'CS03-04');

      this.amountsDollar.insureAmount =
        Number(insure_cost.amount) == 0 ? this.expenses.insurance : Number(insure_cost.amount);
      this.amountsDollar.transpAmount =
        Number(transp_cost.amount) == 0 ? this.expenses.transport_amt : Number(transp_cost.amount);
      this.amountsDollar.AppAmount = Number(this.data.amount);

      this.insure = !this.$store.getters.findService('ICS03') ? true : false;
      this.transport = !this.$store.getters.findService('ICS03') ? true : false;

      if (this.amountsDollar.AppAmount > 0 && this.currency.code != 'USD') {
        const app_usd = await axios.get(
          `/api/convert-currency/${this.amountsDollar.AppAmount}/${this.currency.code}/USD`
        );

        this.amountsDollar.AppAmount = app_usd.data;
      }

      if (this.data.type_transport === 'COURIER' && this.amountsDollar.AppAmount <= 2999) {
        this.expenses.agent_payment = 0;
      }

      if (this.expenses.tax_comex) {
        await this.taxComex(true);
      }

      if (this.data.type_transport != 'COURIER') {
        this.portCharge();
      }
    } catch (error) {
      console.error(error);
    } finally {
      this.$store.dispatch('playPauseLoading', false);
    }
  }
  // created: function() {
  //   this.debouncedGetTaxs = _.debounce(this.taxCheck, 500);
  //   // this.expenses.agent_payment = this.data.type_transport == 'COURIER' ? 0 : 250;
  // }
};
</script>

<template>
  <section class="lg:flex justify-center w-full p-4">
    <div
      class="mb-5"
      v-show="$store.getters.findService('ICS04') && !$store.getters.findService('ICS03')"
    >
      <Load />
    </div>

    <section
      class="lg:w-8/12 flex flex-wrap -mx-3"
      :class="[!$store.getters.findService('ICS04') ? 'justify-center' : 'justify-center']"
    >
      <!-- asignacion de aduana -->
      <section class="container grid px-6 mx-auto">
        <div class="flex justify-between items-end">
          <h4 class="mb-1 text-lg bg-gray-200 text-black-600 dark:text-gray-600">
            Asignación de Agente de Aduana
          </h4>
        </div>

        <div class="px-4 pb-4 mb-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
          <div class="lg:flex lg:flex-col lg:items-center my-1">
            <div class="px-2 md:flex lg:w-7/12 my-4">
              <div>
                <input
                  v-bind:value="true"
                  v-model="expenses.customs_house"
                  type="radio"
                  class="form-checkbox h-5 w-5 text-blue-600"
                  :disabled="expenses.courier_svc && data.amount < 3000"
                />
                <span class="mx-2 text-xs text-black text-gray-500"> Comextech </span>
              </div>
              <div>
                <input
                  v-bind:value="false"
                  v-model="expenses.customs_house"
                  type="radio"
                  class="form-checkbox h-5 w-5 text-blue-600"
                  :disabled="expenses.courier_svc && data.amount < 3000"
                />
                <span class="mx-2 text-xs text-black text-gray-500"> Cliente </span>
              </div>
              <div v-if="expenses.courier_svc && data.amount < 3000">
                <input
                  v-bind:value="true"
                  v-model="expenses.courier_svc"
                  type="radio"
                  class="md:ml-2 form-checkbox h-5 w-5 text-blue-600"
                  checked
                />
                <span class="mx-2 text-xs text-black text-gray-500"> Servicio incluido </span>
              </div>
            </div>

            <div class="my-5 lg:my-0 lg:flex lg:justify-end lg:w-7/12">
              <div class="lg:w-full px-1 mb-2 lg:mb-0">
                <label class="block text-sm" v-if="expenses.courier_svc && data.amount < 3000">
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

                <label
                  class="block text-sm"
                  v-if="!expenses.courier_svc || (expenses.courier_svc && data.amount > 3000)"
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

              <div class="lg:w-full px-1 mb-2 lg:mb-0">
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

      <!-- importar archivos -->
      <section class="container grid px-6 mx-auto">
        <div class="flex justify-between items-end">
          <h4 class="mb-1 text-lg bg-gray-200 text-black-600 dark:text-gray-300">
            Documentos necesarios
          </h4>
        </div>
        <div
          class="
            flex flex-wrap
            justify-center
            py-10
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
                    w-42
                    flex
                    items-center
                    px-3.5
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
                    bg-blue-1000 
                    hover:bg-blue-1100 
                    active:bg-blue-1000
                  "
                  :class="[
                    item.submit ? 'bg-red-500 hover:bg-red-800' : 'bg-blue-1000 hover:bg-blue-1100'
                  ]"
                  ><svg
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
                    w-42
                    flex
                    items-center
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
                    bg-blue-1000 
                    hover:bg-blue-1100 
                    active:bg-blue-1000
                  "
                  :class="[
                    item.submit ? 'bg-red-500 hover:bg-red-800' : 'bg-blue-1000 hover:bg-blue-1100'
                  ]"
                  ><svg
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

      <!-- tabla  acordeon -->
      <section class="container flex flex-col items-center justify-center px-6 mx-auto">
        <details class="w-9/12">
          <summary class="mb-4 text-lg text-center text-black-600 dark:text-gray-300">
            Cálculo de Impuestos
          </summary>
          <div>
            <section class="container grid px-3">
              <div
                class="w-full md:w-3/4 md:mx-4 overflow-hidden rounded-lg "
                :class="[!$store.getters.findService('ICS04') ? '' : 'justify-start']"
              >
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
                        <th>Moneda Dólar</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th colspan="2">Moneda de Origen</th>
                      </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800">
                      <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-2 py-3">{{ formatPrice(AppAmount, 'USD') }}</td>
                        <td class="px-2 py-3">USD</td>
                        <td class="px-2 py-3">Mercaderia</td>
                        <td rowspan="3" class="px-2">
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
                        <td class="px-2 py-3">
                          {{ formatPrice(data.amount, currency.code) }}
                        </td>
                        <td class="px-2 py-3">{{ currency.code }}</td>
                      </tr>
                      <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-2 py-3">{{ formatPrice(transpAmount, 'USD') }}</td>
                        <td class="px-2 py-3">USD</td>
                        <td class="px-2 py-3">Transporte</td>
                        <td class="px-2 py-3">
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
                        <td class="px-2 py-3">USD</td>
                      </tr>
                      <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-2 py-3">
                          {{ formatPrice(this.insureAmount) }}
                        </td>
                        <td class="px-2 py-3">USD</td>
                        <td class="px-2 py-3">Seguro</td>
                        <td class="px-2 py-3">
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
                        <td class="px-2 py-3">USD</td>
                      </tr>
                      <!-- <tr class="bg-gray-100">
                        <td class="text-blue-1000 font-semibold px-2 py-3">
                          {{ expenses.cif_amt }} aqui
                        </td>
                        <td class="text-blue-1000 font-semibold px-2 py-3">USD</td>
                        <td class="text-blue-1000 font-semibold px-2 py-3">Valor CIF</td>
                      </tr> -->
                    </tbody>
                  </table>
                </div>
              </div>
            </section>
          </div>
        </details>
        <table>
          <thead>
            <tr>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr class="bg-gray-100">
              <td class="text-blue-1000 font-semibold px-2 py-3">{{ expenses.cif_amt }}</td>
              <td class="text-blue-1000 font-semibold px-2 py-3">USD</td>
              <td class="text-blue-1000 font-semibold px-2 py-3">Valor CIF</td>
            </tr>
          </tbody>
        </table>
      </section>

      <!-- checkbox incluir -->
      <section
        class="container flex px-6 mx-auto mt-4 justify-center"
        :class="[!$store.getters.findService('ICS04') ? ' ' : '']"
      >
        <div class="w-10/12 flex flex-col lg:items-start mb-8">
          <span class="font-semibold mt-3 mb-2">Incluir</span>
          <div class="flex justify-start items-center my-1 ml-2">
            <div class="w-full sm:w-3/5 flex flex-col md:flex-row items-center">
              <input
                type="checkbox"
                v-model="expenses.iva"
                class="form-checkbox h-5 w-5 text-blue-600"
              />
              <span :class="[expenses.iva ? 'text-center mx-2' : 'text-center mx-2 text-gray-400']">
                {{ formatPrice(expenses.iva_amt, 'CLP') }} CLP
              </span>
              <h1 :class="[expenses.iva ? 'text-center mx-4' : 'text-center mx-4 text-gray-400']">
                IVA ( 19% )
              </h1>
              <!-- <img class="w-24 my-4" src="https://homer.sii.cl/responsive/images/logo.jpg" /> -->
            </div>
          </div>
          <div class="flex justify-start items-center my-1 ml-2">
            <div class="w-full sm:w-3/5 flex flex-col md:flex-row items-center">
              <input
                type="checkbox"
                v-model="expenses.adv"
                class="form-checkbox h-5 w-5 text-blue-600"
              />
              <span :class="[expenses.adv ? 'text-center mx-2' : 'text-center text-gray-400 mx-2']">
                {{ formatPrice(expenses.adv_amt, 'CLP') }} CLP
              </span>
              <h1 :class="[expenses.adv ? 'text-center mx-4' : 'text-center text-gray-400 mx-4']">
                Ad Valorem ( 6% )
              </h1>
              <!-- <img
                class="w-24 my-4"
                src="https://user-images.githubusercontent.com/53098149/132052671-8d382ada-a5c1-4d73-8c04-1b3112a793f7.jpeg"
              /> -->
            </div>
          </div>
        </div>
      </section>

      <!-- tabla gastos del puerto -->
      <section class="container flex flex-col items-center justify-center px-6 mx-auto">
        <details class="w-9/12">
          <summary class="mb-4 text-lg text-center text-black-600 dark:text-gray-300">
            Gastos de Puerto
          </summary>
          <div>
            <section class="container grid px-3">
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
            </section>
          </div>
        </details>
        <table>
          <tfoot>
            <tr class="bg-gray-100">
              <td class="text-blue-1000 font-semibold px-2 py-3">
                {{ formatPrice(expenses.port_charges, 'USD') }} USD
              </td>
              <td class="text-blue-1000 font-semibold px-2 py-3">
                Gastos de Puerto {{ data.type_transport == 'CONTAINER' ? 'FCL' : 'LCL' }}
              </td>
            </tr>
          </tfoot>
        </table>
      </section>

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
    </section>
  </section>
</template>

<script>
import { mapState } from 'vuex';
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
    ...mapState('application', ['data', 'currency', 'busy']),
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
      transport: false
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
        this.handleStatusSubmitFile('certif');
      }
    },
    certificateFile() {
      const file = this.$refs.file_cert.files[0];
      if (file) {
        this.handleStatusSubmitFile('certif');
        this.expenses.file_certificate = file;
        this.certificate = this.nameFileUpload;
      }
    },
    handleFile() {
      const file = this.$refs.file.files[0];
      if (file) {
        this.handleStatusSubmitFile();
        this.expenses.files.push(file);
        this.expenses.file_descrip.push(this.nameFileUpload);
      }
    },
    handleStatusSubmitFile(ref = null) {
      if (ref == 'certif') {
        this.certif = this.certif.map((e) =>
          e.name === this.nameFileUpload ? { ...e, submit: !e.submit } : e
        );
      } else {
        this.treaties = this.treaties.map((e) =>
          e.name === this.nameFileUpload ? { ...e, submit: !e.submit } : e
        );
      }
    },

    previewFiles(event) {
      const certificate = event.target.files[0];
      this.expenses.file_certificate = certificate;
    },
    async submitForm() {
      try {
        this.$store.dispatch('application/busyButton', true);
        this.expenses.dataLoad = this.$store.state.load.loads;

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
    }
  },
  watch: {
    'expenses.customs_house': {
      handler(after, before) {
        this.expenses.custom_agent_id = '';

        this.expenses.agent_payment = this.data.type_transport == 'COURIER' ? 0 : 250;
      },
      deep: true
    },
    insureAmount: function(after, before) {
      this.debouncedGetTaxs();
    },
    transpAmount: function(after, before) {
      this.debouncedGetTaxs();
    },
    AppAmount: function(after, before) {
      this.debouncedGetTaxs();
    }
  },
  async mounted() {
    try {
      this.$store.dispatch('exchange/getSummary', this.application_id);

      const transpCostp = this.exchangeItem.find((tic) => tic.code === 'CS03-01');

      if (transpCostp.amount <= 0) {
        await axios.post('/set-application-summary', {
          application_id: btoa(this.application_id),
          currency_code: currency
        });

        this.$store.dispatch('exchange/getSummary', this.application_id);
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
  created: function() {
    this.debouncedGetTaxs = _.debounce(this.taxCheck, 500);
    this.expenses.agent_payment = this.data.type_transport == 'COURIER' ? 0 : 250;
  }
};
</script>

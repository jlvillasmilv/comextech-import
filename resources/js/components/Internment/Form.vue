<template>
  <section class="lg:flex lg:flex-col items-center justify-center w-full p-4">
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
                      (data.type_transport === 'COURIER' && AppAmount >= 3000)
                  "
                  v-model="expenses.customs_house"
                  :value="true"
                  type="radio"
                  class="form-checkbox h-5 w-5 text-blue-600"
                />
                <input
                  v-if="data.type_transport === 'COURIER' && AppAmount <= 2999"
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
                      (data.type_transport === 'COURIER' && AppAmount >= 3000)
                  "
                  v-model="expenses.customs_house"
                  :value="false"
                  type="radio"
                  class="form-checkbox h-5 w-5 text-blue-600"
                />
                <input
                  v-if="data.type_transport === 'COURIER' && AppAmount <= 2999"
                  type="radio"
                  class="form-checkbox h-5 w-5 text-blue-600"
                  disabled
                />
                <span class="mx-2 text-xs text-gray-500">Cliente</span>
              </div>
              <div v-if="data.type_transport === 'COURIER'">
                <input
                  v-if="AppAmount <= 2999"
                  v-model="expenses.courier_svc"
                  :value="true"
                  type="radio"
                  class="form-checkbox h-5 w-5 text-blue-600"
                  :disabled="expenses.courier_svc && AppAmount >= 2999"
                />
                <input
                  v-if="AppAmount >= 3000"
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
                  v-if="data.type_transport === 'COURIER' && AppAmount <= 2999"
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
                    (data.type_transport === 'COURIER' && AppAmount >= 3000) ||
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
                        (data.type_transport === 'COURIER' && AppAmount <= 2999)
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
                    !isCertFile
                      ? 'bg-blue-1000 border-transparent text-white hover:bg-blue-1100 active:bg-blue-1000'
                      : 'bg-transparent border-blue-1000 text-blue-1000 hover:bg-blue-1000 hover:text-white active:bg-blue-1000'
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
                        certif.submit
                          ? 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'
                          : 'M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z'
                      ]"
                    ></path>
                  </svg>
                  <span> {{ certif.name }} </span>
                </a>
              </label>
              <span>{{ certFileName }}</span>
              <a
                :href="filesUpload.certFile ? filesUpload.certFile.file_store.disk : '#'"
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
                    !isSecFile
                      ? 'bg-blue-1000 border-transparent text-white hover:bg-blue-1100 active:bg-blue-1000'
                      : 'bg-transparent border-blue-1000 text-blue-1000 hover:bg-blue-1000 hover:text-white active:bg-blue-1000'
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
                        treaties.submit
                          ? 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'
                          : 'M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z'
                      ]"
                    ></path>
                  </svg>
                  <span> {{ treaties.name }} </span></a
                >
              </label>
              <span class="text-center">{{ file1Name }}</span>
              <a
                :href="filesUpload.file1Name ? filesUpload.file1Name.file_store.disk : '#'"
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
                    !isOtherFile
                      ? 'bg-blue-1000 border-transparent text-white hover:bg-blue-1100 active:bg-blue-1000'
                      : 'bg-transparent border-blue-1000 text-blue-1000 hover:bg-blue-1000 hover:text-white active:bg-blue-1000'
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
                        otherFile.submit
                          ? 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'
                          : 'M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z'
                      ]"
                    ></path>
                  </svg>
                  <span> {{ otherFile.name }} </span></a
                >
              </label>
              <span class="text-center">{{ file2Name }}</span>
              <a
                :href="filesUpload.file2Name ? filesUpload.file2Name.file_store.disk : '#'"
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

      <!-- tabla  acordeon -->
      <div class="w-full">
        <h2 class="mb-1 text-xl text-blue-1300 font-semibold">Impuestos y Aranceles</h2>
      </div>
      <div
        class="container flex flex-col items-center justify-center py-4 px-6 mx-auto bg-white rounded-lg shadow-md"
      >
        <details class="w-full">
          <summary class="mb-4">
            Cálculo de impuestos según costos y paridades de Aduana Chile
          </summary>
          <div class="mt-8">
            <div class="container grid px-3">
              <div
                class="table-full w-full overflow-hidden xl:flex-no-wrap  "
                :class="[!$store.getters.findService('ICS04') ? '' : 'sm:justify-end']"
              >
                <div class="flex justify-center sm:w-6/12 xl:w-5/12 overflow-x-auto">
                  <table>
                    <thead>
                      <tr
                        class="
                          text-right
                          font-semibold
                          tracking-wide
                        "
                      >
                        <th colspan="3">Moneda CLP</th>
                      </tr>
                      <tr>
                        <th class="py-2">&nbsp;</th>
                        <th class="py-2 px-3 font-normal">Monto</th>
                        <th class="py-2 pr-1 font-normal">Moneda</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      <tr class="text-sm">
                        <td class="py-2 px-4 text-base">Mercaderia</td>
                        <td class="py-2">{{ $options.filters.setPrice(clpAmount, 'CLP') }}</td>
                        <td class="py-2">CLP</td>
                      </tr>
                      <tr class="text-sm">
                        <td class="py-2 px-4 text-base">Transporte</td>
                        <td class="py-2">{{ $options.filters.setPrice(clpTransport, 'CLP') }}</td>
                        <td class="py-2">CLP</td>
                      </tr>
                      <tr class="text-sm">
                        <td class="py-2 px-4 text-base">Seguro</td>
                        <td class="py-2">{{ $options.filters.setPrice(clpInsurance, 'CLP') }}</td>
                        <td class="py-2">CLP</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="div-arrow-full w-1/12">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                    role="img"
                    width="2.5em"
                    height="2.5em"
                    preserveAspectRatio="xMidYMid meet"
                    viewBox="0 0 20 20"
                    class="arrow-full"
                  >
                    <path fill="#142c44" d="M2.5 10L9 3.5V7h8v6H9v3.5L2.5 10z" />
                  </svg>
                </div>
                <div class="flex justify-center sm:w-5/12 xl:w-5/12 overflow-x-auto">
                  <table>
                    <thead>
                      <tr
                        class="
                          text-center
                          font-semibold
                          tracking-wide
                        "
                      >
                        <th colspan="3">
                          Moneda Dolár
                        </th>
                      </tr>
                      <tr>
                        <th class="py-2 px-3 font-normal">Monto</th>
                        <th class="py-2 pr-1 font-normal">Paridad</th>
                        <th class="py-2 font-normal">Moneda</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      <tr class="text-sm">
                        <td class="py-2">{{ $options.filters.setPrice(AppAmount, 'USD') }}</td>
                        <td class="py-2">{{ parityAmountDollar }}</td>
                        <td class="py-2">USD</td>
                      </tr>
                      <tr class="text-sm">
                        <td class="py-2">{{ $options.filters.setPrice(transpAmount, 'USD') }}</td>
                        <td class="py-2">{{ parityAmountDollar }}</td>
                        <td class="py-2">USD</td>
                      </tr>
                      <tr class="text-sm">
                        <td class="py-2">{{ $options.filters.setPrice(insureAmount, 'USD') }}</td>
                        <td class="py-2">{{ parityAmountDollar }}</td>
                        <td class="py-2">USD</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="top-arrow-dollar w-full my-4">
                  <div class="flex justify-between">
                    <div class="cif-pesos pl-28">
                      <table>
                        <thead>
                          <th></th>
                        </thead>
                        <tbody>
                          <tr class="font-semibold">
                            <td class="bg-gray-200 py-2 px-1">
                              {{ $options.filters.setPrice(clpCif, 'CLP') }}
                            </td>
                            <td class="bg-gray-200 py-2 px-1">CIF Pesos</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div>
                      <table>
                        <thead>
                          <th></th>
                        </thead>
                        <tbody>
                          <tr class="font-semibold">
                            <td class="bg-gray-200 py-2 px-1">
                              {{ $options.filters.setPrice(expenses.cif_amt, 'USD') }}
                            </td>
                            <td class="bg-gray-200 py-2 px-1">CIF Dólar</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="flex justify-end sm:pr-14 mt-4">
                    <span
                      class="w-10 h-10 iconify"
                      data-icon="entypo:arrow-up"
                      style="color: #142c44;"
                    ></span>
                  </div>
                </div>
                <div class="div-arrow-full-2">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                    role="img"
                    width="2.5em"
                    height="2.5em"
                    preserveAspectRatio="xMidYMid meet"
                    viewBox="0 0 20 20"
                    class="arrow-full-2"
                  >
                    <path fill="#142c44" d="M2.5 10L9 3.5V7h8v6H9v3.5L2.5 10z" />
                  </svg>
                </div>
                <div class="flex justify-center sm:w-6/12 xl:w-4/12 overflow-x-auto">
                  <table>
                    <thead>
                      <tr
                        class="
                          text-center
                          font-semibold
                          tracking-wide
                        "
                      >
                        <th colspan="3">
                          Moneda original
                        </th>
                      </tr>
                      <tr>
                        <th class="py-2 px-3 font-normal">Monto</th>
                        <th class="py-2 pr-1 font-normal">Paridad</th>
                        <th class="py-2 font-normal">Moneda</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      <tr class="text-sm">
                        <td class="py-2">
                          {{ $options.filters.setPrice(data.amount, currency.code) }}
                        </td>
                        <td class="py-2">{{ parityAmountOrigin }}</td>
                        <td class="py-2">{{ currency.code }}</td>
                      </tr>
                      <tr class="text-sm">
                        <td class="py-2">
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
                            {{ $options.filters.setPrice(transpAmount, 'USD') }}
                          </span>
                        </td>
                        <td class="py-2">1</td>
                        <td class="py-2">USD</td>
                      </tr>
                      <tr class="text-sm">
                        <td class="py-2">
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
                            {{ $options.filters.setPrice(insureAmount, 'USD') }}
                          </span>
                        </td>
                        <td class="py-2">1</td>
                        <td class="py-2">USD</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="table-mobile mt-8">
                <div class="flex flex-col items-center">
                  <table>
                    <thead>
                      <tr
                        class="
                          text-center
                          font-semibold
                          tracking-wide
                        "
                      >
                        <th colspan="3">
                          Moneda original
                        </th>
                      </tr>
                      <tr>
                        <th class="py-2 px-3 font-normal">Monto</th>
                        <th class="py-2 pr-1 font-normal">Paridad</th>
                        <th class="py-2 font-normal">Moneda</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      <tr class="text-sm">
                        <td class="py-2">
                          {{ $options.filters.setPrice(data.amount, currency.code) }}
                        </td>
                        <td class="py-2">{{ parityAmountOrigin }}</td>
                        <td class="py-2">{{ currency.code }}</td>
                      </tr>
                      <tr class="text-sm">
                        <td class="py-2">
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
                            {{ $options.filters.setPrice(transpAmount, 'USD') }}
                          </span>
                        </td>
                        <td class="py-2">1</td>
                        <td class="py-2">USD</td>
                      </tr>
                      <tr class="text-sm">
                        <td class="py-2">
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
                            {{ $options.filters.setPrice(insureAmount, 'USD') }}
                          </span>
                        </td>
                        <td class="py-2">1</td>
                        <td class="py-2">USD</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="w-full flex justify-center">
                  <div class="flex justify-center w-3/12 my-2 pr-2">
                    <span
                      class="w-10 h-10 iconify"
                      data-icon="entypo:arrow-down"
                      style="color: #142c44;"
                    ></span>
                  </div>
                </div>
                <div class="flex flex-col items-center">
                  <div>
                    <table>
                      <thead>
                        <tr
                          class="
                          text-center
                          font-semibold
                          tracking-wide
                        "
                        >
                          <th colspan="3">
                            Moneda Dolár
                          </th>
                        </tr>
                        <tr>
                          <th class="py-2 px-3 font-normal">Monto</th>
                          <th class="py-2 pr-1 font-normal">Paridad</th>
                          <th class="py-2 font-normal">Moneda</th>
                        </tr>
                      </thead>
                      <tbody class="text-center">
                        <tr class="text-sm">
                          <td class="py-2">{{ $options.filters.setPrice(AppAmount, 'USD') }}</td>
                          <td class="py-2">{{ parityAmountDollar }}</td>
                          <td class="py-2">USD</td>
                        </tr>
                        <tr class="text-sm">
                          <td class="py-2">
                            {{ $options.filters.setPrice(transpAmount, 'USD') }}
                          </td>
                          <td class="py-2">{{ parityAmountDollar }}</td>
                          <td class="py-2">USD</td>
                        </tr>
                        <tr class="text-sm">
                          <td class="py-2">
                            {{ $options.filters.setPrice(insureAmount, 'USD') }}
                          </td>
                          <td class="py-2">{{ parityAmountDollar }}</td>
                          <td class="py-2">USD</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="lg:ml-4 xl:ml-12 pl-2">
                    <table>
                      <thead>
                        <th></th>
                      </thead>
                      <tbody>
                        <tr class="font-semibold">
                          <td class="bg-gray-200 py-2 px-1">
                            {{ $options.filters.setPrice(expenses.cif_amt, 'USD') }}
                          </td>
                          <td class="bg-gray-200 py-2 px-1">CIF Dólar</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="w-full flex justify-center">
                  <div class="flex justify-center w-3/12 my-2 pr-2">
                    <span
                      class="w-10 h-10 iconify"
                      data-icon="entypo:arrow-down"
                      style="color: #142c44;"
                    ></span>
                  </div>
                </div>
                <div class="flex flex-col items-center">
                  <div>
                    <table>
                      <thead>
                        <tr
                          class="
                text-right
                font-semibold
                tracking-wide
                "
                        >
                          <th colspan="3">Moneda CLP</th>
                        </tr>
                        <tr>
                          <!-- <th class="py-2">&nbsp;</th> -->
                          <th class="py-2 px-3 font-normal">Monto</th>
                          <th class="py-2 pr-1 font-normal">Moneda</th>
                        </tr>
                      </thead>
                      <tbody class="text-center">
                        <tr class="text-sm">
                          <!-- <td class="py-2 px-4 text-base">Mercaderia</td> -->
                          <td class="py-2">{{ $options.filters.setPrice(clpAmount, 'CLP') }}</td>
                          <td class="py-2">CLP</td>
                        </tr>
                        <tr class="text-sm">
                          <!-- <td class="py-2 px-4 text-base">Transporte</td> -->
                          <td class="py-2">
                            {{ $options.filters.setPrice(clpTransport, 'CLP') }}
                          </td>
                          <td class="py-2">CLP</td>
                        </tr>
                        <tr class="text-sm">
                          <!-- <td class="py-2 px-4 text-base">Seguro</td> -->
                          <td class="py-2">
                            {{ $options.filters.setPrice(clpInsurance, 'CLP') }}
                          </td>
                          <td class="py-2">CLP</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div>
                    <table>
                      <thead>
                        <th></th>
                      </thead>
                      <tbody>
                        <tr class="font-semibold">
                          <td class="bg-gray-200 py-2 px-1">
                            {{ $options.filters.setPrice(clpCif, 'CLP') }}
                          </td>
                          <td class="bg-gray-200 py-2 px-1">CIF Pesos</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="w-full flex justify-center">
                  <div class="flex justify-center w-3/12 my-2 pr-2">
                    <span
                      class="w-10 h-10 iconify"
                      data-icon="entypo:arrow-down"
                      style="color: #142c44;"
                    ></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </details>
        <div class="cif w-full">
          <div class="lg:flex lg:ml-20 xl:ml-36 pl-1">
            <table>
              <thead>
                <th></th>
              </thead>
              <tbody>
                <tr class="font-semibold">
                  <td class="bg-gray-200 py-2 px-1">
                    {{ $options.filters.setPrice(clpCif, 'CLP') }}
                  </td>
                  <td class="bg-gray-200 py-2 px-1">CIF Pesos</td>
                </tr>
              </tbody>
            </table>
            <div class="lg:ml-4 xl:ml-12 pl-2">
              <table>
                <thead>
                  <th></th>
                </thead>
                <tbody>
                  <tr class="font-semibold">
                    <td class="bg-gray-200 py-2 px-1">
                      {{ $options.filters.setPrice(expenses.cif_amt, 'USD') }}
                    </td>
                    <td class="bg-gray-200 py-2 px-1">CIF Dólar</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="flex justify-end w-3/12 my-2 pr-2">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              aria-hidden="true"
              role="img"
              width="2.5em"
              height="2.5em"
              preserveAspectRatio="xMidYMid meet"
              viewBox="0 0 20 20"
              class="hidden md:block"
            >
              <path fill="#142c44" d="M10 17.5L3.5 11H7V3h6v8h3.5L10 17.5z" />
            </svg>
          </div>
        </div>
      </div>

      <!-- checkbox incluir -->
      <div class="w-full flex flex-wrap justify-center p-4 mt-4 bg-gray-200 rounded-lg shadow-md">
        <div class="flex flex-col justify-between sm:w-6/12 lg:w-4/12 xl:w-3/12 px-4 xl:py-0">
          <div class="button-ad-mobile">
            <button type="button" class="mr-4 focus:outline-none" @click="activeAd()">
              <img
                src="../../../../public/img/tgr.png"
                class="w-24 bg-white px-2 border-2 shadow-md transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-110 img-advalorem"
                :style="expenses.adv ? { filter: filterImg, opacity: opacityImg } : ''"
                alt="tgr"
              />
            </button>
            <div>
              <p class="text-gray-400"><strong class="text-black">T</strong>esoreria</p>
              <p class="text-gray-400"><strong class="text-black">G</strong>eneral de la</p>
              <p class="text-gray-400"><strong class="text-black">R</strong>epublica</p>
            </div>
          </div>
          <div class="py-1">
            <span class="font-semibold">Advalorem</span>
            <div class="flex justify-between bg-gray-300 p-2 rounded">
              <p>6%</p>
              <p>
                {{ expenses.adv ? `${$options.filters.setPrice(expenses.adv_amt, 'CLP')} CLP` : 0 }}
              </p>
            </div>
          </div>
          <figure class="container-sii">
            <img
              src="../../../../public/img/SII-white.png"
              class="w-24 bg-white px-2 mr-4 border-2 shadow-md"
              alt="sii"
            />
            <div>
              <p class="text-gray-400"><strong class="text-black">S</strong>ervicio de</p>
              <p class="text-gray-400"><strong class="pl-0.5 text-black">I</strong>mpuestos</p>
              <p class="text-gray-400"><strong class="pl-0.5 text-black">I</strong>nternos</p>
            </div>
          </figure>
          <div class="py-3">
            <span class="font-semibold">IVA de internacion</span>
            <div class="flex justify-between bg-gray-300 p-2 rounded">
              <p>19%</p>
              <p>{{ `${$options.filters.setPrice(expenses.iva_amt, 'CLP')} CLP` }}</p>
            </div>
          </div>
        </div>
        <div class="flex flex-col justify-between items-start sm:w-6/12 lg:w-5/12 h-48 px-4">
          <div class="container-advalorem flex justify-center">
            <button type="button" class="mr-4 focus:outline-none" @click="activeAd()">
              <img
                src="../../../../public/img/tgr.png"
                class="w-24 bg-white px-2 border-2 shadow-md transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-110 img-advalorem"
                :style="expenses.adv ? { filter: filterImg, opacity: opacityImg } : ''"
                alt="tgr"
              />
            </button>
            <div>
              <p class="text-gray-400"><strong class="text-black">T</strong>esoreria</p>
              <p class="text-gray-400"><strong class="text-black">G</strong>eneral de la</p>
              <p class="text-gray-400"><strong class="text-black">R</strong>epublica</p>
            </div>
          </div>
          <figure class="container-sii-full flex justify-center">
            <img
              src="../../../../public/img/SII-white.png"
              class="w-24 bg-white px-2 mr-4 border-2 shadow-md"
              alt="sii"
            />
            <div>
              <p class="text-gray-400"><strong class="text-black">S</strong>ervicio de</p>
              <p class="text-gray-400"><strong class="pl-0.5 text-black">I</strong>mpuestos</p>
              <p class="text-gray-400"><strong class="pl-0.5 text-black">I</strong>nternos</p>
            </div>
          </figure>
        </div>
        <div class="flex flex-col justify-around sm:w-6/12 lg:w-4/12 px-4">
          <div class="my-4">
            <p class="font-semibold text-black text-center">Gestion de impuestos</p>
          </div>
          <div class="flex flex-wrap justify-around">
            <button
              @click="taxComex(false)"
              :class="[
                'w-28 h-10 my-1 border-2 border-blue-500 rounded-md transition-colors duration-150 focus:outline-none hover:bg-blue-200 ',
                !expenses.tax_comex ? 'bg-blue-200 ' : 'bg-transparent'
              ]"
              type="button"
            >
              Cliente
            </button>
            <button
              @click="taxComex(true)"
              :class="[
                'w-28 h-10 my-1 border-2 border-blue-500 rounded-md transition-colors duration-150 focus:outline-none hover:bg-blue-200 ',
                expenses.tax_comex ? 'bg-blue-200' : 'bg-transparent'
              ]"
              type="button"
            >
              Comextech
            </button>
          </div>
          <div>
            <p class="text-center text-sm">
              {{
                expenses.tax_comex
                  ? 'Los impuestos serán gestionados y pagados por ComexTech, no por el cliente y podrán sufrir variación según Tipo de cambio'
                  : 'Los impuestos serán gestionados y pagados por el cliente, no por ComexTech y podrán sufrir variación según Tipo de cambio'
              }}
            </p>
          </div>
        </div>
      </div>

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

    <!-- <pre>
    {{expenses}}
  </pre> -->
  </section>
</template>

<script>
import { mapState } from 'vuex';
import Load from '../Transport/Load.vue';
// import TableMobile from './TableMobile.vue';

export default {
  props: {
    application_id: {
      required: true,
      type: Number
    }
  },
  components: { Load },
  computed: {
    ...mapState('internment', ['expenses', 'files', 'filesUpload']),
    ...mapState('application', ['data', 'currency', 'busy']),
    ...mapState('exchange', ['exchangeItem'])
  },
  data() {
    return {
      filterImg: 'grayscale(0)',
      opacityImg: '1',
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
      transpAmount: 0,
      insureAmount: 0,
      AppAmount: 0,
      clpAmount: 0,
      clpTransport: 0,
      clpInsurance: 0,
      clpCif: 0,
      parityAmountOrigin: 0,
      parityAmountDollar: 0,
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
      isOtherFile: false
    };
  },
  methods: {
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
          const { internment_id, intl_treaty } = this.filesUpload.certFile;
          await axios.delete(`/internment-file-remove/${internment_id}/${intl_treaty}`);
          this.filesUpload.certFile = '';
        }

        this.expenses.file_certificate = '';
        this.filesUpload.certFile = '';
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
          const { internment_id, intl_treaty } = this.filesUpload.file1Name;
          await axios.delete(`/internment-file-remove/${internment_id}/${intl_treaty}`);
          this.filesUpload.file1Name = '';
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
          const { internment_id, intl_treaty } = this.filesUpload.file2Name;
          await axios.delete(`/internment-file-remove/${internment_id}/${intl_treaty}`);
          this.filesUpload.file2Name = '';
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
        this.handleStatusSubmitFile();
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

    activeAd() {
      this.expenses.adv = !this.expenses.adv;
      this.advalorem();
    },

    async advalorem() {
      // change iva value if Advalorem is checked
      if (this.expenses.adv) {
        let CIF = parseFloat(
          Number(this.expenses.cif_amt) + Number(this.expenses.cif_amt * 0.06)
        ).toFixed(2);

        let cif_clp = await axios.get(`/custom-convert-currency/${CIF}/USD`);

        if (cif_clp.data <= 0) {
          cif_clp = await axios.get(`/api/convert-currency/${CIF}/USD/CLP`);
        }

        this.expenses.iva_amt = cif_clp.data * (19 / 100);
      } else {
        this.taxCheck();
      }
    },

    taxComex(value) {
      this.expenses.tax_comex = value;
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
    },

    async convertAmountToClp() {
      const amountClp = await axios.get(`/api/convert-currency/${this.AppAmount}/USD/CLP`);
      this.clpAmount = amountClp.data;

      const transportClp = await axios.get(`/api/convert-currency/${this.transpAmount}/USD/CLP`);
      this.clpTransport = transportClp.data;

      const insuranceClp = await axios.get(`/api/convert-currency/${this.insureAmount}/USD/CLP`);
      this.clpInsurance = insuranceClp.data;

      const cifClp = await axios.get(`/api/convert-currency/${this.expenses.cif_amt}/USD/CLP`);
      this.clpCif = cifClp.data;
    },

    async calculateParity() {
      const parityOrigin = parseFloat(this.AppAmount);
      const dataAmount = parseFloat(this.data.amount);
      this.parityAmountOrigin = (Math.trunc(parityOrigin) / dataAmount).toFixed(2);

      const parityDollar = await axios.get(`/api/convert-currency/${this.AppAmount}/USD/CLP`);
      this.parityAmountDollar = (
        Math.trunc(parseFloat(parityDollar.data)) / this.AppAmount
      ).toFixed(0);
    }
  },
  watch: {
    'expenses.customs_house': {
      handler(after, before) {
        this.expenses.custom_agent_id = '';

        this.expenses.agent_payment = this.expenses.customs_house ? 250 : 0;
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
    /* Vue-loader config and active */
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
    try {
      this.certif.submit = this.filesUpload.certFile ? true : false;
      this.treaties.submit = this.filesUpload.file1Name ? true : false;
      this.otherFile.submit = this.filesUpload.file2Name ? true : false;

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

      if (this.data.type_transport == 'COURIER' && this.AppAmount <= 2999) {
        this.expenses.agent_payment = 0;
      }

      this.convertAmountToClp();
      this.taxCheck();
      this.calculateParity();
      this.advalorem();

      if (this.data.type_transport != 'COURIER') {
        this.portCharge();
      }
    } catch (error) {
      loader.hide();
      console.error(error);
    } finally {
      loader.hide();
    }
  },
  created: function() {
    this.debouncedGetTaxs = _.debounce(this.taxCheck, 500);
    // this.expenses.agent_payment = this.data.type_transport == 'COURIER' ? 0 : 250;
  }
};
</script>
<style lang="scss" scoped>
.img-advalorem {
  filter: grayscale(100%);
  opacity: 0.35;
}

.img-advalorem:hover {
  filter: grayscale(0);
  opacity: 1;
}

@media (max-width: 640px) {
  .top-arrow {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }
  .top-arrow-dollar {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }
  .cif-pesos {
    display: none;
  }
  .div-arrow-full,
  .div-arrow-full-2 {
    display: none;
  }
  .container-advalorem {
    margin-top: 1rem;
  }
  .table-full {
    display: none;
  }
  .table-mobile {
    display: flex;
    flex-direction: column;
  }
}

@media (max-width: 1280px) {
  .cif {
    display: none;
  }
  .arrow-full-2 {
    display: none;
  }
}

@media (min-width: 640px) {
  .top-arrow {
    display: none;
  }
  .top-arrow-dollar {
    display: flex;
    flex-direction: column;
    justify-content: center;
    // align-items: ;
    padding-right: 4rem;
  }
  .div-arrow-full,
  .div-arrow-full-2 {
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
  .table-full {
    display: flex;
    flex-wrap: wrap;
  }
  .table-mobile {
    display: none;
  }
}

@media (min-width: 1280px) {
  .cif {
    display: block;
  }
  .top-arrow-dollar {
    display: none;
  }
  .table-full {
    flex-wrap: nowrap;
  }
}
@media (max-width: 474px) {
  .button-ad-mobile {
    display: flex;
    justify-content: center;
    margin-top: 1rem;
    margin-bottom: 1rem;
  }
  .container-sii {
    display: flex;
    margin-top: 1rem;
    margin-bottom: 1rem;
  }
  .container-advalorem {
    display: none;
  }
  .container-sii-full {
    display: none;
  }
}
@media (min-width: 474px) {
  .button-ad-mobile {
    display: none;
  }
  .container-sii {
    display: none;
  }
}
</style>

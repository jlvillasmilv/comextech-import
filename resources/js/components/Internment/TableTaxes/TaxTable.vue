<template>
  <section>
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
  </section>
</template>
<script></script>
<style></style>

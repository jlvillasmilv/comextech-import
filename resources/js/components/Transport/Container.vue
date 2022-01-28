<template>
  <section>
    <!-- form if data.condition is EXW -->
    <section v-if="data.condition == 'EXW'">
      <transition name="fade">
        <div
          v-if="
            !expenses.dataLoad || expenses.dataLoad.length == 0 || $store.state.address.formAddress
          "
          class="w-full flex flex-col flex-wrap sm:items-center my-8"
        >
          <!-- Direccion de origen -->
          <h3 class="mb-10 text-center">Direcciones y Puertos</h3>
          <div class="w-72 md:w-8/12 flex justify-center px-3 mb-6 md:mb-0">
            <div class="w-full">
              <span class="text-sm font-semibold">Origen</span>
              <div v-if="!expenses.fav_origin_address" class="flex">
                <vue-google-autocomplete
                  v-model="expenses.origin_address"
                  id="addressOrigin"
                  classname="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  v-on:placechanged="getAddressOrigin"
                  placeholder="Direccion, Codigo Postal"
                >
                </vue-google-autocomplete>
              </div>
              <div v-else class="flex">
                <select
                  v-model="expenses.origin_address"
                  class="block
                      appearance-none
                      w-full
                      border border-gray-150
                      dark:border-gray-600
                      text-gray-700
                      p-2
                      pr-8
                      rounded
                      leading-tight
                      focus:outline-none focus:bg-white focus:border-gray-500"
                >
                  <option
                    class="text-sm"
                    v-for="item in origin_transport"
                    :value="item.id"
                    :key="item.id"
                  >
                    {{ item.address }}
                  </option>
                </select>
              </div>
              <label class="inline-flex text-sm items-center mx-2 mt-2">
                <input
                  type="checkbox"
                  class="form-checkbox h-4 w-4 text-gray-800"
                  v-model="expenses.fav_origin_address"
                  @change="expenses.origin_address = ''"
                />
                <span class="ml-2 text-gray-700">
                  {{ data.condition === 'FOB' ? 'Puertos favoritos' : 'Almacenes favoritos' }}
                </span>
              </label>
              <span
                class="text-xs text-red-600 dark:text-red-400"
                v-if="expenses.errors.has('origin_address')"
                v-html="expenses.errors.get('origin_address')"
              ></span>
            </div>
          </div>

          <!-- Codigo postal origen -->
          <div
            v-if="postalCodeOrigin && !expenses.fav_origin_address"
            class="w-72 md:w-8/12 flex justify-center px-3 mb-6 md:mb-0"
          >
            <div class="w-full">
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
          <div class="w-72 md:w-8/12 flex justify-center px-3 mb-6 md:mb-0">
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
          <div class="w-72 md:w-8/12 flex justify-center px-3 mb-6 md:mb-0">
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
          <div class="flex justify-center w-full py-4">
            <button
              v-if="!showShipping"
              @click="showShippingMethod()"
              class="
                md:w-2/12
                bg-transparent
                focus:outline-none
                uppercase
                text-xs
                hover:bg-blue-600
                text-blue-700
                font-semibold
                hover:text-white
                py-2
                px-2
                border border-blue-500
                hover:border-transparent
                rounded
              "
            >
              Transporte Local
            </button>
            <button
              v-else-if="showShipping"
              @click="HideShippingMethod()"
              class="
                md:w-2/12
                bg-transparent
                focus:outline-none
                uppercase
                text-xs
                hover:bg-blue-600
                text-blue-700
                font-semibold
                hover:text-white
                py-2
                px-2
                border border-blue-500
                hover:border-transparent
                rounded
              "
            >
              Transporte Local
            </button>
            <hr class="md:w-8/12 md:mt-4 md:mb-4 md:border-solid md:border-t-2" />
          </div>

          <!-- Destino de Envio -->
          <div v-if="showShipping" class="w-72 md:w-8/12 flex justify-center px-3 mb-6 md:mb-0">
            <div class="w-full">
              <span class="text-sm font-semibold">Destino</span>
              <div class="flex" v-if="!expenses.fav_dest_address">
                <vue-google-autocomplete
                  v-model="expenses.dest_address"
                  id="addressDestination"
                  classname="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  :placeholder="
                    expenses.fav_dest_address
                      ? 'Nombre o codigo Puerto/Aeropuerto'
                      : 'Direccion, Codigo Postal'
                  "
                  v-on:placechanged="getAddressDestination"
                >
                </vue-google-autocomplete>
              </div>
              <div v-else class="flex">
                <select
                  v-model="expenses.dest_address"
                  class="text-sm block w-full mt-1 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray"
                >
                  <option
                    v-for="item in addressDestination"
                    :value="item.id"
                    :key="item.id"
                    class=""
                  >
                    {{ item.address }}
                  </option>
                </select>
              </div>
              <label class="inline-flex text-sm items-center mx-2 mt-2">
                <input
                  type="checkbox"
                  class="form-checkbox h-4 w-4 text-gray-800"
                  v-model="expenses.fav_dest_address"
                  @change="expenses.dest_address = ''"
                /><span class="ml-2 text-gray-700"> Direccion de Destino Favoritas </span>
              </label>
              <span
                class="text-xs text-red-600 dark:text-red-400"
                v-if="expenses.errors.has('dest_address')"
                v-html="expenses.errors.get('dest_address')"
              ></span>
            </div>
          </div>

          <!-- codigo postal de destino -->
          <div
            v-if="postalCodeDestination && !expenses.fav_dest_address"
            class="w-72 md:w-8/12 flex justify-center px-3 mb-6 md:mb-0"
          >
            <div class="w-full">
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
      <transition name="fade">
        <FormDate v-if="$store.state.address.addressDate" />
      </transition>
    </section>

    <!-- Form if data.condition is FOB -->
    <section v-if="data.condition == 'FOB'">
      <transition name="fade">
        <div
          v-if="
            !expenses.dataLoad || expenses.dataLoad.length == 0 || $store.state.address.formAddress
          "
          class="w-full flex flex-col flex-wrap sm:items-center my-8"
        >
          <h3 class="mb-10 text-center">Direcciones y Puertos</h3>

          <!-- Aeropuerto / Puerto origen -->
          <div class="w-72 md:w-8/12 flex justify-center px-3 mb-6 md:mb-0">
            <div class="w-full">
              <span class="text-sm font-semibold"
                >{{ data.type_transport === 'AEREO' ? 'Aeropuerto' : 'Puerto' }} Origen</span
              >
              <div class="flex">
                <v-select
                  class="w-full"
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
          <div class="w-72 md:w-8/12 flex justify-center px-3 mb-6 md:mb-0">
            <div class="w-full">
              <span class="text-sm font-semibold"
                >{{ data.type_transport === 'AEREO' ? 'Aeropuerto' : 'Puerto' }} Destino</span
              >
              <div class="flex">
                <v-select
                  class="w-full"
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

          <!-- Boton transporte local -->
          <div class="flex justify-center w-full py-4">
            <button
              v-if="!showShipping"
              @click="showShippingMethod()"
              class="
                md:w-2/12
                bg-transparent
                focus:outline-none
                uppercase
                text-xs
                hover:bg-blue-600
                text-blue-700
                font-semibold
                hover:text-white
                py-2
                px-2
                border border-blue-500
                hover:border-transparent
                rounded
              "
            >
              Transporte Local
            </button>
            <button
              v-else-if="showShipping"
              @click="HideShippingMethod()"
              class="
                md:w-2/12
                bg-transparent
                focus:outline-none
                uppercase
                text-xs
                hover:bg-blue-600
                text-blue-700
                font-semibold
                hover:text-white
                py-2
                px-2
                border border-blue-500
                hover:border-transparent
                rounded
              "
            >
              Transporte Local
            </button>
            <hr class="md:w-8/12 md:mt-4 md:mb-4 md:border-solid md:border-t-2" />
          </div>

          <!-- Destino de Envio -->
          <div v-if="showShipping" class="w-72 md:w-8/12 flex justify-center px-3 mb-6 md:mb-0">
            <div class="w-full">
              <span class="text-sm font-semibold">Destino</span>
              <div class="flex" v-if="!expenses.fav_dest_address">
                <vue-google-autocomplete
                  v-model="expenses.dest_address"
                  id="addressDestination"
                  classname="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  :placeholder="
                    expenses.fav_dest_address
                      ? 'Nombre o codigo Puerto/Aeropuerto'
                      : 'Direccion, Codigo Postal'
                  "
                  v-on:placechanged="getAddressDestination"
                >
                </vue-google-autocomplete>
              </div>
              <div v-else class="flex">
                <select
                  v-model="expenses.dest_address"
                  class="text-sm block w-full mt-1 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray"
                >
                  <option
                    v-for="item in addressDestination"
                    :value="item.id"
                    :key="item.id"
                    class=""
                  >
                    {{ item.address }}
                  </option>
                </select>
              </div>
              <label class="inline-flex text-sm items-center mx-2 mt-2">
                <input
                  type="checkbox"
                  class="form-checkbox h-4 w-4 text-gray-800"
                  v-model="expenses.fav_dest_address"
                  @change="expenses.dest_address = ''"
                /><span class="ml-2 text-gray-700"> Direccion de Destino Favoritas </span>
              </label>
              <span
                class="text-xs text-red-600 dark:text-red-400"
                v-if="expenses.errors.has('dest_address')"
                v-html="expenses.errors.get('dest_address')"
              ></span>
            </div>
          </div>

          <!-- codigo postal de destino -->
          <div
            v-if="postalCodeDestination && !expenses.fav_dest_address"
            class="w-72 md:w-8/12 flex justify-center px-3 mb-6 md:mb-0"
          >
            <div class="w-full">
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
      <transition name="fade">
        <FormDate v-if="$store.state.address.addressDate" />
      </transition>
    </section>

    <!-- fcl table quote   -->
    <section v-if="fclTableQuote" class="md:flex md:justify-center">
      <div class="md:flex md:w-10/12 overflow-x-auto rounded-lg shadow-xs">
        <table v-if="data.condition == 'EXW'" class="table-auto md:w-full whitespace-no-wrap">
          <thead>
            <tr class="text-sm text-center font-semibold tracking-wide text-left text-white">
              <th
                class="
                w-1/12
                px-4 
                py-3
                border-b
                dark:border-gray-700
                bg-blue-900
                dark:text-gray-400 dark:bg-gray-800
                "
              >
                {{ this.$store.state.application.selectedCondition.name }}
              </th>
              <th
                class="
                w-4/12
                px-4 
                py-3
                border-b
                dark:border-gray-700
                bg-blue-900
                dark:text-gray-400 dark:bg-gray-800
                "
              >
                CONCEPTO
              </th>
              <th
                class="
                w-2/12
                px-4 
                py-3
                border-b
                dark:border-gray-700
                bg-blue-900
                dark:text-gray-400 dark:bg-gray-800
                "
              >
                TARIFA
              </th>
              <th
                class="
                w-1/12
                px-4 
                py-3
                border-b
                dark:border-gray-700
                bg-blue-900
                dark:text-gray-400 dark:bg-gray-800
                "
              >
                MONEDA
              </th>
            </tr>
          </thead>
          <tbody class="text-center bg-white dark:bg-gray-800">
            <tr class="text-sm text-gray-700 dark:text-gray-400">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">TRAMO LOCAL (ORIGEN)</td>
              <td class="text-red-600 font-semibold px-4 py-3">POR COTIZAR</td>
              <td class="px-4 py-3">USD</td>
            </tr>
            <tr class="text-sm text-gray-700 dark:text-gray-400 divide-y dark:divide-gray-700">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">TRANSPORTE INTERNACIONAL</td>
              <td
                :class="[
                  !fclQuote.transport.transport_amount
                    ? 'text-red-600 font-semibold px-4 py-3'
                    : 'font-semibold px-4 py-3'
                ]"
              >
                {{
                  fclQuote.transport.transport_amount
                    ? formatPrice(fclQuote.transport.transport_amount)
                    : 'POR COTIZAR'
                }}
              </td>
              <td class="px-4 py-3">USD</td>
            </tr>
            <tr class="text-sm text-gray-700 dark:text-gray-400 divide-y dark:divide-gray-700">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">SEGURO</td>
              <td
                :class="[
                  !fclQuote.transport.insurance
                    ? 'text-red-600 font-semibold px-4 py-3'
                    : 'font-semibold px-4 py-3'
                ]"
              >
                {{
                  fclQuote.transport.insurance
                    ? formatPrice(fclQuote.transport.insurance)
                    : 'POR COTIZAR'
                }}
              </td>
              <td class="px-4 py-3">USD</td>
            </tr>
            <tr class="text-sm text-gray-700 dark:text-gray-400 divide-y dark:divide-gray-700">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">GASTOS LOCALES</td>
              <td
                :class="[
                  !fclQuote.transport.oth_exp
                    ? 'text-red-600 font-semibold px-4 py-3'
                    : 'font-semibold px-4 py-3'
                ]"
              >
                {{
                  fclQuote.transport.oth_exp
                    ? formatPrice(fclQuote.transport.oth_exp)
                    : 'POR COTIZAR'
                }}
              </td>
              <td class="px-4 py-3">CLP</td>
            </tr>
            <tr class="text-sm text-gray-700 dark:text-gray-400 divide-y dark:divide-gray-700">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">TRANSPORTE LOCAL</td>
              <td
                :class="[
                  !fclQuote.transport.local_transp
                    ? 'text-red-600 font-semibold px-4 py-3'
                    : 'font-semibold px-4 py-3'
                ]"
              >
                {{
                  fclQuote.transport.local_transp
                    ? formatPrice(fclQuote.transport.local_transp)
                    : 'POR COTIZAR'
                }}
              </td>
              <td class="px-4 py-3">CLP</td>
            </tr>
          </tbody>
        </table>

        <table v-if="data.condition == 'FOB'" class="table-auto md:w-full whitespace-no-wrap">
          <thead>
            <tr class="text-sm text-center font-semibold tracking-wide text-left text-white">
              <th
                class="
                  w-1/12
                  px-4 
                  py-3
                  border-b
                  dark:border-gray-700
                  bg-blue-900
                  dark:text-gray-400 dark:bg-gray-800
                "
              >
                {{ this.$store.state.application.selectedCondition.name }}
              </th>
              <th
                class="
                  w-4/12
                  px-4 
                  py-3
                  border-b
                  dark:border-gray-700
                  bg-blue-900
                  dark:text-gray-400 dark:bg-gray-800
                "
              >
                CONCEPTO
              </th>
              <th
                class="
                  w-2/12
                  px-4 
                  py-3
                  border-b
                  dark:border-gray-700
                  bg-blue-900
                  dark:text-gray-400 dark:bg-gray-800
                "
              >
                TARIFA
              </th>
              <th
                class="
                  w-1/12
                  px-4 
                  py-3
                  border-b
                  dark:border-gray-700
                  bg-blue-900
                  dark:text-gray-400 dark:bg-gray-800
                "
              >
                MONEDA
              </th>
            </tr>
          </thead>
          <tbody class="text-center bg-white dark:bg-gray-800">
            <!-- <tr class="text-center">
              <td class="px-4 py-3">{{ this.$store.state.application.selectedCondition.name }}</td>
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">&nbsp;</td>
            </tr> -->
            <tr class="text-sm text-gray-700 dark:text-gray-400 divide-y dark:divide-gray-700">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">TRANSPORTE INTERNACIONAL</td>
              <td
                :class="[
                  !fclQuote.transport.transport_amount
                    ? 'text-red-600 font-semibold px-4 py-3'
                    : 'font-semibold px-4 py-3'
                ]"
              >
                {{
                  fclQuote.transport.transport_amount
                    ? formatPrice(fclQuote.transport.transport_amount)
                    : 'POR COTIZAR'
                }}
              </td>
              <td class="px-4 py-3">USD</td>
            </tr>
            <tr class="text-sm text-gray-700 dark:text-gray-400 divide-y dark:divide-gray-700">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">SEGURO</td>
              <td
                :class="[
                  !fclQuote.transport.insurance
                    ? 'text-red-600 font-semibold px-4 py-3'
                    : 'font-semibold px-4 py-3'
                ]"
              >
                {{
                  fclQuote.transport.insurance
                    ? formatPrice(fclQuote.transport.insurance)
                    : 'POR COTIZAR'
                }}
              </td>
              <td class="px-4 py-3">USD</td>
            </tr>
            <tr class="text-sm text-gray-700 dark:text-gray-400 divide-y dark:divide-gray-700">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">GASTOS LOCALES</td>
              <td
                :class="[
                  !fclQuote.transport.oth_exp
                    ? 'text-red-600 font-semibold px-4 py-3'
                    : 'font-semibold px-4 py-3'
                ]"
              >
                {{
                  fclQuote.transport.oth_exp
                    ? formatPrice(fclQuote.transport.oth_exp)
                    : 'POR COTIZAR'
                }}
              </td>
              <td class="px-4 py-3">CLP</td>
            </tr>
            <tr class="text-sm text-gray-700 dark:text-gray-400 divide-y dark:divide-gray-700">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">TRANSPORTE LOCAL</td>
              <td
                :class="[
                  !fclQuote.transport.local_transp
                    ? 'text-red-600 font-semibold px-4 py-3'
                    : 'font-semibold px-4 py-3'
                ]"
              >
                {{
                  fclQuote.transport.local_transp
                    ? formatPrice(fclQuote.transport.local_transp)
                    : 'POR COTIZAR'
                }}
              </td>
              <td class="px-4 py-3">CLP</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

    <!-- botones cotizar/editar -->
    <section
      :class="[
        !expenses.dataLoad || expenses.dataLoad.length <= 0
          ? 'flex justify-center'
          : 'flex justify-center my-5 innline w-1/7 mt-5'
      ]"
    >
      <button v-if="!expenses.dataLoad" class="hidden" @click="HideAddress()">Editar</button>

      <button
        v-else-if="expenses.dataLoad.length > 0"
        @click="HideAddress()"
        class="
          mr-4
          w-24
          h-12
          text-white
          transition-colors
          text-lg
          bg-green-700
          rounded-lg
          focus:shadow-outline
          hover:bg-green-800
        "
      >
        Editar
      </button>
      <button
        @click="submitQuote()"
        :class="[
          !expenses.dataLoad
            ? 'w-1/3 h-12 px-4 text-white transition-colors text-lg bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800'
            : expenses.dataLoad.length <= 0
            ? 'vld-parent w-1/3 h-12 px-4 text-white transition-colors text-lg bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800'
            : 'ml-4 w-24 h-12 text-white transition-colors text-lg bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800'
        ]"
      >
        Cotizar
      </button>
    </section>
  </section>
</template>

<script>
import FormDate from './FormDate.vue';
import VueGoogleAutocomplete from 'vue-google-autocomplete';
import { mapState } from 'vuex';
import Button from '../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Button.vue';

export default {
  components: { VueGoogleAutocomplete, Button, FormDate },
  data() {
    return {
      fclQuote: {},
      fclTableQuote: false
    };
  },
  methods: {
    /**
     * Send api quote (button Cotizar fedex, dhl, ups)
     * @param {Number} appAmount selected service amount if fedex, dhl or ups
     * @param {Number} transCompanyId number of the service that is selected:
     * @param {2} FEDEX
     * @param {3} DHL
     * @param {4} UPS
     */
    async submitQuote(appAmount, transCompanyId) {
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

      this.$store.dispatch('address/showAddress', false);
      this.$store.dispatch('load/showLoadCharge', false);

      try {
        this.expenses.dataLoad = this.$store.state.load.loads;
        this.expenses.app_amount = appAmount;
        this.expenses.trans_company_id = transCompanyId;
        const fclResponse = await this.expenses.post('/applications/transports');

        /* Show fclTableQuote  */
        if (fclResponse.status == 200) {
          this.fclTableQuote = true;
          this.fclQuote = fclResponse.data;

          /* Vue-loader hidden */
          loader.hide();
        }

        // Message to validate if transport_amount is 0
        if (fclResponse.data.transport.transport_amount === 0) {
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
        this.$store.dispatch('load/setLoad', fclResponse.data);
        // this.$store.dispatch('callIncomingOrNextMenu', true);
      } catch (error) {
        console.error(error);
      }
    },

    /**
     * Show / Hide from address (button "Editar")
     */
    HideAddress() {
      this.$store.dispatch('address/showAddress', true);
      this.$store.dispatch('load/showLoadCharge', true); /* Hide / Show loads and dimensions form */
      this.fclTableQuote = false;
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

    showShippingMethod() {
      this.$store.dispatch('address/showLocalShipping', true);
    },
    HideShippingMethod() {
      this.$store.dispatch('address/showLocalShipping', false);
    },

    /**
     * When the location found
     * @param {Object} addressData Data of the found location
     * @param {Object} placeResultData PlaceResult object
     * @param {String} id Input container ID
     */
    getAddressOrigin(addressData, placeResultData, id) {
      this.$store.dispatch('address/getAddressOrigin', { addressData, placeResultData });
    },

    getAddressDestination(addressData, placeResultData, id) {
      this.$store.dispatch('address/getAddressDestination2', { addressData, placeResultData });
    },

    formatPrice(value, currency) {
      return Number(value).toLocaleString(navigator.language, {
        minimumFractionDigits: currency == 'CLP' ? 0 : 2,
        maximumFractionDigits: currency == 'CLP' ? 0 : 2
      });
    }
  },
  computed: {
    ...mapState('address', [
      'expenses',
      'addressDestination',
      'portsOrigin',
      'portsOriginTemp',
      'portsDestination',
      'portsDesTemp',
      'addressDate',
      'formAddress',
      'postalCodeOrigin',
      'postalCodeDestination',
      'showShipping'
    ]),
    ...mapState('application', ['data', 'currency', 'origin_transport'])
  }
};
</script>

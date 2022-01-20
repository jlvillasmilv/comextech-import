<template>
  <div>
    <div v-if="data.condition == 'EXW'">
      <transition name="fade">
        <div
          v-if="
            !expenses.dataLoad || expenses.dataLoad.length == 0 || $store.state.address.formAddress
          "
          class="w-full flex flex-col flex-wrap items-center my-8"
        >
          <!-- Direccion de origen -->
          <h3 class="mb-10">Direcciones y Puertos</h3>
          <div class="flex justify-center w-full px-3 mb-6 md:mb-0">
            <div class="mt-2 mr-8 flex justify-start w-2/12">
              Direccion Origen
            </div>
            <label class="w-6/12 text-sm">
              <vue-google-autocomplete
                v-if="!expenses.fav_origin_address"
                v-model="expenses.origin_address"
                id="addressOrigin"
                classname="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                v-on:placechanged="getAddressOrigin"
                placeholder="Direccion, Codigo Postal"
              >
              </vue-google-autocomplete>
              <div v-else class="relative">
                <select
                  v-model="expenses.origin_address"
                  class="block w-full mt-1 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray"
                >
                  <option v-for="item in origin_transport" :value="item.id" :key="item.id">
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
                  Tus
                  {{ data.condition === 'FOB' ? 'Puertos' : 'Almacenes o Fabricas' }}
                  Favoritos
                </span>
              </label>
              <span
                class="text-xs text-red-600 dark:text-red-400"
                v-if="expenses.errors.has('origin_address')"
                v-html="expenses.errors.get('origin_address')"
              ></span>
            </label>
            <div class="flex justify-end w-1/12">
              <h3 class="mt-2">Recogida</h3>
            </div>
          </div>
          <!-- Codigo postal origen -->
          <div
            v-if="postalCodeOrigin && !expenses.fav_origin_address"
            class="flex justify-center w-full px-3 mb-6 md:mb-0"
          >
            <div class="mt-2 mr-8 flex justify-start w-2/12">
              Codigo postal de origen
            </div>
            <label class="w-6/12 text-sm">
              <input
                class="w-full block border border-gray-150 text-gray-700 p-2 mt-1 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                type="number"
                max="15"
                v-model="expenses.origin_postal_code"
                placeholder="Código postal de origen"
              />
              <span
                class="text-xs text-red-600 dark:text-red-400"
                v-if="expenses.errors.has('origin_postal_code')"
                v-html="expenses.errors.get('origin_postal_code')"
              ></span>
            </label>
            <div class="flex justify-center w-1/12">
              <h3 class="mt-2"></h3>
            </div>
          </div>
          <!-- Aeropuerto / Puerto origen -->
          <div class="flex justify-center w-full px-3 mb-6 md:mb-0">
            <div class="mt-2 mr-8 flex justify-start w-2/12">
              <h3>
                {{ data.type_transport === 'AEREO' ? 'Aeropuerto' : 'Puerto' }}
                Origen
              </h3>
            </div>
            <label class="w-6/12 text-sm">
              <div class="relative">
                <v-select
                  label="name"
                  v-model="expenses.origin_port_id"
                  placeholder="Puerto Origen"
                  :options="portsOrigin"
                  :reduce="(portsOrigin) => portsOrigin.id"
                >
                  <template
                    v-slot:no-options="{
                      search,
                      searching
                    }"
                  >
                    <template v-if="searching" class="text-sm">
                      Lo sentimos no hay opciones que coincidan
                      <strong>{{ search }}</strong
                      >.
                    </template>
                    <em style="opacity: 0.5" v-else>
                      Puertos
                    </em>
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
                  Tus
                  {{ data.type_transport === 'AEREO' ? 'Aeropuertos' : 'Puertos' }}
                  Favoritos
                </span>
              </label>
              <span
                class="text-xs text-red-600 dark:text-red-400"
                v-if="expenses.errors.has('origin_port_address')"
                v-html="expenses.errors.get('origin_port_address')"
              ></span>
            </label>
            <div class="flex justify-end w-1/12">
              <!-- <h3 class="mt-2">Recogida</h3> -->
            </div>
          </div>
          <!-- Aeropuerto / Puerto destino -->
          <div class="flex justify-center w-full px-3 mb-6 md:mb-0">
            <div class="mt-2 mr-8 flex justify-start w-2/12">
              <h3>
                {{ data.type_transport === 'AEREO' ? 'Aeropuerto' : 'Puerto' }}
                Destino
              </h3>
            </div>
            <label class="w-6/12 text-sm">
              <div>
                <v-select
                  label="name"
                  v-model="expenses.dest_port_id"
                  placeholder="Puerto Destino"
                  :options="portsDestination"
                  :reduce="(portsDestination) => portsDestination.id"
                >
                  <template
                    v-slot:no-options="{
                      search,
                      searching
                    }"
                  >
                    <template v-if="searching" class="text-sm">
                      Lo sentimos no hay opciones que coincidan
                      <strong>{{ search }}</strong
                      >.
                    </template>
                    <em style="opacity: 0.5" v-else>
                      Puertos
                    </em>
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
                  Tus
                  {{ data.type_transport === 'AEREO' ? 'Aero puertos' : 'Puertos' }}
                  Favoritos
                </span>
              </label>
              <span
                class="text-xs text-red-600 dark:text-red-400"
                v-if="expenses.errors.has('dest_port_id')"
                v-html="expenses.errors.get('dest_port_id')"
              ></span>
            </label>
            <div class="flex justify-end w-1/12">
              <!-- <h3 class="mt-2">Recogida</h3> -->
            </div>
          </div>
          <!-- Boton transporte local -->
          <div class="flex justify-center w-full py-4">
            <button
              v-if="!showShipping"
              @click="showShippingMethod()"
              class="w-2/12 bg-transparent focus:outline-none uppercase text-xs hover:bg-blue-600 text-blue-700 font-semibold hover:text-white py-2 px-2 border border-blue-500 hover:border-transparent rounded"
            >
              Transporte Local
            </button>
            <button
              v-else-if="showShipping"
              @click="HideShippingMethod()"
              class="w-2/12 bg-transparent focus:outline-none uppercase text-xs hover:bg-blue-600 text-blue-700 font-semibold hover:text-white py-2 px-2 border border-blue-500 hover:border-transparent rounded"
            >
              Transporte Local
            </button>
            <hr class="w-8/12 mt-4 mb-4 border-solid border-t-2" />
          </div>
          <!-- Destino de Envio -->
          <div v-if="showShipping" class="flex justify-center w-full px-3 mb-6 md:mb-0">
            <div class="mt-2 mr-8 flex justify-start w-2/12">
              <h3>
                Direccion Destino
              </h3>
            </div>
            <label class="w-6/12 text-sm">
              <vue-google-autocomplete
                v-if="!expenses.fav_dest_address"
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

              <div v-else class="relative">
                <select
                  v-model="expenses.dest_address"
                  class="block w-full mt-1 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray"
                >
                  <option
                    v-for="item in addressDestination"
                    :value="item.id"
                    :key="item.id"
                    class=" "
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
                /><span class="ml-2 text-gray-700">
                  Direccion de Destino Favoritas
                </span>
              </label>
            </label>
            <div class="flex justify-end w-1/12">
              <h3 class="mt-2">Recogida</h3>
            </div>
            <span
              class="text-xs text-red-600 dark:text-red-400"
              v-if="expenses.errors.has('dest_address')"
              v-html="expenses.errors.get('dest_address')"
            ></span>
          </div>
          <!-- codigo postal de destino -->
          <div
            v-if="postalCodeDestination && !expenses.fav_dest_address"
            class="flex justify-center w-full px-3 mb-6 md:mb-0"
          >
            <div class="mt-2 mr-8 flex justify-start w-2/12">
              Codigo postal de destino
            </div>
            <label class="w-6/12 text-sm">
              <input
                class="w-full block border border-gray-150 text-gray-700 p-2 mt-1 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                type="number"
                max="15"
                v-model="expenses.dest_postal_code"
                placeholder="Código postal de destino"
              />
              <span
                class="text-xs text-red-600 dark:text-red-400"
                v-if="expenses.errors.has('dest_postal_code')"
                v-html="expenses.errors.get('dest_postal_code')"
              ></span>
            </label>
            <div class="flex justify-center w-1/12">
              <h3 class="mt-2"></h3>
            </div>
          </div>
        </div>
      </transition>

      <!-- Date and description -->
      <transition name="fade">
        <FormDate v-if="$store.state.address.addressDate" />
      </transition>
    </div>

    <!-- Form if data.condition is FOB -->
    <div v-if="data.condition == 'FOB'">
      <transition name="fade">
        <div
          v-if="
            !expenses.dataLoad || expenses.dataLoad.length == 0 || $store.state.address.formAddress
          "
          class="flex flex-col items-center flex-wrap w-full -mx-3 my-8"
        >
          <h3 class="mb-10">Direcciones y Puertos</h3>
          <!-- <div
                            class="flex justify-around w-full px-3 mb-6 md:mb-0"
                        >
                            <div class="flex justify-start w-2/12">
                                <h3 class="mt-2">
                                    Direccion Origen
                                </h3>
                            </div>
                            <label class="w-8/12 text-sm">
                                <vue-google-autocomplete
                                    v-if="!expenses.fav_origin_address"
                                    v-model="expenses.origin_address"
                                    id="addressOrigin"
                                    classname="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    v-on:placechanged="getAddressOrigin"
                                    placeholder="Direccion, Codigo Postal"
                                >
                                </vue-google-autocomplete>
                                <div v-else class="relative">
                                    <select
                                        v-model="expenses.origin_address"
                                        class="
                      block
                      w-full
                      border border-gray-150
                      text-gray-700
                      p-2
                      mt-1
                      pr-8
                      rounded
                      leading-tight
                      focus:outline-none
                      focus:bg-white
                      focus:border-gray-500
                  "
                                    >
                                        <option
                                            v-for="item in origin_transport"
                                            :value="item.id"
                                            :key="item.id"
                                            class=" "
                                        >
                                            {{ item.address }}
                                        </option>
                                    </select>
                                </div>
                                <label
                                    class="inline-flex text-sm items-center mx-2 mt-2"
                                >
                                    <input
                                        type="checkbox"
                                        class="form-checkbox h-4 w-4 text-gray-800"
                                        v-model="expenses.fav_origin_address"
                                        @change="expenses.origin_address = ''"
                                    />
                                    <span class="ml-2 text-gray-700">
                                        Tus
                                        {{
                                            data.condition === 'FOB'
                                                ? 'Puertos'
                                                : 'Almacenes o Fabricas'
                                        }}
                                        Favoritos
                                    </span>
                                </label>
                                <span
                                    class="text-xs text-red-600 dark:text-red-400"
                                    v-if="expenses.errors.has('origin_address')"
                                    v-html="
                                        expenses.errors.get('origin_address')
                                    "
                                ></span>
                            </label>
                            <div class="flex justify-center w-2/12">
                                <h3 class="mt-2">Recogida</h3>
                            </div>
                        </div> -->

          <!-- Aeropuerto / Puerto origen -->
          <div class="flex justify-center w-full px-3 mb-6 md:mb-0">
            <div class="mt-2 mr-8 flex justify-start w-2/12">
              <h3>
                {{ data.type_transport === 'AEREO' ? 'Aeropuerto' : 'Puerto' }}
                Origen
              </h3>
            </div>
            <label class="w-6/12 text-sm">
              <div class="relative">
                <v-select
                  label="name"
                  v-model="expenses.origin_port_id"
                  placeholder="Puerto Origen"
                  :options="portsOrigin"
                  :reduce="(portsOrigin) => portsOrigin.id"
                >
                  <template
                    v-slot:no-options="{
                      search,
                      searching
                    }"
                  >
                    <template v-if="searching" class="text-sm">
                      Lo sentimos no hay opciones que coincidan
                      <strong>{{ search }}</strong
                      >.
                    </template>
                    <em style="opacity: 0.5" v-else>
                      Puertos
                    </em>
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
                  Tus
                  {{ data.type_transport === 'AEREO' ? 'Aeropuertos' : 'Puertos' }}
                  Favoritos
                </span>
              </label>
              <span
                class="text-xs text-red-600 dark:text-red-400"
                v-if="expenses.errors.has('origin_port_address')"
                v-html="expenses.errors.get('origin_port_address')"
              ></span>
            </label>
            <div class="flex justify-end w-1/12">
              <!-- <h3 class="mt-2">Recogida</h3> -->
            </div>
          </div>

          <!-- Aeropuerto / Puerto destino -->
          <div class="flex justify-center w-full px-3 mb-6 md:mb-0">
            <div class="mt-2 mr-8 flex justify-start w-2/12">
              <h3>
                {{ data.type_transport === 'AEREO' ? 'Aeropuerto' : 'Puerto' }}
                Destino
              </h3>
            </div>
            <label class="w-6/12 text-sm">
              <div>
                <v-select
                  label="name"
                  v-model="expenses.dest_port_id"
                  placeholder="Puerto Destino"
                  :options="portsDestination"
                  :reduce="(portsDestination) => portsDestination.id"
                >
                  <template
                    v-slot:no-options="{
                      search,
                      searching
                    }"
                  >
                    <template v-if="searching" class="text-sm">
                      Lo sentimos no hay opciones que coincidan
                      <strong>{{ search }}</strong
                      >.
                    </template>
                    <em style="opacity: 0.5" v-else>
                      Puertos
                    </em>
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
                  Tus
                  {{ data.type_transport === 'AEREO' ? 'Aero puertos' : 'Puertos' }}
                  Favoritos
                </span>
              </label>
              <span
                class="text-xs text-red-600 dark:text-red-400"
                v-if="expenses.errors.has('dest_port_id')"
                v-html="expenses.errors.get('dest_port_id')"
              ></span>
            </label>
            <div class="flex justify-end w-1/12">
              <!-- <h3 class="mt-2">Recogida</h3> -->
            </div>
          </div>

          <!-- Boton transporte local -->
          <div class="flex justify-center w-full py-4">
            <button
              v-if="!showShipping"
              @click="showShippingMethod()"
              class="w-2/12 bg-transparent focus:outline-none uppercase text-xs hover:bg-blue-600 text-blue-700 font-semibold hover:text-white py-2 px-2 border border-blue-500 hover:border-transparent rounded"
            >
              Transporte Local
            </button>
            <button
              v-else-if="showShipping"
              @click="HideShippingMethod()"
              class="w-2/12 bg-transparent focus:outline-none uppercase text-xs hover:bg-blue-600 text-blue-700 font-semibold hover:text-white py-2 px-2 border border-blue-500 hover:border-transparent rounded"
            >
              Transporte Local
            </button>
            <hr class="w-8/12 mt-4 mb-4 border-solid border-t-2" />
          </div>

          <!-- Destino de Envio -->
          <div v-if="showShipping" class="flex justify-center w-full px-3 mb-6 md:mb-0">
            <div class="mt-2 mr-8 flex justify-start w-2/12">
              <h3>
                Direccion Destino
              </h3>
            </div>
            <label class="w-6/12 text-sm">
              <vue-google-autocomplete
                v-if="!expenses.fav_dest_address"
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

              <div v-else class="relative">
                <select
                  v-model="expenses.dest_address"
                  class="block w-full mt-1 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray"
                >
                  <option
                    v-for="item in addressDestination"
                    :value="item.id"
                    :key="item.id"
                    class=" "
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
                /><span class="ml-2 text-gray-700">
                  Direccion de Destino Favoritas
                </span>
              </label>
            </label>
            <div class="flex justify-end w-1/12">
              <h3 class="mt-2">Recogida</h3>
            </div>
            <span
              class="text-xs text-red-600 dark:text-red-400"
              v-if="expenses.errors.has('dest_address')"
              v-html="expenses.errors.get('dest_address')"
            ></span>
          </div>
          <!-- codigo postal de destino -->
          <div
            v-if="postalCodeDestination && !expenses.fav_dest_address"
            class="flex justify-center w-full px-3 mb-6 md:mb-0"
          >
            <div class="mt-2 mr-8 flex justify-start w-2/12">
              Codigo postal de destino
            </div>
            <label class="w-6/12 text-sm">
              <input
                class="w-full block border border-gray-150 text-gray-700 p-2 mt-1 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                type="number"
                max="15"
                v-model="expenses.dest_postal_code"
                placeholder="Código postal de destino"
              />
              <span
                class="text-xs text-red-600 dark:text-red-400"
                v-if="expenses.errors.has('dest_postal_code')"
                v-html="expenses.errors.get('dest_postal_code')"
              ></span>
            </label>
            <div class="flex justify-center w-1/12">
              <h3 class="mt-2"></h3>
            </div>
          </div>
        </div>
      </transition>

      <!-- Date and description -->
      <transition name="fade">
        <FormDate v-if="$store.state.address.addressDate" />
      </transition>
    </div>

    <!-- lcl table quote -->
    <section v-if="lclTable">
      <div class="w-full overflow-x-auto mt-8 flex justify-center">
        <table v-if="data.condition == 'EXW'" class="w-full">
          <thead>
            <tr class="text-sm text-center font-semibold tracking-wide text-left text-white">
              <th
                class="px-4 py-3 border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800"
              >
                &nbsp;
              </th>
              <th
                class="px-4 py-3 border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800"
              >
                &nbsp;
              </th>
              <th
                class="px-4 py-3 border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800"
              >
                TARIFA
              </th>
              <th
                class="px-4 py-3 border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800"
              >
                MONEDA
              </th>
            </tr>
          </thead>
          <tbody class="text-center bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
            <tr class="text-xs text-gray-700 dark:text-gray-400">
              <td class="px-4 py-3">{{ this.$store.state.application.selectedCondition.name }}</td>
              <td class="px-4 py-3">TRAMO LOCAL (ORIGEN)</td>
              <td class="text-red-600 px-4 py-3">POR COTIZAR</td>
              <td class="px-4 py-3">USD</td>
            </tr>
            <tr class="text-xs text-gray-700 dark:text-gray-400">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">TRANSPORTE INTERNACIONAL</td>
              <td
                :class="[
                  !lclTableQuote.transport.transport_amount ? 'text-red-600 px-4 py-3' : 'px-4 py-3'
                ]"
              >
                {{
                  lclTableQuote.transport.transport_amount
                    ? formatPrice(lclTableQuote.transport.transport_amount)
                    : 'POR COTIZAR'
                }}
              </td>
              <td class="px-4 py-3">USD</td>
            </tr>
            <tr class="text-xs text-gray-700 dark:text-gray-400">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">SEGURO</td>
              <td
                :class="[
                  !lclTableQuote.transport.insurance ? 'text-red-600 px-4 py-3' : 'px-4 py-3'
                ]"
              >
                {{
                  lclTableQuote.transport.insurance
                    ? formatPrice(lclTableQuote.transport.insurance)
                    : 'POR COTIZAR'
                }}
              </td>
              <td class="px-4 py-3">USD</td>
            </tr>
            <tr class="text-xs text-gray-700 dark:text-gray-400">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">GASTOS LOCALES</td>
              <td
                :class="[!lclTableQuote.transport.oth_exp ? 'text-red-600 px-4 py-3' : 'px-4 py-3']"
              >
                {{
                  lclTableQuote.transport.oth_exp
                    ? formatPrice(lclTableQuote.transport.oth_exp)
                    : 'POR COTIZAR'
                }}
              </td>
              <td class="px-4 py-3">CLP</td>
            </tr>
            <tr class="text-xs text-gray-700 dark:text-gray-400">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">TRANSPORTE LOCAL</td>
              <td
                :class="[
                  !lclTableQuote.transport.local_transp ? 'text-red-600 px-4 py-3' : 'px-4 py-3'
                ]"
              >
                {{
                  lclTableQuote.transport.local_transp
                    ? formatPrice(lclTableQuote.transport.local_transp)
                    : 'POR COTIZAR'
                }}
              </td>
              <td class="px-4 py-3">CLP</td>
            </tr>
          </tbody>
        </table>

        <table v-if="data.condition == 'FOB'" class="w-full">
          <thead>
            <tr class="text-sm text-center font-semibold tracking-wide text-left text-white">
              <th
                class="px-4 py-3 border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800"
              >
                &nbsp;
              </th>
              <th
                class="px-4 py-3 border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800"
              >
                &nbsp;
              </th>
              <th
                class="px-4 py-3 border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800"
              >
                TARIFA
              </th>
              <th
                class="px-4 py-3 border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800"
              >
                MONEDA
              </th>
            </tr>
          </thead>
          <tbody class="text-center bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
            <!-- <tr class="text-center">
              <td class="px-4 py-3">{{ this.$store.state.application.selectedCondition.name }}</td>
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">&nbsp;</td>
            </tr> -->
            <tr class="text-xs text-gray-700 dark:text-gray-400">
              <td class="px-4 py-3">{{ this.$store.state.application.selectedCondition.name }}</td>
              <td class="px-4 py-3">TRANSPORTE INTERNACIONAL</td>
              <td
                :class="[
                  !lclTableQuote.transport.transport_amount ? 'text-red-600 px-4 py-3' : 'px-4 py-3'
                ]"
              >
                {{
                  lclTableQuote.transport.transport_amount
                    ? formatPrice(lclTableQuote.transport.transport_amount)
                    : 'POR COTIZAR'
                }}
              </td>
              <td class="px-4 py-3">USD</td>
            </tr>
            <tr class="text-xs text-gray-700 dark:text-gray-400">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">SEGURO</td>
              <td
                :class="[
                  !lclTableQuote.transport.insurance ? 'text-red-600 px-4 py-3' : 'px-4 py-3'
                ]"
              >
                {{
                  lclTableQuote.transport.insurance
                    ? formatPrice(lclTableQuote.transport.insurance)
                    : 'POR COTIZAR'
                }}
              </td>
              <td class="px-4 py-3">USD</td>
            </tr>
            <tr class="text-xs text-gray-700 dark:text-gray-400">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">GASTOS LOCALES</td>
              <td
                :class="[!lclTableQuote.transport.oth_exp ? 'text-red-600 px-4 py-3' : 'px-4 py-3']"
              >
                {{
                  lclTableQuote.transport.oth_exp
                    ? formatPrice(lclTableQuote.transport.oth_exp)
                    : 'POR COTIZAR'
                }}
              </td>
              <td class="px-4 py-3">CLP</td>
            </tr>
            <tr class="text-xs text-gray-700 dark:text-gray-400">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">TRANSPORTE LOCAL</td>
              <td
                :class="[
                  !lclTableQuote.transport.local_transp ? 'text-red-600 px-4 py-3' : 'px-4 py-3'
                ]"
              >
                {{
                  lclTableQuote.transport.local_transp
                    ? formatPrice(lclTableQuote.transport.local_transp)
                    : 'POR COTIZAR'
                }}
              </td>
              <td class="px-4 py-3">CLP</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
    <div
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
    </div>
  </div>
</template>

<script>
import FormDate from './FormDate.vue';
import VueGoogleAutocomplete from 'vue-google-autocomplete';
import { mapState } from 'vuex';
import Button from '../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Button.vue';

export default {
  components: { VueGoogleAutocomplete, mapState, Button, FormDate },
  data() {
    return {
      lclTableQuote: {},
      lclTable: false
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
        const lclResponse = await this.expenses.post('/applications/transports');

        /* Show fclTableQuote  */
        if (lclResponse.status == 200) {
          this.lclTableQuote = lclResponse.data;
          this.lclTable = true;

          /* Vue-loader hidden */
          loader.hide();
        }

        // Mensaje para validar si transport_amount es igual a 0
        if (lclResponse.data.transport.transport_amount === 0) {
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

              axios
                .post('/notifications-transport', { application_id: this.data.application_id })
                .then(function(response) {
                  console.log(response);
                })
                .catch(function(error) {
                  console.log(error);
                });
              // axios.post
              // Toast.fire({
              //   icon: 'success',
              //   title: 'Datos Agregados'
              // });
            }
          });
        } else {
          Toast.fire({
            icon: 'success',
            title: 'Datos Agregados'
          });
        }
       
        this.$store.dispatch('load/setLoad', lclResponse.data);
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
      this.lclTable = false;
    },

    getFavOriginPort: async function() {
      this.expenses.origin_port_id = '';
      if (this.expenses.fav_origin_port && this.data.supplier_id) {
        let idsupplier = this.data.supplier_id;
        const type = this.data.type_transport == 'AEREO' ? 'A' : 'P';
        await this.$store.dispatch('address/getFavOriginPort', {
          idsupplier,
          type
        });
      } else {
        await this.$store.dispatch('address/setOrigFavOritPorts');
      }
    },

    getFavDestPort: async function() {
      this.expenses.dest_port_id = '';
      const type = this.data.type_transport == 'AEREO' ? 'A' : 'P';
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

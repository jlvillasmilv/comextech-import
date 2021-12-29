<template>
  <div>
    <div v-if="data.condition == 'EXW'">
      <transition name="fade">
        <div
          v-if="
            !expenses.dataLoad || expenses.dataLoad.length == 0 || $store.state.address.formAddress
          "
          class="flex flex-col items-center flex-wrap w-full -mx-3 my-8"
        >
          <h3 class="mb-10">Direcciones y Puertos</h3>
          <div class="flex justify-around w-full px-3 mb-6 md:mb-0">
            <div class="flex justify-start w-2/12">
              <h3 class="mt-2">Direccion Origen</h3>
            </div>
            <label class="w-8/12 text-sm">
              <!-- <span
                                    class="text-gray-700 dark:text-gray-400 font-semibold"
                                >
                                    {{
                                        data.condition === 'FOB'
                                            ? ' Puertos de Proveedor'
                                            : ' Almacen o Fabrica del Proveedor'
                                    }}
                                </span> -->
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
                    focus:outline-none focus:bg-white focus:border-gray-500
                  "
                >
                  <option v-for="item in origin_transport" :value="item.id" :key="item.id" class="">
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
            <div class="flex justify-center w-2/12">
              <h3 class="mt-2">Recogida</h3>
            </div>
          </div>
          <div class="flex justify-around w-full px-3 mb-6 md:mb-0">
            <div class="flex justify-start w-2/12">
              <h3 class="mt-2">
                {{ data.type_transport === 'AEREO' ? 'Aeropuerto' : 'Puerto' }}
                Origen
              </h3>
            </div>
            <label class="w-8/12 text-sm">
              <div class="relative">
                <v-select
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
            <div class="flex justify-end w-2/12">
              <!-- <h3 class="mt-2">Recogida</h3> -->
            </div>
          </div>
          <div class="flex justify-around w-full px-3 mb-6 md:mb-0">
            <div class="flex justify-start w-2/12">
              <h3 class="mt-2">
                {{ data.type_transport === 'AEREO' ? 'Aeropuerto' : 'Puerto' }}
                Destino
              </h3>
            </div>
            <label class="w-8/12 text-sm">
              <div>
                <v-select
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
            <div class="flex justify-end w-2/12">
              <!-- <h3 class="mt-2">Recogida</h3> -->
            </div>
          </div>

          <div class="flex w-full py-4">
            <button
              @click="showShippingMethod()"
              class="
                w-2/12
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
            <hr class="w-8/12 mt-4 mb-4 border-solid border-t-2" />
          </div>

          <!-- Destino de Envio -->
          <div v-if="showShipping == true" class="flex justify-around w-full px-3 mb-6 md:mb-0">
            <div class="flex justify-start w-2/12">
              <h3 class="mt-2">Direccion Destino</h3>
            </div>
            <label class="w-8/12 text-sm">
              <!-- <span
                                    class="text-gray-700 dark:text-gray-400 font-semibold"
                                >
                                    Destino de Envio
                                </span> -->

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
                  class="
                    block
                    w-full
                    border border-gray-150
                    text-gray-700
                    p-2
                    pr-8
                    rounded
                    mt-1
                    leading-tight
                    focus:outline-none focus:bg-white focus:border-gray-500
                  "
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
            </label>
            <div class="flex justify-center w-2/12">
              <h3 class="mt-2">Recogida</h3>
            </div>

            <span
              class="text-xs text-red-600 dark:text-red-400"
              v-if="expenses.errors.has('dest_address')"
              v-html="expenses.errors.get('dest_address')"
            ></span>
          </div>
        </div>
      </transition>
      <transition name="fade">
        <div v-if="addressDate" class="flex flex-wrap justify-center -mx-3 mb-6">
          <div class="w-1/4 px-3 mb-6 md:mb-0">
            <label class="block text-sm">
              <span class="text-gray-700 dark:text-gray-400 font-semibold"> Fecha recogida </span>
              <input
                type="date"
                v-model="expenses.estimated_date"
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
                placeholder="Nombre o codigo Puerto/Aeropuerto"
                :min="minDate"
              />
              <span
                class="text-xs text-red-600 dark:text-red-400"
                v-if="expenses.errors.has('estimated_date')"
                v-html="expenses.errors.get('estimated_date')"
              ></span>
            </label>
          </div>
          <div class="w-1/3 px-2">
            <label class="block text-sm">
              <span class="text-gray-700 dark:text-gray-400 font-semibold">
                Descripcion de la carga
              </span>
              <input
                v-model="expenses.description"
                maxlength="250"
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
                placeholder="Introduzca la descripcion aqui"
              />
            </label>
            <span
              class="text-xs text-red-600 dark:text-red-400"
              v-if="expenses.errors.has('description')"
              v-html="expenses.errors.get('description')"
            ></span>
          </div>
          <div class="w-1/6 mt-8">
            <label class="ml-6 text-gray-500 dark:text-gray-400">
              <input
                type="checkbox"
                class="form-checkbox h-4 w-4 text-gray-800"
                v-model="expenses.insurance"
              />
              <span class="ml-2 text-gray-700">Seguro </span>
            </label>
          </div>
          <!-- <div class="w-1/6 mt-8" v-if="expenses.insurance">
                            <span class="ml-2 text-gray-700">
                                {{ (data.amount) * 0.03 }}
                                {{ currency.code }}
                            </span>
                        </div> -->
        </div>
      </transition>
    </div>

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
          <div class="flex justify-around w-full px-3 mb-6 md:mb-0">
            <div class="flex justify-start w-2/12">
              <h3 class="mt-2">
                {{ data.type_transport === 'AEREO' ? 'Aeropuerto' : 'Puerto' }}
                Origen
              </h3>
            </div>
            <label class="w-8/12 text-sm">
              <div class="relative">
                <v-select
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
            <div class="flex justify-end w-2/12">
              <!-- <h3 class="mt-2">Recogida</h3> -->
            </div>
          </div>
          <div class="flex justify-around w-full px-3 mb-6 md:mb-0">
            <div class="flex justify-start w-2/12">
              <h3 class="mt-2">
                {{ data.type_transport === 'AEREO' ? 'Aeropuerto' : 'Puerto' }}
                Destino
              </h3>
            </div>
            <label class="w-8/12 text-sm">
              <div>
                <v-select
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
            <div class="flex justify-end w-2/12">
              <!-- <h3 class="mt-2">Recogida</h3> -->
            </div>
          </div>

          <div class="flex w-full py-4">
            <button
              @click="showShippingMethod()"
              class="
                w-2/12
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
            <hr class="w-8/12 mt-4 mb-4 border-solid border-t-2" />
          </div>

          <!-- Destino de Envio -->
          <div v-if="showShipping == true" class="flex justify-around w-full px-3 mb-6 md:mb-0">
            <div class="flex justify-start w-2/12">
              <h3 class="mt-2">Direccion Destino</h3>
            </div>
            <label class="w-8/12 text-sm">
              <!-- <span
                                    class="text-gray-700 dark:text-gray-400 font-semibold"
                                >
                                    Destino de Envio
                                </span> -->

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
                  class="
                    block
                    w-full
                    border border-gray-150
                    text-gray-700
                    p-2
                    pr-8
                    rounded
                    mt-1
                    leading-tight
                    focus:outline-none focus:bg-white focus:border-gray-500
                  "
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
            </label>
            <div class="flex justify-center w-2/12">
              <h3 class="mt-2">Recogida</h3>
            </div>

            <span
              class="text-xs text-red-600 dark:text-red-400"
              v-if="expenses.errors.has('dest_address')"
              v-html="expenses.errors.get('dest_address')"
            ></span>
          </div>
        </div>
      </transition>
      <transition name="fade">
        <div v-if="addressDate" class="flex flex-wrap justify-center -mx-3 mb-6">
          <div class="w-1/4 px-3 mb-6 md:mb-0">
            <label class="block text-sm">
              <span class="text-gray-700 dark:text-gray-400 font-semibold">
                Fecha estimada de recogida
              </span>
              <input
                type="date"
                v-model="expenses.estimated_date"
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
                placeholder="Nombre o codigo Puerto/Aeropuerto"
                :min="minDate"
              />
              <span
                class="text-xs text-red-600 dark:text-red-400"
                v-if="expenses.errors.has('estimated_date')"
                v-html="expenses.errors.get('estimated_date')"
              ></span>
            </label>
          </div>
          <div class="w-1/3 px-2">
            <label class="block text-sm">
              <span class="text-gray-700 dark:text-gray-400 font-semibold">
                Descripcion de la carga
              </span>
              <input
                v-model="expenses.description"
                maxlength="250"
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
                placeholder="Introduzca la descripcion aqui"
              />
            </label>
            <span
              class="text-xs text-red-600 dark:text-red-400"
              v-if="expenses.errors.has('description')"
              v-html="expenses.errors.get('description')"
            ></span>
          </div>
          <div class="w-1/6 mt-8">
            <label class="ml-6 text-gray-500 dark:text-gray-400">
              <input
                type="checkbox"
                class="form-checkbox h-4 w-4 text-gray-800"
                v-model="expenses.insurance"
              />
              <span class="ml-2 text-gray-700">Seguro </span>
            </label>
          </div>
          <!-- <div class="w-1/6 mt-8" v-if="expenses.insurance">
                            <span class="ml-2 text-gray-700">
                                {{ data.amount }}
                                {{ currency.code }}
                            </span>
                        </div> -->
        </div>
      </transition>
    </div>
    <section v-if="lclTable">
      <div class="mt-8 flex justify-center">
        <table v-if="data.condition == 'EXW'" class="w-full">
          <thead>
            <tr class="bg-gray-100">
              <th>&nbsp;</th>
              <th>&nbsp;</th>
              <th class="text-blue-700">TARIFA</th>
              <th class="text-blue-700">MONEDA</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            <tr class="text-center">
              <td class="px-4 py-3">{{ this.$store.state.application.selectedCondition.name }}</td>
              <td class="px-4 py-3">TRAMO LOCAL (ORIGEN)</td>
              <td class="px-4 py-3">POR COTIZAR</td>
              <td class="px-4 py-3">USD</td>
            </tr>
            <tr class="text-center">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">TRANSPORTE INTERNACIONAL</td>
              <td class="px-4 py-3">{{ lclTableQuote.transport.transport_amount }}</td>
              <td class="px-4 py-3">USD</td>
            </tr>
            <tr class="text-center">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">SEGURO</td>
              <td class="px-4 py-3">{{ lclTableQuote.transport.insurance }}</td>
              <td class="px-4 py-3">USD</td>
            </tr>
            <tr class="text-center">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">GASTOS LOCALES</td>
              <td class="px-4 py-3">
                {{
                  lclTableQuote.transport.oth_exp ? lclTableQuote.transport.oth_exp : 'POR COTIZAR'
                }}
              </td>
              <td class="px-4 py-3">CLP</td>
            </tr>
            <tr class="text-center">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">TRANSPORTE LOCAL</td>
              <td class="px-4 py-3">
                {{
                  lclTableQuote.transport.local_transp
                    ? lclTableQuote.transport.local_transp
                    : 'POR COTIZAR'
                }}
              </td>
              <td class="px-4 py-3">CLP</td>
            </tr>
          </tbody>
        </table>

        <table v-if="data.condition == 'FOB'" class="w-full">
          <thead>
            <tr class="bg-gray-100">
              <th>&nbsp;</th>
              <th>&nbsp;</th>
              <th class="text-blue-700">TARIFA</th>
              <th class="text-blue-700">MONEDA</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            <!-- <tr class="text-center">
              <td class="px-4 py-3">{{ this.$store.state.application.selectedCondition.name }}</td>
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">&nbsp;</td>
            </tr> -->
            <tr class="text-center">
              <td class="px-4 py-3">{{ this.$store.state.application.selectedCondition.name }}</td>
              <td class="px-4 py-3">TRANSPORTE INTERNACIONAL</td>
              <td class="px-4 py-3">{{ lclTableQuote.transport.transport_amount }}</td>
              <td class="px-4 py-3">USD</td>
            </tr>
            <tr class="text-center">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">SEGURO</td>
              <td class="px-4 py-3">{{ lclTableQuote.transport.insurance }}</td>
              <td class="px-4 py-3">USD</td>
            </tr>
            <tr class="text-center">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">GASTOS LOCALES</td>
              <td class="px-4 py-3">
                {{
                  lclTableQuote.transport.oth_exp ? lclTableQuote.transport.oth_exp : 'POR COTIZAR'
                }}
              </td>
              <td class="px-4 py-3">CLP</td>
            </tr>
            <tr class="text-center">
              <td class="px-4 py-3">&nbsp;</td>
              <td class="px-4 py-3">TRANSPORTE LOCAL</td>
              <td class="px-4 py-3">
                {{
                  lclTableQuote.transport.local_transp
                    ? lclTableQuote.transport.local_transp
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
          : 'flex justify-center my-5 innline w-1/7 mt-5',
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
            : 'ml-4 w-24 h-12 text-white transition-colors text-lg bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800',
        ]"
      >
        Cotizar
      </button>
    </div>
  </div>
</template>

<script>
import VueGoogleAutocomplete from 'vue-google-autocomplete';
import { mapState } from 'vuex';
import Button from '../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Button.vue';

export default {
  components: { VueGoogleAutocomplete, mapState, Button },
  data() {
    return {
      showShipping: false,
      lclTableQuote: {},
      lclTable: false,
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
        width: 100,
      });

      this.$store.dispatch('address/showAddress', false);
      this.$store.dispatch('load/showLoadCharge', false);

      this.$store.dispatch('address/showQuoteFCL', true);
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
            confirmButtonText: 'Enviar',
          }).then((result) => {
            if (result.isConfirmed) {
              // Swal.fire('Deleted!', 'Your file has been deleted.', 'success');

              axios
                .post('/notifications-transport', { application_id: this.data.application_id })
                .then(function (response) {
                  console.log(response);
                })
                .catch(function (error) {
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
            title: 'Datos Agregados',
          });
        }
        this.$store.dispatch('exchange/getSummary', this.data.application_id);
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
    getFavOriginPort: async function () {
      this.expenses.origin_port_id = '';
      if (this.expenses.fav_origin_port && this.data.supplier_id) {
        let idsupplier = this.data.supplier_id;
        const type = this.data.type_transport == 'AEREO' ? 'A' : 'P';
        await this.$store.dispatch('address/getFavOriginPort', {
          idsupplier,
          type,
        });
      } else {
        await this.$store.dispatch('address/setOrigFavOritPorts');
      }
    },
    getFavDestPort: async function () {
      this.expenses.dest_port_id = '';
      const type = this.data.type_transport == 'AEREO' ? 'A' : 'P';
      if (this.expenses.fav_dest_port) {
        await this.$store.dispatch('address/getFavDestPorts', type);
      } else {
        await this.$store.dispatch('address/setOrigFavDestPorts');
      }
    },
    showShippingMethod() {
      this.showShipping = !this.showShipping;
    },
    /**
     * When the location found
     * @param {Object} addressData Data of the found location
     * @param {Object} placeResultData PlaceResult object
     * @param {String} id Input container ID
     */
    getAddressOrigin: function (addressData, placeResultData, id) {
      this.expenses.origin_address = placeResultData.formatted_address;

      for (const component of placeResultData.address_components) {
        const componentType = component.types[0];

        switch (componentType) {
          case 'country':
            this.expenses.origin_ctry_code = component.short_name;
            break;

          case 'locality':
            this.expenses.origin_locality = component.long_name;
            break;

          case 'postal_code': {
            this.expenses.origin_postal_code = component.long_name;
            break;
          }
        }
      }
    },
    getAddressDestination: function (addressData, placeResultData, id) {
      for (const component of placeResultData.address_components) {
        const componentType = component.types[0];

        switch (componentType) {
          case 'country':
            this.expenses.dest_ctry_code = component.short_name;
            break;

          case 'locality':
            this.expenses.dest_locality = component.long_name;
            break;

          case 'administrative_area_level_2': {
            this.expenses.dest_province = component.long_name;
            break;
          }

          case 'postal_code': {
            this.expenses.dest_postal_code = component.long_name;
            break;
          }
        }
      }

      this.expenses.dest_address = placeResultData.formatted_address;
    },
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
      'minDate',
    ]),
    ...mapState('application', ['data', 'currency', 'origin_transport']),
  },
};
</script>

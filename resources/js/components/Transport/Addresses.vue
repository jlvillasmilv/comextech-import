<template>
    <div class="container grid px-6 my-1">
        <transition name="fade">
            <Load v-if="Load == true" />
        </transition>
        <!-- Notification validation error -->
        <span
            class="text-xs text-red-600 dark:text-red-400"
            v-if="expenses.errors.has('dataLoad.0.length')"
            v-html="expenses.errors.get('dataLoad.0.length')"
        ></span>
        <span
            class="text-xs text-red-600 dark:text-red-400"
            v-if="expenses.errors.has('dataLoad.0.width')"
            v-html="expenses.errors.get('dataLoad.0.width')"
        ></span>
        <span
            class="text-xs text-red-600 dark:text-red-400"
            v-if="expenses.errors.has('dataLoad.0.height')"
            v-html="expenses.errors.get('dataLoad.0.height')"
        ></span>
        <span
            class="text-xs text-red-600 dark:text-red-400"
            v-if="expenses.errors.has('dataLoad.0.weight')"
            v-html="expenses.errors.get('dataLoad.0.weight')"
        ></span>
        <span
            class="text-xs text-red-600 dark:text-red-400"
            v-if="expenses.errors.has('fedex')"
            v-html="expenses.errors.get('fedex')"
        ></span>
        <div v-show="isActivateAddress">
            <div v-if="$store.state.load.item.mode_selected != 'COURIER'">
                <transition name="fade">
                    <div
                        v-if="
                            !expenses.dataLoad ||
                                expenses.dataLoad.length == 0 ||
                                $store.state.address.formAddress
                        "
                        class="flex flex-col items-center flex-wrap w-full -mx-3 my-8"
                    >
                        <h3 class="mb-10">Direcciones y Puertos</h3>
                        <div
                            class="flex justify-around w-full px-3 mb-6 md:mb-0"
                        >
                            <div class="flex justify-start w-2/12">
                                <h3 class="mt-2">
                                    Direccion Origen
                                </h3>
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
                                    v-if="!expenses.fav_address_origin"
                                    v-model="expenses.address_origin"
                                    id="addressOrigin"
                                    classname="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    v-on:placechanged="getAddressOrigin"
                                    placeholder="Direccion, Codigo Postal"
                                >
                                </vue-google-autocomplete>
                                <div v-else class="relative">
                                    <select
                                        v-model="expenses.address_origin"
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
                                        v-model="expenses.fav_address_origin"
                                        @change="expenses.address_origin = ''"
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
                                    v-if="expenses.errors.has('address_origin')"
                                    v-html="
                                        expenses.errors.get('address_origin')
                                    "
                                ></span>
                            </label>
                            <div class="flex justify-center w-2/12">
                                <h3 class="mt-2">Recogida</h3>
                            </div>
                        </div>
                        <div
                            class="flex justify-around w-full px-3 mb-6 md:mb-0"
                        >
                            <div class="flex justify-start w-2/12">
                                <h3 class="mt-2">
                                    Puerto Origen
                                </h3>
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
                                    v-if="!expenses.fav_address_origin"
                                    v-model="expenses.address_origin"
                                    id="addressOrigin"
                                    classname="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    v-on:placechanged="getAddressOrigin"
                                    placeholder="Direccion, Codigo Postal"
                                >
                                </vue-google-autocomplete>
                                <div v-else class="relative">
                                    <select
                                        v-model="expenses.address_origin"
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
                                        v-model="expenses.fav_address_origin"
                                        @change="expenses.address_origin = ''"
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
                                    v-if="expenses.errors.has('address_origin')"
                                    v-html="
                                        expenses.errors.get('address_origin')
                                    "
                                ></span>
                            </label>
                            <div class="flex justify-end w-2/12">
                                <!-- <h3 class="mt-2">Recogida</h3> -->
                            </div>
                        </div>
                        <div
                            class="flex justify-around w-full px-3 mb-6 md:mb-0"
                        >
                            <div class="flex justify-start w-2/12">
                                <h3 class="mt-2">
                                    Puerto Destino
                                </h3>
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
                                    v-if="!expenses.fav_address_origin"
                                    v-model="expenses.address_origin"
                                    id="addressOrigin"
                                    classname="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    v-on:placechanged="getAddressOrigin"
                                    placeholder="Direccion, Codigo Postal"
                                >
                                </vue-google-autocomplete>
                                <div v-else class="relative">
                                    <select
                                        v-model="expenses.address_origin"
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
                                        v-model="expenses.fav_address_origin"
                                        @change="expenses.address_origin = ''"
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
                                    v-if="expenses.errors.has('address_origin')"
                                    v-html="
                                        expenses.errors.get('address_origin')
                                    "
                                ></span>
                            </label>
                            <div class="flex justify-end w-2/12">
                                <!-- <h3 class="mt-2">Recogida</h3> -->
                            </div>
                        </div>

                        <!-- Destino de Envio -->
                        <div
                            class="flex justify-around w-full px-3 mb-6 md:mb-0"
                        >
                            <div class="flex justify-start w-2/12">
                                <h3 class="mt-2">
                                    Direccion Destino
                                </h3>
                            </div>
                            <label class="w-8/12 text-sm">
                                <!-- <span
                                    class="text-gray-700 dark:text-gray-400 font-semibold"
                                >
                                    Destino de Envio
                                </span> -->

                                <vue-google-autocomplete
                                    v-if="!expenses.fav_dest_address"
                                    v-model="expenses.address_destination"
                                    id="addressDestination"
                                    classname="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
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
                                        v-model="expenses.address_destination"
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
                      focus:outline-none
                      focus:bg-white
                      focus:border-gray-500
                  "
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
                                <label
                                    class="inline-flex text-sm items-center mx-2 mt-2"
                                >
                                    <input
                                        type="checkbox"
                                        class="form-checkbox h-4 w-4 text-gray-800"
                                        v-model="expenses.fav_dest_address"
                                        @change="
                                            expenses.address_destination = ''
                                        "
                                    /><span class="ml-2 text-gray-700">
                                        Direccion de Destino Favoritas
                                    </span>
                                </label>
                            </label>
                            <div class="flex justify-center w-2/12">
                                <h3 class="mt-2">Recogida</h3>
                            </div>

                            <span
                                class="text-xs text-red-600 dark:text-red-400"
                                v-if="
                                    expenses.errors.has('address_destination')
                                "
                                v-html="
                                    expenses.errors.get('address_destination')
                                "
                            ></span>
                        </div>
                    </div>
                </transition>
                <transition name="fade">
                    <div
                        v-if="
                            (!expenses.dataLoad &&
                                expenses.address_destination !== '') ||
                                (expenses.address_destination !== '' &&
                                    expenses.dataLoad.length <= 0) ||
                                $store.state.address.addressDate
                        "
                        class="flex flex-wrap -mx-3 mb-6"
                    >
                        <div class="w-1/4 px-3 mb-6 md:mb-0">
                            <label class="block text-sm">
                                <span
                                    class="text-gray-700 dark:text-gray-400 font-semibold"
                                >
                                    Fecha Estimada
                                </span>
                                <input
                                    type="date"
                                    v-model="expenses.estimated_date"
                                    class="
                  block
                  w-full
                  mt-1
                  text-sm
                  dark:border-gray-600
                  dark:bg-gray-700
                  focus:border-purple-400
                  focus:outline-none
                  focus:shadow-outline-purple
                  dark:text-gray-300
                  dark:focus:shadow-outline-gray
                  form-input
                "
                                    placeholder="Nombre o codigo Puerto/Aeropuerto"
                                    :min="minDate"
                                />
                                <span
                                    class="text-xs text-red-600 dark:text-red-400"
                                    v-if="expenses.errors.has('estimated_date')"
                                    v-html="
                                        expenses.errors.get('estimated_date')
                                    "
                                ></span>
                            </label>
                        </div>
                        <div class="w-1/3 px-2">
                            <label class="block text-sm">
                                <span
                                    class="text-gray-700 dark:text-gray-400 font-semibold"
                                >
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
                  dark:border-gray-600
                  dark:bg-gray-700
                  focus:border-purple-400
                  focus:outline-none
                  focus:shadow-outline-purple
                  dark:text-gray-300
                  dark:focus:shadow-outline-gray
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
                            <label
                                class="ml-6 text-gray-500 dark:text-gray-400"
                            >
                                <input
                                    type="checkbox"
                                    class="form-checkbox h-4 w-4 text-gray-800"
                                    v-model="expenses.insurance"
                                />
                                <span class="ml-2 text-gray-700">Seguro </span>
                            </label>
                        </div>
                        <div class="w-1/6 mt-8" v-if="expenses.insurance">
                            <span class="ml-2 text-gray-700">
                                {{ data.amount }}
                                {{ currency.code }}
                            </span>
                        </div>
                    </div>
                </transition>
            </div>
            <div v-else>
                <transition name="fade">
                    <div
                        v-if="
                            !expenses.dataLoad ||
                                expenses.dataLoad.length == 0 ||
                                $store.state.address.formAddress
                        "
                        class="flex flex-wrap -mx-3 my-8"
                    >
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label class="block text-sm">
                                <span
                                    class="text-gray-700 dark:text-gray-400 font-semibold"
                                >
                                    {{
                                        data.condition === 'FOB'
                                            ? ' Puertos de Proveedor'
                                            : ' Almacen o Fabrica del Proveedor'
                                    }}
                                </span>
                                <vue-google-autocomplete
                                    v-if="!expenses.fav_address_origin"
                                    v-model="expenses.address_origin"
                                    id="addressOrigin"
                                    classname="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    v-on:placechanged="getAddressOrigin"
                                    placeholder="Direccion, Codigo Postal"
                                >
                                </vue-google-autocomplete>
                                <div v-else class="relative">
                                    <select
                                        v-model="expenses.address_origin"
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
                                        v-model="expenses.fav_address_origin"
                                        @change="expenses.address_origin = ''"
                                    /><span class="ml-2 text-gray-700">
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
                                    v-if="expenses.errors.has('address_origin')"
                                    v-html="
                                        expenses.errors.get('address_origin')
                                    "
                                ></span>
                            </label>
                        </div>
                        <!-- Destino de Envio -->
                        <div class="w-full md:w-1/2 px-3">
                            <label class="block text-sm">
                                <span
                                    class="text-gray-700 dark:text-gray-400 font-semibold"
                                >
                                    Destino de Envio
                                </span>

                                <vue-google-autocomplete
                                    v-if="!expenses.fav_dest_address"
                                    v-model="expenses.address_destination"
                                    id="addressDestination"
                                    classname="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
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
                                        v-model="expenses.address_destination"
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
                      focus:outline-none
                      focus:bg-white
                      focus:border-gray-500
                  "
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
                                <label
                                    class="inline-flex text-sm items-center mx-2 mt-2"
                                >
                                    <input
                                        type="checkbox"
                                        class="form-checkbox h-4 w-4 text-gray-800"
                                        v-model="expenses.fav_dest_address"
                                        @change="
                                            expenses.address_destination = ''
                                        "
                                    /><span class="ml-2 text-gray-700">
                                        Direccion de Destino Favoritas
                                    </span>
                                </label>
                            </label>

                            <span
                                class="text-xs text-red-600 dark:text-red-400"
                                v-if="
                                    expenses.errors.has('address_destination')
                                "
                                v-html="
                                    expenses.errors.get('address_destination')
                                "
                            ></span>
                        </div>
                    </div>
                </transition>
                <transition name="fade">
                    <div
                        v-if="
                            (!expenses.dataLoad &&
                                expenses.address_destination !== '') ||
                                (expenses.address_destination !== '' &&
                                    expenses.dataLoad.length <= 0) ||
                                $store.state.address.addressDate
                        "
                        class="flex flex-wrap -mx-3 mb-6"
                    >
                        <div class="w-1/4 px-3 mb-6 md:mb-0">
                            <label class="block text-sm">
                                <span
                                    class="text-gray-700 dark:text-gray-400 font-semibold"
                                >
                                    Fecha Estimada
                                </span>
                                <input
                                    type="date"
                                    v-model="expenses.estimated_date"
                                    class="
                  block
                  w-full
                  mt-1
                  text-sm
                  dark:border-gray-600
                  dark:bg-gray-700
                  focus:border-purple-400
                  focus:outline-none
                  focus:shadow-outline-purple
                  dark:text-gray-300
                  dark:focus:shadow-outline-gray
                  form-input
                "
                                    placeholder="Nombre o codigo Puerto/Aeropuerto"
                                    :min="minDate"
                                />
                                <span
                                    class="text-xs text-red-600 dark:text-red-400"
                                    v-if="expenses.errors.has('estimated_date')"
                                    v-html="
                                        expenses.errors.get('estimated_date')
                                    "
                                ></span>
                            </label>
                        </div>
                        <div class="w-1/3 px-2">
                            <label class="block text-sm">
                                <span
                                    class="text-gray-700 dark:text-gray-400 font-semibold"
                                >
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
                  dark:border-gray-600
                  dark:bg-gray-700
                  focus:border-purple-400
                  focus:outline-none
                  focus:shadow-outline-purple
                  dark:text-gray-300
                  dark:focus:shadow-outline-gray
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
                            <label
                                class="ml-6 text-gray-500 dark:text-gray-400"
                            >
                                <input
                                    type="checkbox"
                                    class="form-checkbox h-4 w-4 text-gray-800"
                                    v-model="expenses.insurance"
                                />
                                <span class="ml-2 text-gray-700">Seguro </span>
                            </label>
                        </div>
                        <div class="w-1/6 mt-8" v-if="expenses.insurance">
                            <span class="ml-2 text-gray-700">
                                {{ data.amount }}
                                {{ currency.code }}
                            </span>
                        </div>
                    </div>
                </transition>
            </div>
            <div
                :class="[
                    !expenses.dataLoad || expenses.dataLoad.length <= 0
                        ? 'flex justify-center'
                        : 'flex justify-center my-5 innline w-1/7 mt-5'
                ]"
            >
                <button
                    v-if="!expenses.dataLoad"
                    class="hidden"
                    @click="HideAddress()"
                >
                    Editar
                </button>

                <button
                    v-else-if="expenses.dataLoad.length > 0"
                    @click="HideAddress()"
                    class="mr-4 w-24 h-12 text-white transition-colors text-lg bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800"
                >
                    Editar
                </button>

                <button
                    v-if="
                        $store.state.load.loads[0].mode_selected == 'CONTAINER'
                    "
                    @click="submitQuote(0)"
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

                <button
                    v-else-if="
                        $store.state.load.loads[0].mode_selected != 'CONTAINER'
                    "
                    @click="submitForm()"
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
            <!-- <div v-if="expenses.progress">
                Progress: {{ expenses.progress.percentage }}%
            </div> -->

            <!-- Bloque cotizacion de fedex -->
            <!-- <transition name="fade"> -->
            <div name="fade" class="sm:flex sm:justify-center">
                <div
                    v-if="
                        showApisQuote == true &&
                            fedex.DeliveryTimestamp &&
                            fedex.ServiceType &&
                            fedex.FUEL &&
                            fedex.PEAK &&
                            fedex.Discount &&
                            TotalEstimed &&
                            fedex.TotalNetCharge &&
                            (!expenses.dataLoad || expenses.dataLoad.length > 0)
                    "
                    :class="[
                        !expenses.dataLoad
                            ? 'hidden'
                            : 'lg:w-9/12 md:9/12 py-4 my-4 focus:outline-none border rounded-sm'
                    ]"
                >
                    <div
                        class="sm:w-2/12 sm:inline-block align-top text-center text-sm px-2 mb-8"
                    >
                        <div class="mb-8 text-sm font-semibold">
                            <span>LLEGADA</span>
                        </div>
                        <span>{{ fedex.DeliveryTimestamp }}</span>
                    </div>

                    <div
                        class="sm:w-2/12 sm:inline-block align-top text-center text-sm mb-8"
                    >
                        <div class="mb-8 text-sm font-semibold">
                            <span>SERVICIO</span>
                        </div>
                        <span>{{ fedex.ServiceType }}</span>
                    </div>

                    <div class="sm:w-5/12 inline-block align-top px-2">
                        <table>
                            <thead>
                                <tr>
                                    <th class="text-sm font-semibold">
                                        <div class="mb-8 text-sm font-semibold">
                                            <span>CONCEPTOS</span>
                                        </div>
                                    </th>
                                    <th
                                        class="w-28 sm:w-28 text-sm font-semibold"
                                    >
                                        <div class="mb-8 text-sm font-semibold">
                                            <span>TARIFA</span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-left text-sm">
                                        Tarifa Transporte
                                    </td>
                                    <td class="text-right text-sm">
                                        {{ fedex.TotalBaseCharge }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left text-sm">
                                        Recargo Combustible
                                    </td>
                                    <td class="text-right text-sm">
                                        {{ fedex.FUEL }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left text-sm">
                                        Recargo por alta demanda
                                    </td>
                                    <td class="text-right text-sm">
                                        {{ fedex.PEAK }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left text-sm">
                                        Descuento
                                    </td>
                                    <td class="text-right text-sm">
                                        {{ fedex.Discount }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left text-sm">
                                        Total Estimado
                                    </td>
                                    <td class="text-right text-sm">
                                        {{ TotalEstimed }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div
                        class="sm:w-2/12 h-full inline-block align-top text-center text-sm px-2"
                    >
                        <div class="flex flex-col h-full justify-around">
                            <div
                                class="flex flex-auto self-end items-center mt-8"
                            >
                                <img
                                    src="../../../../public/img/fedex-logo.png"
                                    alt="fedex-logo"
                                    class="mx-auto my-2 w-4/12 sm:w-9/12"
                                />
                            </div>
                            <div
                                class="flex flex-auto items-center justify-center"
                            >
                                <button
                                    @click="submitQuote(TotalEstimed, 2)"
                                    class="w-24 px-2 h-14 text-white transition-colors text-sm bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800"
                                >
                                    Cotizar FEDEX
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- </transition> -->

            <!-- Bloque cotizacion de DHL -->

            <div name="fade" class="sm:flex sm:justify-center">
                <div
                    v-if="
                        showApisQuote == true &&
                            dhl.DeliveryDate &&
                            dhl.DeliveryTime &&
                            dhl.ProductShortName &&
                            dhl.WeightCharge &&
                            dhl['FUEL SURCHARGE'] &&
                            dhl['EMERGENCY SITUATION'] &&
                            dhl.Discount &&
                            dhl.ComextechDiscount &&
                            (!expenses.dataLoad || expenses.dataLoad.length > 0)
                    "
                    :class="[
                        !expenses.dataLoad
                            ? 'hidden'
                            : 'lg:w-9/12 md:9/12 py-4 my-4 focus:outline-none border rounded-sm'
                    ]"
                >
                    <div
                        class="sm:w-2/12 sm:inline-block align-top text-center text-sm px-2 mb-8"
                    >
                        <div class="mb-8 text-sm font-semibold">
                            <span>LLEGADA</span>
                        </div>
                        <span>{{ dhl.DeliveryDate }}</span>
                        <span>{{ dhl.DeliveryTime }}</span>
                    </div>

                    <div
                        class="sm:w-2/12 sm:inline-block align-top text-center text-sm mb-8"
                    >
                        <div class="mb-8 text-sm font-semibold">
                            <span>SERVICIO</span>
                        </div>
                        <span>{{ dhl.ProductShortName }}</span>
                    </div>

                    <div class="sm:w-5/12 inline-block align-top px-2">
                        <table>
                            <thead>
                                <tr>
                                    <th class="text-sm font-semibold">
                                        <div class="mb-8 text-sm font-semibold">
                                            <span>CONCEPTOS</span>
                                        </div>
                                    </th>
                                    <th
                                        class="w-28 sm:w-28 text-sm font-semibold"
                                    >
                                        <div class="mb-8 text-sm font-semibold">
                                            <span>TARIFA</span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-left text-sm">
                                        Tarifa Transporte
                                    </td>
                                    <td class="text-right text-sm">
                                        {{ transportDHL }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left text-sm">
                                        Recargo Combustible
                                    </td>
                                    <td class="text-right text-sm">
                                        {{ dhl['FUEL SURCHARGE'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left text-sm">
                                        Situación de emergencia
                                    </td>
                                    <td class="text-right text-sm">
                                        {{ dhl['EMERGENCY SITUATION'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left text-sm">
                                        Descuento
                                    </td>
                                    <td class="text-right text-sm">
                                        {{ dhl.ComextechDiscount }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left text-sm">
                                        Total Estimado
                                    </td>
                                    <td class="text-right text-sm">
                                        {{ dhl.ComextechTotal }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div
                        class="sm:w-2/12 h-full inline-block align-top text-center text-sm px-2"
                    >
                        <div class="flex flex-col h-full justify-around">
                            <div
                                class="flex flex-auto self-end items-center mt-8"
                            >
                                <img
                                    src="../../../../public/img/dhl-express.jpg"
                                    alt="dhl-logo"
                                    class="mx-auto my-2 w-4/12 sm:w-9/12"
                                />
                            </div>
                            <div
                                class="flex flex-auto items-center justify-center"
                            >
                                <button
                                    @click="
                                        submitQuote(dhl.ComextechDiscount, 2)
                                    "
                                    class="w-24 px-2 h-14 text-white transition-colors text-sm bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800"
                                >
                                    Cotizar DHL
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bloque cotizacion de UPS -->
            <!-- <div name="fade" class="sm:flex sm:justify-center">
                <div
                    v-if="
                        showApisQuote == true &&
                            dhl.DeliveryDate &&
                            dhl.DeliveryTime &&
                            dhl.ProductShortName &&
                            dhl.WeightCharge &&
                            dhl['FUEL SURCHARGE'] &&
                            dhl['EMERGENCY SITUATION'] &&
                            dhl.Discount &&
                            dhl.ComextechDiscount &&
                            (!expenses.dataLoad || expenses.dataLoad.length > 0)
                    "
                    :class="[
                        !expenses.dataLoad
                            ? 'hidden'
                            : 'lg:w-9/12 md:9/12 py-4 my-4 focus:outline-none border rounded-sm'
                    ]"
                >
                    <div
                        class="sm:w-2/12 sm:inline-block align-top text-center text-sm px-2 mb-8"
                    >
                        <div class="mb-8 text-sm font-semibold">
                            <span>LLEGADA</span>
                        </div>
                        <span>{{ dhl.DeliveryDate }}</span>
                        <span>{{ dhl.DeliveryTime }}</span>
                    </div>

                    <div
                        class="sm:w-2/12 sm:inline-block align-top text-center text-sm mb-8"
                    >
                        <div class="mb-8 text-sm font-semibold">
                            <span>SERVICIO</span>
                        </div>
                        <span>{{ dhl.ProductShortName }}</span>
                    </div>

                    <div class="sm:w-5/12 inline-block align-top px-2">
                        <table>
                            <thead>
                                <tr>
                                    <th class="text-sm font-semibold">
                                        <div class="mb-8 text-sm font-semibold">
                                            <span>CONCEPTOS</span>
                                        </div>
                                    </th>
                                    <th
                                        class="w-28 sm:w-28 text-sm font-semibold"
                                    >
                                        <div class="mb-8 text-sm font-semibold">
                                            <span>TARIFA</span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-left text-sm">
                                        Tarifa Transporte
                                    </td>
                                    <td class="text-right text-sm">
                                        {{ transportDHL }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left text-sm">
                                        Recargo Combustible
                                    </td>
                                    <td class="text-right text-sm">
                                        {{ dhl['FUEL SURCHARGE'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left text-sm">
                                        Situación de emergencia
                                    </td>
                                    <td class="text-right text-sm">
                                        {{ dhl['EMERGENCY SITUATION'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left text-sm">
                                        Descuento
                                    </td>
                                    <td class="text-right text-sm">
                                        {{ dhl.Discount }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left text-sm">
                                        Total Estimado
                                    </td>
                                    <td class="text-right text-sm">
                                        {{ dhl.ComextechDiscount }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div
                        class="sm:w-2/12 h-full inline-block align-top text-center text-sm px-2"
                    >
                        <div class="flex flex-col h-full justify-around">
                            <div
                                class="flex flex-auto self-end items-center mt-8"
                            >
                                <img
                                    src="../../../../public/img/ups-logo.png"
                                    alt="dhl-logo"
                                    class="mx-auto my-2 w-4/12 sm:w-9/12"
                                />
                            </div>
                            <div
                                class="flex flex-auto items-center justify-center"
                            >
                                <button
                                    @click="
                                        submitQuote(dhl.ComextechDiscount, 2)
                                    "
                                    class="w-24 px-2 h-14 text-white transition-colors text-sm bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800"
                                >
                                    Cotizar DHL
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</template>

<script>
import VueGoogleAutocomplete from 'vue-google-autocomplete';
import Load from './Load.vue';
import { mapState } from 'vuex';
import Button from '../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Button.vue';
import Container from '../Container.vue';

export default {
    components: { Load, VueGoogleAutocomplete, Button },
    props: {
        Container,
        originTransport: {
            type: Array,
            required: false
        }
    },
    data() {
        return {
            address: '',
            minDate: new Date().toISOString().substr(0, 10),
            Load: true,
            safe: false,
            fedex: {} /* response object api fedex */,
            dhl: {} /* response object api DHL */,
            transportDHL: '' /* transportation rate Fedex */,
            BaseChargeTotal: '',
            TotalEstimed: '' /* estimated total Fedex */,
            formAdress: true /* Form addresses */,
            adressDate: false /* Form date and description */,
            showApisQuote: false /* api quote block */
        };
    },
    methods: {
        /* Quote to wait for the apis (button cotizar) */
        async submitForm() {
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
            this.Load = false; /* Hide form loads and dimensions */
            try {
                this.showApisQuote = true;
                this.expenses.dataLoad = this.$store.state.load.loads;

                /* get data from fedex quote and rate api */
                const fedexApi = await this.expenses.post('/get-fedex-rate');

                /* It is validated if the request was successful to show the quote block (FEDEX) */
                if (fedexApi.status == 200) {
                    /* The variable is equalized to later use it in the template */
                    this.fedex = fedexApi.data;

                    /* transforming the time into format "day-month-yyyy" */
                    this.fedex.DeliveryTimestamp = this.$luxon(
                        this.fedex.DeliveryTimestamp
                    );

                    this.TotalEstimed = this.fedex.TotalEstimed.toFixed(2);
                }

                /* get data from DHL quote and rate api */
                const DhlApi = await this.expenses.post('/get-dhl-quote');

                if (DhlApi.status == 200) {
                    this.dhl = DhlApi.data;

                    this.transportDHL =
                        parseFloat(this.dhl.WeightCharge) +
                        parseFloat(this.dhl.TotalDiscount);

                    // this.dhl.Discount = (this.transportDHL * 60) / 100;
                    // this.dhl.Discount = parseFloat(this.dhl.Discount).toFixed(
                    //     2
                    // );

                    this.dhl.ComextechDiscount = this.dhl.ComextechDiscount.toFixed(
                        2
                    );
                }
                /* Vue-loader hidden */
                loader.hide();
            } catch (error) {
                console.error(error);
            }
        },
        /**
         * Show / Hide from address (button "Editar")
         */
        HideAddress() {
            this.$store.dispatch('address/showAddress', true);

            this.fedex = {};

            this.dhl = {};

            this.Load = true; /* Hide / Show loads and dimensions form */

            this.showApisQuote = false;

            // /* Here the dataLoad is set to 0 to edit the view */
            // this.expenses.dataLoad = this.expenses.dataLoad.length == 0;
        },

        /**
         * Send api quote (button Cotizar fedex, dhl, ups)
         * @param {Number} appAmount selected service amount if fedex, dhl or ups
         * @param {Number} transCompanyId number of the service that is selected:
         * @param {2} FEDEX
         * @param {3} DHL
         * @param {4} UPS
         */
        async submitQuote(appAmount, transCompanyId) {
            try {
                this.expenses.dataLoad = this.$store.state.load.loads;
                this.expenses.app_amount = appAmount;
                this.expenses.trans_company_id = transCompanyId;
                await this.expenses.post('/applications/transports');
                Toast.fire({
                    icon: 'success',
                    title: 'Datos Agregados'
                });
                this.$store.dispatch(
                    'exchange/getSummary',
                    this.data.application_id
                );
                this.$store.dispatch('callIncomingOrNextMenu', true);
            } catch (error) {
                console.log(error);
            }
        },
        /**
         * When the location found
         * @param {Object} addressData Data of the found location
         * @param {Object} placeResultData PlaceResult object
         * @param {String} id Input container ID
         */
        getAddressOrigin: function(addressData, placeResultData, id) {
            this.expenses.address_origin = placeResultData.formatted_address;
            this.expenses.origin_latitude = addressData.latitude;
            this.expenses.origin_longitude = addressData.longitude;

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
        getAddressDestination: function(addressData, placeResultData, id) {
            for (const component of placeResultData.address_components) {
                const componentType = component.types[0];

                switch (componentType) {
                    case 'country':
                        this.expenses.dest_ctry_code = component.short_name;
                        break;

                    case 'locality':
                        this.expenses.dest_locality = component.long_name;
                        break;

                    case 'postal_code': {
                        this.expenses.dest_postal_code = component.long_name;
                        break;
                    }
                }
            }

            this.expenses.address_destination =
                placeResultData.formatted_address;
            this.expenses.dest_latitude = addressData.latitude;
            this.expenses.dest_longitude = addressData.longitude;
            //this.expenses.dest_ctry_code = placeResultData.address_components.
        }
    },
    computed: {
        ...mapState('address', ['expenses', 'addressDestination']),
        ...mapState('application', ['data', 'currency', 'origin_transport']),
        addreses() {
            if (this.data.condiction == 'FOB') {
                return this.addressDestination.filter(
                    item => item.place == 'PUERTO'
                );
            } else {
                return this.addressDestination.filter(
                    item => item.place !== 'PUERTO'
                );
            }
        },
        isActivateAddress() {
            const { loads } = this.$store.state.load;

            if (loads.length) {
                if (loads[loads.length - 1].mode_selected == 'CONTAINER') {
                    if (loads[loads.length - 1].weight > 0) {
                        return true;
                    }
                    return false;
                }
            }

            /* Condicionales para mostrar el formulario de addresses dependiendo de la validacion del peso */
            if (loads.length) {
                if (
                    loads[loads.length - 1].weight_units == 'KG' &&
                    loads[loads.length - 1].weight < 2
                )
                    return false;
                if (
                    loads[loads.length - 1].weight_units == 'KG' &&
                    loads[loads.length - 1].weight >= 2 &&
                    loads[loads.length - 1].weight <= 2268
                )
                    return true;
                if (
                    loads[loads.length - 1].weight_units == 'LB' &&
                    loads[loads.length - 1].weight < 4.4
                )
                    return false;
                if (
                    loads[loads.length - 1].weight_units == 'LB' &&
                    loads[loads.length - 1].weight >= 4.4 &&
                    loads[loads.length - 1].weight <= 5000
                )
                    return true;
                else false;
            }
            return false;
        }
    },
    async created() {
        this.expenses.application_id = this.data.application_id;
        await this.$store.dispatch('address/getAddressDestination');
    }
};
</script>

<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.7s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}
</style>

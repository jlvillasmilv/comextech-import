<template>
    <div>
        <div class="flex flex-wrap">
            <h1 class="flex-auto text-2xl text-blue-900 ">
                {{ title }}
            </h1>
        </div>
        <div class="flex  mt-3 mb-8   ">
            <ul class="flex  space-x-2 mt-3 ">
                <li
                    v-for="name in $store.state.load.types"
                    :key="name"
                    :class="[
                        'cursor-pointer px-5 text-gray-900 border-b-2',
                        name == item.mode_selected ? ' border-blue-500' : ''
                    ]"
                    @click="typeSelected(name)"
                >
                    {{ name }}
                </li>
            </ul>
        </div>
        <div v-if="item.mode_selected">
            <div
                v-for="(item, id) in loads"
                :key="id"
                class="flex w-full justify-items-center  dark:text-gray-400 space-x-5 mt-2 "
            >
                <div
                    class="inline w-1/6"
                    v-if="item.mode_selected != 'CONTAINER'"
                >
                    <span v-if="id == 0" class=" text-sm my-2 font-semibold ">
                        Calcular por
                    </span>
                    <div v-if="id == 0" class="block space-x-0">
                        <!-- <button
                            @click="changeMode()"
                            :class="[
                                'focus:outline-none  font-medium py-2 px-4 rounded-2 rounded-lg',
                                !item.mode_calculate
                                    ? 'bg-blue-800 text-white'
                                    : 'bg-gray-50'
                            ]"
                        >
                            Envio
                        </button> -->
                        <button
                            @click="changeMode()"
                            :class="[
                                'focus:outline-none font-medium py-2 px-4 rounded-2 rounded-lg',
                                item.mode_calculate
                                    ? 'bg-blue-800 text-white'
                                    : 'bg-gray-50'
                            ]"
                        >
                            Unidad
                        </button>
                    </div>
                </div>
                <div
                    v-if="item.mode_selected != 'CONTAINER'"
                    class="inline w-1/6 p-1"
                >
                    <div class="relative">
                        <label
                            v-if="id == 0"
                            class="block text-sm  font-semibold"
                        >
                            Tipo de Carga
                        </label>
                        <select
                            v-model="item.type_load"
                            value="Seleccionar"
                            class="block text-sm  w-2/3 bg-white border border-gray-200 text-gray-700 py-2 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        >
                            <option value="1" selected> Pallet / s</option>
                            <option value="2"> Caja / s</option>
                            <option value="3"> Unidad/es</option>
                            <option value="4"> Bidón / es</option>
                            <option value="5"> Bags </option>
                        </select>
                    </div>
                </div>
                <div class="inline w-1/6 p-1" v-else>
                    <div class="relative">
                        <label
                            v-if="id == 0"
                            class="block text-sm  font-semibold"
                        >
                            Tipo de Container
                        </label>
                        <select
                            v-model="item.type_container"
                            class="block text-sm  w-2/3 bg-white border border-gray-200 text-gray-700 py-2 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        >
                            <option value="1"> 20'DV </option>
                            <option value="2"> 40'DV </option>
                            <option value="3"> 40'HC </option>
                            <option value="4"> 45'HC </option>
                        </select>
                    </div>
                </div>
                <div class="inline" v-if="item.mode_calculate">
                    <div v-if="item.mode_selected != 'CONTAINER'">
                        <span
                            v-if="id == 0"
                            class="text-sm text-center font-semibold "
                        >
                            Dimension Unitaria
                        </span>
                        <div class="flex">
                            <input
                                v-model.number="item.length"
                                type="number"
                                class="h-9 w-13 focus:outline-none border rounded-l-lg flex items-center text-center  text-sm"
                                placeholder="L"
                            />
                            <input
                                v-model.number="item.width"
                                type="number"
                                class="h-9 w-13 focus:outline-none border rounded-none flex items-center text-center  text-sm"
                                placeholder="W"
                            />
                            <input
                                v-model.number="item.height"
                                type="number"
                                class="h-9 w-13 focus:outline-none border rounded-r-lg flex items-center text-center  text-sm"
                                placeholder="H"
                            />
                        </div>
                        <label
                            class="inline-flex text-sm items-center mx-2 mt-2"
                        >
                            <input
                                type="radio"
                                v-model="item.length_unit"
                                @click="changeLoadType('CM')"
                                class="form-checkbox h-4 w-4 text-gray-800"
                                :id="'lengthUnit' + id"
                                value="CM"
                            /><span class="ml-2 text-gray-700"> cm </span>
                        </label>
                        <label
                            class="inline-flex text-sm items-center mx-2  mt-2"
                        >
                            <input
                                :selected="true"
                                type="radio"
                                v-model="item.length_unit"
                                @click="changeLoadType('IN')"
                                class="form-checkbox h-4 w-4 text-gray-800"
                                :id="'lengthUnit' + id"
                                value="IN"
                            /><span class="ml-2 text-gray-700"> pulg </span>
                        </label>
                    </div>
                </div>
                <div
                    class="inline text-center"
                    v-if="item.mode_selected != 'CONTAINER'"
                >
                    <span
                        v-if="id == 0"
                        class="text-sm text-center font-semibold "
                    >
                        CBM
                    </span>
                    <input
                        v-if="item.mode_calculate"
                        :value="
                            (item.cbm =
                                (item.length * item.width * item.height) /
                                10000)
                        "
                        class="h-9 w-15 focus:outline-none border  rounded-lg flex text-center   text-sm"
                        :disabled="item.mode_calculate"
                        placeholder="CBM"
                    />
                    <input
                        v-else
                        v-model="item.cbm"
                        class="h-9 w-15 focus:outline-none border  rounded-lg flex text-center   text-sm"
                        placeholder="CBM"
                    />
                </div>
                <div class="inline">
                    <span class="text-sm text-center font-semibold ">
                        Peso Unitario
                    </span>
                    <input
                        v-model.number="item.weight"
                        type="number"
                        :class="[
                            'h-9 focus:outline-none border rounded-lg flex text-center text-sm',
                            item.mode_selected != 'CONTAINER'
                                ? ' w-16'
                                : ' w-17'
                        ]"
                    />
                    <span
                        v-if="validateweight"
                        class="text-center text-red-600 text-xs"
                        >{{ validateweight }}</span
                    >
                    <br v-if="validateweight" />
                    <label class="inline-flex text-sm items-center mx-2 mt-2">
                        <input
                            type="radio"
                            v-model="item.weight_units"
                            @click="changeLoadType('CM')"
                            :id="'weight_units' + id"
                            :name="'weight_units' + id"
                            class="form-checkbox h-4 w-4 text-gray-800"
                            checked
                            value="KG"
                        />
                        <span class="ml-2 text-gray-700"> Kg </span>
                    </label>
                    <label class="inline-flex text-sm items-center mx-2  mt-2">
                        <input
                            type="radio"
                            v-model="item.weight_units"
                            @click="changeLoadType('IN')"
                            :id="'weight_units' + id"
                            :name="'weight_units' + id"
                            class="form-checkbox h-4 w-4 text-gray-800"
                            value="LB"
                        />
                        <span class="ml-2 text-gray-700"> Lbs </span>
                    </label>
                </div>
                <div class="flex">
                    <label
                        class="inline-flex text-sm items-center "
                        v-if="item.mode_selected != 'CONTAINER'"
                    >
                        <input
                            type="checkbox"
                            v-model="item.stackable"
                            class="form-checkbox h-4 w-4 text-gray-800"
                            checked
                        />
                        <span class="ml-2 text-gray-700 ">Non Stackable</span>
                    </label>
                </div>
                <div
                    class="innline w-1/7 mt-5"
                    v-if="item.mode_calculate || typeSelected == 'CONTAINER'"
                >
                    <button
                        v-if="id > 0"
                        @click="deleteForm(id)"
                        class="bg-transparent focus:outline-none uppercase text-xs hover:bg-red-600 text-red-700 font-semibold hover:text-white py-2 px-2 border border-red-500 hover:border-transparent rounded"
                    >
                        Eliminar
                    </button>

                    <button
                        v-else
                        @click="AddFielForm"
                        class="bg-transparent focus:outline-none uppercase text-xs hover:bg-blue-600 text-blue-700 font-semibold hover:text-white py-2 px-2 border border-blue-500 hover:border-transparent rounded"
                    >
                        Añadir Carga
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
    props: {
        title: {
            require: false,
            default: 'Cotizador Online'
        }
    },
    data() {
        return {
            showKg: true,
            showIn: true
        };
    },
    methods: {
        AddFielForm() {
            // const { loads } = this.$store.state.load;
            // if (loads[loads.length - 1].length_unit === 'CM') {
            //     this.showIn = false;
            // }
            // if (loads[loads.length - 1].length_unit === 'IN') {
            //     this.showKg = false;
            // }
            this.$store.dispatch('load/addLoad', this.item);
        },
        deleteForm(id) {
            // const { loads } = this.$store.state.load;
            // if (loads[loads.length - 1].length_unit === 'CM') {
            //     this.showKg = true;
            //     this.showIn = false;
            // }
            // if (loads[loads.length - 1].length_unit === 'IN') {
            //     this.showIn = true;
            //     this.showKg = false;
            // }
            this.$store.dispatch('load/removedLoad', id);
            // if(loads[loads.length - 1]) {

            // }
            // this.reset();
        },
        changeMode() {
            // this.$store.state.load.item.mode_calculate = !this.$store.state.load
            //     .item.mode_calculate;
            // this.reset();
        },
        typeSelected(value) {
            this.$store.state.load.item.mode_selected = value;
            this.reset();
        },
        reset() {
            this.$store.state.load.loads = [];
            this.$store.dispatch('load/addLoad', this.item);
        },
        changeLoadType(unit) {
            this.$store.dispatch('load/changeLoadType', unit);
        }
    },
    computed: {
        ...mapState('load', ['item', 'loads']),
        validateweight() {
            const { loads } = this.$store.state.load;

            if (loads[loads.length - 1].mode_selected == 'CONTAINER') {
                return false;
            }

            /* switch case para peso unitario en KG y LB */
            switch (
                (loads.length &&
                    loads[loads.length - 1].weight_units == 'KG') ||
                loads[loads.length - 1].weight_units == 'LB'
            ) {
                case loads[loads.length - 1].weight == '':
                    return '';
                case loads[loads.length - 1].weight_units == 'KG' &&
                    loads[loads.length - 1].weight < 2:
                    return 'Limite minimo de peso: 2 KG';
                case loads[loads.length - 1].weight_units == 'LB' &&
                    loads[loads.length - 1].weight < 4.4:
                    return 'Limite minimo de peso: 4.4 LB';
                case loads[loads.length - 1].weight_units == 'KG' &&
                    loads[loads.length - 1].weight > 2268:
                    return 'Excede limite maximo de peso: 2268 KG';
                case loads[loads.length - 1].weight_units == 'LB' &&
                    loads[loads.length - 1].weight > 5000:
                    return 'Excede limite maximo de peso: 5000 LB';
                case loads[loads.length - 1].weight_units == 'KG' &&
                    loads[loads.length - 1].weight >= 2:
                    return '';
                case loads[loads.length - 1].weight_units == 'LB' &&
                    loads[loads.length - 1].weight >= 4.4:
                    return '';
                default:
                    false;
                    break;
            }
            return false;
        }
    },
    created() {
         this.$store.state.load.item.mode_selected = this.$store.state.application.data.type_transport;
        if (!this.loads.length) this.reset();
    }
};
</script>
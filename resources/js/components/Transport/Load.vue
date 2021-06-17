<template>
    <div>
        <div class="flex flex-wrap">
            <h1 class="flex-auto text-2xl text-blue-900 ">
                {{ title }}
            </h1>
        </div>
        <div class="flex  mt-3 dark:text-gray-400  ">
            <ul class="flex  space-x-2 mt-3 ">
                <li
                    v-for="name in types"
                    :key="name"
                    :class="[
                        'cursor-pointer px-5 text-gray-900 border-b-2',
                        name == modeTypeSelected ? ' border-blue-500' : ''
                    ]"
                    @click="typeSelected(name)"
                >
                    {{ name }}
                </li>
            </ul>
        </div>
        <div
            v-for="(item, id) in FielFormLoad"
            :key="id"
            class="flex w-full justify-items-center inline-flex dark:text-gray-400 space-x-5 mt-2 "
        >
            <div class="inline w-1/6" v-if="modeTypeSelected != 'CONTAINER'">
                <span v-if="id == 0" class=" text-sm my-2 font-semibold ">
                    Calcular por
                </span>
                <div v-if="id == 0" class="block space-x-0">
                    <button
                        @click="changeMode()"
                        :class="[
                            'focus:outline-none  font-medium py-2 px-4 rounded-2 rounded-lg',
                            !modeCalculate
                                ? 'bg-blue-800 text-white'
                                : 'bg-gray-50'
                        ]"
                    >
                        Envio
                    </button>
                    <button
                        @click="changeMode()"
                        :class="[
                            'focus:outline-none font-medium py-2 px-4 rounded-2 rounded-lg',
                            modeCalculate
                                ? 'bg-blue-800 text-white'
                                : 'bg-gray-50'
                        ]"
                    >
                        Unidad
                    </button>
                </div>
            </div>
            <div
                v-if="modeTypeSelected != 'CONTAINER'"
                class="inline w-1/6 p-1"
            >
                <div class="relative">
                    <label v-if="id == 0" class="block text-sm  font-semibold">
                        Tipo de Carga
                    </label>
                    <select
                        v-model="item.typeLoad"
                        value="Seleccionar"
                        class="block text-sm  w-2/3 bg-white border border-gray-200 text-gray-700 py-2 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    >
                        <option value="2" translate=""> Pallet / s</option>
                        <option value="3" translate=""> Caja / s</option>
                        <option value="4" translate=""> Unidad/es</option>
                        <option value="5" translate=""> Bidón / es</option>
                        <option value="6" translate=""> Bags </option>
                    </select>
                </div>
            </div>
            <div class="inline w-1/6 p-1" v-else>
                <div class="relative">
                    <label v-if="id == 0" class="block text-sm  font-semibold">
                        Tipo de Container
                    </label>
                    <select
                        v-model="item.typeContainer"
                        class="block text-sm  w-2/3 bg-white border border-gray-200 text-gray-700 py-2 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    >
                        <option value="2" translate=""> 20'DV </option>
                        <option value="3" translate=""> 40'DV </option>
                        <option value="4" translate=""> 40'HC </option>
                        <option value="5" translate=""> 45'HC </option>
                    </select>
                </div>
            </div>
            <div class="inline" v-if="modeCalculate">
                <div v-if="modeTypeSelected != 'CONTAINER'">
                    <span
                        v-if="id == 0"
                        class="text-sm text-center font-semibold "
                    >
                        Dimension Unitaria
                    </span>
                    <div class="flex">
                        <input
                            v-model.number="item.lengths"
                            class="h-9 w-13 focus:outline-none border rounded-l-lg flex items-center text-center  text-sm"
                            placeholder="L"
                        />
                        <input
                            v-model.number="item.width"
                            class="h-9 w-13 focus:outline-none border rounded-none flex items-center text-center  text-sm"
                            placeholder="W"
                        />
                        <input
                            v-model.number="item.high"
                            class="h-9 w-13 focus:outline-none border rounded-r-lg flex items-center text-center  text-sm"
                            placeholder="H"
                        />
                    </div>
                    <label class="inline-flex text-sm items-center mx-2 mt-2">
                        <input
                            type="radio"
                            v-model="item.lengthUnit"
                            class="form-checkbox h-4 w-4 text-gray-800"
                            :id="'lengthUnit' + id"
                            value="cm"
                        /><span class="ml-2 text-gray-700"> cm </span>
                    </label>
                    <label class="inline-flex text-sm items-center mx-2  mt-2">
                        <input
                            type="radio"
                            v-model="item.lengthUnit"
                            class="form-checkbox h-4 w-4 text-gray-800"
                            :id="'lengthUnit' + id"
                            value="pulg"
                        /><span class="ml-2 text-gray-700"> pulg </span>
                    </label>
                </div>
            </div>
            <div
                class="inline text-center"
                v-if="modeTypeSelected != 'CONTAINER'"
            >
                <span v-if="id == 0" class="text-sm text-center font-semibold ">
                    CBM
                </span>
                <input
                    :value="(item.lengths * item.width * item.high) / 10000"
                    class="h-9 w-15 focus:outline-none border  rounded-lg flex text-center   text-sm"
                    :disabled="modeCalculate"
                    placeholder="CBM"
                />
            </div>
            <div class="inline">
                <span v-if="id == 0" class="text-sm text-center font-semibold ">
                    Peso Unitario
                </span>
                <input
                    :value="item.weight"
                    :class="[
                        'h-9 focus:outline-none border rounded-lg flex text-center text-sm',
                        modeTypeSelected != 'CONTAINER' ? ' w-16' : ' w-17'
                    ]"
                />
                <label class="inline-flex text-sm items-center mx-2 mt-2">
                    <input
                        type="radio"
                        v-model="item.weightUnits"
                        :id="'weightUnits' + id"
                        :name="'weightUnits' + id"
                        class="form-checkbox h-4 w-4 text-gray-800"
                        checked
                        value="kg"
                    />
                    <span class="ml-2 text-gray-700"> kg </span>
                </label>
                <label class="inline-flex text-sm items-center mx-2  mt-2">
                    <input
                        type="radio"
                        v-model="item.weightUnits"
                        :id="'weightUnits' + id"
                        :name="'weightUnits' + id"
                        class="form-checkbox h-4 w-4 text-gray-800"
                        value="lbs"
                    />
                    <span class="ml-2 text-gray-700"> lbs </span>
                </label>
            </div>
            <div class="flex">
                <label
                    class="inline-flex text-sm items-center "
                    v-if="modeTypeSelected != 'CONTAINER'"
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
                v-if="modeCalculate || typeSelected == 'CONTAINER'"
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
</template>
<script>
export default {
    data() {
        return {
            expenses: {
                origin: false,
                destinacion: false,
                originWarehouse: false,
                destinacionWarehouse: false
            },
            modeCalculate: true,
            modeTypeSelected: "AERERO",
            safe: false,
            types: ["AEREO", "CONTAINER", "CONSOLIDADO"],
            item: {
                typeLoad: "",
                typeContainer: "",
                lengths: "",
                width: "",
                high: "",
                lengthUnit: true,
                id: 1,
                cbm: "",
                weight: "",
                weightUnits: true,
                stackable: "",
                id: 0
            },
            FielFormLoad: []
        };
    },
    props:{
        title:{
            require:false,
            default:'Cotizador Online'
        }
    },
    methods: {
        AddFielForm() {
            this.FielFormLoad.push({ ...this.item });
        },
        deleteForm(id) {
            this.FielFormLoad.splice(id, 1);
        },
        changeMode() {
            this.modeCalculate = !this.modeCalculate;
            this.reset();
        },
        typeSelected(value) {
            this.reset();
            this.modeTypeSelected = value;
        },
        reset() {
            this.FielFormLoad = [];
            this.FielFormLoad.push({ ...this.item });
        },
    },
    created() {
        this.reset();
    }
};
</script>

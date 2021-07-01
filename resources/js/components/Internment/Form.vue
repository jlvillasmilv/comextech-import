<template>
    <div class="w-full p-4">
        <div v-show="!transportSelected">
            <Load @getDataLoad="getDataLoad" />
        </div>
        <div class="flex flex-wrap -mx-3 ">
            <div class="w-1/2 px-3 mb-2 md:mb-0">
                <label class="block text-sm">
                    <span
                        class="text-gray-700 dark:text-gray-400 font-semibold"
                    >
                        Agente de Aduana
                    </span>
                    <input
                        class="block w-full mt-1 mb-3 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        placeholder="Datos del Agente de Aduana "
                    />
                    <input
                        type="checkbox"
                        class="form-checkbox h-4 w-4   text-blue-600"
                    /><span class="ml-2 text-xs text-black  text-gray-500">
                        Quiero que Comextech me asigne mi agente de aduana
                    </span>
                </label>
            </div>

            <div class="w-1/2 px-3">
                <span
                    class="text-gray-700 dark:text-gray-400 font-semibold text-sm"
                >
                    Tratado Internacional {{ treaties }} {{  nameFileUpload }}
                </span>
                <input
                    id="fileid"
                    v-show="showInputFile"
                    @change="handleFile()"
                    ref="file"
                    type="file"
                    hidden
                />
                <div
                    class="text-gray-600 dark:text-gray-400 flex space-x-5 justify-start  "
                >
                    <label
                        v-for="(item, key) in treaties"
                        :key="key"
                        class="inline-flex items-center mt-3"
                    >
                        <button
                            @click="openWindowFile(item)"
                            :class="[
                                'text-white   py-2 px-4 rounded-full',
                                item.submit
                                    ? 'bg-blue-500 hover:bg-blue-700'
                                    : 'bg-green-500 hover:bg-green-700'
                            ]"
                        >
                            {{ item.name }}
                        </button>
                        <!-- <input
                            v-model="treatiesSelected"
                            type="checkbox"
                            @input="checkInput(item)"
                            :id="key"
                            :value="item"
                            @click="openWindowFile(item)"
                            class="form-checkbox h-5 w-5 text-blue-600"
                        /><span class="ml-2 text-black"> {{ item }} </span> -->
                    </label>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap -mx-3 ">
            <div class="w-1/2 px-3 mb-2 md:mb-0">
                <label class="block text-sm">
                    <span
                        class="text-gray-700 dark:text-gray-400 font-semibold"
                    >
                        Pago de Agente de Aduana
                    </span>
                    <input
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        placeholder="Monto"
                    />
                </label>
            </div>
            <div class="w-1/2 px-3 ">
                <span
                    class="text-gray-700 dark:text-gray-400 font-semibold text-sm"
                >
                    Certificado
                </span>
                <div
                    class="text-gray-600 dark:text-gray-400 flex space-x-5 justify-start "
                >
                    <label class="inline-flex items-center mt-3">
                        <input
                            type="radio"
                            class="form-checkbox h-5 w-5 text-blue-600"
                            id="1"
                            name="1"
                        />
                        <span class="ml-2 text-black"> Origen</span>
                    </label>
                    <label class="inline-flex items-center mt-3">
                        <input
                            type="radio"
                            class="form-checkbox h-5 w-5 text-blue-600"
                            id="1"
                            name="1"
                        />
                        <span class="ml-2 text-black"> Fitosanitario</span>
                    </label>
                    <label class="inline-flex items-center mt-3">
                        <input
                            type="radio"
                            class="form-checkbox h-5 w-5 text-blue-600"
                            id="1"
                            name="1"
                        />
                        <span class="ml-2 text-black"> Form F</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Load from "../Transport/Load.vue";

export default {
    props: {
        application_id: {
            required: true,
            type: Number
        },
        transportSelected: {
            required: true,
            default: false
        }
    },
    components: { Load },
    data() {
        return {
            treaties: [
                {
                    name: "Form1",
                    submit: false
                },
                {
                    name: "Eur1",
                    submit: false
                },
                {
                    name: "Mercosur",
                    submit: false
                }
            ],
            dataLoad: [],
            treatiesSelected: [],
            files: [],
            showInputFile: false,
            nameFileUpload: ''
        };
    },
    methods: {
        getDataLoad(payload) {
            this.dataLoad = payload;
        },
        openWindowFile({ e, name: entry }) {

            let value = this.treatiesSelected.find(a => a.name == entry);

            if (value == undefined) {
                this.showInputFile = !this.showInputFile;
                let fileInputElement = this.$refs.file;
                this.nameFileUpload  = entry
                fileInputElement.click();
            }
        },
        handleFile() {
            this.treaties =  this.treaties.map(e =>
                 e.name === this.nameFileUpload ? { ...e, submit: true } : e
            );
            console.log(this.$refs.file.files[0], "ARCHIVO");
             
        },
        checkInput(e) {
            console.log("SALIO");
        }
        // async submitFile() {
        //     this.$swal.fire(
        //         Option("info", "Almacenando tu archivo, un momento!")
        //     );
        //     this.file = this.$refs.file.files[0];
        //     let formData = new FormData();
        //     formData.append("file", this.file);
        //     formData.append("type", this.data);
        //     let header = {
        //         headers: {
        //             "Content-Type": "multipart/form-data"
        //         }
        //     };
        //     try {
        //         await axios.post("/single-file", formData, header);
        //         this.status = true;
        //         this.$swal.fire(
        //             Option("success", "Archivo almacenado exitosamente!")
        //         );
        //     } catch (e) {
        //         this.$swal.fire(
        //             Option("error", "Ah ocurrido un error intente nuevamente!")
        //         );
        //     }
        // },
    }
};
</script>

<style></style>

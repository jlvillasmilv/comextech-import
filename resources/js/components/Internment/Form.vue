<template>
    <div class="w-full p-4">
        <div v-show="!transportSelected">
            <Load @dataForm="getDataLoad" />
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
                        v-model="expenses.agent_name"
                        class="block w-full mt-1 mb-3 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        placeholder="Datos del Agente de Aduana "
                    />
                    <span class="text-xs text-red-600 dark:text-red-400"
                                v-if="expenses.errors.has('agent_name')"
                                v-html="expenses.errors.get('agent_name')"
                            ></span>
                    <input
                        v-model="expenses.customs_house"
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
                    Tratado Internacional 
                </span>
                <input
                    id="fileid"
                    v-show="showInputFile"
                    @change="handleFile('x')"
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
                        v-model.number="expenses.agent_payment"
                        type="number"
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        placeholder="Monto"
                    />
                    <span class="text-xs text-red-600 dark:text-red-400"
                                v-if="expenses.errors.has('agent_payment')"
                                v-html="expenses.errors.get('agent_payment')"
                            ></span>
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
                            id="Origen"
                            value="Origen"
                            v-model="expenses.certificate"
                            type="radio"
                            class="form-checkbox h-5 w-5 text-blue-600"
                        />
                        <span class="ml-2 text-black">
                           
                             Origen
                             </span>
                       
                    </label>
                    <label class="inline-flex items-center mt-3">
                        <input
                            id="Fitosanitario"
                            value="Fitosanitario"
                            v-model="expenses.certificate"
                            type="radio"
                            class="form-checkbox h-5 w-5 text-blue-600"
                        />
                        <span class="ml-2 text-black"> Fitosanitario</span>
                    </label>
                    <label class="inline-flex items-center mt-3">
                        <input
                            id="Form F" value="Form F" v-model="expenses.certificate"
                            type="radio"
                            class="form-checkbox h-5 w-5 text-blue-600"
                        />
                        <span class="ml-2 text-black"> Form F</span>
                    </label>
                      
                </div>
                <div class="flex ">
                        <label class="flex flex-col items-center px-4 py-6 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-white">
                            <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                            </svg>
                            <span class="mt-2 text-base leading-normal">Subir Certificado</span>
                            <input type='file' class="hidden" id="fileic"
                            @change="previewFiles"
                            ref="certificate" />
                        </label>
                    </div>
            </div>
        </div>
        <button
                    @click="submitForm()"
                    class="w-1/3 h-12 px-4 text-white transition-colors text-lg duration-150 bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800"
                >
                    Cotizar
        </button>
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
             expenses: new Form({
                application_id: this.application_id,
                transport: this.transportSelected,
                agent_name:"",
                agent_payment:0,
                treatiesSelected: [],
                file_descrip: [],
                customs_house: false,
                certificate: "Origen",
                file_certificate: "",
                dataLoad: [],
                files: []
            }),

            
            showInputFile: false,
            nameFileUpload: ''
        };
    },
    methods: {
        getDataLoad(payload) {
           this.expenses.dataLoad = payload;
        },
        openWindowFile({ e, name: entry }) {

            let value = this.expenses.treatiesSelected.find(a => a.name == entry);

            if (value == undefined) {
                this.showInputFile = !this.showInputFile;
                let fileInputElement = this.$refs.file;
                this.nameFileUpload  = entry
                fileInputElement.click();
            }
        },
        handleFile() {

            const file = this.$refs.file.files[0]

            this.treaties =  this.treaties.map(e =>
                 e.name === this.nameFileUpload ? { ...e, submit: true } : e
                );

            this.expenses.files.push(file);

            this.expenses.file_descrip.push(this.nameFileUpload)
             
        },
        previewFiles(event) {
            // console.log(event.target.files);
            const certificate = event.target.files[0];
            this.expenses.file_certificate = certificate;
        },
        checkInput(e) {
            console.log("SALIO");
        },
        async submitForm() {
            try {
            const response = await this.expenses.post("/internment");

            Toast.fire({
                        icon: 'success',
                        title: 'Datos Agregados'
                    })

                this.$emit("incomingMenu");

             } catch (error) {
                console.error(error);
            }
        }
        
    }
};
</script>

<style></style>

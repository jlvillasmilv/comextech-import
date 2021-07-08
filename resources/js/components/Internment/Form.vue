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
                    <span
                        class="text-xs text-red-600 dark:text-red-400"
                        v-if="expenses.errors.has('agent_name')"
                        v-html="expenses.errors.get('agent_name')"
                    ></span>
                    <div>
                        <input
                            v-model="expenses.customs_house"
                            type="checkbox"
                            class="form-checkbox h-4 w-4   text-blue-600"
                        /><span class="ml-2 text-xs text-black  text-gray-500">
                            Quiero que Comextech me asigne mi agente de aduana
                        </span>
                    </div>
                </label>
            </div>

            <div class="w-1/2 px-3">
                 <input
                    id="filecert"
                    v-show="showInputFile"
                    @change="certificateFile()"
                    ref="file_cert"
                    type="file"
                    hidden
                />
                <span class="text-gray-700 dark:text-gray-400 font-semibold text-sm" >
                    Certificado
                </span>
                <div
                    class="text-gray-600 dark:text-gray-400 flex space-x-5 justify-start "
                >
                    <label
                        v-for="(item, key) in certif"
                        :key="key"
                        class="inline-flex items-center mt-3"
                    >
                        <a
                            @click="openWindowFileCert(item)"
                            class="flex  px-2 py-2 m-2  text-sm  rounded-full font-medium leading-5 text-white transition-colors duration-150   border border-transparent rounded-lg    focus:outline-none focus:shadow-outline-blue"
                            :class="[
                                item.submit
                                    ? 'bg-red-500 hover:bg-red-800'
                                    : 'bg-blue-500 hover:bg-blue-800'
                            ]"
                            ><svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                class="h-6 w-6"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    :d="[
                                        item.submit
                                            ? 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'
                                            : 'M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z'
                                    ]"
                                ></path>
                            </svg>
                            <span> {{ item.name }} </span></a
                        >
                    </label>

                </div>
                



              
                 <span
                    class="text-xs text-red-600 dark:text-red-400"
                    v-if="expenses.errors.has('file_certificate')"
                    v-html="expenses.errors.get('file_certificate')"
                ></span>
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
                    <span
                        class="text-xs text-red-600 dark:text-red-400"
                        v-if="expenses.errors.has('agent_payment')"
                        v-html="expenses.errors.get('agent_payment')"
                    ></span>
                </label>
            </div>
            <div class="w-1/2 px-3 ">
                <input
                    id="fileid"
                    v-show="showInputFile"
                    @change="handleFile()"
                    ref="file"
                    type="file"
                    hidden
                />
                <span
                    class="text-gray-700 dark:text-gray-400 font-semibold text-sm"
                >
                    Tratado Internacional
                </span>
                <div
                    class="text-gray-600 dark:text-gray-400 flex space-x-5 justify-start "
                >
                    <label
                        v-for="(item, key) in treaties"
                        :key="key"
                        class="inline-flex items-center mt-3"
                    >
                        <a
                            @click="openWindowFile(item)"
                            class="flex  px-2 py-2 m-2  text-sm  rounded-full font-medium leading-5 text-white transition-colors duration-150   border border-transparent rounded-lg    focus:outline-none focus:shadow-outline-blue"
                            :class="[
                                item.submit
                                    ? 'bg-red-500 hover:bg-red-800'
                                    : 'bg-blue-500 hover:bg-blue-800'
                            ]"
                            ><svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                class="h-6 w-6"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    :d="[
                                        item.submit
                                            ? 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'
                                            : 'M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z'
                                    ]"
                                ></path>
                            </svg>
                            <span> {{ item.name }} </span></a
                        >
                    </label>

                </div>
               
                <span
                    class="text-xs text-red-600 dark:text-red-400"
                    v-if="expenses.errors.has('file_certificate')"
                    v-html="expenses.errors.get('file_certificate')"
                ></span>
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
             certif: [
                {
                    name: "Origen",
                    submit: false
                },
                {
                    name: "Fitosanitario",
                    submit: false
                },
                {
                    name: "Form F",
                    submit: false
                }
            ],

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
            certificate: {},
            expenses: new Form({
                application_id: this.application_id,
                transport: this.transportSelected,
                agent_name: "",
                agent_payment: 0,
                treatiesSelected: [],
                file_descrip: [],
                customs_house: false,
                certificate: "Origen",
                file_certificate: "",
                dataLoad: [],
                files: new FormData()
            }),

            showInputFile: false,
            nameFileUpload: ""
        };
    },
    methods: {
        getDataLoad(payload) {
            this.expenses.dataLoad = payload;
        },
        openWindowFile({ e, name: entry }) {
            this.nameFileUpload = entry;
            let value = this.treaties.find(a => a.name == entry);
            if (!value.submit) {
                this.showInputFile = !this.showInputFile;
                let fileInputElement = this.$refs.file;
                fileInputElement.click();
            } else {
                this.handleStatusSubmitFile();
            }
        },

         openWindowFileCert({ e, name: entry }) {

            this.nameFileUpload = entry;
            let value = this.certif.find(a => a.name == entry);
            if (!value.submit) {
                this.showInputFile = !this.showInputFile;
                let fileInputElement = this.$refs.file_cert;
                fileInputElement.click();
            } else {
                 this.handleStatusCertificate();
            }
        },

         certificateFile() {
            const file = this.$refs.file_cert.files[0];
            if (file) {
                this.handleStatusCertificate();
                this.expenses.file_certificate = file;
                this.certificate = this.nameFileUpload
            }
        },

        handleFile() {
            const file = this.$refs.file.files[0];
            if (file) {
                this.handleStatusSubmitFile();
                this.expenses.files.append(this.nameFileUpload, file);
                this.expenses.file_descrip.push(this.nameFileUpload);
            }
        },
        handleStatusSubmitFile(ref = null) {

            this.treaties = this.treaties.map(e =>
                e.name === this.nameFileUpload ? { ...e, submit: !e.submit } : e
                );
           
        },
         handleStatusCertificate(ref = null) {

            this.certif = this.certif.map(e =>
                e.name === this.nameFileUpload ? { ...e, submit: !e.submit } : e
                );
           
        },
        previewFiles(event) {
            console.log(event.target.files);
            const certificate = event.target.files[0];
            this.expenses.file_certificate = certificate;
        },
        async submitForm() {
            try {
                const response = await this.expenses.post("/internment");

                Toast.fire({
                    icon: "success",
                    title: "Datos Agregados"
                });

                this.$emit("incomingMenu");
            } catch (error) {
                console.error(error);
            }
        }
    }
};
</script>
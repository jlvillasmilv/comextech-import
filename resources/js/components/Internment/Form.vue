<template>
    <div class="w-full  p-4">
        <div class="mb-5" v-show="!$store.getters.findService('ICS03')">
            <Load/>
        </div>
        <div class="flex flex-wrap -mx-3  " :class="[ !$store.getters.findService('ICS03') ?' ':'justify-center' ]">
            <div class="w-auto px-3 mb-2 md:mb-0  justify-evenly">
                <label class="block text-sm ">
                    <span
                        class="text-gray-700 dark:text-gray-400 font-semibold"
                    >
                        Agente de Aduana
                    </span>
                    <div class="my-4">
                        <v-select
                            v-if="!expenses.customs_house"
                            label="contact_person"
                            placeholder="Seleccionar su Agente de Aduana"
                            :options="custom_agents"
                            v-model="expenses.custom_agent_id"
                            :reduce="e => e.id"
                        >
                            <template v-slot:no-options="{ search, searching }">
                                <template v-if="searching" class="text-sm">
                                    Lo sentimos no hay opciones que coincidan
                                    <strong>{{ search }}</strong
                                    >.
                                </template>
                                <em style="opacity: 0.5;" v-else>
                                    No posee proveedores en tu lista</em
                                >
                            </template>
                        </v-select>
                    </div>
                    <span
                        class="text-xs text-red-600 dark:text-red-400"
                        v-if="expenses.errors.has('custom_agent_id')"
                        v-html="expenses.errors.get('custom_agent_id')"
                    ></span>
                    <div>
                        <input
                            v-model="expenses.customs_house"
                            type="checkbox"
                            class="form-checkbox h-5 w-5 text-blue-600"
                        /><span class="ml-2 text-xs text-black  text-gray-500">
                            Quiero que Comextech me asigne mi agente de aduana
                        </span>
                    </div>
                </label>
            </div>
            <div
                class="w-auto px-1 mb-2 md:mb-0"
                v-if="!expenses.customs_house"
            >
                <label class="block text-sm mt-2">
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
            <div class="w-auto px-1 px-3 mt-2">
                <input
                    id="filecert"
                    v-show="showInputFile"
                    @change="certificateFile()"
                    ref="file_cert"
                    type="file"
                    hidden
                />
                <div
                    class="text-gray-600 dark:text-gray-400 flex space-x-5 justify-start"
                >
                    <label
                        v-for="(item, key) in certif"
                        :key="key"
                        class="inline-flex items-center mt-3"
                    >
                        <a
                            @click="openWindowFileCert(item)"
                            class="flex  px-2 py-2 m-2  text-sm  font-medium leading-5 text-white transition-colors duration-150   border border-transparent rounded-lg    focus:outline-none focus:shadow-outline-blue"
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
            <div class="w-auto px-3 mt-2 ">
                <input
                    id="fileid"
                    v-show="showInputFile"
                    @change="handleFile()"
                    ref="file"
                    type="file"
                    hidden
                />
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
                            class="flex  px-2 py-2 m-2  text-sm font-medium leading-5 text-white transition-colors duration-150   border border-transparent rounded-lg    focus:outline-none focus:shadow-outline-blue"
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
                    v-if="expenses.errors.has('file_descrip')"
                    v-html="expenses.errors.get('file_descrip')"
                ></span>
            </div>
        </div>
        <div class="flex   space-x-5 mt-5  " :class="[ !$store.getters.findService('ICS03') ?' ':' justify-start ml-64 ' ]">
            <div class="flex mx-5">
                <ul class="space-y-2">
                    <li>
                        Mercaderia - {{ currency.code }}
                        {{ formatPrice(data.amount , currency.code) }}
                    </li>
                    <li>
                        Transporte - {{ currency.code }}
                        {{ formatPrice((data.amount * 2) / 100, currency.code) }}
                    </li>
                    <li>
                        Seguro - {{ currency.code }}
                        {{ formatPrice((data.amount * 5) / 100, currency.code) }}
                    </li>
                    <li class="border-t-2 border-fuchsia-600">
                        Valor CIF - 
                        {{ formatPrice(expenses.cif_amt,'CLP') }}
                    </li>
                </ul>
            </div>
            <div class="flex">
                 <div class="w-1/7 ml-8 mr-3">
                <img
                    v-if="expenses.iva"
                    class="  h-7 w-11 mb-6 object-contain"
                    src="https://homer.sii.cl/responsive/images/logo.jpg"
                />
                <img
                    v-if="expenses.adv"
                    class="h-7 w-11 object-contain "
                    src="https://user-images.githubusercontent.com/53098149/132052671-8d382ada-a5c1-4d73-8c04-1b3112a793f7.jpeg"
                />
            </div>
            <div class=" w-1/7 space-y-9">
                <h1 v-if="expenses.iva">
                    IVA ( 19% ) {{ formatPrice(expenses.iva_amt,'CLP') }}
                </h1>
                <h1 v-if="expenses.adv"> Ad Valorem ( 6% ) {{ formatPrice(expenses.adv_amt,'CLP') }}  </h1>
            </div>
            </div>
        </div>
        <div class="flex " :class="[ !$store.getters.findService('ICS03') ?' ':' justify-center' ]" >
                   <div class="my-2">
            <input
                type="checkbox"
                v-model="expenses.iva"
                class="form-checkbox h-5 w-5 text-blue-600"
            /><span class="m-2 text-xs text-black  text-gray-500">
                Requiero Financiamiento de IVA
            </span>
            <input
                type="checkbox"
                v-model="expenses.adv"
                class="form-checkbox  h-5 w-5 text-blue-600"
            /><span class="m-2 text-xs text-black  text-gray-500">
                Requiero Financiamiento de Ad.V.
            </span>
        </div>
        </div>
        <div class="flex justify-center">
            <button
            @click="submitForm()"
            class="w-1/6 h-12 my-10 text-white transition-colors text-lg duration-150 bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800"
        > Cotizar </button>
        </div>
        
    </div>

</template>

<script>
import { mapState, mapGetters } from "vuex";
import Load from "../Transport/Load.vue";
 
export default {
    props: {
        application_id: {
            required: true,
            type: Number
        }
    },
    components: { Load },
    computed: {
        ...mapState('internment',['expenses']),
        ...mapState('application', ['data','currency']),
    },
    data() {
        return {
            certif: [
                {
                    name: "Cargar Invoice",
                    submit: false
                }
            ],

            treaties: [
                {
                    name: "Otro Documento",
                    submit: false
                }
            ],
            certificate: {},
            custom_agents: [],
            showInputFile: false,
            nameFileUpload: "",
            // amountCIF:111
        };
    },
    methods: {
        formatPrice(value, currency) {
            return Number(value).toLocaleString(navigator.language, { 
                    minimumFractionDigits: currency == 'CLP' ? 0 : 2,
                    maximumFractionDigits: currency == 'CLP' ? 0 : 2
                });
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
                this.certificate = this.nameFileUpload;
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
                this.expenses.dataLoad = this.$store.state.load.loads
                await this.expenses.post("/internment");
                Toast.fire({
                    icon: "success",
                    title: "Datos Agregados"
                });
                this.$store.dispatch('exchange/getSummary', this.data.application_id);
                this.$store.dispatch('callIncomingOrNextMenu', true )

            } catch (error) {
                console.error(error);
            }
        },
    },
    async mounted() {
        try {
        // agente de Aduana del cliente
            let agents = await axios.get("/agentslist");
            this.custom_agents = agents.data;
            //asignar id de solicitud
            this.expenses.application_id = this.application_id
            this.expenses.transport = !this.$store.getters.findService('ICS03')

            this.expenses.cif_amt =(
                Number(this.data.amount) +
                 (Number(this.data.amount) * 2) / 100) +
                  ((Number(this.data.amount) * 5) / 100);

            const resp = await axios.get(
                `/api/convert-currency/${this.expenses.cif_amt}/${this.currency.code}/CLP`);

            this.expenses.cif_amt = resp.data;

            this.expenses.iva_amt = Math.round(this.expenses.cif_amt * 19 / 100);
            this.expenses.adv_amt = (this.expenses.cif_amt * 6 / 100);

        } catch (error) {
            console.log(error);
        }
    },
};
</script>

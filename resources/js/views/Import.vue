<template>
    <div class="md:container md:mx-auto text-gray-900 dark:text-gray-200">
        <ul class="flex justify-center items-center mt-2 ">
            <button
                v-if="!responseId"
                @click="statusModal = !statusModal"
                class="flex  px-2 py-2 m-2  text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-blue"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"
                    />
                </svg>
            </button>

            <div v-for="(item, id) in form.services" :key="id">
                <li
                    :class="[
                        'cursor-pointer py-2 px-5 text-gray-500 border-b-8',
                        item.name == activetab
                            ? 'text-b-500 border-indigo-500'
                            : ''
                    ]"
                >
                    {{ item.name }}
                </li>
            </div>
        </ul>
        <!-- <div class="w-full py-6">
            <div class="flex">
                <div
                    v-for="(item, id) in form.services"
                    :key="id"
                    class="w-1/4"
                >
                    <div class="relative mb-2" v-if="id > 0">
                        <div  >
                            <div
                                class="absolute flex align-center items-center align-middle content-center"
                                style="width: calc(100% - 2.5rem - 1rem); top: 50%; transform: translate(-50%, -50%)"
                            >
                                <div
                                    class="w-full bg-gray-200 rounded items-center align-middle align-center flex-1"
                                >
                                    <div
                                        class="w-0 bg-green-300 py-1 rounded width"
                                    ></div>
                                </div>
                            </div>
                            <div
                                :class="[item.name == activetab ? 'bg-green-500' :'bg-white']"
                                class="w-10 h-10 mx-auto   rounded-full text-lg text-white flex items-center"
                            >
                                <span  :class="[item.name == activetab ? 'text-white' :'text-gray-600']"   class="text-center   w-full">
                                     <svg class="w-full fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                        <path class="heroicon-ui" d="M5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2zm14 8V5H5v6h14zm0 2H5v6h14v-6zM8 9a1 1 0 1 1 0-2 1 1 0 0 1 0 2zm0 8a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div v-else-if="id == 0" class="relative mb-2">
                        <div
                            :class="[item.name == activetab ? 'bg-green-500' :'bg-white']" class="w-10 h-10 mx-auto  rounded-full text-lg text-white flex items-center"
                        >
                            <span  :class="[item.name == activetab ? 'text-white' :'text-gray-600']" class="text-center  w-full">
                                <svg
                                    class="w-full fill-current"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    width="24"
                                    height="24"
                                >
                                    <path
                                        class="heroicon-ui"
                                        d="M5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2zm14 8V5H5v6h14zm0 2H5v6h14v-6zM8 9a1 1 0 1 1 0-2 1 1 0 0 1 0 2zm0 8a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"
                                    />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="text-xs text-center md:text-base">
                        {{ item.name }}
                    </div>
                </div>
            </div>
        </div> -->

        <!-- <div class="w-full py-6">
            <div class="flex">
                <div class="w-1/4">
                    <div class="relative mb-2">
                        <div
                            class="w-10 h-10 mx-auto bg-green-500 rounded-full text-lg text-white flex items-center"
                        >
                            <span class="text-center text-white w-full">
                                <svg
                                    class="w-full fill-current"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    width="24"
                                    height="24"
                                >
                                    <path
                                        class="heroicon-ui"
                                        d="M5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2zm14 8V5H5v6h14zm0 2H5v6h14v-6zM8 9a1 1 0 1 1 0-2 1 1 0 0 1 0 2zm0 8a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"
                                    />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="text-xs text-center md:text-base">
                        Select Server
                    </div>
                </div>

                <div class="w-1/4">
                    <div class="relative mb-2">
                        <div
                            class="absolute flex align-center items-center align-middle content-center"
                            style="width: calc(100% - 2.5rem - 1rem); top: 50%; transform: translate(-50%, -50%)"
                        >
                            <div
                                class="w-full bg-gray-200 rounded items-center align-middle align-center flex-1"
                            >
                                <div
                                    class="w-0 bg-green-300 py-1 rounded"
                                    style="width: 100%;"
                                ></div>
                            </div>
                        </div>

                        <div
                            class="w-10 h-10 mx-auto bg-green-500 rounded-full text-lg text-white flex items-center"
                        >
                            <span class="text-center text-white w-full">
                                <svg
                                    class="w-full fill-current"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    width="24"
                                    height="24"
                                >
                                    <path
                                        class="heroicon-ui"
                                        d="M19 10h2a1 1 0 0 1 0 2h-2v2a1 1 0 0 1-2 0v-2h-2a1 1 0 0 1 0-2h2V8a1 1 0 0 1 2 0v2zM9 12A5 5 0 1 1 9 2a5 5 0 0 1 0 10zm0-2a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm8 11a1 1 0 0 1-2 0v-2a3 3 0 0 0-3-3H7a3 3 0 0 0-3 3v2a1 1 0 0 1-2 0v-2a5 5 0 0 1 5-5h5a5 5 0 0 1 5 5v2z"
                                    />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="text-xs text-center md:text-base">Add User</div>
                </div>

                <div class="w-1/4">
                    <div class="relative mb-2">
                        <div
                            class="absolute flex align-center items-center align-middle content-center"
                            style="width: calc(100% - 2.5rem - 1rem); top: 50%; transform: translate(-50%, -50%)"
                        >
                            <div
                                class="w-full bg-gray-200 rounded items-center align-middle align-center flex-1"
                            >
                                <div
                                    class="w-0 bg-green-300 py-1 rounded"
                                    style="width: 33%;"
                                ></div>
                            </div>
                        </div>

                        <div
                            class="w-10 h-10 mx-auto bg-white border-2 border-gray-200 rounded-full text-lg text-white flex items-center"
                        >
                            <span class="text-center text-gray-600 w-full">
                                <svg
                                    class="w-full fill-current"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    width="24"
                                    height="24"
                                >
                                    <path
                                        class="heroicon-ui"
                                        d="M9 4.58V4c0-1.1.9-2 2-2h2a2 2 0 0 1 2 2v.58a8 8 0 0 1 1.92 1.11l.5-.29a2 2 0 0 1 2.74.73l1 1.74a2 2 0 0 1-.73 2.73l-.5.29a8.06 8.06 0 0 1 0 2.22l.5.3a2 2 0 0 1 .73 2.72l-1 1.74a2 2 0 0 1-2.73.73l-.5-.3A8 8 0 0 1 15 19.43V20a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2v-.58a8 8 0 0 1-1.92-1.11l-.5.29a2 2 0 0 1-2.74-.73l-1-1.74a2 2 0 0 1 .73-2.73l.5-.29a8.06 8.06 0 0 1 0-2.22l-.5-.3a2 2 0 0 1-.73-2.72l1-1.74a2 2 0 0 1 2.73-.73l.5.3A8 8 0 0 1 9 4.57zM7.88 7.64l-.54.51-1.77-1.02-1 1.74 1.76 1.01-.17.73a6.02 6.02 0 0 0 0 2.78l.17.73-1.76 1.01 1 1.74 1.77-1.02.54.51a6 6 0 0 0 2.4 1.4l.72.2V20h2v-2.04l.71-.2a6 6 0 0 0 2.41-1.4l.54-.51 1.77 1.02 1-1.74-1.76-1.01.17-.73a6.02 6.02 0 0 0 0-2.78l-.17-.73 1.76-1.01-1-1.74-1.77 1.02-.54-.51a6 6 0 0 0-2.4-1.4l-.72-.2V4h-2v2.04l-.71.2a6 6 0 0 0-2.41 1.4zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-2a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"
                                    />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="text-xs text-center md:text-base">Setting</div>
                </div>

                <div class="w-1/4">
                    <div class="relative mb-2">
                        <div
                            class="absolute flex align-center items-center align-middle content-center"
                            style="width: calc(100% - 2.5rem - 1rem); top: 50%; transform: translate(-50%, -50%)"
                        >
                            <div
                                class="w-full bg-gray-200 rounded items-center align-middle align-center flex-1"
                            >
                                <div
                                    class="w-0 bg-green-300 py-1 rounded"
                                    style="width: 0%;"
                                ></div>
                            </div>
                        </div>

                        <div
                            class="w-10 h-10 mx-auto bg-white border-2 border-gray-200 rounded-full text-lg text-white flex items-center"
                        >
                            <span class="text-center text-gray-600 w-full">
                                <svg
                                    class="w-full fill-current"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    width="24"
                                    height="24"
                                >
                                    <path
                                        class="heroicon-ui"
                                        d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-2.3-8.7l1.3 1.29 3.3-3.3a1 1 0 0 1 1.4 1.42l-4 4a1 1 0 0 1-1.4 0l-2-2a1 1 0 0 1 1.4-1.42z"
                                    />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="text-xs text-center md:text-base">Finished</div>
                </div>
            </div>
        </div> -->

        <div class="w-full p-2 ">
            <Container :bg="false" v-if="activetab == 'Pago Proveedor'">
                <FormPayment
                    @Add="AddPay"
                    :amountTotal="form.amount"
                    @incomingMenu="incomingMenu"
                    :percentajeDelete="deletePay"
                />
                <TablePayment
                    :amount="form.amount"
                    :data="pays"
                    :currencies="currency"
                    @deleteRow="deletePayment"
                />
            </Container>

            <Container v-if="activetab == 'Transporte'">
                    <Addresses @incomingMenu="incomingMenu" />
            </Container>

            <Container v-if="activetab == 'Proceso de Internación'">
                <div class="w-full p-4">
                    <div v-if="!serviceTransport.length">
                        <!-- <Load :title="`Carga de Internacion`" /> -->
                    </div>
                    <FormInternment @incomingMenu="incomingMenu" @ />
                </div>
            </Container>

            <Container v-if="activetab == 'Bodegaje Local'">
                Bodegaje Local
            </Container>
        </div>
        <Modal v-if="statusModal" :title="title" class="mt-10">
            <template v-slot:body>
                <div class="mt-2" v-if="!next">
                    <label
                        v-for="(item, id) in tabs"
                        :key="id"
                        class="flex items-center ml-6 my-2 focu:otext-gray-600 dark:text-gray-400"
                    >
                        <input
                            @click="tabsAdd(item)"
                            :checked="item.selected"
                            type="checkbox"
                            class=" focus:outline-none  form-checkbox h-5 w-5 text-green-600"
                        />
                        <span class="ml-2"> {{ item.name }} </span>
                    </label>
                </div>
                <div v-else>
                    <form
                        @submit.prevent="submitFormApplications"
                        @keydown="form.onKeydown($event)"
                    >
                        <h3
                            class="my-4  font-semibold text-gray-700 dark:text-gray-200"
                        >
                            Informacion de Proveedor
                        </h3>
                        <div class="dark:text-gray-200">
                            <h3 class="my-4  text-gray-500 text-sm">
                                Proveedor de Mercancia
                            </h3>
                            <v-select
                                label="name"
                                placeholder="Seleccionar Proveedor"
                                :options="suppliers"
                                v-model="form.supplier_id"
                                :reduce="supplier => supplier.id"
                            >
                                <template
                                    v-slot:no-options="{ search, searching }"
                                >
                                    <template v-if="searching" class="text-sm">
                                        Lo sentimos no hay opciones que
                                        coincidan
                                        <strong>{{ search }}</strong
                                        >.
                                    </template>
                                    <em style="opacity: 0.5;" v-else>
                                        No posee proveedores en tu lista</em
                                    >
                                </template>
                            </v-select>
                            <span
                                class="text-xs text-red-600 dark:text-red-400"
                                v-if="form.errors.has('supplier_id')"
                                v-html="form.errors.get('supplier_id')"
                            ></span>
                        </div>
                        <div class="dark:text-gray-200">
                            <h3 class="my-3 text-gray-500 text-sm ">
                                Moneda de Pago
                            </h3>
                            <v-select
                                label="name_code"
                                v-model="currency"
                                placeholder="Moneda"
                                :options="currencies"
                            >
                                <template
                                    v-slot:no-options="{ search, searching }"
                                >
                                    <template v-if="searching" class="text-sm">
                                        Lo sentimos no hay opciones que
                                        coincidan
                                        <strong>{{ search }}</strong
                                        >.
                                    </template>
                                    <em style="opacity: 0.5;" v-else>
                                        Moneda
                                    </em>
                                </template>
                            </v-select>
                            <span
                                class="text-xs text-red-600 dark:text-red-400"
                                v-if="form.errors.has('currency_id')"
                                v-html="form.errors.get('currency_id')"
                            ></span>
                        </div>

                        <div class="flex flex-wrap -mx-3  ">
                            <div class="w-full md:w-1/2 px-3  md:mb-0">
                                <h3 class="my-3 text-gray-500 text-sm ">
                                    Fecha de Estimacion
                                </h3>
                                <input
                                    type="date"
                                    v-model="form.estimated_date"
                                    :class="[
                                        classStyle.input,
                                        classStyle.wfull,
                                        classStyle.formInput
                                    ]"
                                />
                            </div>
                            <div class="w-full md:w-1/2 px-3">
                                <h3 class="my-3  text-gray-500  text-sm">
                                    Monto Total de Operacion
                                </h3>
                                <input
                                    type="number"
                                    v-model="form.amount"
                                    :class="[
                                        classStyle.input,
                                        classStyle.formInput,
                                        classStyle.wfull
                                    ]"
                                />
                                <span
                                    class="text-xs text-red-600 dark:text-red-400"
                                    v-if="form.errors.has('amount')"
                                    v-html="form.errors.get('amount')"
                                ></span>
                            </div>
                        </div>
                        <div class="dark:text-gray-200">
                            <h3 class="my-4  text-gray-500  text-sm ">
                                Description
                            </h3>
                            <textarea
                                v-model="form.description"
                                name="message"
                                :class="[
                                    classStyle.wfull,
                                    classStyle.formInput,
                                    'py-4 px-4 text-xs'
                                ]"
                                placeholder="Necesito importar un Equipo desde China con Valor del Equipo es USD 50.000,00 Pago de 20% adelanto y 80% Saldo contra entrega Entrega para 30 dias a partir del adelanto"
                            >
                            </textarea>
                        </div>
                    </form>
                </div>
            </template>
            <template v-slot:footer>
                <div v-if="next">
                    <button
                        @click="next = !next"
                        class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray"
                    >
                        Atras
                    </button>
                    <button
                        type="submit"
                        :disabled="form.busy"
                        @click="submitFormApplications()"
                        class="transform motion-safe:hover:scale-110 w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green"
                    >
                        Aceptar
                    </button>
                </div>
                <div v-else>
                    <button
                        @click="clearSeletedTabs()"
                        class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray"
                    >
                        Cancelar
                    </button>
                    <button
                        v-if="form.services.length > 0"
                        @click="next = !next"
                        class=" transform motion-safe:hover:scale-110 w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green"
                    >
                        Siguiente
                    </button>
                </div>
            </template>
        </Modal>
    </div>
</template>
<script>
import PaymentProvider from "../layouts/PaymentProvider.vue";
import Modal from "../components/Modal.vue";
import Transport from "../layouts/Transport.vue";
import Container from "../components/Container.vue";
import Addresses from "../components/Transport/Addresses.vue";
import FormInternment from "../components/Internment/Form.vue";
import FormPayment from "../components/PaymentProvider/Form.vue";
import TablePayment from "../components/PaymentProvider/Table.vue";

export default {
    data() {
        return {
            form: new Form({
                application_id: 0,
                amount: 0,
                supplier_id: "",
                currency_id: "",
                estimated_date: "",
                description: "",
                services: []
            }),
            currency: "",
            position: 0,
            tabs: [],
            suppliers: [],
            activetab: false,
            statusModal: true,
            title: "Servicios para Cotizacion",
            next: false,
            currencies: [],
            classStyle: {
                span:
                    "ml-15 mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none   dark:text-gray-300 dark:focus:shadow-outline-gray ",
                input:
                    "block  text-center  mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none   dark:text-gray-300 dark:focus:shadow-outline-gray",
                wfull: "w-full",
                formInput: " form-input",
                label: "block  text-gray-700 text-xs dark:text-gray-400"
            },
            responseId: false,
            pays: [],
            formEditPayment: "",
            deletePay: 0
        };
    },
    components: {
        Modal,
        PaymentProvider,
        Transport,
        // Internment,
        Container,
        Addresses,
        FormInternment,
        FormPayment,
        TablePayment,
    },
    methods: {
        tabsAdd(item) {
            this.tabs = this.tabs.map(e =>
                e.id === item.id ? { ...e, selected: !e.selected } : e
            );
            this.form.services = this.tabs.filter(e => e.selected);
        },
        AddPay(payload) {
            console.log(payload);
            this.pays.push({ ...payload, id: this.pays.length });
        },
        toogleMenu(value) {
            this.activetab = value.name;
        },
        setValidate() {
            if (isNaN(this.form.fee1) || this.form.fee1 > 100) {
                this.form.fee1 = 0;
            } else {
                this.form.fee2 = 100 - this.form.fee1;
            }
        },
        clearSeletedTabs() {
            this.statusModal = !this.statusModal;
            this.tabs.map(e => (e.selected = false));
        },
        incomingMenu() {
            this.position = this.position + 1;
            this.activetab = this.form.services[this.position].name;
        },
        deletePayment(item) {
            this.pays = this.pays.filter(e => e.id !== item.id);
            this.deletePay = item;
        },
        async submitFormApplications() {
            try {
                this.form.currency_id = this.currency.id;
                const response = await this.form.post("/applications");
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Solicitud creada con exito!",
                    showConfirmButton: false,
                    timer: 1500
                });
                this.activetab = this.form.services[0].name;
                this.form.application_id = response.data;
                this.statusModal = !this.statusModal;
                this.position = 0;
            } catch (error) {
                console.log("error");
            }
        }
    },
    computed: {
        mount2() {
            return;
        },
        mount1() {
            return Math.round(this.form.amount * (this.form.fee1 / 100));
        },
        serviceTransport() {
            return this.form.services.filter(item => item.name == "Transporte");
        }
    },
    async created() {
        try {
            let tabs = await axios.get("/api/category_services");
            this.tabs = tabs.data;

            let suppliers = await axios.get("/supplierlist");
            this.suppliers = suppliers.data;

            let currencies = await axios.get("/api/currencies");
            this.currencies = currencies.data;
        } catch (error) {
            console.log(error);
        }

        let application = document.getElementById("applications");

        if (application == null) {
            console.log("Nueva Solicitud");
        } else {
            console.log("Editando", application.value);
        }
    }
};
</script>

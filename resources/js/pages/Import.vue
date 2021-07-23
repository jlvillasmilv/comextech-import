<template>
    <div class="md:container md:mx-auto text-gray-900 dark:text-gray-200">
        <ul class="flex justify-center items-center mt-2 ">
            <button
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

            <button
                rel="prev"
                class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple"
                @click="incomingMenu(false)"
            >
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        fill-rule="evenodd"
                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                        clip-rule="evenodd"
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

            <button
                rel="next"
                @click="incomingMenu(true)"
                class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple"
            >
                <svg
                    class="w-4 h-4 fill-current"
                    aria-hidden="true"
                    viewBox="0 0 20 20"
                >
                    <path
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd"
                        fill-rule="evenodd"
                    ></path>
                </svg>
            </button>
        </ul>

        <div class="w-full p-2 ">
            <Container :bg="false" v-if="activetab == 'Pago Proveedor'">
                <FormPayment
                    :application_id="form.application_id"
                    :amountTotal="form.amount"
                    @incomingMenu="incomingMenu"
                    :currencies="currency"
                />
            </Container>

            <Container v-if="activetab == 'Transporte'">
                <Addresses
                    @incomingMenu="incomingMenu"
                    :application_id="form.application_id"
                />
            </Container>

            <Container v-if="activetab == 'Proceso de Internación'">
                <FormInternment
                    @incomingMenu="incomingMenu"
                    :transportSelected="transportSelected"
                    :application_id="form.application_id"
                />
            </Container>

            <Container v-if="activetab == 'Bodegaje Local'">
                <internal-storage :application_id="form.application_id" />
            </Container>
        </div>
        <Modal v-if="statusModal" :title="title" class="mt-10">
            <template v-slot:body>
                <div class="mt-2">
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
                            <h3 class="my-3  text-gray-500  text-sm">
                                Proveedor
                            </h3>
                            <v-select
                                :disabled="form.statusSuppliers == 'without'"
                                label="name"
                                :placeholder="
                                    form.statusSuppliers !== 'E-commerce'
                                        ? 'Seleccionar Proveedor'
                                        : 'Seleccione E-commerce'
                                "
                                :options="
                                    form.statusSuppliers !== 'E-commerce'
                                        ? suppliers
                                        : agencyElectronic
                                "
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
                            <div v-if="form.statusSuppliers == 'E-commerce'" class="w-full md:w-full  ">
                                <input
                                    v-model="form.ecommerce_url"
                                    type="text"
                                    placeholder="Ingrese url generado por e-commerce "
                                    :class="[
                                        classStyle.input,
                                        classStyle.formInput,
                                        classStyle.wfull
                                    ]"
                                />
                            </div>
                            <div class="mt-2">
                                <label class="inline-flex items-center">
                                    <input
                                        type="radio"
                                        class="form-radio"
                                        name="accountType"
                                        v-model="form.statusSuppliers"
                                        @change="form.supplier_id = ''"
                                        value="with"
                                    />
                                    <span class="ml-2"> Con Proveedor </span>
                                </label>
                                <label class="inline-flex items-center ml-6">
                                    <input
                                        type="radio"
                                        class="form-radio"
                                        name="accountType"
                                        v-model="form.statusSuppliers"
                                        @change="form.supplier_id = ''"
                                        value="E-commerce"
                                    />
                                    <span class="ml-2"> E-commerce </span>
                                </label>
                                <label class="inline-flex items-center ml-6">
                                    <input
                                        type="radio"
                                        class="form-radio"
                                        name="accountType"
                                        v-model="form.statusSuppliers"
                                        @change="form.supplier_id = ''"
                                        value="without"
                                    />
                                    <span class="ml-2"> Sin Proveedor </span>
                                </label>
                            </div>
                            <span
                                class="text-xs text-red-600 dark:text-red-400"
                                v-if="form.errors.has('supplier_id')"
                                v-html="form.errors.get('supplier_id')"
                            ></span>
                        </div>
                        <div class="dark:text-gray-200">
                            <h3 class="my-3  text-gray-500  text-sm">
                                Condicion de Venta del Proveedor
                            </h3>
                            <div class="relative">
                                <select
                                    v-model="form.condition"
                                    @change="toogleMenuTabs()"
                                    class="block appearance-none w-full border border-gray-150 dark:border-gray-600  text-gray-700 p-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                >
                                    <option
                                        v-for="item in arrayServices"
                                        :value="item.name"
                                        :key="item.name"
                                    >
                                        {{ item.name }}
                                    </option>
                                </select>
                                <span
                                    class="text-xs text-red-600 dark:text-red-400"
                                    v-if="form.errors.has('condition')"
                                    v-html="form.errors.get('condition')"
                                ></span>

                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
                                >
                                    <svg
                                        class="fill-current h-4 w-4"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                                        />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-3  ">
                            <div class="w-full md:w-1/2 px-3  md:mb-0">
                                <h3 class="my-3 text-gray-500 text-sm ">
                                    Moneda de Pago
                                </h3>
                                <div class="relative">
                                    <v-select
                                        label="name_code"
                                        v-model="currency"
                                        placeholder="Moneda"
                                        :options="currencies"
                                    >
                                        <template
                                            v-slot:no-options="{
                                                search,
                                                searching
                                            }"
                                        >
                                            <template
                                                v-if="searching"
                                                class="text-sm"
                                            >
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

                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
                                    >
                                        <svg
                                            class="fill-current h-4 w-4"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                                            />
                                        </svg>
                                    </div>
                                </div>
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
                        <div v-if="tabs.length">
                            <label
                                v-for="(item, id) in tabs"
                                :key="id"
                                class="flex items-center my-2 focu:otext-gray-600 dark:text-gray-400"
                            >
                                <div class="flex items-center ">
                                    <input
                                        v-if="item.selected"
                                        type="checkbox"
                                        class=" focus:outline-none  form-checkbox h-5 w-5 text-green-600"
                                    />
                                    <div v-else class=" ">
                                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                     </div>

                                    <span :class="[ !item.selected ? 'text-gray-300': '' , 'ml-2']"> {{ item.name }} </span>
                                </div>
                            </label>
                        </div>
                        <span
                            class="text-xs text-red-600 dark:text-red-400"
                            v-if="form.errors.has('services')"
                            v-html="form.errors.get('services')"
                        ></span>
                    </form>
                </div>
            </template>
            <template v-slot:footer>
                <a
                    href="/applications"
                    class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray"
                >
                    Cancelar
                </a>
                <button
                    type="submit"
                    :disabled="form.busy"
                    @click="submitFormApplications()"
                    class="transform motion-safe:hover:scale-110 w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green"
                >
                    Aceptar
                </button>
            </template>
        </Modal>
    </div>
</template>
<script>
import Modal from "../components/Modal.vue";

import Container from "../components/Container.vue";
import Addresses from "../components/Transport/Addresses.vue";
import FormInternment from "../components/Internment/Form.vue";
import FormPayment from "../components/PaymentProvider/Form.vue";
import TablePayment from "../components/PaymentProvider/Table.vue";
import InternalStorage from "../components/InternalStorage.vue";

export default {
    data() {
        return {
            form: new Form({
                application_id: 0,
                amount: 0,
                supplier_id: "",
                currency_id: "",
                ecommerce_url: "",
                condition: "",
                description: "",
                statusSuppliers: "with",
                services: []
            }),
            agencyElectronic: [
                {
                    name: "Mercado Libre"
                },
                {
                    name: "Alibaba"
                },
                {
                    name: "Amazon"
                }
            ],
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
            formEditPayment: "",
            deletePay: 0,
            transportSelected: false,
            arrayServices: []
        };
    },
    components: {
        Modal,
        Container,
        Addresses,
        FormInternment,
        FormPayment,
        TablePayment,
        InternalStorage
    },
    methods: {
        toogleMenu(value) {
            this.activetab = value.name;
        },
        clearSeletedTabs() {
            this.statusModal = !this.statusModal;
            this.tabs.map(e => (e.selected = false));
        },
        incomingMenu(next = true) {
            if (this.position >= 0) {
                this.position = next ? this.position + 1 : this.position - 1;
                this.activetab = this.form.services[this.position].name;
            }
        },

        async submitFormApplications() {
            try {
                this.transportSelected = this.serviceFind("Transporte");
                this.form.currency_id = this.currency.id;
                const response = await this.form.post("/applications");

                if (response.data > 0) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Solicitud creada con exito!",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    this.activetab = this.form.services[0].name;
                    this.form.application_id = response.data.id;
                    console.log(data.id);
                    this.statusModal = !this.statusModal;
                    this.position = 0;
                }
            } catch (error) {
                console.log("error");
            }
        },
        serviceFind(value) {
            let response = this.form.services.find(item => item.name == value);
            return response ? true : false;
        },
        toogleMenuTabs() {
            this.tabs = this.form.condition.services;           
        }
    },
    async created() {
        try {
            let tabs = await axios.get("/api/suppl_cond_sales");
            this.arrayServices = tabs.data;
            this.tabs = tabs.data[0].services;
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

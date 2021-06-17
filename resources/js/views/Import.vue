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
            <div v-for="(item, id) in tabs" :key="id" @click="toogleMenu(item)">
                <li
                    v-if="item.selected"
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
        <div class="w-full p-2 ">
            <div v-if="activetab == 'Pago Proveedor'">
                <payment-provider :amountTotal="form.amount"/>
            </div>
            <div v-if="activetab == 'Transporte'">
                <Transport />
            </div>
            <div v-if="activetab == 'Proceso de Internación'">
                <Internment :services="form.services" />
            </div>
            <div v-if="activetab == 'Bodegaje Local'">
                Bodegaje Local
            </div>
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
                    <div class="dark:text-gray-200">
                        <h3 class="my-3 text-gray-500 text-sm ">
                            Moneda de Pago
                        </h3>
                        <v-select
                            label="name_code"
                            v-model="form.currency_id"
                            :reduce="currencie => currencie.id"
                            placeholder="Moneda"
                            :options="currencies"
                        >
                            <template v-slot:no-options="{ search, searching }">
                                <template v-if="searching" class="text-sm">
                                    Lo sentimos no hay opciones que coincidan
                                    <strong>{{ search }}</strong
                                    >.
                                </template>
                                <em style="opacity: 0.5;" v-else> Moneda </em>
                            </template>
                        </v-select>
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
                            <input type="number"
                                v-model="form.amount"
                                :class="[
                                    classStyle.input,
                                    classStyle.formInput,
                                    classStyle.wfull
                                ]"
                            />
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
                        v-if="tabsSelected.length > 0"
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
import Internment from "../layouts/Internment";
import Modal from "../components/Modal.vue";
import Transport from "../layouts/Transport.vue";


export default {
    data() {
        return {
            form: new Form({
                amount: 0,
                supplier_id: "",
                currency_id: "",
                estimated_date: "",
                description: "",
                services: []
            }),
            tabs: [],
            suppliers: [],
            activetab: false,
            statusModal: true,
            title: "Servicios para Cotizacion",
            next: false,
            currencies: [],
            tablePayment: [],
            classStyle: {
                span:
                    "ml-15 mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none   dark:text-gray-300 dark:focus:shadow-outline-gray ",
                input:
                    "block  text-center  mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none   dark:text-gray-300 dark:focus:shadow-outline-gray",
                wfull: "w-full",
                formInput: " form-input",
                label: "block  text-gray-700 text-xs dark:text-gray-400"
            },
            responseId: false
        };
    },
    components: {
        Modal,
        PaymentProvider,
        Transport,
        Internment
    },
    methods: {
        tabsAdd(item) {
            this.tabs = this.tabs.map(e =>
                e.id === item.id ? { ...e, selected: !e.selected } : e
            );
            this.form.services = this.tabs.filter(e => e.selected);
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
        async submitFormApplications() {
            // try {
           
            const response   = await this.form.post('/applications')
            //     Swal.fire({
            //         position: 'center',
            //         icon: 'success',
            //         title: 'Solicitud creada con exito!',
            //         showConfirmButton: false,
            //         timer: 1500
            //     })
            //     this.responseId  = response.data
            //     // this.form.services.sort((a, b) => b.id - a.id)
            //     this.activetab   = this.form.services[0].name
            //  }catch(error) {
            //        console.log('error')
            //  }
            this.statusModal = !this.statusModal;
            this.activetab = this.form.services[0].name;
        }
    },
    computed: {
        mount2() {
            return Math.round(this.form.amount * (this.form.fee2 / 100));
        },
        mount1() {
            return Math.round(this.form.amount * (this.form.fee1 / 100));
        },
        tabsSelected() {
            return this.tabs.filter(e => e.selected !== false);
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
    }
};
</script>

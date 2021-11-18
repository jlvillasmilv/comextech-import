<template>
    <div class="md:container md:mx-auto text-gray-900 dark:text-gray-200">
        <tabs />

        <div class="w-full p-2">
            <container :bg="false" v-if="$store.state.tabActive == 'ICS01'">
                <form-payment />
            </container>
            <container v-if="$store.state.tabActive == 'ICS03'">
                <addresses />
            </container>
            <container v-if="$store.state.tabActive == 'ICS04'">
                <form-internment :application_id="data.application_id" />
            </container>

            <container v-if="$store.state.tabActive == 'ICS05'">
                <internal-storage :application_id="data.application_id" />
            </container>

            <container v-if="$store.state.tabActive == 'ICS07'">
                <exchange :application_id="data.application_id" />
            </container>
        </div>
        <modal
            v-if="$store.state.statusModal"
            :title="title"
            class="transition ease-out duration-150"
        >
            <template v-slot:body>
                <div class="mt-1">
                    <form
                        @submit.prevent="submitFormApplications"
                        @keydown="data.onKeydown($event)"
                    >
                        <h3 class="my-3 text-green-700 text-lg">
                            Servicios
                        </h3>
                        <div class="flex w-full">
                            <label
                                v-for="(item, id) in tabs"
                                :key="id"
                                class="
                  flex
                  items-center
                  my-2 mr-6
                  focu:otext-gray-600
                  dark:text-gray-400
                "
                            >
                                <!-- data.statusSuppliers == 'with' -->
                                <div class="flex items-center">
                                    <input
                                        v-if="item.selected && !item.checked"
                                        type="checkbox"
                                        class="
                      focus:outline-none
                      form-checkbox
                      h-5 222 11
                      w-5
                      text-green-600
                    "
                                        :value="item"
                                        v-model="$store.state.selectedServices"
                                    />
                                    <input
                                        v-if="item.checked"
                                        type="checkbox"
                                        class="
                      focus:outline-none
                      form-checkbox
                      h-5 2 2222 7
                      w-5
                      text-green-600
                    "
                                        @click="deleteService(item)"
                                        :value="item"
                                        :checked="item.checked"
                                    />
                                    <div v-else-if="!item.selected" class="">
                                        <svg
                                            class="w-5 h-5 text-gray-300"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"
                                            ></path>
                                        </svg>
                                    </div>
                                    <span
                                        :class="[
                                            !item.selected
                                                ? 'text-gray-300'
                                                : '',
                                            'ml-2'
                                        ]"
                                    >
                                        {{ item.name }}
                                    </span>
                                </div>
                            </label>
                        </div>
                        <span
                            class="text-xs text-red-600 dark:text-red-400"
                            v-if="data.errors.has('services')"
                            v-html="data.errors.get('services')"
                        ></span>
                        <h3 class="my-3 text-green-700 text-lg">
                            Proveedor
                        </h3>
                        <div class="flex">
                            <section
                                class="w-8/12 flex flex-col justify-center"
                            >
                                <div
                                    class="inline-flex flex-col w-full dark:text-gray-200"
                                >
                                    <v-select
                                        class="w-full"
                                        :disabled="
                                            data.statusSuppliers == 'without'
                                        "
                                        label="name"
                                        :placeholder="
                                            data.statusSuppliers !==
                                            'E-commerce'
                                                ? 'Seleccionar Proveedor'
                                                : 'Seleccione E-commerce'
                                        "
                                        :options="
                                            data.statusSuppliers !==
                                            'E-commerce'
                                                ? suppliers
                                                : agencyElectronic
                                        "
                                        v-model="data.supplier_id"
                                        :reduce="supplier => supplier.id"
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
                                            <em style="opacity: 0.5" v-else>
                                                No posee proveedores en tu
                                                lista</em
                                            >
                                        </template>
                                    </v-select>
                                    <div
                                        class="inline-flex w-full md:w-8/12"
                                        v-show="
                                            data.statusSuppliers == 'E-commerce'
                                        "
                                    >
                                        <input
                                            v-model="data.ecommerce_url"
                                            type="text"
                                            placeholder="Ingrese url generado por e-commerce "
                                            :disabled="
                                                data.statusSuppliers !==
                                                    'E-commerce'
                                            "
                                            :class="[
                                                classStyle.input,
                                                classStyle.formInput,
                                                classStyle.wfull
                                            ]"
                                        />
                                    </div>
                                </div>
                            </section>
                            <section class="w-4/12 flex justify-center">
                                <div class="inline-flex flex-col w-full mx-4">
                                    <label
                                        v-for="(item, index) in statusSuppliers"
                                        :key="index"
                                        class="inline-flex justify-center items-center"
                                    >
                                        <input
                                            type="radio"
                                            class="form-radio"
                                            name="accountType"
                                            v-model="data.statusSuppliers"
                                            @click="
                                                toDisableProviderPayment(
                                                    item.name,
                                                    true
                                                )
                                            "
                                            :value="item.name"
                                        />
                                        <span class="m-2">
                                            {{ item.description }}
                                        </span>
                                    </label>
                                </div>
                            </section>
                        </div>
                        <span
                            class="text-xs text-red-600 dark:text-red-400"
                            v-if="data.errors.has('supplier_id')"
                            v-html="data.errors.get('supplier_id')"
                        ></span>
                        <h3 class="my-3 text-green-700 text-lg">
                            Pago
                        </h3>
                        <div class="w-full flex items-center">
                            <div class="sm:w-4/12 md:w-4/12">
                                <!-- <h3 class="my-3 text-gray-500 text-sm">
                                    Moneda de Pago
                                </h3> -->

                                <v-select
                                    label="name"
                                    v-model="$store.state.application.currency"
                                    placeholder="Moneda de Pago"
                                    @input="handleCurrency"
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
                                        <em style="opacity: 0.5" v-else>
                                            Moneda
                                        </em>
                                    </template>
                                    <template v-slot:option="currencies">
                                        {{
                                            `${currencies.name} (${currencies.code}) `
                                        }}
                                    </template>
                                </v-select>
                                <span
                                    class="text-xs text-red-600 dark:text-red-400"
                                    v-if="data.errors.has('currency_id')"
                                    v-html="data.errors.get('currency_id')"
                                ></span>
                            </div>
                            <div
                                class="flex flex-wrap justify-center sm:w-4/12 md:w-4/12"
                                v-show="data.statusSuppliers == 'with'"
                            >
                                <!-- <h3 class="my-3 text-gray-500 text-sm">
                                    Porcentaje de Pago
                                </h3> -->

                                <div
                                    v-for="(item, id) in paymentPercentage"
                                    :key="id"
                                    @click="handlePercentage(item)"
                                    :class="[
                                        item.valueInitial ==
                                        data.valuePercentage.valueInitial
                                            ? 'bg-blue-500 text-white '
                                            : 'bg-transparent text-blue-700 ',
                                        'w-3/12 hover:bg-blue-500 font-semibold hover:text-white px-1 py-2 text-sm mx-0.5 border border-blue-500 hover:border-transparent rounded my-2 text-center'
                                    ]"
                                >
                                    {{ item.name }}
                                </div>
                                <span
                                    class="text-xs text-red-600 dark:text-red-400"
                                    v-if="data.errors.has('valuePercentage')"
                                    v-html="data.errors.get('valuePercentage')"
                                ></span>
                            </div>
                            <div
                                class="flex flex-col justify-between sm:w-4/12"
                            >
                                <div
                                    :class="[
                                        data.statusSuppliers == 'with'
                                            ? 'w-full'
                                            : 'w-full',
                                        'md:mb-0'
                                    ]"
                                >
                                    <h3 class="my-2.5 text-gray-500 text-sm">
                                        Condicion de Venta
                                    </h3>
                                    <div class="relative">
                                        <select
                                            v-model="
                                                $store.state.application
                                                    .selectedCondition
                                            "
                                            @change="toogleMenuTabs()"
                                            class="
                      block
                      appearance-none
                      w-full
                      border border-gray-150
                      dark:border-gray-600
                      text-gray-700
                      p-2
                      pr-8
                      rounded
                      leading-tight
                      focus:outline-none
                      focus:bg-white
                      focus:border-gray-500
                    "
                                        >
                                            <option
                                                v-for="item in arrayServices"
                                                :value="item"
                                                :key="item.name"
                                            >
                                                {{ item.name }}
                                            </option>
                                        </select>
                                        <span
                                            class="text-xs text-red-600 dark:text-red-400"
                                            v-if="data.errors.has('condition')"
                                            v-html="
                                                data.errors.get('condition')
                                            "
                                        ></span>
                                        <div
                                            class="
                      pointer-events-none
                      absolute
                      inset-y-0
                      right-0
                      flex
                      items-center
                      px-2
                      text-gray-700
                    "
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
                                <div class="w-full">
                                    <h3 class="my-3 text-gray-500 text-sm">
                                        Monto de Operacion
                                    </h3>
                                    <input
                                        type="number"
                                        v-model="data.amount"
                                        :class="[
                                            classStyle.input,
                                            classStyle.formInput,
                                            classStyle.wfull
                                        ]"
                                    />
                                    <span
                                        class="text-xs text-red-600 dark:text-red-400"
                                        v-if="data.errors.has('amount')"
                                        v-html="data.errors.get('amount')"
                                    ></span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="my-3 text-green-700 text-lg">
                                Tipo de Transporte
                            </h3>
                            <div class="flex  mt-3 mb-8   ">
                                <ul class="flex  space-x-2 mt-3 ">
                                    <li
                                        v-for="name in $store.state.load.types"
                                        :key="name"
                                        :class="[
                                            'cursor-pointer px-5 text-gray-900 border-b-2',
                                            name ==
                                            $store.state.application.data.type_transport
                                                ? ' border-blue-500'
                                                : ''
                                        ]"
                                        @click="typeSelected(name)"
                                    >
                                        {{ name }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </template>
            <template v-slot:footer>
                <a
                    href="/applications"
                    class="
            w-full
            px-5
            py-3
            text-sm
            font-medium
            leading-5
            text-white text-gray-700
            transition-colors
            duration-150
            border border-gray-300
            rounded-lg
            dark:text-gray-400
            sm:px-4
            sm:py-2
            sm:w-auto
            active:bg-transparent
            hover:border-gray-500
            focus:border-gray-500
            active:text-gray-500
            focus:outline-none
            focus:shadow-outline-gray
          "
                >
                    Cancelar
                </a>
                <button
                    type="submit"
                    :disabled="busy"
                    @click="submitFormApplications()"
                    class="
            transform
            motion-safe:hover:scale-110
            w-full
            px-5
            py-3
            text-sm
            font-medium
            leading-5
            text-white
            transition-colors
            duration-150
            bg-green-600
            border border-transparent
            rounded-lg
            sm:w-auto
            sm:px-4
            sm:py-2
            active:bg-green-600
            hover:bg-green-700
            focus:outline-none
            focus:shadow-outline-green
          "
                >
                    Aceptar
                </button>
            </template>
        </modal>
    </div>
</template>
<script>
import Modal from '../components/Modal.vue';
import Container from '../components/Container.vue';
import Addresses from '../components/Transport/Addresses.vue';
import FormInternment from '../components/Internment/Form.vue';
import FormPayment from '../components/PaymentProvider/Form.vue';
import InternalStorage from '../components/InternalStorage.vue';
import Exchange from '../components/Exchange';
import servicedefault from '../data/services.json';
import Tabs from '../components/Tabs.vue';
import { mapState } from 'vuex';

export default {
    data() {
        return {
            busy: false,
            statusSuppliers: [
                { description: 'Proveedor', name: 'with' },
                { description: 'Sin Proveedor', name: 'without' },
                { description: 'E-commerce', name: 'E-commerce' }
            ],
            position: 0,
            title: 'Servicios para Cotizacion',
            next: false,
            classStyle: {
                span:
                    'ml-15 mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none   dark:text-gray-300 dark:focus:shadow-outline-gray ',
                input:
                    'block  text-center  mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none   dark:text-gray-300 dark:focus:shadow-outline-gray',
                wfull: 'w-full',
                formInput: ' form-input',
                label: 'block  text-gray-700 text-xs dark:text-gray-400'
            },
            paymentPercentage: [
                { name: '10/90', valueInitial: 50 },
                { name: '20/80', valueInitial: 20 },
                { name: '100%', valueInitial: 100 },
                { name: '30/70', valueInitial: 30 },
                { name: '60/40', valueInitial: 40 },
                { name: 'OTROS', valueInitial: 0 }
            ],
            objectPayment: {
                id: 11,
                name: 'Pagos',
                code: 'ICS07',
                selected: true,
                pivot: {
                    application_cond_sale_id: 1,
                    category_service_id: 8
                }
            }
        };
    },
    components: {
        Modal,
        Container,
        Addresses,
        FormInternment,
        FormPayment,
        InternalStorage,
        Exchange,
        Tabs
    },
    methods: {
        deleteService({ id }) {
            this.$store.state.selectedServices = this.$store.state.selectedServices.filter(
                item => item.id !== id
            );
            this.$store.state.application.tabs = this.$store.state.application.tabs.map(
                tab => (tab.id == id ? { ...tab, checked: false } : tab)
            );
        },
        toDisableProviderPayment(value, provider = false) {
            this.clearEcommerceSupplier(provider);
            this.clearSelectedServices();
            if (value == 'without') {
                this.$store.state.application.tabs = this.tabs.map(item =>
                    item.code == 'ICS01' ? { ...item, selected: false } : item
                );
            } else {
                this.$store.state.application.tabs = this.selectedCondition.services;
            }
        },
        clearEcommerceSupplier(provider) {
            if (provider) this.data.ecommerce_url = '';
            this.data.supplier_id = '';
        },
        insertPaymentsToServices() {
            const { selectedServices } = this.$store.state;
            // Verificar si pagos ya esta agregado a servicios
            const exchange = selectedServices.find(e => e.code == 'ICS07');
            if (!exchange) selectedServices.push(this.objectPayment);
        },
        async submitFormApplications() {
            try {
                //obtener id de la moneda seleccionada antes del submit
                this.data.currency_id = this.$store.state.application.currency.id;
                //obtener solo los codigo de los services
                this.data.services = this.servicesCode;
                // enviar form de data
                const { data } = await this.data.post('/applications');
                this.busy = true;
                if (data) {
                    this.insertPaymentsToServices();
                    // Mostrar mensaje confirmacion
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Solicitud creada con exito!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    // Ir a la posicion 0 para mostrar el menu
                    this.$store.state.tabActive = this.$store.state.selectedServices[
                        this.$store.state.positionTabs
                    ].code;
                    // asignar id devuelta al form id
                    this.data.application_id = data.id;
                    this.$store.dispatch('exchange/getSummary', data.id);

                    //  cerrar modal
                    this.$store.state.statusModal = !this.$store.state
                        .statusModal;
                    //  posicion de modal comienzan en 0
                    this.$store.state.positionTabs = 0;
                    this.busy = false;

                    if (data.supplier_id != null) {
                        this.$store.dispatch(
                            'application/getOriginTransport',
                            data.id
                        );
                    }
                }
            } catch (error) {
                console.error(error);
            }
        },
        clearEcommerceSupplier(provider) {
            if (provider) {
                this.data.ecommerce_url = '';
                this.data.supplier_id = '';
            }
        },
        clearSelectedServices() {
            this.$store.state.selectedServices = [];
        },
        handlePercentage(item) {
            this.handleCurrency();
            this.data.valuePercentage = item;
        },
        handleCurrency() {
            this.$store.state.payment.payment = [];
            this.$store.state.payment.percentageInitial = 100;
            this.data.amount = 0;
        },
        toogleMenuTabs() {
            this.clearSelectedServices();
            this.$store.state.application.tabs = this.selectedCondition.services;
            this.data.condition = this.selectedCondition.name;
            this.toDisableProviderPayment(this.data.statusSuppliers);
        },
        typeSelected(value) {
            this.$store.state.application.data.type_transport = value;
            this.$store.state.load.item.type_transport = value;
           // this.reset();
        },
        reset() {
            this.$store.state.load.loads = [];
            this.$store.dispatch('load/addLoad', this.item);
        }
    },
    computed: {
        ...mapState('application', [
            'tabs',
            'data',
            'agencyElectronic',
            'suppliers',
            'arrayServices',
            'currencies',
            'origin_transport',
            'currency',
            'selectedCondition'
        ]),
        servicesCode() {
            return this.$store.state.selectedServices.map(item => item.code);
        }
    },
    async mounted() {
        try {
            this.$store.dispatch('application/getSuppliers');
            this.$store.dispatch('application/getServices');
            this.$store.dispatch('application/getCurrencies');

            let application = document.getElementById('applications');

            if (application !== null) {
                const id = application.value;
                this.toogleMenuTabs();
                const { data } = await axios.get('/get-application/' + id);
                this.$store.dispatch('application/setData', data);
                await this.$store.dispatch(
                    'application/getServicesSelecteds',
                    id
                );
                this.$store.state.selectedServices = this.tabs.filter(
                    e => e.checked
                );
                this.$store.dispatch(
                    'payment/setPayment',
                    data.payment_provider
                );
                this.$store.dispatch('load/setLoad', data);
                this.$store.dispatch('address/setTransport', data);
                this.$store.dispatch('internment/setData', data);
            } else {
                this.$store.state.application.tabs = servicedefault;
            }
        } catch (error) {}
    }
};
</script>

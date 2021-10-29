<template>
    <div v-if="isLoanding" class="col-lg text-center">
        <div v-if="!StatusSii">
            <h6 class="font-weight-bold">
                Registra tus credenciales del SII y has tu proceso mas facil!
            </h6>
            <formProvider @updatePassword="getAPI"></formProvider>
        </div>
        <div v-else>
            <button
                @click="showModal()"
                type="button"
                class="mt-2 text-white bg-blue-800 border-blue-700  inline-block text-center align-middle p-2 text-sm rounded"
                data-toggle="modal"
                data-target=".bd-example-modal-md"
            >
                ABRIR MI CARTERA
            </button>
            <button
                v-if="items.length > 0"
                type="button"
                class="mt-2 text-white bg-blue-800 border-blue-700  inline-block text-center align-middle p-2 text-sm rounded"
                @click="onAncipate"
            >
                SOLICITAR
            </button>
        </div>
        <quote_table :source="source" :items="items" />
        <div
            v-if="showTable == true"
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
            id="modal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="myLargeModalLabel"
            aria-hidden="true"
        >
            <div
                class="overflow-x-hidden fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
            >
                <div
                    class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-4xl"
                >
                    <div class="flex flex-wrap justify-between items-center">
                        <h5 class="text-blue-800 font-bold text-lg">
                            Registro de Ventas del SII
                        </h5>

                        <button
                            @click="closeModal()"
                            class="items-center justify-center text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <svg
                                class="w-4 h-4"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                role="img"
                                aria-hidden="true"
                            >
                                <path
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"
                                    fill-rule="evenodd"
                                ></path>
                            </svg>
                            <!-- <span aria-hidden="true">&times;</span> -->
                        </button>
                    </div>
                    <div
                        class="flex flex-wrap justify-between items-center my-3"
                    >
                        <div>
                            Cant. Factura Cotizadas:
                            <strong>{{ items.length }}</strong>
                        </div>
                        <div>
                            <span>
                                <i class="far fa-circle fa-lg text-dark"> </i>
                                Poca Informacion</span
                            >
                            <span>
                                <i class="fa fa-circle fa-lg bankable"> </i>
                                Evaluable</span
                            >
                            <span>
                                <i class="fa fa-circle fa-lg very-bankable ">
                                </i
                                >Confiable</span
                            >
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="flex flex-col">
                            <vue-good-table
                                :columns="columns"
                                :rows="invoices"
                                :search-options="{
                                    enabled: true,
                                    placeholder: 'Busqueda'
                                }"
                                title="Registro de Ventas del SI"
                                styleClass="vgt-table condensed"
                                theme="polar-bear"
                                compactMode
                                :pagination-options="{
                                    enabled: true,
                                    nextLabel: 'Siguiente',
                                    prevLabel: 'Anterior',
                                    rowsPerPageLabel: 'Nro ',
                                    ofLabel: ' /'
                                }"
                            >
                                <template slot="table-row" slot-scope="props">
                                    <span v-if="props.column.field == 'select'">
                                        <a @click="onRowSelected(props.row)"
                                            ><i
                                                ><svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                    aria-hidden="true"
                                                    role="img"
                                                    width="1em"
                                                    height="1em"
                                                    preserveAspectRatio="xMidYMid meet"
                                                    viewBox="0 0 20 20"
                                                >
                                                    <g fill="none">
                                                        <path
                                                            fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M10 18a8 8 0 1 0 0-16a8 8 0 0 0 0 16zm1-11a1 1 0 1 0-2 0v2H7a1 1 0 1 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2h-2V7z"
                                                            fill="#36b9cc"
                                                        />
                                                    </g></svg></i
                                        ></a>
                                    </span>

                                    <span v-if="props.column.field == 'rut'">
                                        {{
                                            props.row.rut
                                                | VMask('##.###.###-NN')
                                        }}
                                    </span>
                                    <span v-else>
                                        {{
                                            props.formattedRow[
                                                props.column.field
                                            ]
                                        }}
                                    </span>
                                    <span
                                        v-if="
                                            props.column.field == 'settlement'
                                        "
                                    >
                                        <span
                                            :class="[
                                                props.row
                                                    .settlement_status_id ===
                                                    null ||
                                                props.row
                                                    .settlement_status_id == 1
                                                    ? ' text-dark'
                                                    : '',
                                                props.row
                                                    .settlement_status_id === 3
                                                    ? 'very-bankable'
                                                    : '',
                                                props.row
                                                    .settlement_status_id === 2
                                                    ? 'bankable'
                                                    : ''
                                            ]"
                                        >
                                            <i
                                                :class="[
                                                    props.row
                                                        .settlement_status_id ===
                                                        null ||
                                                    props.row
                                                        .settlement_status_id ==
                                                        1
                                                        ? ' far fa-circle fa-lg'
                                                        : 'fa fa-circle fa-lg'
                                                ]"
                                            >
                                            </i>
                                        </span>
                                    </span>
                                </template>
                            </vue-good-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else class="col-lg text-center">
        <h4 class="h4 text-dark mb-4">
            Estamos procesando tu informacion, un momento!
        </h4>
        <div class="lds-dual-ring row justify-content-center"></div>
    </div>
</template>

<script>
import Option from '../../config/alert';
import QuoteTable from '../Factoring/QuoteTable';
import FormCredential from '../../views/Provider';
import { VueGoodTable } from 'vue-good-table';

export default {
    data() {
        return {
            color: { '1': 'red', '2': 'blue', null: 'red', '3': 'green' },
            columns: [
                {
                    label: 'Simular',
                    field: 'select',
                    sortable: false,
                    thClass: 'vgt-center-align',
                    tdClass: 'vgt-center-align',
                    tooltip: 'Seleccionar Registro',
                    width: '72px'
                },
                {
                    label: 'Info',
                    sortable: false,
                    thClass: 'vgt-center-align',
                    tdClass: 'vgt-center-align',
                    field: 'settlement',
                    width: '50px'
                },
                {
                    label: 'Folio',
                    field: 'folio',
                    type: 'number',
                    thClass: 'vgt-center-align',
                    tdClass: 'vgt-center-align',
                    width: '75px'
                },
                {
                    label: 'RUT',
                    field: 'rut',
                    formatFn: this.formatRut,
                    thClass: 'vgt-center-align',
                    tdClass: 'vgt-center-align',
                    width: '125px'
                },
                {
                    label: 'Pagador',
                    field: 'name'
                },
                {
                    label: 'Monto',
                    field: 'total',
                    type: 'number',
                    thClass: 'vgt-left-align',
                    tdClass: 'vgt-left-align',
                    formatFn: this.formatFn,
                    width: '110px'
                },
                {
                    label: 'Fecha',
                    field: 'fecha',
                    type: 'date',
                    thClass: 'vgt-left-align',
                    tdClass: 'vgt-left-align',
                    width: '95px',
                    dateInputFormat: 'yyyy-MM-dd',
                    dateOutputFormat: 'dd-MM-yy'
                }
            ],
            invoices: [],
            items: [],
            invoicesOriginal: {},
            source: 'api',
            route: 'applications',
            credential: {},
            client: {},
            isLoanding: false,
            StatusSii: true,
            showTable: false
        };
    },
    components: {
        quote_table: QuoteTable,
        formProvider: FormCredential,
        VueGoodTable
    },
    methods: {
        formatRut: function(value) {
            return value;
        },
        formatFn: function(value) {
            return '$ ' + Number(value).toLocaleString();
        },
        async getAPI() {
            try {
                this.isLoanding = false;
                let response = await axios.get('libredte');
                this.invoices = response.data;
                this.invoicesOriginal = response.data;
                this.isLoanding = true;
                this.StatusSii = true;
            } catch (error) {
                this.StatusSii = false;
                this.isLoanding = true;
                this.$swal.fire(Option('warning', error.response.data));
            }
        },
        async onRowSelected(item) {
            this.invoices = this.invoices.filter(
                items => items.folio !== item.folio
            );
            this.$swal.fire(
                Option('success', ` Factura Cotizada! Folio ${item.folio}`)
            );
            let data = {
                rut: item.rut,
                payer: item.name,
                number: item.folio,
                total_amount: item.total,
                issuing_date: item.fecha
            };
            let response = await axios.post('quote/calculation', data);
            this.items.push(response.data);
        },
        onDelete: function(index, item) {
            let result = this.invoicesOriginal.find(
                element => element.folio == item.number
            );
            this.items.splice(index, 1);
            this.invoices.push(result);
        },
        async onAncipate() {
            let value = this.items.filter(
                item => item.change_expire === undefined
            );
            if (value.length > 0) {
                return this.$swal.fire(
                    Option(
                        'warning',
                        'Todas la facturas requieren de actualizar la fecha de vencimiento! '
                    )
                );
            }
            const { value: result } = await Swal.fire({
                title: 'Esta seguro de Realizar la solicitud?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, solicitar!',
                cancelButtonText: 'Cancelar'
            });
            if (result) {
                try {
                    let payload = {
                        items: this.items
                    };
                    let response = await axios.post(
                        '/factoring/quote/anticipate',
                        payload
                    );
                    this.items.splice(0);
                    Swal.fire({
                        icon: 'success',
                        title: 'Se ha creado la solicitud! ',
                        text: `Tu solicitud Nº ${response.data.application.id} 
                                    requiere de una evaluacion y aprobacion para su ejecucion, 
                                    te informaremos a tu email ${response.data.user.email}
                                    `,
                        footer:
                            '<a href=' +
                            this.route +
                            '> Ver tus solicitudes? </a>'
                    });
                } catch (error) {
                    Swal.fire(
                        'Ah ocurrido un error!',
                        'Lo sentimos, vuelva a intentar',
                        'error'
                    );
                }
            }
        },
        showModal() {
            this.showTable = true;
        },
        closeModal() {
            this.showTable = false;
        }
    },
    async created() {
        this.$root.$refs.B = this;
        this.getAPI();
    }
};
</script>

<style>
.lds-dual-ring {
    display: inline-block;
    width: 80px;
    height: 80px;
}
.bankable {
    color: #bfbcbb;
}
.very-bankable {
    color: green;
}

.lds-dual-ring:after {
    content: ' ';
    display: block;
    width: 64px;
    height: 64px;
    margin: 8px;
    border-radius: 50%;
    border: 6px solid #8ee5ff;
    border-color: #8ee5ff transparent #8ee5ff transparent;
    animation: lds-dual-ring 1.2s linear infinite;
}
@keyframes lds-dual-ring {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>

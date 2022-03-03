<template>
    <div v-if="isLoanding" class="relative w-auto text-center">
        <div v-if="!StatusSii" class="flex flex-col justify-around w-full">
            <h6 class="font-bold">
                Registra tus credenciales del SII y has tu proceso mas facil!
            </h6>
            <formProvider @updatePassword="getAPI"></formProvider>
        </div>
        <div v-else class="flex justify-center">
            <button
                @click="showModal()"
                type="button"
                class="mt-2 mx-2 text-white bg-blue-1300 inline-block text-center align-middle p-2 text-sm rounded hover:bg-blue-1200 focus:shadow-outline-blue focus:outline-none"
                data-toggle="modal"
                data-target=".bd-example-modal-md"
            >
                ABRIR MI CARTERA
            </button>
            <button
                v-if="items.length > 0"
                type="button"
                class="mt-2 mx-2 text-white bg-blue-1300 inline-block text-center align-middle p-2 text-sm rounded hover:bg-blue-1200 focus:shadow-outline-blue focus:outline-none"
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
            class="overflow-x-hidden fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
            id="modal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="myLargeModalLabel"
            aria-hidden="true"
        >
            <div
                class="transform-none transition-opacity h-full w-full sm:w-auto relative pointer-events-none sm:mt-16"
            >
                <div
                    class="relative flex flex-col pointer-events-auto bg-white bg-clip-padding rounded-sm border-solid outline-none p-2"
                >
                    <div class="flex flex-wrap justify-between items-center">
                        <h5 class="text-blue-1300 font-bold text-lg">
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
                        <div class="flex flex-wrap justify-start">
                            <span class="inline-block">
                              <svg
                                        class="inline-block"
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        aria-hidden="true"
                                        role="img"
                                        width="1.5em"
                                        height="1.2em"
                                        preserveAspectRatio="xMidYMid meet"
                                        viewBox="0 0 24 24"
                                    >
                                        <g fill="none">
                                            <circle
                                                cx="11"
                                                cy="12"
                                                r="11"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            />
                                        </g>
                                    </svg>
                               
                                Poca Informacion</span
                            >
                            <span>
                                    <svg
                                        class="inline-block"
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        aria-hidden="true"
                                        role="img"
                                        width="1.5em"
                                        height="1.2em"
                                        preserveAspectRatio="xMidYMid meet"
                                        viewBox="0 0 24 24"
                                    >
                                        <g fill="none">
                                            <circle
                                                cx="11"
                                                cy="11"
                                                r="11"
                                                fill="#bfbcbb"
                                            />
                                        </g>
                                    </svg>

                                Evaluable</span
                            >
                            <span>
                                <i>
                                    <svg
                                        class="inline-block"
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        aria-hidden="true"
                                        role="img"
                                        width="1.5em"
                                        height="1.2em"
                                        preserveAspectRatio="xMidYMid meet"
                                        viewBox="0 0 24 24"
                                    >
                                        <g fill="none">
                                            <circle
                                                cx="11"
                                                cy="11"
                                                r="11"
                                                fill="green"
                                            />
                                        </g>
                                    </svg> </i
                                >Confiable</span
                            >
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="flex flex-col w-full h-full">
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
                                                    class="w-6 h-6 inline-block"
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
                                            v-if="
                                                props.row
                                                    .settlement_status_id == 1
                                            "
                                            ><svg
                                                    class="inline-block"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                    aria-hidden="true"
                                                    role="img"
                                                    width="1.5em"
                                                    height="1.2em"
                                                    preserveAspectRatio="xMidYMid meet"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <g fill="none">
                                                        <circle
                                                            cx="11"
                                                            cy="12"
                                                            r="11"
                                                            stroke="currentColor"
                                                            stroke-width="2"
                                                        />
                                                    </g>
                                                </svg>
                                        </span>
                                        <span
                                            v-if="
                                                props.row
                                                    .settlement_status_id == 2
                                            "
                                            >
                                                <svg
                                                    class="inline-block"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                    aria-hidden="true"
                                                    role="img"
                                                    width="1.5em"
                                                    height="1.2em"
                                                    preserveAspectRatio="xMidYMid meet"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <g fill="none">
                                                        <circle
                                                            cx="11"
                                                            cy="11"
                                                            r="11"
                                                            fill="green"
                                                        />
                                                    </g>
                                                </svg>
                                            </span>
                                        <span
                                            v-if="
                                                props.row
                                                    .settlement_status_id == 3
                                            "
                                            >
                                                <svg
                                                    class="inline-block"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                    aria-hidden="true"
                                                    role="img"
                                                    width="1.5em"
                                                    height="1.2em"
                                                    preserveAspectRatio="xMidYMid meet"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <g fill="none">
                                                        <circle
                                                            cx="11"
                                                            cy="11"
                                                            r="11"
                                                            fill="#bfbcbb"
                                                        />
                                                    </g>
                                                </svg> 
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
    <div v-else class="relative w-full px-6 text-center">
        <h4 class="text-xl text-gray-800 mb-4">
            Estamos procesando tu informacion, un momento!
        </h4>
        <div class="lds-dual-ring inline-block w-32 h-32"></div>
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
                    field: 'name',
                    width: '310px'
                },
                {
                    label: 'Monto',
                    field: 'total',
                    type: 'number',
                    thClass: 'vgt-left-align',
                    tdClass: 'vgt-left-align',
                    formatFn: this.formatFn,
                    width: '120px'
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
                        text: `Tu solicitud Nº ${response.data.application} 
                                    requiere de una evaluacion y aprobacion para su ejecucion, 
                                    te informaremos a tu email ${response.data.user}
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
                window.setTimeout(function () { window.location.reload() }, 2000) ;
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
.lds-dual-ring:after {
    content: ' ';
    display: block;
    width: 64px;
    height: 64px;
    margin: 8px;
    border-radius: 100%;
    border: 4px solid #296180;
    border-color: #296180 transparent #296180 transparent;
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

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
                type="button"
                class="btn btn-primary mt-2"
                data-toggle="modal"
                data-target=".bd-example-modal-md"
            >
                ABRIR MI CARTERA
            </button>
            <button
                v-if="items.length > 0"
                type="button"
                class="btn btn-primary mt-2"
                @click="onAncipate"
            >
                SOLICITAR
            </button>
        </div>
        <quote_table :source="source" :items="items" />
        <div
            class="modal fade bd-example-modal-md"
            tabindex="-1"
            role="dialog"
            aria-labelledby="myLargeModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-xl">
                <div class="modal-content p-2">
                    <div
                        class="row justify-content-between  align-items-center mx-2 my-1 "
                    >
                        <div class="h5 text-primary font-weight-bold ">
                            Registro de Ventas del SII
                        </div>

                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="row justify-content-between mx-2 my-1">
                        <div>
                            Cant. Factura Cotizadas :
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
                    <div class="row">
                        <div class="col-12">
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
                                                class="fas text-info fa-plus-circle fa-lg"
                                            ></i
                                        ></a>
                                    </span>

                                    <span v-if="props.column.field == 'rut'">
                                        {{
                                            props.row.rut
                                                | VMask("##.###.###-NN")
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
import Option from "../../config/alert";
import QuoteTable from "../Factoring/QuoteTable";
import FormCredential from "../../views/Provider";
import { VueGoodTable } from "vue-good-table";

export default {
    data() {
        return {
            color: { "1": "red", "2": "blue", null: "red", "3": "green" },
            columns: [
                {
                    label: "Simular",
                    field: "select",
                    sortable: false,
                    tdClass: "text-center",
                    thClass: "text-center",
                    tooltip: "Seleccionar Registro",
                    width: "67px"
                },
                {
                    label: "Info",
                    sortable: false,
                    tdClass: "text-right",
                    field: "settlement",
                    width: "40px"
                },
                {
                    label: "Folio",
                    field: "folio",
                    type: "number",
                    thClass: "text-left",
                    tdClass: "text-center",
                    width: "70px"
                },
                {
                    label: "RUT",
                    field: "rut",
                    formatFn: this.formatRut,
                    thClass: "text-center",
                    tdClass: "text-left",
                    width: "115px"
                },
                {
                    label: "Pagador",
                    field: "name"
                },
                {
                    label: "Monto",
                    field: "total",
                    type: "number",
                    thClass: "text-left",
                    tdClass: "text-left",
                    formatFn: this.formatFn,
                    width: "110px"
                },
                {
                    label: "Fecha",
                    field: "fecha",
                    type: "date",
                    thClass: "text-left",
                    tdClass: "text-left",
                    width: "95px",
                    dateInputFormat: "yyyy-MM-dd",
                    dateOutputFormat: "dd-MM-yy"
                }
            ],
            invoices: [],
            items: [],
            invoicesOriginal: {},
            source: "api",
            route: "applications",
            credential: {},
            client: {},
            isLoanding: false,
            StatusSii: true
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
            return "$ " + Number(value).toLocaleString();
        },
        async getAPI() {
            try {
                this.isLoanding = false;
                let response = await axios.get("libredte");
                this.invoices = response.data;
                this.invoicesOriginal = response.data;
                this.isLoanding = true;
                this.StatusSii = true;
            } catch (error) {
                this.StatusSii = false;
                this.isLoanding = true;
                this.$swal.fire(Option("warning", error.response.data));
            }
        },
        async onRowSelected(item) {
            this.invoices = this.invoices.filter(
                items => items.folio !== item.folio
            );
            this.$swal.fire(
                Option("success", ` Factura Cotizada! Folio ${item.folio}`)
            );
            let data = {
                rut: item.rut,
                payer: item.name,
                number: item.folio,
                total_amount: item.total,
                issuing_date: item.fecha
            };
            let response = await axios.post("factoring/quote/calculation", data);
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
                        "warning",
                        "Todas la facturas requieren de actualizar la fecha de vencimiento! "
                    )
                );
            }
            const { value: result } = await Swal.fire({
                title: "Esta seguro de Realizar la solicitud?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, solicitar!",
                cancelButtonText: "Cancelar"
            });
            if (result) {
                try {
                    let payload = {
                        items: this.items
                    };
                    let response = await axios.post(
                        "/factoring/quote/anticipate",
                        payload
                    );
                    this.items.splice(0);
                    Swal.fire({
                        icon: "success",
                        title: "Se ha creado la solicitud! ",
                        text: `Tu solicitud Nº ${response.data.application.id} 
                                    requiere de una evaluacion y aprobacion para su ejecucion, 
                                    te informaremos a tu email ${response.data.user.email}
                                    `,
                        footer:
                            "<a href=" +
                            this.route +
                            "> Ver tus solicitudes? </a>"
                    });
                } catch (error) {
                    Swal.fire(
                        "Ah ocurrido un error!",
                        "Lo sentimos, vuelva a intentar",
                        "error"
                    );
                }
            }
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
    content: " ";
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

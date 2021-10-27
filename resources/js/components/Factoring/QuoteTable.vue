<template>
    <div>
        <div v-if="items.length > 0">
            <div class="text-right h5 font-weight-bold mt-4 ">
                <dl>
                    <p>Monto Total :&nbsp; {{ formatPrice(total_amount) }}</p>
                    <p>Excedentes : {{ formatPrice(surplus) }}</p>
                    <p>Desembolso : {{ formatPrice(total) }}</p>
                </dl>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr
                            class="text-center"
                            style="font-size: 15px; width:1px; white-space:nowrap;"
                        >
                            <th>
                                <b>Factura</b> <br />
                                Folio / Emisión
                            </th>
                            <th><strong>Pagador</strong><br />Nombre / RUT</th>
                            <th>
                                <strong>Tasa</strong> <br />
                                Fcto / Mora
                            </th>
                            <th>
                                <strong>Montos</strong> <br />
                                Factura/ Desembolso
                            </th>
                            <th>
                                <strong>Costos</strong> <br />
                                Comisión/ Dif. Precio
                            </th>
                            <th>
                                <strong>Operación</strong> <br />
                                Fcto/ Excedentes
                            </th>
                            <th>Vencimiento</th>
                            <th>
                                Cambiar <br />
                                Fecha
                            </th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            class="text-center"
                            v-for="(item, index) in items"
                            :key="item.id"
                        >
                            <td>
                                {{ item.number }} <br />
                                {{ getHumanDate(item.issuing_date) }}
                            </td>
                            <td class="">
                                <p
                                    style="font-size: 10.5px"
                                    class="text-center text-uppercase mb-0"
                                >
                                    {{ item.payer }}
                                </p>
                                <b style="font-size: 14px" class="text-center">
                                    {{ item.rut | VMask("##.###.###-NN") }}</b
                                >
                            </td>
                            <td>
                                <strong class="text-primary">
                                    {{
                                        Number(item.rate).toLocaleString() +
                                            " %"
                                    }}
                                </strong>
                                <br />
                                {{
                                    Number(item.mora_rate).toLocaleString() +
                                        " %"
                                }}
                            </td>
                            <td>
                                {{ formatPrice(item.total_amount) }} <br />
                                {{ formatPrice(item.disbursement) }}
                            </td>
                            <td>
                                {{ formatPrice(item.commission) }} <br />
                                {{ formatPrice(item.dif) }}
                            </td>
                            <td>
                                {{
                                    Number(item.discount).toLocaleString() +
                                        " %"
                                }}
                                <br />
                                {{ formatPrice(item.surplus) }}
                            </td>
                            <td
                                :class="{
                                    'text-danger': !item.change_expire,
                                    'text-success': item.change_expire
                                }"
                            >
                                {{ getHumanDate(item.expire_date) }}
                            </td>
                            <td class="text-md-right">
                                <div class="btn-group" role="group">
                                    <button
                                        data-toggle="modal"
                                        :data-target="`#${source}`"
                                        @click="onChangeDateExpire(index, item)"
                                        :class="{
                                            'btn btn-danger': !item.change_expire,
                                            'btn btn-success':
                                                item.change_expire
                                        }"
                                        v-bind="$attrs"
                                    >
                                        <i
                                            :class="{
                                                'fas fa-calendar-times fa-lg': !item.change_expire,
                                                'fas fa-calendar-check fa-lg':
                                                    item.change_expire
                                            }"
                                        ></i>
                                    </button>
                                </div>
                            </td>
                            <td class="text-md-right">
                                <div class="btn-group" role="group">
                                    <button
                                        class="btn btn-danger"
                                        v-bind="$attrs"
                                        @click="onDelete(index, item)"
                                    >
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div
            class="modal fade"
            :id="`${source}`"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div
                            class="modal-title h6  font-weight-bold text-uppercase mb-4"
                        >
                            Cambio de fecha de vencimiento de factura Folio #{{
                                itemEditing.number
                            }}
                        </div>
                        <div class="row">
                            <div
                                class="col col-sm-9 col-md-9"
                                v-if="expireDate"
                            >
                                <datepicker
                                    bootstrap-styling
                                    :language="es"
                                    :disabled-dates="disabledDates"
                                    monday-first
                                    calendar-button
                                    calendar-button-icon="far fa-calendar-alt"
                                    v-model="expireDate"
                                    @closed="onCalculate()"
                                >
                                </datepicker>
                            </div>
                            <div class="col col-sm-3 col-md-3 ">
                                <button
                                    data-toggle="modal"
                                    v-bind="$attrs"
                                    data-dismiss="modal"
                                    class="btn btn-primary"
                                >
                                    <i class="fas fa-calendar-plus fa-lg"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
//date picker
import Datepicker from "vuejs-datepicker";
import { es } from "vuejs-datepicker/dist/locale";

const moment = require("moment");

export default {
    data() {
        return {
            es: es,
            disabledDates: {
                to: new Date(moment().add(15, "d"))
            },
            expireDate: false,
            itemEditing: {},
            index: false,
            flag: true
        };
    },
    props: {
        items: {
            type: Array,
            default: () => []
        },
        source: {
            type: String
        }
    },
    components: {
        Datepicker
    },
    computed: {
        total() {
            if (!this.items) {
                return 0;
            }
            return this.items.reduce(function(total, items) {
                return total + Number(items.disbursement);
            }, 0);
        },
        total_amount() {
            if (!this.items) {
                return 0;
            }
            return this.items.reduce(function(total_amount, items) {
                return total_amount + Number(items.total_amount);
            }, 0);
        },
        surplus() {
            if (!this.items) {
                return 0;
            }
            return this.items.reduce(function(surplus, items) {
                return surplus + Number(items.surplus);
            }, 0);
        }
    },
    methods: {
        getHumanDate(date) {
            return moment(date, "YYYY-MM-DD").format("DD-MM-YY");
        },
        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(".", ",");
            return "$ " + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
        onDelete(index, item) {
            this.source == "xml"
                ? this.$root.$refs.A.onDelete(index, item)
                : this.$root.$refs.B.onDelete(index, item);
        },
        onChangeDateExpire(index, item) {
            this.expireDate = item.expire_date;
            this.itemEditing = item;
            this.index = index;
        },
        async onCalculate() {
            try {
                let date = moment(this.expireDate).format("yyyy-MM-DD");
                let payload = {
                    rut: this.itemEditing.rut,
                    payer: this.itemEditing.payer,
                    number: this.itemEditing.number,
                    total_amount: this.itemEditing.total_amount,
                    issuing_date: this.itemEditing.issuing_date,
                    payment_date: date
                };
                let response = await axios.post("quote/calculation", payload);
                let expire = { change_expire: true };
                this.items.splice(this.index, 1, {
                    ...response.data,
                    ...expire
                });
                this.itemEditing.splice(0);
                this.index = false;
            } catch (error) {
                alert(error.response.data.message);
            }
        }
    }
};
</script>

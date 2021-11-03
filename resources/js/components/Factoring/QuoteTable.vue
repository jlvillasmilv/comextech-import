<template>
    <div>
        <div v-if="items.length > 0">
            <div class="text-right text-lg font-bold mt-6 mb-2">
                <dl>
                    <p>Monto Total :&nbsp; {{ formatPrice(total_amount) }}</p>
                    <p>Excedentes : {{ formatPrice(surplus) }}</p>
                    <p>Desembolso : {{ formatPrice(total) }}</p>
                </dl>
            </div>
            <div class="w-full rounded-lg shadow-xs">
                <div class="w-full">
                    <table class="w-full">
                        <thead>
                            <tr
                                class="text-sm font-semibold text-gray-700 border-b dark:border-gray-700 bg-gray-200 dark:text-gray-400 dark:bg-gray-800"
                            >
                                <th class="text-center px-4 py-3">
                                    <b>Factura</b> <br />
                                    Folio / Emisión
                                </th>
                                <th class="text-center px-4 py-3">
                                    <strong>Pagador</strong><br />Nombre / RUT
                                </th>
                                <th class="text-center px-4 py-3">
                                    <strong>Tasa</strong> <br />
                                    Fcto / Mora
                                </th>
                                <th class="text-center px-4 py-3">
                                    <strong>Montos</strong> <br />
                                    Factura/ Desembolso
                                </th>
                                <th class="text-center px-4 py-3">
                                    <strong>Costos</strong> <br />
                                    Comisión/ Dif. Precio
                                </th>
                                <th class="text-center px-4 py-3">
                                    <strong>Operación</strong> <br />
                                    Fcto/ Excedentes
                                </th>
                                <th class="text-center px-4 py-3">
                                    Vencimiento
                                </th>
                                <th class="text-center px-4 py-3">
                                    Cambiar <br />
                                    Fecha
                                </th>
                                <th class="text-center px-4 py-3">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody
                            class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                        >
                            <tr
                                class="text-gray-700 dark:text-gray-400"
                                v-for="(item, index) in items"
                                :key="item.id"
                            >
                                <td class="px-4 py-3">
                                    {{ item.number }} <br />
                                    {{ getHumanDate(item.issuing_date) }}
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-xs uppercase mb-0">
                                        {{ item.payer }}
                                    </p>
                                    <b class="text-center text-sm">
                                        {{
                                            item.rut | VMask('##.###.###-NN')
                                        }}</b
                                    >
                                </td>
                                <td class="px-4 py-3">
                                    <strong class="text-blue-700">
                                        {{
                                            Number(item.rate).toLocaleString() +
                                                ' %'
                                        }}
                                    </strong>
                                    <br />
                                    {{
                                        Number(
                                            item.mora_rate
                                        ).toLocaleString() + ' %'
                                    }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ formatPrice(item.total_amount) }} <br />
                                    {{ formatPrice(item.disbursement) }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ formatPrice(item.commission) }} <br />
                                    {{ formatPrice(item.dif) }}
                                </td>
                                <td class="px-4 py-3">
                                    {{
                                        Number(item.discount).toLocaleString() +
                                            ' %'
                                    }}
                                    <br />
                                    {{ formatPrice(item.surplus) }}
                                </td>
                                <td
                                    :class="{
                                        'text-red-600': !item.change_expire,
                                        'text-green-500': item.change_expire
                                    }"
                                >
                                    {{ getHumanDate(item.expire_date) }}
                                </td>
                                <td>
                                    <div role="group">
                                        <button
                                            data-toggle="modal"
                                            :data-target="`#${source}`"
                                            @click="
                                                onChangeDateExpire(index, item)
                                            "
                                            :class="{
                                                'btn btn-danger': !item.change_expire,
                                                'btn btn-success':
                                                    item.change_expire
                                            }"
                                            v-bind="$attrs"
                                        >
                                            <i>
                                                <svg
                                                    v-if="!item.change_expire"
                                                    class="w-8 h-8 inline-block"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                    aria-hidden="true"
                                                    role="img"
                                                    width="1em"
                                                    height="1em"
                                                    preserveAspectRatio="xMidYMid meet"
                                                    viewBox="0 0 16 16"
                                                >
                                                    <g fill="#e02424">
                                                        <path
                                                            d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zM6.854 8.146L8 9.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 10l1.147 1.146a.5.5 0 0 1-.708.708L8 10.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 10L6.146 8.854a.5.5 0 1 1 .708-.708z"
                                                        />
                                                    </g>
                                                </svg>
                                                <svg
                                                    v-else-if="
                                                        item.change_expire
                                                    "
                                                    class="w-8 h-8 inline-block"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                    aria-hidden="true"
                                                    role="img"
                                                    width="1em"
                                                    height="1em"
                                                    preserveAspectRatio="xMidYMid meet"
                                                    viewBox="0 0 16 16"
                                                >
                                                    <g fill="#1cc88a">
                                                        <path
                                                            d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zm-5.146-5.146l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708z"
                                                        />
                                                    </g>
                                                </svg>
                                            </i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <div role="group">
                                        <button
                                            v-bind="$attrs"
                                            @click="onDelete(index, item)"
                                        >
                                            <i>
                                                <svg
                                                    class="mr-4 mt-2 w-8 h-8"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                    aria-hidden="true"
                                                    role="img"
                                                    width="1em"
                                                    height="1em"
                                                    preserveAspectRatio="xMidYMid meet"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        d="M6 7H5v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7H6zm4 12H8v-9h2v9zm6 0h-2v-9h2v9zm.618-15L15 2H9L7.382 4H3v2h18V4z"
                                                        fill="#e02424"
                                                    />
                                                </svg>
                                            </i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
import Datepicker from 'vuejs-datepicker';
import { es } from 'vuejs-datepicker/dist/locale';

const moment = require('moment');

export default {
    data() {
        return {
            es: es,
            disabledDates: {
                to: new Date(moment().add(15, 'd'))
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
            return moment(date, 'YYYY-MM-DD').format('DD-MM-YY');
        },
        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace('.', ',');
            return '$ ' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        },
        onDelete(index, item) {
            this.source == 'xml'
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
                let date = moment(this.expireDate).format('yyyy-MM-DD');
                let payload = {
                    rut: this.itemEditing.rut,
                    payer: this.itemEditing.payer,
                    number: this.itemEditing.number,
                    total_amount: this.itemEditing.total_amount,
                    issuing_date: this.itemEditing.issuing_date,
                    payment_date: date
                };
                let response = await axios.post('quote/calculation', payload);
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

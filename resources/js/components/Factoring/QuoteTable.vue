<template>
    <div class="grid gap-6 mb-8">
        <div class="min-w-0 p-4 dark:bg-gray-800" v-if="items.length > 0">
            <dl class="text-right text-base font-bold mt-6 mb-2">
                <p>Monto Total :&nbsp; {{ formatPrice(total_amount) }}</p>
                <p>Excedentes : {{ formatPrice(surplus) }}</p>
                <p>Desembolso : {{ formatPrice(total) }}</p>
            </dl>
            <div class="w-full overflow-x-auto">
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
                                    {{ item.rut | VMask('##.###.###-NN') }}</b
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
                                    Number(item.mora_rate).toLocaleString() +
                                        ' %'
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
                                            modalDate();
                                            onChangeDateExpire(index, item);
                                        "
                                        :class="{
                                            'rounded px-2 py-2 bg-red-600 hover:bg-red-700': !item.change_expire,
                                            'rounded px-2 py-2 bg-green-500 hover:bg-green-600':
                                                item.change_expire
                                        }"
                                        v-bind="$attrs"
                                    >
                                        <i>
                                            <svg
                                                v-if="!item.change_expire"
                                                class="w-7 h-7 inline-block"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                aria-hidden="true"
                                                role="img"
                                                width="1em"
                                                height="1em"
                                                preserveAspectRatio="xMidYMid meet"
                                                viewBox="0 0 16 16"
                                            >
                                                <g fill="#ffffff">
                                                    <path
                                                        d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zM6.854 8.146L8 9.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 10l1.147 1.146a.5.5 0 0 1-.708.708L8 10.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 10L6.146 8.854a.5.5 0 1 1 .708-.708z"
                                                    />
                                                </g>
                                            </svg>
                                            <svg
                                                v-else-if="item.change_expire"
                                                class="w-7 h-7 inline-block"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                aria-hidden="true"
                                                role="img"
                                                width="1em"
                                                height="1em"
                                                preserveAspectRatio="xMidYMid meet"
                                                viewBox="0 0 16 16"
                                            >
                                                <g fill="#ffffff">
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
                                <div role="group" class="mr-2">
                                    <button
                                        class="rounded mb-0.5 px-2 py-2 bg-red-600 hover:bg-red-700"
                                        v-bind="$attrs"
                                        @click="onDelete(index, item)"
                                    >
                                        <i>
                                            <svg
                                                class="w-7 h-7"
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
                                                    fill="#ffffff"
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
            <div
                v-if="showDate == true"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="flex flex-col justify-around overflow-x-hidden fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
                tabindex="-1"
                role="dialog"
                aria-labelledby="myLargeModalLabel"
                aria-hidden="true"
                :id="`${source}`"
            >
                <div
                    class="flex transform-none transition-opacity h-36 sm:h-28 w-full sm:w-auto relative pointer-events-none sm:mt-16"
                    role="document"
                >
                    <div
                        class="relative flex flex-col pointer-events-auto bg-white bg-clip-padding rounded-sm border-solid outline-none p-2"
                    >
                        <div class="">
                            <div class="font-bold uppercase mb-6">
                                Cambio de fecha de vencimiento de factura Folio
                                #{{ itemEditing.number }}
                            </div>
                            <div class="flex flex-wrap justify-around px-2">
                                <div
                                    class="flex flex-grow-0 flex-shrink-0 px-8"
                                    v-if="expireDate"
                                >
                                    <label class="block text-sm">
                                        <input
                                            type="date"
                                            v-model="expireDate"
                                            :min="minDate"
                                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                            v-on:change="onCalculate()"
                                        />
                                    </label>

                                    <!-- <datepicker
                                        bootstrap-styling
                                        :language="es"
                                        :disabled-dates="disabledDates"
                                        monday-first
                                        calendar-button
                                        calendar-button-icon="far fa-calendar-alt"
                                        v-model="expireDate"
                                        @closed="onCalculate()"
                                    >
                                    </datepicker> -->
                                </div>
                                <div>
                                    <button
                                        @click="closeModal()"
                                        data-toggle="modal"
                                        v-bind="$attrs"
                                        data-dismiss="modal"
                                        class="rounded px-2 py-2 bg-blue-800 hover:bg-blue-900"
                                    >
                                        <i>
                                            <svg
                                                class="h-7 w-7"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                aria-hidden="true"
                                                role="img"
                                                width="1em"
                                                height="1em"
                                                preserveAspectRatio="xMidYMid meet"
                                                viewBox="0 0 16 16"
                                            >
                                                <g fill="#ffffff">
                                                    <path
                                                        d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zM8.5 8.5V10H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V11H6a.5.5 0 0 1 0-1h1.5V8.5a.5.5 0 0 1 1 0z"
                                                    />
                                                </g>
                                            </svg>
                                        </i>
                                    </button>
                                </div>
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
            flag: true,
            showDate: false,
            minDate: new Date().toISOString().substr(0, 10)
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
            // this.showDate = true;
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
        },
        modalDate() {
            this.showDate = true;
        },
        closeModal() {
            this.showDate = false;
        }
    }
};
</script>

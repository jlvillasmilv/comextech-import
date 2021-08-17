<template>
    <div class="container grid grid-cols-1 px-6 my-1 ">
        <div class="flex justify-end pb-2">
            <button
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2"
                @click="convert('CLP')"
            >
                CLP
            </button>
            <button
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                @click="convert('USD')"
            >
                USD
            </button>
        </div>

    
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full table-fixed">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-white  uppercase border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800"
                        >
                            <th class="w-1/2 px-4 py-3">CONCEPTO</th>
                            <th class="w-1/4">FECHA</th>
                            <th class="w-1/4">MONEDA ORIGEN (M.O.)</th>
                            <th class="w-1/4">MONTO M.O.</th>
                            <th class="w-1/4">MONTO CLP</th>
                        </tr>
                    </thead>
                    <tbody
                        class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                    >
                        <tr v-show="$store.getters.findService('ICS01')">
                            <td class="text-left px-4 py-3 ">
                                <div class="text-sm">
                                    <div>
                                        <p class="font-semibold input">
                                            Pago al Proveedor
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-left px-4 py-3"></td>
                            <td class="text-left px-4 py-3"></td>
                            <td class="text-left px-4 py-3">
                                {{ $store.state.currency.code }}
                            </td>
                        </tr>
                        <tr
                            v-for="(item, key) in $store.state.payment"
                            :key="key"
                            class="text-gray-700 dark:text-gray-400"
                        >
                            <td class="text-left px-4 py-3">
                                <div class="text-xs">
                                    <div>
                                        <p class="font-semibold input">
                                            Pago al Proveedor Nro
                                            {{ key + 1 }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-left px-4 py-3">
                                {{ item.datePay }}
                            </td>
                            <td class="text-left px-4 py-3">
                                {{
                                    item.percentage *
                                        $store.state.application.amount
                                }}
                            </td>
                            <td class="text-left px-4 py-3">
                                 {{ $store.state.currency.code }}
                            </td>
                        </tr>
                        <tr v-show="$store.state.expenses.iva">
                            <td class="text-left px-4 py-3">
                                <div class="text-sm">
                                    <div>
                                        <p class="font-semibold input">
                                            IVA Internacion
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-left px-4 py-3">
                                <div class="text-sm">
                                    <div>
                                        <p class="font-semibold input">
                                             
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-left px-4 py-3">
                                <div class="text-sm">
                                    <div>
                                        <p class="font-semibold input">
                                           {{ $store.getters.CIF * 19 }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr v-show="$store.state.expenses.adv">
                            <td class="text-left px-4 py-3">
                                <div class="text-sm">
                                    <div>
                                        <p class="font-semibold input">
                                            Aranceles
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-left px-4 py-3">
                                <div class="text-sm">
                                    <div>
                                        <p class="font-semibold input">
                                            
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-left px-4 py-3">
                                <div class="text-sm">
                                    <div>
                                        <p class="font-semibold input">
                                            {{ $store.getters.CIF * 6 }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-left px-4 py-3">
                                <div class="text-sm">
                                    <div>
                                        <p class="font-semibold input">
                                            
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4"></td>
                            <td>{{ totalAmount }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        application_id: {
            type: Number,
            required: false
        }
    },
    data() {
        return {
            form: new Form({
                application_id: this.application_id
            }),
            data: [
                {
                    name: "A. pago proveedor",
                    date: "",
                    mo: "YUAN",
                    amo: 455000,
                    clp: 6000000
                },
                {
                    name: "A.1 ADELANTO",
                    date: "2021-08-21",
                    mo: "YUAN",
                    amo: 455000,
                    clp: 6000000
                },
                {
                    name: "A.1 ADELANTO",
                    date: "2021-08-21",
                    mo: "YUAN",
                    amo: 330000,
                    clp: 4000000
                },
                {
                    name: "B.- Transporte Internacional",
                    date: "2021-10-10",
                    mo: "USD",
                    amo: 4000,
                    clp: 3000000
                }
            ]
        };
    },
    methods: {
        convert(currency) {
            console.log(currency);
        }
    },
    computed: {
        totalAmount: function() {
            var sum = 0;
            this.data.forEach(e => {
                sum += e.clp;
            });
            return sum;
        }
    }
};
</script>

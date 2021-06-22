<template>
    <div class="w-1/2">
        <div class="mb-8 overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-white  uppercase border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800"
                        >
                            <th class="px-4 py-3">Pago</th>
                            <th class="">Porcentaje</th>
                            <th class="px-4 py-3">Moneda</th>
                            <th class="px-4 py-3">Monto</th>
                            <th class="px-4 py-3">Forma</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody
                        v-if="data.length"
                        class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                    >
                        <tr
                            v-for="(item, key) in dataPays"
                            :key="key"
                            class="text-gray-700 dark:text-gray-400"
                        >
                            <td class="px-4 py-3">
                                <div class="flex items-center text-sm">
                                    <div>
                                        <p class="font-semibold input">
                                            Pago Nro {{ key + 1 }}
                                        </p>
                                        <p
                                            class="text-xs text-gray-600 dark:text-gray-400"
                                        >
                                            {{ item.datePay }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-2 py-2 text-sm">
                                {{ item.percentage }} %
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ currencies.code }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{
                                    Math.round(amount * (item.percentage / 100))
                                }}
                            </td>
                            <td class="px-4 py-3 text-xs">
                                <span
                                    class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:text-white dark:bg-green-600"
                                >
                                    {{ item.typePay }}
                                </span>
                            </td>
                            <td>
                                <svg
                                    @click="deleteRow(item)"
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
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                    />
                                </svg>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        data: {
            default: () => {
                return [];
            },
            type: Array,
            required: true
        },
        amount: {
            required: true
        },
        currencies: {
            required: true
        }
    },
    methods: {
        deleteRow(item) {
            this.$emit("deleteRow", item);
        }
    },
    computed: {
        dataPays() {
            return this.data;
        }
    },
    created() {
        console.log(this.amount);
    }
};
</script>

<style></style>

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
                        </tr>
                    </thead>
                    <tbody
                        v-if="data.length"
                        class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                    >
                        <tr
                            v-for="(item, key) in data"
                            :key="key"
                            class="text-gray-700 dark:text-gray-400"
                        >
                            {{
                                item.percentage
                            }}
                            <!-- <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            <div>
                                                <p class="font-semibold"> Adelantado </p>
                                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                                    6/10/2020
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 text-sm">
                                        10 %
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        USD
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        $ 369.95
                                    </td>
                                    <td class="px-4 py-3 text-xs">
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:text-white dark:bg-green-600">
                                            Contado
                                        </span>
                                    </td>    -->
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
        }
    },
    computed: {
        dataPays() {
            return this.data;
        }
    }
};
</script>

<style></style>

<template>
	<div class="container grid px-6 my-1 ">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr
                                class="text-xs  text-center font-semibold tracking-wide text-left text-white  uppercase border-b dark:border-blue-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800"
                            >
                                <th class="py-3">CONCEPTO</th>
                                <th class=" py-3">FECHA</th>
                                <th class=" py-3">MONEDA ORIGEN (M.O.)</th>
                                <th class=" py-3">MONTO M.O.</th>
                                <th class=" py-3">MONTO CLP</th>
                            </tr>
                        </thead>
                        <tbody
                            class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            <tr
                                v-for="(item, key) in data"
                                :key="key"
                                class="text-gray-700 dark:text-gray-400"
                            >
                                <td>
                                    <div class="flex items-center text-sm">
                                        <div>
                                            <p class="font-semibold input">
                                                {{ item.name }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td> {{ item.date }} </td>
                                <td> {{ item.mo }} </td>
                                <td> {{ item.amo }} </td>
                                <td> {{ item.clp }} </td>
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
	                    mo: 'YUAN',
	                    amo: 455000,
	                    clp: 6000000,
	                },
	                {
	                    name: "A.1 ADELANTO",
	                    date: "2021-08-21",
	                    mo: 'YUAN',
	                    amo: 455000,
	                    clp: 6000000,
	                },
	                {
	                    name: "A.1 ADELANTO",
	                    date: "2021-08-21",
	                    mo: 'YUAN',
	                    amo: 330000,
	                    clp: 4000000,
	                },
	                {
	                    name: "B.- Transporte Internacional",
	                    date: "2021-10-10",
	                    mo: 'USD',
	                    amo: 4000,
	                    clp: 3000000,
	                },

            ],
        };
    },
    computed: {
	    totalAmount: function () {
                    var sum = 0;
                    this.data.forEach(e => {
                        sum += e.clp;
                    });
                    return sum
            }
	}
    
};
</script>

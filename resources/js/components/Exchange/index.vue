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
                <div class="flex space-x-4 ...">
                      <div class="w-4/5">

                         <table class="w-full table-fixed">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-white  uppercase border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800"
                        >
                            <th class="w-1/2 px-4 py-3"> CONCEPTO </th>
                            <th class="w-1/4"> FECHA </th>
                            <th class="w-1/4"> MONEDA ORIGEN (M.O.) </th>
                            <th class="w-1/4"> MONTO M.O. </th>
                        </tr>
                    </thead>
                    <tbody
                        class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                    >
                      
                        <tr
                            v-for="(item, key) in data"
                            :key="key"
                            class="text-gray-700 dark:text-gray-400"
                        >
                            <td class="text-left px-4 py-3">
                                <div class="text-xs">
                                    <div>
                                        <p class="font-semibold input">
                                            {{ item.name }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-left px-4 py-3">
                                {{ getHumanDate(item.date) }}
                            </td>
                            <td class="text-left px-4 py-3">
                                {{ item.currency }}
                            </td>
                            <td class="text-left px-4 py-3">
                                 {{ Number(item.amo).toLocaleString() }}
                            </td>
                        </tr>
                
                    </tbody>
                   
                </table>

            </div>
  <div class="w-1/5">
      
         <table class="w-full table-fixed">
                    <tr
                            class="text-xs font-semibold tracking-wide text-left text-white  uppercase border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800"
                        >
                        <th class="w-1/2 px-4 py-3 text-center">Monto {{ currency_ex }}</th>
                    </tr>
                   <tbody
                        class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                    >
                        <tr  v-for="(item, key) in data"
                            :key="key"
                            class="text-gray-700 dark:text-gray-400">
                             <td class="px-4 py-3 text-center">
                                 {{  Number(item.amo2).toLocaleString() }}
                            </td>
                        </tr>
                    </tbody>
                     <tfoot>
                        <tr>
                            <td class="text-center px-4 py-3"> <strong>{{  Number(totalAmount).toLocaleString() }}</strong></td>
                        </tr>
                    </tfoot>
         </table>

  </div>
 
</div>
               

               
            </div>
        </div>
    </div>
</template>
<script>

const moment = require('moment');

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
            currency_ex: 'CLP',
            data: [
                {
                    id: 1,
                    name: "A. pago proveedor",
                    date: "2021-08-21",
                    currency: "CNY",
                    amo: 455000,
                    amo2: 6000000
                },
                {
                    id: 2,
                    name: "A.1 ADELANTO",
                    date: "2021-08-21",
                    currency: "CNY",
                    amo: 455000,
                    amo2: 6000000
                },
                {
                    id: 3,
                    name: "A.1 ADELANTO",
                    date: "2021-08-21",
                    currency: "CNY",
                    amo: 330000,
                    amo2: 4000000
                },
                {
                    id: 4,
                    name: "B.- Transporte Internacional",
                    date: "2021-10-10",
                    currency: "USD",
                    amo: 4000,
                    amo2: 3000000
                },
                {
                    id: 5,
                    name: "C.- Seguro Transporte",
                    date: "2021-10-10",
                    currency: "USD",
                    amo: 300,
                    amo2: 210000
                },
                {
                    id: 6,
                    name: "D.- Servicio AGA",
                    date: "2021-10-30",
                    currency: "CLP",
                    amo: 250,
                    amo2: 3000000
                },
                {
                    id: 7,
                    name: "E.- IVA Internacion",
                    date: "2021-10-30",
                    currency: "CLP",
                    amo: 2000000,
                    amo2: 2000000
                },
                {
                    id: 8,
                    name: "F.- Aranceles",
                    date: "2021-10-30",
                    currency: "CLP",
                    amo: 1000000,
                    amo2: 1000000
                },
                {
                    id: 9,
                    name: "F.- Transporte Local",
                    date: "2021-11-10",
                    currency: "CLP",
                    amo: 300000,
                    amo2: 300000
                },
            ]
        };
    },
    methods: {
        getHumanDate(date) {
            return moment(date, 'YYYY-MM-DD').format('DD-MM-YY');
        },
         convert(currency) {
            
            this.currency_ex = currency;

            this.data.forEach(async e => {

                let currencies_api = e.currency+'_'+currency; 
                var new_amo2 = e.amo;

                try {
                  const resp = await axios.get('/api/convert-currency/'+e.amo+'/'+e.currency+'/'+currency);

                    //Find index of specific object using findIndex method.    
                   let objIndex = this.data.findIndex((obj => obj.id == e.id));
                    
                   //Update object's name property.
                   this.data[objIndex].amo2 = resp.data;

                    console.log(resp.data);
                } catch (err) {
                    // Handle Error Here
                    console.error(err);
                }


            });
            // 
        }
    },
    computed: {
        totalAmount: function() {
            var sum = 0;
            this.data.forEach(e => {
                sum += e.amo2;
            });
            return  Number(sum);
        }
    }
};
</script>

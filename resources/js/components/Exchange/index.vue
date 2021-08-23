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
                            v-for="(item, key) in exchangeItem"
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
                        <tr  v-for="(item, key) in exchangeItem"
                            :key="key"
                            class="text-gray-700 dark:text-gray-400">
                             <td class="px-4 py-3 text-center">
                                 {{  Number(item.amo2).toLocaleString() }}
                            </td>
                        </tr>
                    </tbody>
                     <tfoot>
                        <tr>
                            <td class="text-center px-4 py-3"> <strong>{{  Number(totalAmount).toLocaleString() }}</strong>  </td>
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
import { mapState } from "vuex";
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
            
        };
    },
    methods: {
        getHumanDate(date) {
            return this.$luxon(date, 'dd-MM-yyyy');
        },
         convert(currency) {
            
            this.currency_ex = currency;

            this.exchangeItem.forEach(async e => {

                let currencies_api = e.currency+'_'+currency; 
                var new_amo2 = e.amo;

                try {
                  const resp = await axios.get('/api/convert-currency/'+e.amo+'/'+e.currency+'/'+currency);

                    //Find index of specific object using findIndex method.    
                   let objIndex = this.exchangeItem.findIndex((obj => obj.id == e.id));
                    
                   //Update object's name property.
                   this.exchangeItem[objIndex].amo2 = resp.data;

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
        ...mapState('exchange',['exchangeItem']),
        totalAmount: function() {
            var sum = 0;
            this.exchangeItem.forEach(e => {
                sum += e.amo2;
            });
            return  Number(sum);
        }
    }
};
</script>

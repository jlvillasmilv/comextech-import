<template>
    <div class="container grid grid-cols-1 px-6 my-1">
        <div class="flex justify-end pb-2">
            <button
                class="
          bg-gray-600
          hover:bg-gray-700
          text-white
          font-bold
          py-2
          px-4
          rounded
          mr-2
        "
                @click="clone()"
            >
                M O
            </button>
            <button
                class="
          bg-blue-600
          hover:bg-blue-700
          text-white
          font-bold
          py-2
          px-4
          rounded
          mr-2
        "
                @click="convert('CLP')"
            >
                CLP
            </button>
            <button
                class="
          bg-green-600
          hover:bg-green-700
          text-white
          font-bold
          py-2
          px-4
          rounded
        "
                @click="convert('USD')"
            >
                USD
            </button>
        </div>

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <div class="flex space-x-4 ...">
                    <div class="w-full">
                        <table class="w-full table-fixed">
                            <thead>
                                <tr class=" " >
                                    <th class="w-2/5 px-4 py-3  text-xs
                                    font-semibold
                                    tracking-wide
                                    text-left text-white
                                    uppercase
                                    border-b
                                    dark:border-gray-700
                                    bg-blue-900
                                    dark:text-gray-400
                                    dark:bg-gray-800">
                                    CONCEPTO
                                    </th>
                                    <th class="w-1/4 px-4 py-3
                                        text-xs
                                        font-semibold
                                        tracking-wide
                                        text-center text-white
                                        uppercase
                                        border-b
                                        dark:border-gray-700
                                        bg-blue-900
                                        dark:text-gray-400
                                        dark:bg-gray-800">
                                        FECHA
                                    </th>
                                    <th class="w-1/4 px-4 py-3 text-xs
                                        font-semibold
                                        tracking-wide
                                        text-center
                                        text-white
                                        uppercase
                                        border-b
                                        dark:border-gray-700
                                        bg-blue-900
                                        dark:text-gray-400
                                        dark:bg-gray-800">
                                        MONEDA<br />
                                        ORIGEN
                                    </th>
                                    <th class="w-1/4 px-4 py-3  text-xs
                                        font-semibold
                                        tracking-wide
                                        text-center text-white
                                        uppercase
                                        border-b
                                        dark:border-gray-700
                                        bg-blue-900
                                        dark:text-gray-400
                                        dark:bg-gray-800">
                                        MONTO<br />
                                        M.O.
                                    </th>
                                    <th class="px-4 py-3 w-1">&nbsp; </th>
                                    <th class="w-1/4 px-4 py-3
                                    tracking-wide
                                    text-xs
                                    text-center
                                    text-white
                                    uppercase
                                    border-b
                                    dark:border-gray-700
                                    bg-blue-900
                                    dark:text-gray-400
                                    dark:bg-gray-800">
                                        Monto <br />
                                        {{ currency_ex }}
                                    </th>
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
                                        <div>
                                            <p
                                                class="font-semibold input"
                                                :class="
                                                    key == 1 || key == 2
                                                        ? 'ml-5'
                                                        : ''
                                                "
                                            >
                                                {{ item.description }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="text-center px-4 py-3">
                                        <div
                                            :class="key == 0 ? 'invisible' : ''"
                                        >
                                            {{ getHumanDate(item.fee_date) }}
                                        </div>
                                    </td>
                                    <td class="text-center px-4 py-3">
                                        {{ item.code }}
                                    </td>
                                    <td class="text-center px-4 py-3">
                                        {{
                                            formatPrice(item.amount, item.code)
                                        }}
                                    </td>
                                    <td class="text-center px-4 py-3">
                                        &nbsp;
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        {{ formatter(item.amo2, currency_ex) }}
                                    </td>
                                </tr>
                            </tbody>
                             <tfoot>
                                <tr>
                                    <td colspan="6" class="text-right px-4 py-3">
                                        <strong>
                                            {{
                                                formatter(
                                                    totalAmount,
                                                    currency_ex
                                                )
                                            }}</strong
                                        >
                                    </td>
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
            currency_ex: "CLP"
        };
    },
    methods: {
        formatPrice(value, currency) {
            return Number(value).toLocaleString(navigator.language, {
                minimumFractionDigits: currency == "CLP" ? 0 : 2,
                maximumFractionDigits: currency == "CLP" ? 0 : 2
            });
        },
        formatter(value, currency) {
            return Number(value).toLocaleString(navigator.language, {
                style: "currency",
                currency,
                currencyDisplay: "code",
                minimumFractionDigits: currency == "CLP" ? 0 : 2,
                maximumFractionDigits: currency == "CLP" ? 0 : 2
            });
        },
        getHumanDate(date) {
            /* Regular expression to change the date format */
            let dateConvert = date.match(/\d+/g);
            let year = dateConvert[0].substring(2); // number of digits for the year (0 full year)
            let month = dateConvert[1];
            let day = dateConvert[2];
            return `${day}-${month}-${year}`;

            // return this.$luxon(date, "dd-MM-yyyy"); // before it was like this
        },
        clone() {
            this.exchangeItem.forEach(e => {
                //Find index of specific object using findIndex method.
                let objIndex = this.exchangeItem.findIndex(
                    obj => obj.id == e.id
                );
                //Update object's name property.
                this.exchangeItem[objIndex].amo2 = e.amount;
                console.log(this.formatter(e.amount, e.code));
                this.currency_ex = e.code;
            });
            //
        },
        convert(currency) {
            this.currency_ex = currency;

            this.exchangeItem.forEach(async e => {
                if(e.amount != 0 && e.code != currency) {
                    try {
                        
                        const resp = await axios.get(
                            `/api/convert-currency/${e.amount}/${e.code}/${currency}`
                        );

                        //Find index of specific object using findIndex method.
                        let objIndex = this.exchangeItem.findIndex(
                            obj => obj.id == e.id
                        );

                        //Update object's name property.
                        this.exchangeItem[objIndex].amo2 = resp.data;
                    } catch (err) {
                        // Handle Error Here
                        console.error(err);
                    }
                }
            });
            //
        }
    },
    computed: {
        ...mapState("exchange", ["exchangeItem"]),
        totalAmount() {
            if (!this.exchangeItem) {
                return 0;
            }
            return this.exchangeItem.reduce(function(total_amount, items) {
                return total_amount + Number(items.amo2);
            }, 0);
        }
    },
    mounted: function () {
      this.convert('CLP');
    }
};
</script>

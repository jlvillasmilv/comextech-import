<template>
  <div class="flex justify-center container px-6 my-1">
    <loader />
    <div class="md:w-9/12 overflow-hidden rounded-lg ring-1 ring-black ring-opacity-5">
      <div class="w-full md:w-3/4 overflow-x-auto">
        <div class="flex space-x-4">
          <table class="table-auto w-full">
            <thead>
              <tr>
                <td colspan="7">
                  <div class="flex justify-end pb-2">
                    <button
                      class="
                        bg-gray-600
                        hover:bg-gray-700
                        text-white
                        font-bold
                        py-2
                        px-3
                        rounded
                        mr-2
                      "
                      @click="clone()"
                    >
                      M O
                    </button>
                    <button
                      class="
                        bg-blue-1000
                        hover:bg-blue-1100 active:bg-blue-1000
                        text-white
                        font-bold
                        py-2
                        px-3
                        rounded
                        mr-1
                      "
                      :disabled="busy"
                      @click="convert('CLP')"
                    >
                      CLP
                    </button>
                    <button
                      class="bg-blue-1300 hover:bg-blue-1200 active:bg-blue-1300 text-white font-bold py-2 px-3 rounded"
                      @click="convert('USD')"
                      :disabled="busy"
                    >
                      USD
                    </button>
                  </div>
                </td>
              </tr>
              <tr class="">
                <th
                  class="
                    w-2/6
                    px-4
                    py-3
                    text-xs
                    font-semibold
                    tracking-wide
                    text-center 
                    text-white
                    uppercase
                    border-b
                    dark:border-gray-700
                    bg-blue-1300
                    dark:text-gray-400 dark:bg-gray-800
                  "
                >
                  CONCEPTO
                </th>
                <th
                  class="
                    w-1/6
                    px-4
                    py-3
                    text-xs
                    font-semibold
                    tracking-wide
                    text-center text-white
                    uppercase
                    border-b
                    dark:border-gray-700
                    bg-blue-1300
                    dark:text-gray-400 dark:bg-gray-800
                  "
                >
                  FECHA
                </th>
                <th
                  class="
                    w-1/6
                    px-4
                    py-3
                    text-xs
                    font-semibold
                    tracking-wide
                    text-center text-white
                    uppercase
                    border-b
                    dark:border-gray-700
                    bg-blue-1300
                    dark:text-gray-400 dark:bg-gray-800
                  "
                >
                  MONEDA<br />
                  ORIGEN
                </th>
                <th
                  class="
                    w-1/6
                    px-4
                    py-3
                    text-xs
                    font-semibold
                    tracking-wide
                    text-center text-white
                    uppercase
                    border-b
                    dark:border-gray-700
                    bg-blue-1300
                    dark:text-gray-400 dark:bg-gray-800
                  "
                >
                  MONTO<br />
                  M.O.
                </th>
                <th class="">&nbsp;</th>
                <th
                  class="
                    w-2/6
                    px-13
                    py-3
                    tracking-wide
                    text-xs text-center text-white
                    uppercase
                    border-b
                  dark:border-gray-700
                  bg-blue-1300
                  dark:text-gray-400 dark:bg-gray-800
                  "
                  colspan="2"
                >
                  Monto <br />
                  {{ currency_ex }}
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
              <tr
                v-for="(item, key) in exchangeItem"
                :key="key"
                class="text-gray-700 dark:text-gray-400"
              >
                <td class="text-left px-4 py-3 text-sm">
                  <div>
                    <p
                      :class="[
                        'font-semibold',
                        key == 1 ||
                        key == 2 ||
                        key == 3 ||
                        item.code == 'CS03-02' ||
                        item.code == 'CS03-03' ||
                        item.code == 'CS03-04' ||
                        item.code == 'CS03-05' ||
                        item.code == 'CS04-02' ||
                        item.code == 'CS04-03' ||
                        item.code == 'CS04-04' ||
                        item.code == 'CS04-05'
                          ? 'ml-5'
                          : ''
                      ]"
                    >
                      {{ item.description }}
                    </p>
                  </div>
                </td>
                <td
                  :class="
                    item.code == 'CS01-01' || item.code == 'CS03-01' || item.code == 'CS04-01'
                      ? 'invisible'
                      : ''
                  "
                  class="text-center text-sm"
                >
                  {{ getHumanDate(item.fee_date) }}
                </td>
                <td
                  :class="
                    item.code == 'CS01-01' || item.code == 'CS03-01' || item.code == 'CS04-01'
                      ? 'invisible'
                      : ''
                  "
                  class="text-center px-4 py-3 text-sm"
                >
                  {{ item.currency }}
                </td>
                <td
                  :class="
                    item.code == 'CS01-01' || item.code == 'CS03-01' || item.code == 'CS04-01'
                      ? 'invisible'
                      : ''
                  "
                  class="text-center px-4 py-3 text-sm"
                >
                  {{ item.amount | setPrice(item.currency) }}
                </td>
                <td class="text-center px-4 py-3 text-sm">&nbsp;</td>
                <td
                  :class="
                    item.code == 'CS01-01' || item.code == 'CS03-01' || item.code == 'CS04-01'
                      ? 'invisible'
                      : ''
                  "
                  class="px-4 py-3 text-center text-sm"
                >
                  {{ item.amo2 | setPrice(item.currency2) }}
                </td>
                <td
                  :class="
                    item.code == 'CS01-01' || item.code == 'CS03-01' || item.code == 'CS04-01'
                      ? 'invisible'
                      : ''
                  "
                  class="px-4 py-3 text-right text-sm"
                >
                  {{ item.currency2 }}
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td v-if="total !== 0" colspan="6" class="text-right px-4 py-3">
                  <strong>
                    {{ total | setPrice(currency_ex) }}
                  </strong>
                </td>
                <td class="text-center px-4 py-3 text-sm">
                  <strong>
                    {{ currency_ex }}
                  </strong>
                </td>
              </tr>
              <tr>
                <td colspan="7">
                  <div class="flex justify-end">
                    <a
                      href="/applications"
                      class="
                          flex 
                          justify-center 
                          items-center
                          w-44 
                          h-12 
                          px-4
                          mt-6
                          text-lg
                          leading-5
                          text-white
                          transition-colors
                          duration-150
                          bg-blue-1300
                          border border-transparent
                          rounded-lg
                          active:bg-blue-1300
                          hover:bg-blue-1200
                          focus:outline-none focus:shadow-outline-blue
                        "
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="mx-2 h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2h2m3-4H9a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-1m-1 4l-3 3m0 0l-3-3m3 3V3"
                        />
                      </svg>
                      <span> Guardar </span>
                    </a>
                  </div>
                </td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapState } from 'vuex';
import Loader from '../common/utils/Loader.vue';

export default {
  props: {
    application_id: {
      type: Number,
      required: false
    }
  },
  components: { Loader },
  data() {
    return {
      form: new Form({
        application_id: this.application_id
      }),
      currency_ex: '',
      total: 0
    };
  },
  methods: {
    formatPrice(value, currency) {
      return Number(value).toLocaleString(navigator.language, {
        minimumFractionDigits: currency == 'CLP' ? 0 : 2,
        maximumFractionDigits: currency == 'CLP' ? 0 : 2
      });
    },
    //  formatter(value, currency) {
    //   return Number(value).toLocaleString(navigator.language, {
    //     style: 'currency',
    //     currency,
    //     currencyDisplay: 'code',
    //     minimumFractionDigits: currency == 'CLP' ? 0 : 2,
    //     maximumFractionDigits: currency == 'CLP' ? 0 : 2
    //   });
    // },
    getHumanDate(date) {
      /* Regular expression to change the date format */
      let dateConvert = date.match(/\d+/g);
      let year = dateConvert[0].substring(2); // number of digits for the year (0 full year)
      let month = dateConvert[1];
      let day = dateConvert[2];
      return `${day}-${month}-${year}`;
    },
    clone() {
      this.exchangeItem.forEach((e) => {
        //Find index of specific object using findIndex method.
        let objIndex = this.exchangeItem.findIndex((obj) => obj.id == e.id);
        //Update object's name property.
        this.exchangeItem[objIndex].amo2 = e.amount;
        this.exchangeItem[objIndex].currency2 = e.currency;
        this.currency_ex = e.currency;
      });
      this.total = 0;
      this.currency_ex = '';
    },
    async convert(currency) {
      this.$store.dispatch('application/busyButton', true);
      this.currency_ex = currency;

      const totalApi = await axios.post('/set-application-summary', {
        application_id: btoa(this.application_id),
        currency_code: currency
      });

      await this.$store.dispatch('exchange/getSummary', this.application_id);

      this.exchangeItem.forEach(async (e) => {
        //Find index of specific object using findIndex method.
        let objIndex = this.exchangeItem.findIndex((obj) => obj.id == e.id);
        this.exchangeItem[objIndex].currency2 = currency;
      });

      this.total = totalApi.data;
      this.$store.dispatch('application/busyButton', false);
    }
  },
  computed: {
    ...mapState('exchange', ['exchangeItem']),
    ...mapState('application', ['busy'])
  },
  mounted: async function() {
    this.$store.dispatch('playPauseLoading', true);
    try {
      await this.$store.dispatch('exchange/getSummary', this.application_id);
      this.convert('CLP');
    } catch (error) {
      console.error(error);
    } finally {
      this.$store.dispatch('playPauseLoading', false);
    }
  }
};
</script>

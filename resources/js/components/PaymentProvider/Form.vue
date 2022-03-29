<template>
  <section class="flex flex-col lg:items-center w-full dark:bg-gray-900">
    <!-- Pagos -->
    <section class="lg:flex lg:w-8/12 overflow-x-auto">
      <!-- pagos, fecha, tipo, restriccion -->
      <div
        :class="[
          $store.state.payment.percentageInitial == 0 ? 'opacity-25' : '',
          'lg:w-6/12 h-72 mx-3 px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800'
        ]"
      >
        <!-- primer/segundo pago -->
        <div
          class="md:flex md:justify-around md:flex-row"
          v-if="$store.state.application.statusSuppliers !== 'E-commerce'"
        >
          <div class="lg:w-5/12">
            <span class="text-gray-700 dark:text-gray-400 text-lg font-bold">
              {{ $store.state.payment.payment.length == 0 ? 'Primer pago' : 'Segundo pago' }}
            </span>
            <div class="w-full flex justify-start">
              <input
                class="
                  block
                  w-full
                  mt-1
                  text-sm
                  dark:border-gray-600 dark:bg-gray-700
                  focus:border-blue-400 focus:outline-none focus:shadow-outline-blue
                  dark:text-gray-300 dark:focus:shadow-outline-gray
                  form-input
                  text-center
                "
                placeholder="%"
                v-model.number="$store.state.payment.discount"
                :disabled="$store.state.payment.percentageInitial == 0"
                step="1"
                type="number"
              />
            </div>
            <!-- valid if the field is empty -->
            <!-- <input
                            v-else
                            disabled
                            :class="[]"
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input  text-center"
                            placeholder="%"
                            v-model.number="$store.state.payment.discount"
                            step="1"
                            type="number" 
                        />-->
          </div>
          <div class="lg:w-7/12">
            <!--  <span class="text-gray-700 dark:text-gray-400 text-xs">
                            Monto Agregado
                        </span> -->
            <span class="block w-full mt-8 text-center">
              {{ amountRound }}
            </span>
          </div>
        </div>

        <!-- date_pay -->
        <div class="md:flex md:items-center my-3">
          <div class="md:w-1/3">
            <label
              class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
              for="date_pay"
            >
              Fecha
            </label>
          </div>
          <div class="md:w-2/3">
            <input
              id="date_pay"
              v-model="form.date_pay"
              type="date"
              class="
                block
                w-full
                mt-1
                text-sm
                dark:border-gray-600 dark:bg-gray-700
                focus:border-blue-400 focus:outline-none focus:shadow-outline-blue
                dark:text-gray-300 dark:focus:shadow-outline-gray
                form-input
              "
              placeholder="Empresa"
              :min="minDate"
              :disabled="$store.state.payment.discount === 0"
            />
          </div>
        </div>

        <!-- type_pay -->
        <div class="md:flex md:items-center my-3">
          <div class="md:w-1/3">
            <label
              class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
              for="grid-state"
            >
              Tipo
            </label>
          </div>
          <div class="md:w-2/3">
            <div class="relative">
              <select
                v-model="form.type_pay"
                class="
                  block
                  appearance-none
                  w-full
                  border border-gray-150
                  text-gray-700
                  p-2
                  pr-8
                  rounded
                  leading-tight
                  focus:outline-none focus:bg-white focus:border-gray-500
                  dark:text-gray-300
                  dark:border-gray-600
                  dark:bg-gray-700
                  dark:focus:shadow-outline-gray
                "
                id="grid-state"
                :disabled="$store.state.payment.discount === 0"
              >
                <option value="Transferencia">Transferencia</option>
                <!-- <option value="Carta de Credito">Carta de Credito</option> -->
              </select>
              <div
                class="
                  pointer-events-none
                  absolute
                  inset-y-0
                  right-0
                  flex
                  items-center
                  px-2
                  text-gray-700
                "
              >
                <svg
                  class="fill-current h-4 w-4"
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 20 20"
                >
                  <path
                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                  />
                </svg>
              </div>
            </div>
          </div>
        </div>

        <!-- restriccion -->
        <div class="md:flex md:items-center my-3" v-if="form.type_pay == 'Transferencia'">
          <div class="md:w-1/3">
            <label
              class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
              for="date_pay"
            >
              Restricción
            </label>
          </div>
          <div class="md:w-2/3">
            <div class="relative">
              <select
                v-model="form.payment_release"
                class="
                  block
                  appearance-none
                  w-full
                  border border-gray-150
                  text-gray-700
                  p-2
                  pr-8
                  rounded
                  leading-tight
                  focus:outline-none focus:bg-white focus:border-gray-500
                  dark:text-gray-300
                  dark:border-gray-600
                  dark:bg-gray-700
                  dark:focus:shadow-outline-gray
                "
                id="grid-state"
                :disabled="$store.state.payment.discount === 0"
              >
                <option value="Sin Restricción">Sin Restricción</option>
                <option value="Contra Documento">Ante Inspeccion</option>
                <option value="Contra Inspeccion">Ante copia BL</option>
              </select>
              <div
                class="
                  pointer-events-none
                  absolute
                  inset-y-0
                  right-0
                  flex
                  items-center
                  px-2
                  text-gray-700
                "
              >
                <svg
                  class="fill-current h-4 w-4"
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 20 20"
                >
                  <path
                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                  />
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- pagos proveedor -->
      <div class="lg:w-6/12 mx-3 px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <div v-if="$store.state.application.statusSuppliers !== 'E-commerce'">
          <h3
            class="
              my-2
              font-semibold
              text-lg text-gray-700
              bg-gray-200
              dark:text-gray-200 dark:bg-gray-800
            "
          >
            Pagos al Proveedor
          </h3>
          <!-- <h3
                        :class="[
                            $store.state.payment.percentageInitial -
                                $store.state.payment.discount >=
                            0
                                ? 'text-black'
                                : 'text-red-600  ',
                            ' text-xs dark:text-gray-200'
                        ]"
                    >
                        Porcentaje Restante :
                        {{
                            $store.state.payment.percentageInitial -
                                $store.state.payment.discount
                        }}
                    </h3> -->
        </div>
        <div class="flex justify-around flex-wrap">
          <h3 class="md:w-1/3 my-4 dark:text-gray-200">Total</h3>
          <h3 class="my-4 dark:text-gray-200">
            {{ Number(data.amount).toLocaleString() }}
            {{ currency.code }}
          </h3>
        </div>
        <hr class="w-full mt-4 mb-4 border-solid border-t-2" />
        <div class="h-8 block">
          <span class="text-center text-red-600 text-xs">
            {{ $store.state.payment.discount > 0 ? 'Complete todos los campos*' : '' }}
          </span>
        </div>

        <!-- botones -->
        <div class="flex space-x-2 px-3 md:mb-0 my-4">
          <button
            :disabled="
              $store.state.payment.discount < 0 ||
                $store.state.payment.percentageInitial == 0 ||
                !form.date_pay ||
                form.type_pay == '' ||
                form.payment_release == ''
            "
            :class="[
              $store.state.payment.discount > 0 &&
              $store.state.payment.percentageInitial != 0 &&
              form.date_pay &&
              form.type_pay != '' &&
              form.payment_release != ''
                ? 'active:bg-blue-1300 hover:bg-blue-1100  bg-blue-1000'
                : 'bg-gray-300 active:bg-gray-300 hover:bg-gray-300',
              'flex px-3 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 border border-transparent rounded-lg focus:outline-none focus:shadow-outline-blue'
            ]"
            @click="addPayment()"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
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
            <span> Agregar </span>
          </button>

          <button
            :disabled="$store.state.payment.percentageInitial !== 0 || busy"
            :class="[
              $store.state.payment.percentageInitial !== 0
                ? 'bg-gray-300 active:bg-gray-300 hover:bg-gray-300'
                : 'bg-blue-1300 active:bg-blue-1300 hover:bg-blue-1200',
              'flex px-3 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 border border-transparent rounded-lg focus:outline-none focus:shadow-outline-blue'
            ]"
            @click="submitPayment()"
          >
            <svg
              v-if="!busy"
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
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

            <svg
              v-if="busy"
              class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
            >
              <circle
                class="opacity-25"
                cx="12"
                cy="12"
                r="10"
                stroke="currentColor"
                stroke-width="4"
              ></circle>
              <path
                class="opacity-75"
                fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
              ></path>
            </svg>
            <span> Guardar</span>
          </button>
        </div>
      </div>
    </section>

    <!-- table  -->
    <section class="lg:w-8/12 overflow-x-auto px-3 py-3">
      <div class="mb-8 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr
                class="
                  text-xs 
                  text-center
                text-white
                  font-semibold
                  uppercase
                  tracking-wide
                  border-b
                bg-blue-1300
                dark:border-gray-700 dark:text-gray-200 dark:bg-blue-900
                "
              >
                <th class="px-4 py-3">Pago</th>
                <th class="">%</th>
                <th class="py-3">Monto</th>
                <th class="py-3">Forma</th>
                <th class="py-3">Restriccion</th>
                <th class="py-3"></th>
              </tr>
            </thead>
            <tbody
              v-if="payment.length"
              class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
            >
              <template v-for="(item, key) in payment">
                <tr :key="key" class="text-gray-700 dark:text-gray-400">
                  <td class="px-4 py-3">
                    <div class="flex items-center text-sm">
                      <div>
                        <p class="font-semibold input">Pago Nro {{ key + 1 }}</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          {{ getHumanDate(item.date_pay) }}
                        </p>
                      </div>
                    </div>
                  </td>
                  <td class="px-2 py-2 text-sm">{{ item.percentage }} %</td>

                  <td class="px-4 py-3 text-sm">
                    {{ formatPrice(data.amount * (item.percentage / 100)) }} USD
                  </td>
                  <td class="px-4 py-3 text-xs text-center">
                    <span
                      class="
                        px-2
                        py-1
                        font-semibold
                        leading-tight
                        text-blue-1300
                        bg-blue-1000
                        rounded-full
                        dark:text-white dark:bg-green-600
                      "
                    >
                      {{ item.type_pay }}
                    </span>
                  </td>
                  <td class="px-4 py-3 text-xs font-semibold">
                    {{ item.payment_release }}
                  </td>
                  <td>
                    <svg
                      @click="removedPayment(item)"
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
                <tr class="text-gray-700 dark:text-gray-400" :key="item.percentage">
                  <td class="px-4 text-xs font-semibold" colspan="2">
                    Comisión:
                  </td>
                  <td class="px-4 text-xs font-semibold" colspan="2">
                    {{ item.transfer_abroad }} USD
                  </td>
                  <td class="px-4 text-xs font-semibold" colspan="2">
                    Transferencia al Extranjero
                  </td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </section>
</template>

<script>
import { mapState } from 'vuex';

export default {
  data() {
    return {
      form: {
        percentage: '',
        date_pay: new Date().toISOString().slice(0, 10),
        type_pay: 'Transferencia',
        payment_release: 'Sin Restricción',
        manyPayment: '',
        id: ''
      },
      application_id: this.$store.state.application.application_id,
      code_serv: 'ICS01',
      minDate: new Date().toISOString().substr(0, 10),
      percentajeDelete: {}
    };
  },
  methods: {
    formatPrice(value) {
      let val = (value / 1).toFixed(0).replace('.', ',');
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
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
    removedPayment(item) {
      if (this.$store.state.application.statusSuppliers == 'E-commerce') this.resetValues(100);
      else this.resetValues(item.percentage);
      this.$store.dispatch('payment/deletePayment', item.id);
    },
    resetValues(percentage, percentageInitial = false) {
      this.$store.state.payment.discount = percentage;
      this.$store.state.payment.percentageInitial += percentage;
    },
    addPayment() {
      const { discount, percentageInitial } = this.$store.state.payment;

      if (
        discount != 0 &&
        percentageInitial - discount >= 0 &&
        this.form.type_pay != '' &&
        this.manyPayment != '' &&
        this.form.date_pay != '' &&
        this.form.payment_release != ''
      ) {
        this.$store.dispatch('payment/addPayment', {
          ...this.form,
          percentage: discount,
          id: this.payment.length,
          application_id: this.data.application_id,
          code_serv: 'ICS01',
          transfer_abroad: this.transfer_abroad
        });
        this.form = {
          percentage: '',
          date_pay: new Date().toISOString().slice(0, 10),
          type_pay: '',
          payment_release: '',
          manyPayment: '',
          id: ''
        };
      }
    },
    async submitPayment() {
      try {
        this.$store.dispatch('application/busyButton', true);
        await axios.post('/applications/payment_provider', this.payment);
        // this.$store.dispatch('payment/getPayment', this.payment);
        this.$store.dispatch('callIncomingOrNextMenu', true);
      } catch (error) {
        Toast.fire({
          icon: 'error',
          title: 'Se ha producido un error al procesar los datos'
        });
      } finally {
        this.$store.dispatch('application/busyButton', false);
      }
    }
  },
  computed: {
    ...mapState('payment', ['payment']),
    ...mapState('application', ['data', 'currency', 'editing', 'busy', 'transfer_abroad']),
    amountRound() {
      const { discount } = this.$store.state.payment;
      return (
        Number(Math.round(this.data.amount * (discount / 100))).toLocaleString() +
        ' ' +
        this.currency.code
      );
    }
  },
  created() {
    const { name: typePayment, valueInitial } = this.data.valuePercentage;

    if (this.editing && this.payment.length) {
      this.$store.state.payment.discount = 0;
      return (this.$store.state.payment.percentageInitial = 0);
    }
    if (this.payment.length && !this.editing) return false;
    else if (this.$store.state.application.statusSuppliers == 'E-commerce')
      this.$store.state.payment.discount = 100;
    else if (typePayment !== 'Otros') this.$store.state.payment.discount = valueInitial;
  }
};
</script>

<style></style>

<template>
  <div>
    <div>
      <h1 class="text-2xl text-blue-1300">
        {{ title }}
      </h1>
    </div>

    <div v-if="data.type_transport">
      <div
        v-for="(item, id) in loads"
        :key="id"
        class="my-4 md:mt-8 flex flex-wrap flex-col md:flex-row md:justify-center items-top dark:text-gray-400 md:space-x-5"
      >
        <!-- tipo de carga -->
        <div
          v-if="data.type_transport != 'CONTAINER'"
          :class="[
            validateWeight
              ? 'my-2 flex justify-center md:inline lg:w-24 lg:h-40'
              : 'my-2 flex justify-center md:inline lg:w-24'
          ]"
        >
          <div class="w-full text-center">
            <label v-if="id == 0" class="text-sm font-semibold"> Tipo de Carga </label>
            <div class="flex justify-center">
              <select
                v-model="item.category_load_id"
                value="Seleccionar"
                class="
                block
                text-sm
                w-11/12
                bg-white
                border 
                border-gray-200
                text-gray-700
                py-2
                px-2
                pr-8
                rounded
                leading-tight
                focus:outline-none focus:bg-white focus:border-gray-500
                dark:text-gray-300
                dark:border-gray-600
                dark:bg-gray-700
                dark:focus:shadow-outline-gray
                form-select
              "
              >
                <option v-if="data.type_transport !='CONSOLIDADO'" value="1">Caja</option>
                <option value="2">Pallet</option>
                <option v-if="data.type_transport !='CONSOLIDADO'" value="3">Unidad</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Tipo container -->
        <div class="my-2.5 flex justify-center md:inline md:w-34" v-else>
          <div class="w-full text-center">
            <label v-if="id == 0" class="text-sm font-semibold">Tipo de Container</label>
            <div class="w-full text-center">
              <select
                v-model="item.type_container"
                class="
                block
                text-sm
                w-full
                bg-white
                border border-gray-200
                text-gray-700
                py-2
                px-2
                pr-8
                rounded
                leading-tight
                focus:outline-none focus:bg-white focus:border-gray-500
                dark:text-gray-300
                dark:border-gray-600
                dark:bg-gray-700
                dark:focus:shadow-outline-gray
                form-select
              "
              >
                <option value="1">20'DV</option>
                <option value="2">40'DV</option>
                <option value="3">40'HC</option>
                <option value="4">40'NOR</option>
                <option value="5">45'HC</option>
              </select>
            </div>
          </div>
        </div>

        <!-- DIMENSIONES POR PAQUETE -->
        <div
          :class="[
            validateWeight
              ? 'lg:h-40 my-2 flex flex-col justify-start md:inline text-center'
              : 'my-2 flex flex-col justify-start md:inline text-center'
          ]"
        >
          <div v-if="data.type_transport != 'CONTAINER'" class="w-full">
            <span v-if="id == 0" class="text-sm font-semibold">
              Dimensiones
            </span>
            <div class="flex justify-center">
              <input
                v-model.number="item.length"
                type="number"
                class="
                  h-9
                  w-24
                  sm:w-44 
                  md:w-20 
                  lg:w-16
                  focus:outline-none
                  border
                  rounded-l-lg
                  flex
                  items-center
                  text-center text-sm
                  dark:border-gray-600
                  dark:bg-gray-700
                  dark:text-gray-300
                  dark:focus:shadow-outline-gray
                "
                placeholder="Largo"
              />
              <input
                v-model.number="item.width"
                type="number"
                class="
                  h-9
                  w-24
                  sm:w-44 
                  md:w-20 
                  lg:w-16
                  focus:outline-none
                  border
                  rounded-none
                  flex
                  items-center
                  text-center text-sm
                  dark:border-gray-600
                  dark:bg-gray-700
                  dark:text-gray-300
                  dark:focus:shadow-outline-gray
                "
                placeholder="Ancho"
              />
              <input
                v-model.number="item.height"
                type="number"
                class="
                  h-9
                  w-24
                  sm:w-44 
                  md:w-20 
                  lg:w-16
                  focus:outline-none
                  border
                  rounded-r-lg
                  flex
                  items-center
                  text-center text-sm
                  dark:border-gray-600
                  dark:bg-gray-700
                  dark:text-gray-300
                  dark:focus:shadow-outline-gray
                "
                placeholder="Alto"
                :disabled="item.stackable"
              />
            </div>
            <label class="inline-flex text-sm items-center mx-2 mt-2">
              <input
                type="radio"
                v-model="item.length_unit"
                @click="changeLoadType('CM')"
                class="
                  form-checkbox
                  h-4
                  w-4
                  text-gray-800
                  dark:focus:shadow-outline-gray dark:text-gray-300
                "
                :id="'lengthUnit' + id"
                value="CM"
              /><span class="ml-2 text-gray-700"> cm </span>
            </label>
            <label class="inline-flex text-sm items-center mx-2 mt-2">
              <input
                :selected="true"
                type="radio"
                v-model="item.length_unit"
                @click="changeLoadType('IN')"
                class="
                  form-checkbox
                  h-4
                  w-4
                  text-gray-800
                  dark:focus:shadow-outline-gray dark:text-gray-300
                "
                :id="'lengthUnit' + id"
                value="IN"
              /><span class="ml-2 text-gray-700"> pulg </span>
            </label>
          </div>
          <span
            class="text-xs text-red-500 dark:text-red-500"
            v-if="expenses.errors.has('dataLoad.0.length')"
            v-html="expenses.errors.get('dataLoad.0.length')"
          ></span>
          <span
            class="text-xs text-red-500 dark:text-red-500"
            v-if="expenses.errors.has('dataLoad.0.width')"
            v-html="expenses.errors.get('dataLoad.0.width')"
          ></span>
          <span
            class="text-xs text-red-500 dark:text-red-500"
            v-if="expenses.errors.has('dataLoad.0.height')"
            v-html="expenses.errors.get('dataLoad.0.height')"
          ></span>
        </div>

        <!-- CBM -->
        <div
          :class="[
            validateWeight
              ? 'my-2 flex lg:inline lg:w-20 lg:h-40 text-center'
              : 'my-2 flex lg:inline lg:w-20 text-center'
          ]"
          v-if="data.type_transport != 'CONTAINER'"
        >
          <div class="w-full">
            <span v-if="id == 0" class="text-sm font-semibold"> CBM </span>
            <div class="flex justify-center">
              <input
                :value="(item.cbm = (item.length * item.width * item.height) / 1000000)"
                class="
                  w-11/12 
                  sm:w-11/12 
                  md:w-20 
                  lg:w-20
                  h-9 
                  flex
                  text-center text-sm
                dark:bg-gray-700
                focus:border-blue-400 focus:outline-none focus:shadow-outline-blue
                dark:text-gray-300 dark:focus:shadow-outline-gray
                  form-input
                "
                :disabled="item.mode_calculate"
                placeholder="CBM"
              />
            </div>
          </div>
        </div>

        <!-- peso unitario -->
        <div
          :class="[
            validateWeight
              ? 'my-2 flex flex-col lg:w-32 lg:h-40 text-center'
              : 'my-2 flex flex-col lg:w-32 text-center'
          ]"
        >
          <div>
            <span v-if="id == 0" class="text-sm font-semibold"> Peso </span>
            <div
              :class="[
                validateWeight ? 'flex flex-col justify-center items-center' : 'flex justify-center'
              ]"
            >
              <input
                v-model.number="item.weight"
                :max="99999"
                type="number"
                :class="[
                  'w-11/12 sm:w-11/12 md:w-28 lg:w-28 h-9 flex text-center text-sm dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input',
                  data.type_transport != 'CONTAINER' ? '' : ''
                ]"
              />
              <span v-if="validateWeight" class="text-center text-red-500 text-xs mt-2">{{
                validateWeight
              }}</span>
              <br v-if="validateWeight" />
            </div>
            <label class="inline-flex text-sm items-center mx-2 mt-2">
              <input
                type="radio"
                v-model="item.weight_units"
                @click="changeLoadType('CM')"
                :id="'weight_units' + id"
                :name="'weight_units' + id"
                class="
                form-checkbox
                h-4
                w-4
                text-gray-800
                form-checkbox
                focus:border-blue-400 focus:outline-none focus:shadow-outline-blue
                dark:focus:shadow-outline-gray dark:text-gray-300
              "
                checked
                value="KG"
              />
              <span class="ml-2 text-gray-700"> Kg </span>
            </label>
            <label class="inline-flex text-sm items-center mx-2 mt-2">
              <input
                type="radio"
                v-model="item.weight_units"
                @click="changeLoadType('IN')"
                :id="'weight_units' + id"
                :name="'weight_units' + id"
                class="
                form-checkbox
                h-4
                w-4
                text-gray-800
                form-checkbox
                focus:border-blue-400 focus:outline-none focus:shadow-outline-blue
                dark:focus:shadow-outline-gray dark:text-gray-300
              "
                value="LB"
              />
              <span class="ml-2 text-gray-700"> Lbs </span>
            </label>
          </div>
        </div>

        <!-- No aplilable -->
        <div class="my-2 flex sm:flex-col md:justify-center lg:justify-start lg:mt-10">
          <label
            class="inline-flex text-sm items-center sm:mb-1.5"
            v-if="data.type_transport === 'CONSOLIDADO'"
          >
            <input
              type="checkbox"
              v-model="item.stackable"
              class="
                form-checkbox
                h-4
                w-4
                text-gray-800
                form-checkbox
                focus:border-blue-400 focus:outline-none focus:shadow-outline-blue
                dark:focus:shadow-outline-gray dark:text-gray-300
              "
              @click="stackable(id)"
              checked
            />
            <span class="ml-2 text-gray-700">No Apilable</span>
          </label>
        </div>

        <!-- Botones añadir/eliminar -->
        <div
          class="flex justify-center h-10 mt-5 lg:mt-7"
          v-if="item.mode_calculate || typeSelected == 'CONTAINER'"
        >
          <button
            v-if="id > 0"
            @click="deleteForm(id)"
            class="
              w-11
              bg-transparent
              focus:outline-none
              uppercase
              text-xs
              hover:bg-gray-300
              text-gray-600
              font-semibold
              py-2
              px-2
              border border-gray-600
              hover:border-transparent
              rounded
              active:text-white
              active:bg-gray-500
            "
          >
            <svg
              class="w-6 h-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              ></path>
            </svg>
            <!-- Eliminar -->
          </button>

          <button
            v-else
            @click="AddFielForm"
            class="  
            w-11
            bg-transparent
            focus:outline-none
            uppercase
            text-xs
            hover:bg-blue-1000
            text-blue-1000
            font-semibold
            hover:text-white
            active:bg-blue-1200
            py-2
            px-2
            border border-blue-1000
            rounded
            "
          >
            <svg
              class="w-6 h-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 6v6m0 0v6m0-6h6m-6 0H6"
              ></path>
            </svg>
            <!-- Añadir Carga -->
          </button>
        </div>
      </div>
    </div>
    <!-- Notification validation error -->

    <span
      class="text-xs text-red-500 dark:text-red-500"
      v-if="expenses.errors.has('dataLoad.0.weight')"
      v-html="expenses.errors.get('dataLoad.0.weight')"
    ></span>
    <span
      class="text-xs text-red-500 dark:text-red-500"
      v-if="expenses.errors.has('fedex')"
      v-html="expenses.errors.get('fedex')"
    ></span>
    <span
      class="text-xs text-red-500 dark:text-red-500"
      v-if="expenses.errors.has('dhl')"
      v-html="expenses.errors.get('dhl')"
    ></span>
  </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
  props: {
    title: {
      require: false,
      default: 'Cotizador Online'
    }
  },
  data() {
    return {
      showKg: true,
      showIn: true
    };
  },
  methods: {
    AddFielForm() {
      this.$store.dispatch('load/addLoad', this.item);
    },
    deleteForm(id) {
      this.$store.dispatch('load/removedLoad', id);
    },
    reset() {
      this.$store.state.load.loads = [];
      this.$store.dispatch('load/addLoad', this.item);
    },
    changeLoadType(unit) {
      this.$store.dispatch('load/changeLoadType', unit);
    },
    stackable(id) {
      this.loads[id].height = this.loads[id].stackable ? 0 : 230;
    }
  },
  computed: {
    ...mapState('load', ['item', 'loads', 'mode_selected']),
    ...mapState('address', ['expenses']),
    ...mapState('application', ['data']),

    validateWeight() {
      const { loads } = this.$store.state.load;

      /* switch case para peso unitario en KG y LB en courier */
      switch (
        (loads.length && loads[loads.length - 1].weight_units == 'KG') ||
        loads[loads.length - 1].weight_units == 'LB'
      ) {
        case loads[loads.length - 1].weight == '':
          return '';

        case loads[loads.length - 1].weight_units == 'KG' &&
          // this.data.type_transport == 'COURIER' &&
          loads[loads.length - 1].weight < 0.01:
          return 'Limite minimo de peso: 0.01 KG';

        case loads[loads.length - 1].weight_units == 'LB' &&
          // this.data.type_transport == 'COURIER' &&
          loads[loads.length - 1].weight < 0.02:
          return 'Limite minimo de peso: 0.02 LB';

        case loads[loads.length - 1].weight_units == 'KG' &&
          this.data.type_transport == 'COURIER' &&
          loads[loads.length - 1].weight > 2268:
          return 'Excede limite maximo de peso: 2268 KG';

        case loads[loads.length - 1].weight_units == 'LB' &&
          this.data.type_transport == 'COURIER' &&
          loads[loads.length - 1].weight > 5000:
          return 'Excede limite maximo de peso: 5000 LB';

        case loads[loads.length - 1].weight_units == 'KG' &&
          this.data.type_transport != 'COURIER' &&
          loads[loads.length - 1].weight > 24000:
          return 'Excede limite maximo de peso: 24.000 KG';

        case loads[loads.length - 1].weight_units == 'LB' &&
          this.data.type_transport != 'COURIER' &&
          loads[loads.length - 1].weight > 52910:
          return 'Excede limite maximo de peso: 52.910 LB';

        case loads[loads.length - 1].weight_units == 'KG' && loads[loads.length - 1].weight >= 0.01:
          return '';

        case loads[loads.length - 1].weight_units == 'LB' && loads[loads.length - 1].weight >= 0.02:
          return '';

        default:
          false;
          break;
      }
      return false;
    }
  },
  created() {
    this.$store.state.load.mode_selected = this.$store.state.application.data.type_transport;
    this.item.category_load_id =  this.data.type_transport !='CONSOLIDADO' ? 1 : 2
    if (!this.loads.length) this.reset();
  },
  
};
</script>
